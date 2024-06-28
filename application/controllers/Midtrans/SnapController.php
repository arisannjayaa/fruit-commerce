<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SnapController extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-GrsQXs1BZ7HDGD210SYbm-Gl', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');
		$this->load->helper('custom');
		$this->load->service('TransactionService', 'transactionService');
		$this->load->model('Cart');
    }

    public function index()
    {
    	$this->load->view('checkout_snap');
    }

    public function token()
    {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$data = $this->Cart->findByUserId($this->auth->user()->id)->result();

		$arrProduct = [];
		foreach ($data as $item) {
			$arrProduct[] = ['id' => $item->product_id, 'price' => $item->price, 'quantity' => $item->quantity, 'name' => $item->title, 'user_id' => $item->user_id, 'description' => $item->description];
		}

		// Required
		$transaction_details = array(
		  'order_id' => genInvoice(),
		  'gross_amount' => $this->input->post('gross_amount'), // no decimal allowed for creditcard
		);

		$item_details = $arrProduct;

		// Optional
		$billing_address = array(
		  'first_name'    => "Andri",
		  'last_name'     => "Litani",
		  'address'       => "Mangga 20",
		  'city'          => "Jakarta",
		  'postal_code'   => "16602",
		  'phone'         => "081122334455",
		  'country_code'  => 'IDN'
		);

		// Optional
		$shipping_address = array(
		  'first_name'    => "Obet",
		  'last_name'     => "Supriadi",
		  'address'       => "Manggis 90",
		  'city'          => "Jakarta",
		  'postal_code'   => "16601",
		  'phone'         => "08113366345",
		  'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
		  'first_name'    => $this->auth->user()->first_name,
		  'last_name'     => $this->auth->user()->last_name,
		  'email'         => $this->auth->user()->email,
		  'phone'         => $this->auth->user()->telephone,
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O", $time),
            'unit' => 'hour',
            'duration'  => 24
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		$encoded_data = myEncrypt(json_encode($transaction_data));
		$this->session->set_userdata('captureRequest', $encoded_data);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }

    public function finish()
    {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$captureRequest = myDecrypt($this->session->userdata('captureRequest'));
		$captureResponse = $this->input->post('result_data');
		$decodeCaptureRequest = json_decode($captureRequest);
		$products = json_encode($decodeCaptureRequest->item_details);
    	$result = json_decode($captureResponse);
		$expired = expiredTime($decodeCaptureRequest->expiry->start_time);

		$data = array(
			'user_id' => $this->auth->user()->id,
			'order_id' => $result->order_id,
			'products' => $products,
			'gross_amount' => $result->gross_amount,
			'status_code' => $result->status_code,
			'payment_type' => $result->payment_type,
			'bank' => $result->va_numbers[0]->bank ?? null,
			'capture_payment_request' => $captureRequest,
			'capture_payment_response' => $captureResponse,
			'expired_time' => $expired
		);

		$this->transactionService->create($data, $result);
    }
}
