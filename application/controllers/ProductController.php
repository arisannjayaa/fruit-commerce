<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('Category');
		$this->load->helper('custom');
		$this->load->service('ProductService', 'productService');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(1);
		$data['categories'] = $this->Category->all();
		return view('product/index', $data);
    }

	public function table()
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);

		return $this->productService->table();
	}

	public function store()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);

		$this->rules();

		if (empty($_FILES['attachment']['name'])) {
			$this->form_validation->set_rules('attachment', 'Lampiran', 'required', array(
				'required' => '%s tidak boleh kosong.',
			));
		}

		if ($this->form_validation->run() == FALSE) {
			$this->output->set_status_header(400);
			$errors = $this->form_validation->error_array();

			$errorObj = [];
			foreach ($errors as $key => $value) {
				$errorObj[$key] = [[$value]];
			}

			echo json_encode(array('errors' => $errorObj));
			return;
		}
		$path 		= 'uploads/products/';

		if (!is_dir($path)) {
			mkdir($path, 0777, TRUE);
		}

		$config['upload_path'] 		= './'.$path;
		$config['allowed_types'] 	= 'jpg|png';
		$config['max_filename']	 	= '255';
		$config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 1024;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload("attachment")) {
			$this->output->set_status_header(400);

			echo json_encode(array('attachment' => "Terjadi error saat upload file"));
			return;
		}

		$file_data 	= $this->upload->data();
		$file_name 	= $path.$file_data['file_name'];
		$arr_file 	= explode('.', $file_name);
		$extension 	= end($arr_file);

		$data = array(
			'title' => $this->input->post('title'),
			'price' => $this->input->post('price'),
			'attachment' => $file_name,
			'description' => $this->input->post('description'),
			'stock' => $this->input->post('stock'),
			'slug' => slug($this->input->post('title')),
			'created_by' => $this->auth->user()->id,
			'category_id' => $this->input->post('category_id'),
		);

		return $this->productService->create($data);
	}

	/**
	 * get data by id
	 * @param $id
	 * @return void
	 */
	public function edit($id)
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);

		$this->output->set_status_header(200);
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->Product->find($id)));
	}

	/**
	 * update data
	 * @return void
	 */
	public function update()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);

		if ($this->input->post('attachment') == null || $this->input->post('attachment') == "") {
			if (empty($_FILES['attachment']['name'])) {
				$this->form_validation->set_rules('attachment', 'Lampiran', 'required', array(
					'required' => '%s tidak boleh kosong.',
				));
			}
		}

		$old_attachment = $this->input->post('old_attachment');

		$this->rules($this->input->post('id'));

		if ($this->form_validation->run() == FALSE) {
			$this->output->set_status_header(400);
			$errors = $this->form_validation->error_array();

			$errorObj = [];
			foreach ($errors as $key => $value) {
				$errorObj[$key] = [[$value]];
			}

			echo json_encode(array('errors' => $errorObj));
			return;
		}

		if (@$_FILES['attachment']['name']) {
			$path = 'uploads/products/';

			if (!is_dir($path)) {
				mkdir($path, 0777, TRUE);
			}

			$config['upload_path'] 		= './'.$path;
			$config['allowed_types'] 	= 'jpg|jpeg|png';
			$config['max_filename']	 	= '255';
			$config['encrypt_name'] 	= TRUE;
			$config['max_size'] 		= 2024;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload("attachment")) {
				$this->output->set_status_header(400);

				echo json_encode(array('attachment' => "Terjadi error saat upload file"));
				return;
			}

			$file_data 	= $this->upload->data();
			$file_name 	= $path.$file_data['file_name'];
			$arr_file 	= explode('.', $file_name);
			$extension 	= end($arr_file);

			if(file_exists('./' . $old_attachment)) {
				unlink('./'.$old_attachment);
			}
		} else {
			$file_name = $old_attachment;
		}

		$data = array(
			'id' => $this->input->post('id'),
			'title' => $this->input->post('title'),
			'price' => $this->input->post('price'),
			'attachment' => $file_name,
			'description' => $this->input->post('description'),
			'stock' => $this->input->post('stock'),
			'slug' => slug($this->input->post('title')),
			'created_by' => $this->auth->user()->id,
			'category_id' => $this->input->post('category_id'),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		return $this->productService->update($data);
	}

	/**
	 * delete data
	 * @return void
	 */
	public function delete()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);

		$id = $this->input->post('id');
		return $this->productService->delete($id);
	}

	public function rules($id = null)
	{
		$rules = array(
			'title' => $id == null ? 'required|is_unique[products.title]' : 'required',
		);

		$this->form_validation->set_rules('title', 'Judul', $rules['title'], array(
			'required' => '%s tidak boleh kosong',
			'is_unique' => '%s harus berisi nilai unik'
		));
		$this->form_validation->set_rules('category_id', 'Kategori', 'required', array(
			'required' => '%s tidak boleh kosong'
		));
		$this->form_validation->set_rules('stock', 'Stok', 'required|numeric', array(
			'required' => '%s tidak boleh kosong',
			'numeric' => '%s harus berupa angka',
		));
		$this->form_validation->set_rules('price', 'Harga', 'required|numeric', array(
			'required' => '%s tidak boleh kosong',
			'numeric' => '%s harus berupa angka',
		));
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
