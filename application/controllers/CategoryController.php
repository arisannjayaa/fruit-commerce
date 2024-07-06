<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->service('CategoryService', 'categoryService');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(1);
		return view('category/index');
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

		return $this->categoryService->table();
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
		);

		return $this->categoryService->create($data);
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
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->Category->find($id)));
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
			'updated_at' => date('Y-m-d H:i:s'),
		);

		return $this->categoryService->update($data);
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
		return $this->categoryService->delete($id);
	}

	public function rules($id = null)
	{
		$rules = array(
			'name' => $id == null ? 'required|is_unique[categories.name]' : 'required',
		);
		$this->form_validation->set_rules('name', 'Kategori', $rules['name'], array(
			'required' => '%s tidak boleh kosong',
			'is_unique' => '%s harus berisi nilai unik'
		));
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
