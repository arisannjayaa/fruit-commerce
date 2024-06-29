<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddressController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->service('AddressService', 'addressService');
		$this->load->model('Address');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(2);
		$data['addresses'] = $this->Address->findByUserId($this->auth->user()->id)->result();
		$data['total'] = $this->Address->getCountRow($this->auth->user()->id);
		return view('home/settings/address-settings', $data);
    }

	public function store()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(2);

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
			'user_id' => $this->auth->user()->id,
			'address' => $this->input->post('address'),
			'label' => $this->input->post('label'),
			'addressee' => $this->input->post('addressee'),
			'telephone' => $this->input->post('telephone'),
			'postal_code' => $this->input->post('postal_code'),
			'is_primary' => $this->input->post('is_primary') ? true : false,
		);

		return $this->addressService->create($data);
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

		$this->auth->protect(2);

		$this->output->set_status_header(200);
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->Address->find($id)->row()));
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

		$this->auth->protect(2);

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
			'user_id' => $this->auth->user()->id,
			'address' => $this->input->post('address'),
			'label' => $this->input->post('label'),
			'addressee' => $this->input->post('addressee'),
			'telephone' => $this->input->post('telephone'),
			'postal_code' => $this->input->post('postal_code'),
			'is_primary' => $this->input->post('is_primary') ? true : false,
		);

		return $this->addressService->update($data);
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

		$this->auth->protect(2);

		$id = $this->input->post('id');
		return $this->addressService->delete($id);
	}

	public function rules()
	{
		$this->form_validation->set_rules('address', 'Alamat', 'required', array(
			'required' => '%s field tidak boleh kosong'
		));
		$this->form_validation->set_rules('label', 'Label', 'required', array(
			'required' => '%s field tidak boleh kosong',
		));
		$this->form_validation->set_rules('postal_code', 'Kode Pos', 'required', array(
			'required' => '%s field tidak boleh kosong',
		));
		$this->form_validation->set_rules('addressee', 'Penerima', 'required', array(
			'required' => '%s field tidak boleh kosong',
		));
		$this->form_validation->set_rules('telephone', 'Telephone', 'required', array(
			'required' => '%s field tidak boleh kosong',
		));
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
