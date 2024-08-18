<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model
{
	protected $table = 'products';
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all()
    {
		$builder = $this->db->select("*")->from($this->table);
		$builder = $builder->order_by('updated_at', 'desc');
        return $builder->get()->result();
    }

    public function find($id)
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

		$builder = $builder->order_by('updated_at', 'desc');

		return $builder->get()->result();
	}

	public function limit($limit)
	{
		$query = $this->db->select("*")->from($this->table);
		return $query->limit($limit)->get()->result();
	}

	public function findByCategoryId($category_id)
	{
		$query = $this->db->select("*")->from($this->table);

		if ($category_id == "") {
			return $query->get()->result();
		}

		$query->where('category_id', $category_id);
		return $query->get()->result();
	}

	public function findBySlug($slug)
	{
		$query = $this->db->select("*")->from($this->table);
		$query->where('slug', $slug);
		return $query->get()->row();
	}

	public function findAllByIsVariant($is_variant)
	{
		$query = $this->db->select("*")->from($this->table);
		$query->where('is_variant', 1);
		return $query->get()->result();
	}

	public function paginate($limit = null, $offset = null)
	{
		if (!$limit && !$offset) {
			$query = $this->db
				->select("*")
				->from($this->table)
				->order_by('created_at', 'desc');
		} else {
			$query = $this->db
				->select("*")
				->from($this->table)
				->order_by('created_at', 'desc')
				->limit($limit)
				->offset($offset)
				->order_by('created_at', 'desc');
		}

		return $query->get();
	}

	public function filter($data = null)
	{
		if ($data == null) {
			$query = $this->db
				->select("*")
				->from($this->table)
				->order_by('total_sold', 'desc');
		}

		if ($data) {
			$query = $this->db
				->select("*")
				->from($this->table);
			if (@$data['category']) {
				$query = $query
					->where_in('category_id', $data['category']);
			}

			if ($data['sort_by']) {
				if ($data['sort_by'] == "popular") {
					$query = $query->order_by('total_sold', 'desc');
				}
				if ($data['sort_by'] == "title_asc") {
					$query = $query->order_by('title', 'asc');
				}
				if ($data['sort_by'] == "title_desc") {
					$query = $query->order_by('title', 'desc');
				}
				if ($data['sort_by'] == "price_asc") {
					$query = $query->order_by('price', 'asc');
				}
				if ($data['sort_by'] == "price_desc") {
					$query = $query->order_by('price', 'desc');
				}
				if ($data['sort_by'] == "created_desc") {
					$query = $query->order_by('created_at', 'desc');
				}
				if ($data['sort_by'] == "created_asc") {
					$query = $query->order_by('created_at', 'asc');
				}
			}
		}

		return $query->get();
	}
}


/* End of file User_model.php and path \application\models\User_model.php */
