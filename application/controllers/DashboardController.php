<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('User');
		$this->load->model('Transaction');
		$this->load->model('Product');
		$this->load->model('Category');
		$this->load->model('Notification');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(1);

		$data['users'] = $this->User->all();
		$data['categories'] = $this->Category->all();
		$data['transactions'] = $this->Transaction->all();
		$data['products'] = $this->Product->all();
		$data['notifications'] = $this->Notification->all()->result();

		return view('dashboard', $data);
    }
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
