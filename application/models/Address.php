<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Address extends CI_Model
{
	protected $table = 'addresses';
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
			->select('a.*')
			->from('addresses a')
			->join('users u', 'u.id = a.user_id')
			->where('a.user_id', $user_id);

		return $builder->get();
	}

	public function findByIsPrimary($user_id)
	{
		$builder = $this->db
			->select('a.*')
			->from('addresses a')
			->join('users u', 'u.id = a.user_id')
			->where('a.user_id', $user_id)
			->where('a.is_primary', 1);

		return $builder->get();
	}

    public function find($id)
    {
		$select = "a.*,
				u.first_name,
				u.last_name,
				u.email,
				u.telephone,
				";

		$builder = $this->db
			->select($select)
			->from('addresses a')
			->join('users u', 'u.id = a.user_id')
			->where('a.id', $id);

		return $builder->get();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
		return $this->db->insert_id();
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

	public function getCountRow($user_id)
	{
		$this->db->from($this->table);
		$this->db->where('user_id', $user_id);
		return $this->db->count_all_results();
	}

	public function setPrimaryAddress($id)
	{
		$this->db->set('is_primary', 'false');
		$this->db->where('id !=', $id);
		$this->db->update($this->table);
	}

	public function setPrimaryAfterDelete()
	{
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0) {
			$query = $query->result();
			$this->db->set('is_primary', 1);
			$this->db->where('id', $query[0]->id);
			$this->db->update($this->table);
		}
	}
}


/* End of file User_model.php and path \application\models\User_model.php */
