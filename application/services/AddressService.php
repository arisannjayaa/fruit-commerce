<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddressService extends MY_Service{
	public function __construct() {
		$this->load->model('Address');
	}

	public function create($data)
	{
		try {
			$this->db->trans_begin();

			$countRow = $this->Address->getCountRow($this->auth->user()->id);

			if ($countRow == 5) {
				$this->output->set_status_header(400);
				echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Tidak dapat menyimpan data alamat lebih dari 5"));
				$this->db->trans_commit();
				return;
			}

			if ($countRow == 0) {
				$data['is_primary'] = true;
			}

			$query = $this->Address->create($data);

			if ($countRow > 0 && $data['is_primary'] === true) {
				$this->Address->setPrimaryAddress($query);
			}

			$this->output->set_status_header(200);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data alamat berhasil ditambahkan"));

			$this->db->trans_commit();
			return;
		} catch (Exception $exception) {
			$this->db->trans_rollback();
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function update($data)
	{
		try {
			$id = $data['id'];
			unset($data['id']);
			$this->output->set_status_header(200);
			$this->Address->update($id, $data);

			if ($data['is_primary'] === true) {
				$this->Address->setPrimaryAddress($id);
			}

			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data alamat berhasil diupdate"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function delete($id)
	{
		try {
			$this->Address->delete($id);
			$this->Address->setPrimaryAfterDelete();
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data alamat berhasil dihapus"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}
}
