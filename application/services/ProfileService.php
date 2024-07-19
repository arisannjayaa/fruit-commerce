<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileService extends MY_Service{
	public function __construct() {
		$this->load->model('User');
	}

	public function update($data)
	{
		try {
			$id = $data['id'];
			unset($data['id']);
			$this->output->set_status_header(200);
			$this->User->update($id, $data);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data Profile berhasil diupdate"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}
}
