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
				$this->Cart->deleteByUserProduct($product->user_id, $product->product_id);
			}

			$this->Transaction->create($data);
			$this->output->set_status_header(200);
			$message = "";

			switch ($result->transaction_status) {
				case "settlement":
					$message =  "Transaksi sudah diterima dan pembayaran sudah dilakukan.";
					break;
				case "pending":
					$message =  "Transaksi sudah diterima dan pembayaran masih tertunda, harap melakukan pembayaran secepatnya.";
					break;
				default:
					$message = "Hari tidak dikenali.";
					break;
			}

			echo json_encode(array('success' => true, 'code' => 200, 'message' => $message));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}
}
