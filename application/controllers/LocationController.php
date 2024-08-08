<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LocationController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->service('LocationService', 'locationService');
    }

	public function checkDistance()
	{
		$latitudeFrom = $this->input->post('latitude');
		$longitudeFrom = $this->input->post('longitude');
		return $this->locationService->distance($latitudeFrom, $longitudeFrom);
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
