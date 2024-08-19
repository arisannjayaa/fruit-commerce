<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Model
{
	protected $table = 'carts';
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
		$select = "c.*,
				p.title,
				p.attachment,
				p.slug,
				p.description,
				p.stock,
				p.price,
				p.is_variant,
				pv.id as variant_id,
				pv.stock as variant_stock,
				pv.price as variant_price,
				pv.name as variant_name";

		$builder = $this->db
			->select($select)
			->from('carts c')
			->join('products p', 'p.id = c.product_id', 'left')
			->join('product_variants pv', 'pv.id = c.product_variant_id', 'left')
			->where('c.user_id', $user_id);

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

	public function deleteByUserProduct($user_id, $product_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('product_id', $product_id);
		return $this->db->delete($this->table);
	}

	public function checkProduct($data)
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
			->where('c.user_id', $data['user_id'])
			->where('c.product_id', $data['product_id']);

		return $builder->get()->row();
	}

	public function checkProductIsVariant($data)
	{
		$select = "c.*,
				p.title,
				p.attachment,
				p.slug,
				p.description,
				pv.stock,
				p.price,
				pv.name as variant_name";

		$builder = $this->db
			->select($select)
			->from('carts c')
			->join('products p', 'p.id = c.product_id', 'left')
			->join('product_variants pv', 'pv.id = c.product_variant_id', 'left')
			->where('c.user_id', $data['user_id'])
			->where('c.product_id', $data['product_id'])
			->where('c.product_variant_id', $data['product_variant_id']);

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
