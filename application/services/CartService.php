<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartService extends MY_Service{
	public function __construct() {
		$this->load->model('User');
		$this->load->model('Cart');
		$this->load->model('Product');
	}

	public function findByUserId($user_id)
	{
		try {
			$result = $this->Cart->findByUserId($user_id)->result();
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'data' => $result));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function delete($id)
	{
		try {
			$this->Cart->delete($id);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data cart berhasil dihapus"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function update($data)
	{
		try {
			$id = $data['id'];
			unset($data['id']);
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Cart->update($id, $data);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data cart berhasil diupdate"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}

	public function create($data)
	{
		try {
			$cartItem = $this->Cart->checkProduct($data['product_id'], $data['user_id']);
			$totalCart = $this->Cart->findByUserId($this->auth->user()->id)->result();
			$product = $this->Product->find($data['product_id']);

			if ($product->stock == 0) {
				$this->output->set_status_header(400);
				echo json_encode(array('success' => false, 'code' => 400, 'message' => "Stok produk sudah habis"));
				return;
			}

			if ($cartItem != null) {

				if ($cartItem->quantity >= $cartItem->stock) {
					$this->output->set_status_header(401);
					echo json_encode(array('success' => false, 'code' => 401, 'message' => "Data produk melebihi stock yang tersedia!"));
					return;
				}

				$id_update = $cartItem->id;
				$update = [
					'product_id' => $cartItem->product_id,
					'user_id' => $cartItem->user_id,
					'quantity' => $cartItem->quantity + 1
				];

				$this->Cart->update($id_update, $update);
				$this->output->set_status_header(200);
				echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data keranjang berhasil ditambahkan"));
				return;
			}

			if (count($totalCart) == 5) {
				$this->output->set_status_header(400);
				echo json_encode(array('status' => "OK", 'code' => 200, 'message' => "Tidak dapat menyimpan data keranjang lebih dari 5"));
				return;
			}

			$this->Cart->create($data);
			$this->output->set_status_header(200);
			echo json_encode(array('success' => true, 'code' => 200, 'message' => "Data keranjang berhasil ditambahkan"));
		} catch (Exception $exception) {
			show_error('Terjadi kesalahan', 500);
		}
	}
}
