<?php
class Admin_Model extends CI_Model {


	public function __construct() {
		parent::__construct();
	}	

	public function get_user_details(){
		$this->db->select('u.*,p.amount');
		$this->db->from('users u');
		$this->db->join('payment_table p', 'u.email = p.user_email_id','left');
		$qry = $this->db->get();
		return $qry->result();
	}

	public function details_update($userId, $data)
	{
		$this->db->where('id', $userId);
		$this->db->update('users', $data);
		return true;
	}

	public function delete_id($id)
	{
		$this->db->where('id', $id)->delete('users');
		return true;
	}		

	public function user_details($id){
		$this->db->select('u.*,p.amount');
		$this->db->from('users u');
		$this->db->join('payment_table p', 'u.email = p.user_email_id','left');
		$this->db->where('u.id', $id);
		$qry = $this->db->get();
		return $qry->row();
	}	

}

