<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->service('ProductService', 'productService');
    }

    public function index()
    {
		return view('home/index');
    }

	public function table()
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		return $this->productService->table();
	}

	public function store()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

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
			'title' => $this->input->post('title'),
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
			exit('No direct script access allowed');
		}

		$this->output->set_status_header(200);
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->Category->find($id)));
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
			'id' => $this->input->post('id'),
			'title' => slug($this->input->post('title')),
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
		return $this->productService->delete($id);
	}

	public function rules()
	{
		$this->form_validation->set_rules('title', 'Judul', 'required', array(
			'required' => '%s field tidak boleh kosong'
		));
		$this->form_validation->set_rules('category_id', 'Kategori', 'required', array(
			'required' => '%s field tidak boleh kosong'
		));
		$this->form_validation->set_rules('stock', 'Stok', 'required', array(
			'required' => '%s field tidak boleh kosong'
		));
		$this->form_validation->set_rules('normal_price', 'Harga Normal', 'required', array(
			'required' => '%s field tidak boleh kosong'
		));
		$this->form_validation->set_rules('promotion_price', 'Harga Promosi', 'required', array(
			'required' => '%s field tidak boleh kosong'
		));
		$this->form_validation->set_rules('description', 'Deskripsi', 'required', array(
			'required' => '%s field tidak boleh kosong'
		));
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
