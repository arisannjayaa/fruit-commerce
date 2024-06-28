<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Model
{
	protected $table = 'transactions';
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

	public function findByUserId($user_id)
	{
		$builder = $this->db
			->select('*')
			->from('transactions t')
			->join('users u', 'u.id = t.user_id')
			->where('t.user_id', $user_id);

		return $builder->get();
	}

	public function findByUserOrderId($user_id, $order_id)
	{
		$select = "t.*,
				u.first_name,
				u.last_name,
				u.email,
				u.telephone,
				";

		$builder = $this->db
			->select($select)
			->from('transactions t')
			->join('users u', 'u.id = t.user_id')
			->where('t.user_id', $user_id)
			->where('t.order_id', $order_id);
		return $builder->get();
	}

    public function find($id)
    {
		$select = "t.*,
				u.first_name,
				u.last_name,
				u.email,
				u.telephone,
				";

		$builder = $this->db
			->select($select)
			->from('transactions t')
			->join('users u', 'u.id = t.user_id')
			->where('t.id', $id);

		return $builder->get();
    }

    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

	public function checkProduct($product_id, $user_id)
	{
		$select = "c.*,
				p.title,
				p.attachment,
				p.slug,
				p.description,
				p.stock,
				p.price";

		$builder = $this->db
			->select($select)
			->from('carts c')
			->join('products p', 'p.id = c.product_id')
			->where('c.user_id', $user_id)
			->where('c.product_id', $product_id);

		return $builder->get()->row();
	}

	public function table($keyword = null, $start = 0, $length = 0, $data = null)
	{
		$builder = $this->db->select("*")->from($this->table);

		if($keyword) {
			$arrKeyword = explode(" ", $keyword);
			for ($i=0; $i < count($arrKeyword); $i++) {
				$builder = $builder->or_like('order_id', $arrKeyword[$i]);
			}
		}

		if ($data) {
			if (isset($data['start']) && isset($data['end'])) {
				$builder = $builder->where('created_at >=', $data['start']);
				$builder = $builder->where('created_at <=', $data['end']);
			}

			if (isset($data['status'])) {
				$builder = $builder->where('status_code', $data['status']);
			}
		}

		if($start != 0 || $length != 0) {
			$builder = $builder->limit($length, $start);
		}

		return $builder->get()->result();
	}

	public function getReport($data = null)
	{
		$builder = $this->db->select("*, users.first_name as first_name, users.last_name as last_name")->from($this->table);
		$builder = $builder->join('users', 'users.id = transactions.user_id');

		if ($data) {
			if (isset($data['start']) && isset($data['end'])) {
				$builder = $builder->where('transactions.created_at >=', $data['start']);
				$builder = $builder->where('transactions.created_at <=', $data['end']);
			}

			if (isset($data['status'])) {
				$builder = $builder->where('transactions.status_code', $data['status']);
			}
		}

		return $builder->get()->result();
	}
}


/* End of file User_model.php and path \application\models\User_model.php */
