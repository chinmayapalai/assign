<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function _construct()
	{
	    parent::__construct();
	   	$this->load->library('form_validation');    	
	   	
	}
	
	public function index()
	{
		$this->load->view('admin/login');
	}

	public function checkuser(){
		if(!$this->input->is_ajax_request()){
			exit('No direct script access allowed');
		} else {
			$this->load->model('User_Model');
			$email = $this->input->post('email');
			$pass = $this->input->post('password');

			$checkuser = $this->User_Model->is_loggedin($email);
			if(md5($pass) == $checkuser->password){
				echo "Login Successfully"; exit;

			} else {
				echo "fail to login"; exit;
			}

		}
	}

	public function dashboard(){
		$this->load->model('Admin_Model', 'admin');
		$data['details'] = $this->admin->get_user_details();

		$this->load->view('admin/admin_dasboard', $data);
	}

	public function customer_details_edit()
	{
		if(!$this->input->is_ajax_request()){
			exit('No direct script access allowed');
		} else {
			$this->load->model('Admin_Model', 'admin');
			$userId = $this->input->post('id');
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');

			$data = ['username' => $name,
					 'email' => $email,
					 'phone' =>$phone];
			$update = $this->admin->details_update($userId, $data);
			if($update){
				echo 'Details updated successfully !!';exit;
			} else {
				echo "Failed to update !!"; exit;
			}
		}
	}

	public function delete_id()
	{
		if(!$this->input->is_ajax_request()){
			exit('No direct script access allowed');
		} else {
			$this->load->model('Admin_Model', 'admin');
			$userId = $this->input->post('user_id');
			$delete = $this->admin->delete_id($userId);
			if($delete){
				echo "Successfully Delete !!";
			}
		}
	}

	public function download($id){
		$this->load->model('Admin_Model', 'admin');
		$line = $this->admin->user_details($id);

		$filename = 'Details_'.$id.'.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/csv; ");

		// file creation
		$file = fopen('php://output', 'w');

		$header = array("Name","Email","Phone No","Amount","Created Date");
		fputcsv($file, $header);
		fputcsv($file,array($line->username,$line->email,$line->phone,$line->amount, date('Y-m-d', strtotime($line->created_date))));
		

		fclose($file);
		exit;
	}

	
}
