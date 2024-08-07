<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportService extends MY_Service{
	public function __construct() {
		$this->load->model('Transaction');
		$this->load->helper('custom');
	}

	public function export_report($data)
	{
		try {
			@$data['start'] = date('Y-m-d', strtotime($data['start'])).' 00:00:00';
			@$data['end'] = date('Y-m-d', strtotime($data['end'])).' 23:59:59';

			$transactions = $this->Transaction->getReport(@$data);

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$sheet->setCellValue('A1', 'LAPORAN');

			$sheet->mergeCells('A1:G1');

			$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(24);

			$sheet->setCellValue('A2', 'Tanggal: ' . formatDateId($data['start']) . ' - ' . formatDateId($data['end']));

			$sheet->mergeCells('A2:H2');

			$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('A2')->getFont()->setBold(false)->setSize(12);

			$sheet->setCellValue('A4', 'No');
			$sheet->setCellValue('B4', 'No.Invoice');
			$sheet->setCellValue('C4', 'Pelanggan');
			$sheet->setCellValue('D4', 'Tipe Pembayaran');
			$sheet->setCellValue('E4', 'Status Pembayaran');
			$sheet->setCellValue('F4', 'Bank');
			$sheet->setCellValue('G4', 'Tanggal Transaksi');
			$sheet->setCellValue('H4', 'Total Bayar');

			foreach (range('A', 'H') as $columnID) {
				$sheet->getColumnDimension($columnID)->setAutoSize(true);
			}

			$no = 1;
			$cell = 5;
			foreach ($transactions as $transaction) {
				$captureResponse = json_decode($transaction->capture_payment_response);
				$sheet->setCellValue('A' . $cell, $no);
				$sheet->setCellValue('B' . $cell, $transaction->order_id);
				$sheet->setCellValue('C' . $cell, $transaction->first_name . ' ' . $transaction->last_name);
				$sheet->setCellValue('D' . $cell, $transaction->payment_type);
				$sheet->setCellValue('E' . $cell, statusPayment($captureResponse->transaction_status));
				$sheet->setCellValue('F' . $cell, strtoupper($transaction->bank));
				$sheet->setCellValue('G' . $cell, formatDateId($transaction->created_at));
				$sheet->setCellValue('H' . $cell, $transaction->gross_amount);
				$no++;
				$cell++;
			}

			$fileName = "Report-" . date('Y-m-d') . ".xlsx";
			$writer = new Xlsx($spreadsheet);

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="' . $fileName . '"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
			exit;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
}
