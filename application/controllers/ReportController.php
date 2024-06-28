<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->service('TransactionService', 'transactionService');
		$this->load->service('ExportService', 'exportService');
		$this->load->helper('custom');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(1);

		return view('report/index');
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

		if(@$this->input->get('status') != "") {
			$data['status'] = $this->input->get('status');
		}

		return $this->transactionService->table($data);
	}

	public function export()
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(1);

		if(@$this->input->get('date_start') != "") {
			@$data['start'] = $this->input->get('date_start');
		}

		if(@$this->input->get('date_end') != "") {
			@$data['end'] = $this->input->get('date_end');
		}

		if(@$this->input->get('status') != "") {
			@$data['status'] = $this->input->get('status');
		}

		$this->exportService->export_report(@$data);
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
