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
}


/* End of file User_model.php and path \application\models\User_model.php */
