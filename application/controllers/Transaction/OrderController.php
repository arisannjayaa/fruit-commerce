<?php

defined('BASEPATH') or exit('No direct script access allowed');

class OrderController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->service('UserService', 'userService');
		$this->load->service('TransactionService', 'transactionService');
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

		return $this->transactionService->order_table();
	}

}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
