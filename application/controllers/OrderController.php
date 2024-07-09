<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->helper('custom');
		$this->load->model('Transaction');
		$this->load->model('Product');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(2);

		$transactions = $this->Transaction->findByUserId($this->auth->user()->id)->num_rows();

		$config['base_url'] = base_url('order-list');
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $transactions;
		$config['per_page'] = 10;

		$limit = $config['per_page'];
		$offset = html_escape($this->input->get('per_page'));

		$this->pagination->initialize($config);

		$data['transactions'] = $this->Transaction->paginate($this->auth->user()->id, $limit, $offset)->result();

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
