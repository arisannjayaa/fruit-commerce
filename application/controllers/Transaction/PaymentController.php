<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PaymentController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->service('UserService', 'userService');
		$this->load->service('TransactionService', 'transactionService');
		$this->load->model('Transaction');
	}

	/**
	 * view html
	 * @return string
	 */
	public function index()
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(1);

		return view('payment/index');
	}
}
