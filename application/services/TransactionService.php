<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class TransactionService extends MY_Service{
	public function __construct() {
		$this->load->model('Cart');
		$this->load->model('Product');
		$this->load->model('Transaction');
		$this->load->helper('custom');
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

	public function update($data)
	{
		$this->db->trans_begin();
		try {
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

			if ($data['capture_payment_response']->transaction_status == 'settlement'){
				$title = 'Transaksi Pembayaran berhasil';
				$message = "Transaksi invoice: " . $data['capture_payment_response']->order_id ." berhasil ditransfer menggunakan" . paymentMethod($data['capture_payment_response']->payment_type);
				$products = json_decode($transaction->products);

				foreach ($products as $product) {
					$findProduct = $this->Product->find($product->id);
					$dataProduct = array(
						'stock' => 	$findProduct->stock - $product->quantity
					);
					$this->Product->update($product->id, $dataProduct);
				}

			}
			else if($data['capture_payment_response']->transaction_status == 'pending'){
				$title = 'Transaksi Pembayaran tertunda';
				$message = "Menunggu pelanggan menyelesaikan transaksi invoice:" . $data['capture_payment_response']->order_id . " menggunakan " . paymentMethod($data['capture_payment_response']->payment_type);
			}
			else if ($data['capture_payment_response']->transaction_status == 'deny') {
				$title = 'Transaksi Pembayaran ditolak';
				$message = "Pembayaran menggunakan " . paymentMethod($data['capture_payment_response']->payment_type) . " untuk transaksi invoice: " . $data['capture_payment_response']->order_id . " ditolak";
			}
			else {
				$title = 'Transaksi Pembayaran kadaluarsa';
				$message = "Pembayaran menggunakan " . paymentMethod($data['capture_payment_response']->payment_type) . " untuk transaksi invoice: " . $data['capture_payment_response']->order_id . " kadaluarsa";
			}

			$data['updated_at'] = date('Y-m-d H:i:s');
			$data['capture_payment_response'] = json_encode($data['capture_payment_response']);

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

			$this->Notification->create(array(
				'user_id' => $transaction->user_id,
				'title' => $title,
				'message' => $message,
				'url' => base_url('transaction/order')
			));

			$this->Transaction->update($id, $data);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data cart berhasil diupdate"));
			$this->db->trans_commit();
			return;
		} catch (Exception $exception) {
			$this->db->trans_rollback();
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function create($data, $result)
	{
		$this->db->trans_begin();
		try {
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

			echo json_encode(array('success' => true, 'code' => 200, 'message' => $message, 'redirect' => base_url('payment/' . $data['order_id'])));
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
		$data['search'] = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
		$query = $this->Transaction->table($data, $start, $length);
		$total_count = $this->Transaction->table($data);

		echo json_encode([
			'draw' => intval($param['draw']),
			'recordsTotal' => count($total_count),
			'recordsFiltered' => count($total_count),
			'data' => $query
		]);
	}

	public function redirectTransactionStatus($transaction_status, $data)
	{
		switch ($transaction_status) {
			case "settlement":
				return view('home/payment/settlement', $data);
				break;
			case "pending":
				return view('home/payment/pending', $data);
				break;
			case "expire":
				return view('home/payment/expire', $data);
				break;
			default:
				return view('home/payment/deny', $data);
				break;
		}
	}

	public function cancel($order_id)
	{
		try {
			$serverKey = 'SB-Mid-server-GrsQXs1BZ7HDGD210SYbm-Gl';

			$client = new \GuzzleHttp\Client();

			$response = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/'.$order_id.'/cancel', [
				'headers' => [
					'accept' => 'application/json',
					'authorization' => 'Basic ' . base64_encode($serverKey),
				],
			]);

			$result =  $response->getBody()->getContents();
			return $result;
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
			return;
		}

	}

	public function checkProduct($products)
	{
		foreach ($products as $product) {
			$find = $this->Product->find($product->id);
			if ($find->stock == 0) {
				return false;
			}

			if ($find->stock < $product->quantity) {
				return false;
			}
		}

		return true;
	}
}
