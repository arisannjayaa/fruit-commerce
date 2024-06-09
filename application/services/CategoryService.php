<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryService extends MY_Service{
	public function __construct() {
		$this->load->model('Category');
	}

	public function table()
	{
		$param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
		$length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
		$search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
		$data = $this->Category->datatable($search, $start, $length);
		$total_count = $this->Category->datatable($search);

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
			$this->Category->create($data);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data kategori berhasil ditambahkan"));
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
			$this->Category->update($id, $data);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data kategori berhasil diupdate"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function delete($id)
	{
		try {
			$this->Category->delete($id);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data kategori berhasil dihapus"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}
}
