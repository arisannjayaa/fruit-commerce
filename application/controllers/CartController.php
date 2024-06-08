<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('Cart');
		$this->load->helper('custom');
		$this->load->service('CartService', 'cartService');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(2);
		return view('home/cart');
    }

	public function all()
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		return $this->cartService->findByUserId($this->auth->user()->id);
	}

	public function store()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$this->rules();

		if (empty($_FILES['attachment']['name'])) {
			$this->form_validation->set_rules('attachment', 'Attachment', 'required', array(
				'required' => 'The %s field tidak boleh kosong.',
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
			'category_id' => $this->input->post('category_id')
		);

		return $this->productService->create($data);
	}

	/**
	 * update data
	 * @return void
	 */
	public function update()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$old_attachment = $this->input->post('old_attachment');

		$this->rules();

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

		if ($_FILES['attachment']['name']) {
			$path = 'uploads/products/';

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
			'category_id' => $this->input->post('category_id')
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
			exit('No direct script access allowed');
		}

		$id = $this->input->post('id');
		return $this->cartService->delete($id);
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
