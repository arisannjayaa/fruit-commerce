<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
class NotificationController extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-GrsQXs1BZ7HDGD210SYbm-Gl', 'production' => false);
		$this->load->library('veritrans');
		$this->load->model('Notification');
		$this->veritrans->config($params);
		$this->load->helper('url');
		
    }

	public function index()
	{
		// Output untuk memastikan handler dipanggil
		echo 'test notification handler';

		// Mendapatkan JSON input dari Midtrans
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

		// Memeriksa apakah dekoding JSON berhasil
		if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
			error_log('Failed to decode JSON input');
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
				'user_id' => 2,
				'title' => "Error",
				'message' => 'Terjadi error pada json',
				'url' => base_url('')
			));
			return;
		}

		// Memanggil veritrans untuk mendapatkan status transaksi
		$mid = $this->veritrans->status($result->order_id);

		// Memeriksa jika status transaksi adalah "settlement"
		if ($mid && $mid->transaction_status == "settlement") {
			// Persiapkan data yang akan diupdate
			$data = array(
				'status_code' => $mid->status_code,
				'order_id' => $mid->order_id,
				'capture_payment_response' => json_encode($mid) // Ubah menjadi JSON string jika diperlukan
			);

			// Panggil model untuk melakukan update data transaksi
			$this->load->model('Transaction_model', 'Transaction');
			$this->Transaction->update($data);
		}

		// Logging untuk memeriksa hasil dari input JSON
		error_log(print_r($result, true));

		//notification handler sample

		/*
		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		if ($transaction == 'capture') {
		  // For credit card transaction, we need to check whether transaction is challenge by FDS or not
		  if ($type == 'credit_card'){
		    if($fraud == 'challenge'){
		      // TODO set payment status in merchant's database to 'Challenge by FDS'
		      // TODO merchant should decide whether this transaction is authorized or not in MAP
		      echo "Transaction order_id: " . $order_id ." is challenged by FDS";
		      }
		      else {
		      // TODO set payment status in merchant's database to 'Success'
		      echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
		      }
		    }
		  }
		else if ($transaction == 'settlement'){
		  // TODO set payment status in merchant's database to 'Settlement'
		  echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
		  }
		  else if($transaction == 'pending'){
		  // TODO set payment status in merchant's database to 'Pending'
		  echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
		  }
		  else if ($transaction == 'deny') {
		  // TODO set payment status in merchant's database to 'Denied'
		  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
		}*/

	}
}
