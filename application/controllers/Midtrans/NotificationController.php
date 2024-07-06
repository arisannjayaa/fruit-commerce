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
		}

		if ($result) {
			$data = array(
				'status_code' => $result->status_code,
				'order_id' => $result->order_id,
				'capture_payment_response' => $result
			);

			return $this->transactionService->update($data);
		}

		echo "error";

		error_log(print_r($result, true));
	}
}
