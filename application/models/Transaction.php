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
			->order_by('t.created_at', 'desc');

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

	public function findByOrderId($order_id)
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
			->where('t.order_id', $order_id);
		return $builder->get();
	}

	public function findByTransactionStatus($transaction_status)
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
			->where('t.transaction_status', $transaction_status);
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

	public function updateByOrderId($id, $data)
	{
		$this->db->where('order_id', $id);
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

	public function table($data = null, $start = 0, $length = 0)
	{
		$builder = $this->db->select("*")->from($this->table);

		if($data['search']) {
			$arrKeyword = explode(" ", $data['search']);
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
				$builder = $builder->where('transaction_status', $data['status']);
			}
		}

		if($start != 0 || $length != 0) {
			$builder = $builder->limit($length, $start);
		}

		$builder = $builder->order_by('created_at', 'desc');

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

	public function paginate($user_id, $limit = null, $offset = null)
	{
		$select = "t.*,
				u.first_name,
				u.last_name,
				u.email,
				u.telephone,
				";

		if (!$limit && !$offset) {
			$query = $this->db
				->select($select)
				->from('transactions t')
				->join('users u', 'u.id = t.user_id')
				->where('t.user_id', $user_id)
				->order_by('created_at', 'desc');
		} else {
			$query = $this->db
				->select($select)
				->from('transactions t')
				->join('users u', 'u.id = t.user_id')
				->where('t.user_id', $user_id)
				->limit($limit)
				->offset($offset)
				->order_by('created_at', 'desc');
		}

		return $query->get();
	}
}


/* End of file User_model.php and path \application\models\User_model.php */
