<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionService extends MY_Service{
	public function __construct() {
		$this->load->model('Cart');
		$this->load->model('Transaction');
	}

	public function findByUserId($user_id)
	{
		try {
			$result = $this->Transaction->findByUserId($user_id)->result();
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'data' => $result));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function delete($id)
	{
		try {
			$this->Transaction->delete($id);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data cart berhasil dihapus"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function update($data)
	{
		try {
			$id = $data['id'];
			unset($data['id']);
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Transaction->update($id, $data);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data cart berhasil diupdate"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function create($data, $result)
	{
		try {
			$products = json_decode($data['products']);

			foreach ($products as $product) {
				$this->Cart->deleteByUserProduct($product->user_id, $product->id);
			}

			$this->Transaction->create($data);
			$this->output->set_status_header(200);
			$message = "";

			switch ($result->transaction_status) {
				case "settlement":
					$message =  "Transaksi telah berhasil dan dana telah masuk ke rekening penjual (merchant).";
					break;
				case "pending":
					$message =  "Transaksi sedang menunggu proses lebih lanjut.";
					break;
				case "expire":
					$message =  "Transaksi kadaluwarsa karena waktu yang diberikan untuk menyelesaikan pembayaran telah habis.";
					break;
				default:
					$message = " Transaksi ditolak atau gagal. ";
					break;
			}

			echo json_encode(array('success' => true, 'code' => 200, 'message' => $message));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function table($data)
	{
		$data['start'] = date('Y-m-d', strtotime($data['start'])).' 00:00:00';
		$data['end'] = date('Y-m-d', strtotime($data['end'])).' 23:59:59';

		$param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
		$length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
		$search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
		$query = $this->Transaction->table($search, $start, $length, $data);
		$total_count = $this->Transaction->table($search);

		echo json_encode([
			'draw' => intval($param['draw']),
			'recordsTotal' => count($total_count),
			'recordsFiltered' => count($total_count),
			'data' => $query
		]);
	}
}
