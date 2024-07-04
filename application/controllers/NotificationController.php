<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('Notification');
    }

	public function all()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);

		$this->output->set_status_header(200);
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->Notification->all()->result()));
	}

	public function read()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->auth->protect(1);


		$data = [
			'is_clicked' => $this->input->post('clicked')
		];

		$result = $this->Notification->read($this->input->post('id'), $data);

		if ($result == true) {
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "OK"));
			return;
		}

		$this->output->set_status_header(500);
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
