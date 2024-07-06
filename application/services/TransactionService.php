<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class TransactionService extends MY_Service{
	public function __construct() {
		$this->load->model('Cart');
		$this->load->model('Transaction');
		$this->load->model('Notification');
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
			$this->db->trans_begin();

			$orderId = $data['order_id'];
			$transaction = $this->Transaction->findByOrderId($orderId)->row();

			if (!$transaction) {
				$this->output->set_status_header(400);
				echo json_encode(array('success' => false, 'code' => 400, 'message' => "Terjadi Kesalahan"));
				$this->db->trans_commit();
				return;
			}

			$id = $transaction->id;
			unset($data['order_id']);

			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Transaction->update($id, $data);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data cart berhasil diupdate"));
			$this->db->trans_commit();
			return;
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function create($data, $result)
	{
		try {
			$this->db->trans_begin();
			$products = json_decode($data['products']);

			foreach ($products as $product) {
				$this->Cart->deleteByUserProduct($product->user_id, $product->id);
			}

			$this->Transaction->create($data);
			$this->output->set_status_header(200);
			$message = "";
			$status = "";

			switch ($result->transaction_status) {
				case "settlement":
					$status = "Berhasil";
					$message =  "Transaksi telah berhasil dan dana telah masuk ke rekening penjual (merchant).";
					break;
				case "pending":
					$status = "Pending";
					$message =  "Transaksi sedang menunggu proses lebih lanjut.";
					break;
				case "expire":
					$status = "Kedaluarsa";
					$message =  "Transaksi kadaluwarsa karena waktu yang diberikan untuk menyelesaikan pembayaran telah habis.";
					break;
				default:
					$status = "Ditolak";
					$message = " Transaksi ditolak atau gagal. ";
					break;
			}

			$this->Notification->create(array(
				'user_id' => $this->auth->user()->id,
				'title' => $this->auth->user()->first_name . ' Membeli ' . count($products) . ' Produk.',
				'message' => 'Pengguna atas nama ' . $this->auth->user()->first_name . ' melakukan transaksi. ' . $message,
				'url' => base_url('transaction/order')
			));

			$options = array(
				'cluster' => 'ap1',
				'useTLS' => true
			);

			$pusher = new Pusher\Pusher(
				'127db0c2612c670ab73d',
				'00310ca89193537c89b1',
				'1828273',
				$options
			);

			$dataPusher['message'] = 'OK';
			$pusher->trigger('my-channel', 'my-event', $dataPusher);
			$invoice = myEncrypt($data['order_id']);

			echo json_encode(array('success' => true, 'code' => 200, 'message' => $message, 'redirect' => base_url('payment/' . $invoice)));
			$this->db->trans_commit();
			return;
		} catch (Exception $exception) {
			$this->db->trans_rollback();
			show_error('Terjadi kesalahan', 500);
			return;
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
