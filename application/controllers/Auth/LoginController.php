<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->service('AuthService', 'authService');
    }

    public function index()
    {
		if ($this->auth->check()) {
			redirect(base_url('dashboard'));
		}

		return view('auth/login');
    }

	public function login()
	{
		if ($this->auth->check()) {
			redirect(base_url('dashboard'));
		}

		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$this->rules();

		if ($this->form_validation->run() == false) {
			$this->output->set_status_header(400);
			$errors = $this->form_validation->error_array();

			$errorObj = [];
			foreach ($errors as $key => $value) {
				$errorObj[$key] = [[$value]];
			}

			echo json_encode(array('errors' => $errorObj));
			return;
		}

		$email = $this->input->post('email');
		$password = $this->input->post('password');

		return $this->authService->login($email, $password);
	}

	public function logout()
	{
		return $this->authService->logout();
	}

	public function rules()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email', array(
			'required' => '%s tidak boleh kosong',
			'valid_email' => '%s gunakan email yang valid'
		));
		$this->form_validation->set_rules('password', 'Password', 'required',  array(
			'required' => '%s tidak boleh kosong',
		));
	}
}

/* End of file LoginController.php and path \application\controllers\Auth\LoginController.php */
