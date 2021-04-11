<?php
class User_Model extends CI_Model {


	public function __construct() {
		parent::__construct();
	}

	public function insert_data($data)
	{
		$this->db->insert('users', $data);	
		return true;
	}

	public function insert_payment($data)
	{
		$this->db->insert('payment_table', $data);	
		return true;
	}

	public function is_loggedin($email){
		//$condition = "(email = '$email' AND BINARY(password => '$password'))";
		$qry = $this->db->select('*')->from('admin')->where('email',$email)->limit(1)->get();
		if($qry->num_rows() > 0){
			return $qry->row();
		} else {
			return false;
		}
	}		

}

