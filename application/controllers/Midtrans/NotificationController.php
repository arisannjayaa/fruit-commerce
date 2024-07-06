<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
class NotificationController extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-GrsQXs1BZ7HDGD210SYbm-Gl', 'production' => false);
		$this->load->library('veritrans');
		$this->load->model('Notification');
		$this->load->service('TransactionService', 'transactionService');
		$this->veritrans->config($params);
		$this->load->helper('url');
		
    }

	public function index()
	{
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

		if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
			error_log('Failed to decode JSON input');
			return;
		}

		if ($result) {
			$data = array(
				'status_code' => $result->status_code,
				'order_id' => $result->order_id,
				'capture_payment_response' => $result
			);

			return $this->transactionService->update($data);
		}
		
		echo json_encode(array("status" => false, "code" => 500, "message" => "Terjadi Kesalahan Server"));

		error_log(print_r($result, true));
	}
}
