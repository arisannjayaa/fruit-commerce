<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model
{
	protected $table = 'users';
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

	public function findByEmail($email)
	{
		return $this->db->get_where($this->table, ['email' => $email])->row_array();
	}

	public function datatable($keyword = null, $start = 0, $length = 0)
	{
		$builder = $this->db->select("*")->from($this->table);

		$builder = $builder->where('role_id', 2);
		if($keyword) {
			$arrKeyword = explode(" ", $keyword);
			for ($i=0; $i < count($arrKeyword); $i++) {
				$builder = $builder->or_like('username', $arrKeyword[$i]);
				$builder = $builder->or_like('email', $arrKeyword[$i]);
				$builder = $builder->or_like('role_id', $arrKeyword[$i]);
			}
		}

		if($start != 0 || $length != 0) {
			$builder = $builder->limit($length, $start);
		}

		return $builder->get()->result();
	}
}


/* End of file User_model.php and path \application\models\User_model.php */
