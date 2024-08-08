<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LocationService extends MY_Service{
	public function __construct() {
		$this->load->model('Address');
	}

	public function distance($latitudeFrom, $longitudeFrom)
	{
		$earthRadius = 6371;
		$latitudeTo = -8.7956767;
		$longitudeTo = 115.2128371;

		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
				cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

		$distance =  $angle * $earthRadius;
		$this->output->set_status_header(200);
		echo json_encode(array('status' => "OK", 'code' => 200, 'data' => $distance));
	}

	public function isLongDistanceRadius($latitudeFrom, $longitudeFrom)
	{
		$earthRadius = 6371;
		$latitudeTo = -8.7956767;
		$longitudeTo = 115.2128371;

		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
				cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

		$distance = $angle * $earthRadius;

		if ($distance > 20) {
			return true;
		}

		return false;
	}
}
