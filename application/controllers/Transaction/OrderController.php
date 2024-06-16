<?php

defined('BASEPATH') or exit('No direct script access allowed');

class OrderController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->service('UserService', 'userService');
		$this->load->service('TransactionService', 'transactionService');
		$this->load->model('Transaction');
	}

	public function index()
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		return view('order/index');
	}

	public function table()
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		if(@$this->input->get('date_start') != "") {
			$data['start'] = $this->input->get('date_start');
		}

		if(@$this->input->get('date_start') != "") {
			$data['end'] = $this->input->get('date_end');
		}

		return $this->transactionService->order_table($data);
	}

	public function detail($id)
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$this->output->set_status_header(200);
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->Transaction->find($id)->row()));
	}

}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
