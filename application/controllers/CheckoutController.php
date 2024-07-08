<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CheckoutController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->helper('custom');
		$this->load->model('Cart');
		$this->load->model('Address');
		$this->load->model('Transaction');
		$this->load->service('CartService', 'cartService');
		$this->load->service('TransactionService', 'transactionService');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(2);

		$data['address'] = $this->Address->findByIsPrimary($this->auth->user()->id)->row();
		$data['carts'] = $this->Cart->findByUserId($this->auth->user()->id)->result();

		if (count($data['carts']) == 0) {
			redirect(base_url('cart'));
		}

		return view('home/checkout/index', $data);
    }

	public function payment($order_id)
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(2);

		$transaction = $this->Transaction->findByUserOrderId($this->auth->user()->id, $order_id)->row();

		if (!$transaction) {
			show_error("Sumber daya yang diminta tidak dapat ditemukan di server ini.", 404, "Halaman Tidak Ditemukan");
		}

		$paymentResponse = json_decode($transaction->capture_payment_response);
		$data['transaction'] = $transaction;

		return $this->transactionService->redirectTransactionStatus($paymentResponse->transaction_status, $data);

	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
