<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductVariantController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('Product');
		$this->load->model('ProductVariant');
		$this->load->helper('custom');
		$this->load->service('ProductVariantService', 'productVariantService');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(1);
		$data['products'] = $this->Product->findAllByIsVariant(1);
		return view('product-variant/index', $data);
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

		return $this->productVariantService->table();
	}

	public function store()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);

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

		$data = array(
			'name' => $this->input->post('name'),
			'price' => $this->input->post('price'),
			'stock' => $this->input->post('stock'),
			'product_id' => $this->input->post('product_id'),
		);

		return $this->productVariantService->create($data);
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
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->ProductVariant->find($id)));
	}

	public function find($id)
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->output->set_status_header(200);
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->ProductVariant->find($id)));
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

		$data = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'price' => $this->input->post('price'),
			'stock' => $this->input->post('stock'),
			'product_id' => $this->input->post('product_id'),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		return $this->productVariantService->update($data);
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
		return $this->productVariantService->delete($id);
	}

	public function rules($id = null)
	{
		$rules = array(
			'name' => $id == null ? 'required|is_unique[product_variants.name]' : 'required|edit_unique[product_variants.name.'.$id.']',
			'product_id' => $id == null ? 'required' : '',
		);

		$this->form_validation->set_rules('name', 'Nama', $rules['name'], array(
			'required' => '%s tidak boleh kosong',
			'is_unique' => '%s harus berisi nilai unik',
			'edit_unique' => '%s harus berisi nilai unik'
		));
		$this->form_validation->set_rules('product_id', 'Produk', $rules['product_id'], array(
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
