<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductVariantService extends MY_Service{
	public function __construct() {
		$this->load->model('ProductVariant');
		$this->load->model('Product');
	}

	public function table()
	{
		$param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
		$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
		$length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
		$search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
		$data = $this->ProductVariant->datatable($search, $start, $length);
		$total_count = $this->ProductVariant->datatable($search);

		echo json_encode([
			'draw' => intval($param['draw']),
			'recordsTotal' => count($total_count),
			'recordsFiltered' => count($total_count),
			'data' => $data
		]);
	}

	public function create($data)
	{
		try {
			$this->output->set_status_header(200);

			$this->ProductVariant->create($data);
			$this->changeDataProduct($data, true);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data varian produk berhasil ditambahkan"));
			return;
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function update($data)
	{
		try {
			$id = $data['id'];
			unset($data['id']);
			$this->output->set_status_header(200);
			$this->ProductVariant->update($id, $data);
			$this->changeDataProduct($data, false);
			echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Data varian produk berhasil diupdate"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function delete($id)
	{
		try {
			$productVariant = $this->ProductVariant->find($id);
			$this->ProductVariant->delete($productVariant->id);
			$this->changeDataProduct(get_object_vars($productVariant), false);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data varian produk berhasil dihapus"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function changeDataProduct($data_product, $is_created = true)
	{
		try {
			if ($is_created) {
				$product = $this->Product->find($data_product['product_id']);
				$data['price'] = $data_product['price'];
				$data['stock'] = $product->stock + $data_product['stock'];
			} else {
				$productVariant = $this->ProductVariant->findAllByProductId($data_product['product_id']);
				$totalStock = 0;

				foreach ($productVariant as $variant) {
					$totalStock += $variant->stock;
				}


				$data['price'] = $data_product['price'];
				$data['stock'] = $totalStock;

				if (count($productVariant) == 0 ) {
					$data['price'] = 0;
				}
			}

			$this->Product->update($data_product['product_id'], $data);
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}
}
