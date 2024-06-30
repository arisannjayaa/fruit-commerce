<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CheckoutController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->helper('custom');
		$this->load->model('Cart');
		$this->load->model('Address');
		$this->load->service('CartService', 'cartService');
    }

    public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$this->auth->protect(2);

		$data['address'] = $this->Address->findByIsPrimary($this->auth->user()->id)->row();
		return view('home/checkout/index');
    }
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
