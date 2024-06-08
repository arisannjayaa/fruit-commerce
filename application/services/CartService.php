<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartService extends MY_Service{
	public function __construct() {
		$this->load->model('User');
		$this->load->model('Cart');
	}

	public function findByUserId($user_id)
	{
		try {
			$result = $this->Cart->findByUserId($user_id)->result();
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'data' => $result));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function delete($id)
	{
		try {
			$this->Cart->delete($id);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data cart berhasil dihapus"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}
}
