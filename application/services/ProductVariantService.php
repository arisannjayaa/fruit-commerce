<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductVariantService extends MY_Service{
	public function __construct() {
		$this->load->model('ProductVariant');
	}

	public function table()
	{
		$param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
		$length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
		$search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
		$data = $this->ProductVariant->datatable($search, $start, $length);
		$total_count = $this->ProductVariant->datatable($search);

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
			$this->ProductVariant->create($data);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data produk berhasil ditambahkan"));
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
			$this->ProductVariant->update($id, $data);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data produk berhasil diupdate"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function delete($id)
	{
		try {
			$product = $this->ProductVariant->find($id);

			if ($product) {
				$this->ProductVariant->delete($product->id);

				if(file_exists('./' . $product->attachment)) {
					unlink('./'.$product->attachment);
				}
			}

			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data produk berhasil dihapus"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function checkStock($products)
	{
		foreach ($products as $product) {
			if ($product->stock == 0) {
				return false;
			}
		}

		return true;
	}
}
