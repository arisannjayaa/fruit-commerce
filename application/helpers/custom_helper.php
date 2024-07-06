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

function myEncrypt($data)
{
	$passphrase = '__@#bukanHanyaManusiacampAh';
	$cipher = "AES-256-CBC";
	$secreet_iv = 'thisTodTeli@#MinorHasTag$&=KlTy!';
	$key = hash('sha256', $passphrase);
	$iv = substr(hash('sha256',$secreet_iv), 0, 16);
	$options = 0;

	$ciphertext = openssl_encrypt($data, $cipher, $key, $options, $iv);

	return rtrim(base64_encode($ciphertext), '=');
}

function myDecrypt($data)
{
	$passphrase = '__@#bukanHanyaManusiacampAh';
	$cipher = "AES-256-CBC";
	$secreet_iv = 'thisTodTeli@#MinorHasTag$&=KlTy!';
	$key = hash('sha256', $passphrase);
	$iv = substr(hash('sha256',$secreet_iv), 0, 16);
	$options = 0;

	$decode = openssl_decrypt(base64_decode($data), $cipher, $key, $options, $iv);

	return $decode ? $decode : 'Wrong Data';
}

function expiredTime($init_time)
{
	$expiration_time = strtotime($init_time . ' +24 hours');
	$formatted_expiration_time = date('Y-m-d H:i:s O', $expiration_time);
	return $formatted_expiration_time;
}

function trimString($text, $max) {
	if (strlen($text) > $max) {
		$trimText = substr($text, 0, $max);
		return $trimText . '...';
	} else {
		return $text;
	}
}

function statusPayment($status)
{
	switch ($status) {
		case "settlement":
			$string = "Berhasil";
			break;
		case "pending":
			$string = "Pending";
			break;
		case "expire":
			$string = "Kedaluarsa";
			break;
		default:
			$string = "Ditolak";
			break;
	}

	return $string;
}

function badgeStatusPayment($status)
{
	switch ($status) {
		case "settlement":
			$badge = "bg-success";
			break;
		case "pending":
			$badge = "bg-warning";
			break;
		case "expire":
			$badge = "bg-danger";
			break;
		default:
			$badge = "bg-danger";
			break;
	}

	return $badge;
}

function paymentMethod($payment_method)
{
	switch ($payment_method) {
		case "bank_transfer":
			$method = "Bank Transfer";
			break;
		default:
			$method = "Manual";
			break;
	}

	return $method;
}
