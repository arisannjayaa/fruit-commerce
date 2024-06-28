<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddressService extends MY_Service{
	public function __construct() {
		$this->load->model('User');
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
