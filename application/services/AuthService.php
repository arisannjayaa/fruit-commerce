<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthService extends MY_Service{
	public function __construct() {
		$this->load->model('User');
		$this->load->model('Cart');
	}

	public function login($email, $password)
	{
		try {
			$user = $this->User->findByEmail($email);

			if ($user) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'id' => $user['id'],
						'email' => $user['email'],
						'role_id' => $user['role_id'],
						'username' => $user['username'],
						'logged_in' => true,
						'login_token' => sha1($user['id'].time().mt_rand(1000, 9999))
					];
					$this->session->sess_regenerate();
					$this->session->set_userdata($data);

					if ($user['role_id'] == 1) {
						$this->output->set_status_header(200);
						echo json_encode(array('message' => "Autentikasi berhasil diterima", 'redirect' => base_url('dashboard')));
						return;
					} else {
						$this->output->set_status_header(200);
						echo json_encode(array('message' => "Autentikasi berhasil diterima", 'redirect' => base_url('')));
						return;
					}
				} else {
					$this->output->set_status_header(400);
					echo json_encode(array('message' => "Email atau password salah!"));
					return;
				}
			} else {
				$this->output->set_status_header(400);
				echo json_encode(array('message' => "Email belum terdaftar!"));
				return;
			}
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function logout()
	{
		$this->auth->destroy();
	}

	public function register($data)
	{
		try {
			$user = $this->User->create($data);
			$this->Cart->create(array('user_id' => $user));
			$this->output->set_status_header(200);
			echo json_encode(array('message' => "Registrasi berhasil, login ke sistem untuk melanjutkan.", 'redirect' => base_url('login')));
			return;
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}
}
