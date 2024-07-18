<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
class NotificationController extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-GrsQXs1BZ7HDGD210SYbm-Gl', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->model('Notification');
		$this->load->service('TransactionService', 'transactionService');
		$this->load->helper('url');
    }

	public function index()
	{
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

		$hash = hash("sha512", $result->order_id.$result->status_code.$result->gross_amount."SB-Mid-server-GrsQXs1BZ7HDGD210SYbm-Gl");
//		dd($hash == $result->signature_key);
		if ($hash == $result->signature_key) {
			$data = array(
				'status_code' => $result->status_code,
				'transaction_status' => $result->transaction_status,
				'order_id' => $result->order_id,
				'capture_payment_response' => $result
			);

			return $this->transactionService->update($data);
		}
		
		echo json_encode(array("status" => false, "code" => 500, "message" => "Terjadi Kesalahan Server"));

		error_log(print_r($result, true));
	}
}
