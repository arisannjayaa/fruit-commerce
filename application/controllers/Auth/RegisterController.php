<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->service('AuthService', 'authService');
    }

    public function index()
    {
		return view('auth/register');
    }

	public function register()
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

		$data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			'role_id' => 2,
		);

		return $this->authService->register($data);
	}

	public function rules()
	{
		$this->form_validation->set_rules('first_name', 'Nama Depan', 'required|trim', array(
			'required' => '%s tidak boleh kosong'
		));
		$this->form_validation->set_rules('last_name', 'Nama Belakang', 'required|trim', array(
			'required' => '%s tidak boleh kosong'
		));
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', array(
			'required' => '%s tidak boleh kosong',
			'valid_email'=> '%s harus valid',
			'is_unique' => '%s sudah digunakan!'
		));
		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]', array(
			'required' => '%s tidak boleh kosong',
			'valid_email'=> '%s harus valid',
			'is_unique' => '%s sudah digunakan!'
		));
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[confirm_password]', array(
			'required' => '%s tidak boleh kosong',
			'min_length' => '%s setidaknya memiliki panjang 3 karakter',
			'matches' => '%s tidak match'
		));
		$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|trim|matches[password]',array(
			'required' => '%s tidak boleh kosong',
			'matches' => '%s tidak match'
		));
	}
}

/* End of file RegisterController.php and path \application\controllers\Auth\RegisterController.php */
