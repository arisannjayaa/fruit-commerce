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

		$this->auth->protect(1);

		return view('order/index');
	}

	public function table()
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);

		if(@$this->input->get('date_start') != "") {
			$data['start'] = $this->input->get('date_start');
		}

		if(@$this->input->get('date_end') != "") {
			$data['end'] = $this->input->get('date_end');
		}

		return $this->transactionService->table($data);
	}

	public function detail($id)
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);

		$this->output->set_status_header(200);
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->Transaction->find($id)->row()));
	}

}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
