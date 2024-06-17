<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->helper('custom');
		$this->load->model('Transaction');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(2);
		$data['transactions'] = $this->Transaction->findByUserId($this->auth->user()->id)->result();
		return view('home/order-list', $data);
    }

	public function detail($order_id)
	{
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(2);

		$this->output->set_status_header(200);
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->Transaction->findByUserOrderId($this->auth->user()->id, $order_id)->row()));
		return;
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
