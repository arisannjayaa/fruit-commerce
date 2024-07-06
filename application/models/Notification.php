<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Model
{
	protected $table = 'notifications';
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function all()
	{
		$query = $this->db->select("*")->from($this->table);
		$query = $query->where('is_clicked', 0);
		$query = $query->order_by('updated_at', 'desc');
		return $query->get();
	}

	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function read($id, $data)
	{
		$query = $this->db->where('id', $id);
		$query = $query->update($this->table, $data);
		return $query;
	}
}


/* End of file User_model.php and path \application\models\User_model.php */
