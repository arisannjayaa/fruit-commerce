<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function slug($string, $spaceRepl = "-")
{
	$string = str_replace("&", "and", $string);
	$string = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);
	$string = strtolower($string);
	$string = preg_replace("/[ ]+/", " ", $string);
	$string = str_replace(" ", $spaceRepl, $string);
	return $string;
}

function formatToRupiah($amount) {
	$formatted_amount = number_format($amount, 0, ',', '.');
	return "Rp. " . $formatted_amount;
}

function genInvoice ($limit = 11) {
	return 'HR'.date('y').'-'.strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit));
}

function uid($limit = 9)
{
	return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
}

function formatDateId($date)
{
	$formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::NONE);

	$timestamp = strtotime($date);
	$formattedDate = $formatter->format($timestamp);

	return $formattedDate;
}
