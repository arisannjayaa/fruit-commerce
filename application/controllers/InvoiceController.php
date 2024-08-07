<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->service('TransactionService', 'transactionService');
		$this->load->model('Transaction');
    }

	public function print($order_id)
	{
		$transaction = $this->Transaction->findByOrderId($order_id)->row();

		if ($transaction == null) {
			show_error("Sumber daya yang diminta tidak dapat ditemukan di server ini.", 404, "Halaman Tidak Ditemukan");
		}


		$data['transaction'] = $transaction;

		if ($this->auth->isMember()) {
			return view('invoice/outcoming', $data);
		}

		return view('invoice/incoming', $data);
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
