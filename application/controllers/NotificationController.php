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
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
