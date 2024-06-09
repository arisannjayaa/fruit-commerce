<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserService extends MY_Service{
	public function __construct() {
		$this->load->model('User');
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

	public function table()
	{
		$param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
		$length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
		$search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
		$data = $this->User->datatable($search, $start, $length);
		$total_count = $this->User->datatable($search);

		echo json_encode([
			'draw' => intval($param['draw']),
			'recordsTotal' => count($total_count),
			'recordsFiltered' => count($total_count),
			'data' => $data
		]);
	}

	public function create($data)
	{
		try {
			$this->output->set_status_header(200);
			$this->User->create($data);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data user berhasil ditambahkan"));
			return;
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function update($data)
	{
		try {
			$id = $data['id'];
			unset($data['id']);
			$this->output->set_status_header(200);
			$this->User->update($id, $data);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data user berhasil diupdate"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function delete($id)
	{
		try {
			$this->User->delete($id);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data user berhasil dihapus"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}
}
