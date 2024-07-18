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
		$this->load->service('ProductService', 'productService');
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

	public function cancel()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(2);
		$order_id = $this->input->post('order_id');

		$result = json_decode($this->transactionService->cancel($order_id));

		if ($result->status_code == "200") {
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Berhasil membatalkan pesanan"));
			$this->Transaction->updateByOrderId($order_id, ['transaction_status' => 'cancel','capture_payment_response' => json_encode($result)]);
			return;
		}

		$this->output->set_status_header(400);
		echo json_encode(array('success' => false, 'code' => 400, 'message' => "Terjadi Kesalahan Server"));
		return;
	}

	public function check()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(2);
		$order_id = $this->input->post('order_id');

		$transaction = $this->Transaction->findByOrderId($order_id)->row();

		$products = json_decode($transaction->products);

		if ($this->transactionService->checkProduct($products) == false) {
			$result = json_decode($this->transactionService->cancel($order_id));

			if ($result->status_code == "200") {
				$this->output->set_status_header(200);
				echo json_encode(array('success' => true, 'code' => 200, 'message' => "Berhasil membatalkan pesanan"));
				$this->Transaction->updateByOrderId($order_id, ['capture_payment_response' => json_encode($result)]);
				return;
			}
		}

		$this->output->set_status_header(400);
		echo json_encode(array('success' => false, 'code' => 400, 'message' => "Terjadi Kesalahan Server"));
		return;
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
