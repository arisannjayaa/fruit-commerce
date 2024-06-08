<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('Category');
		$this->load->model('Product');
		$this->load->helper('custom');
    }

    public function index()
    {
	$data['categories'] = $this->Category->limit(4);
	$data['products'] = $this->Product->limit(10);

	return view('home/index', $data);
    }

	public function shop()
	{
		if ($this->input->get('category') != null) {
			$data['category_id'] = $this->input->get('category');
		} else {
			$data['category_id'] = "";
		}

		$data['categories'] = $this->Category->limit(4);
		$data['products'] = $this->Product->findByCategoryId($data['category_id']);

		return view('home/shop', $data);
	}

	public function detail($slug)
	{
		$data['product'] = $this->Product->findBySlug($slug);

		if ($data['product'] == null) {
			return show_404();
		}

		return view('home/detail-product', $data);
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
