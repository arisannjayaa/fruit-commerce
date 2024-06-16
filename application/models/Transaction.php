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
        $query = $this->db->get_where($this->table, ['id' => $id]);
        return $query->row();
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

	public function datatable($keyword = null, $start = 0, $length = 0)
	{
		$builder = $this->db->select("*")->from($this->table);

		if($keyword) {
			$arrKeyword = explode(" ", $keyword);
			for ($i=0; $i < count($arrKeyword); $i++) {
				$builder = $builder->or_like('title', $arrKeyword[$i]);
			}
		}

		if($start != 0 || $length != 0) {
			$builder = $builder->limit($length, $start);
		}

		return $builder->get()->result();
	}

	public function findBySlug($slug)
	{
		$query = $this->db->select("*")->from($this->table);
		$query->where('slug', $slug);
		return $query->get()->row();
	}
}


/* End of file User_model.php and path \application\models\User_model.php */
