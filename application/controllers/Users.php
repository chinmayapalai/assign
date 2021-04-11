<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function _construct()
	{
	    parent::__construct();
	   	$this->load->library('form_validation'); 
	   	
	   	
	   	
	}

	function getusernameFromemail($email) {
		$find = '@';
		$pos = strpos($email, $find);
		$username = substr($email, 0, $pos);
		return $username;
	}

	public function register()
	{
		$this->load->model('User_Model');
		$this->load->library('ciqrcode');		
		$this->load->library('email');

		$rules = array(
		    array(
		            'field' => 'user_name',
		            'label' => 'Username',
		            'rules' => 'required'
		    ),        
		    array(
		            'field' => 'user_email',
		            'label' => 'Email Address',
		            'rules' => 'required|valid_email'
		    ),
		    array(
		            'field' => 'mobile',
		            'label' => 'Mobile No',
		            'rules' => 'required|regex_match[/^[0-9]{10}$/]'
		    )
		);

		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run()) {

			if(!empty($_FILES['file_attach']['name'])) {
			$file_name = $_FILES['file_attach']['name'];
			$file_size = $_FILES['file_attach']['size']; 
			$tmp_file = $_FILES['file_attach']['tmp_name'];
			
			$targetPath = 'assets/attachments/' . $file_name;
				if (move_uploaded_file($tmp_file, $targetPath)) {
						$attachment = $file_name;
				} 
			} else {
				$attachment = 'NULL';
			}
			$username = $this->input->post('user_name');
			$email = $this->input->post('user_email');
			$mobile = $this->input->post('mobile');

			//qrcode
			$qr_img = $this->getusernameFromemail($email).'.png';
			$param['data'] = $email;
			$param['level'] = '60';
			$param['size'] = 'L';
			$param['savename'] = "assets/qrcodes/".$qr_img;
			$this->ciqrcode->generate($param);

			$data = ['username' => $username ,
					 'email' => $email,
					 'phone' => $mobile,
					 'file' => $attachment,
					 'qrcode' => $qr_img,
					 'created_date' => date('Y-m-d H:i:s')
					];

			 

			$insert_user = $this->User_Model->insert_data($data);
				if($insert_user){

	            	$this->session->set_userdata('name', $this->input->post('user_name'));
	            	$this->session->set_userdata('email', $this->input->post('user_email'));

	            	//for send email
	            	$to =  $email;
	            	$subject = 'Welcome To Zikrabyte Solutions';
	            	$from = 'chinmayapalai01@gmail.com';

	            	$emailContent = '<!DOCTYPE><html><head></head><body><table width="600px" style="border:1px solid #cccccc;margin: auto;border-spacing:0;"><tr><td style="background:#000000;padding-left:3%"><h3 width="300px" vspace=10 />Zikrabyte Solution</h3></td></tr>';
    				$emailContent .='<tr><td style="height:20px"></td></tr>';
    				$emailContent .='<label>Name</label>';
    				$emailContent .= $this->input->post('user_name');
    				$emailContent .='<label>Email</label>';
    				$emailContent .= $this->input->post('user_email');

    				$emailContent .='<tr><td style="height:20px"></td></tr>';
    				$emailContent .= "<tr><td style='background:#000000;color: #999999;padding: 2%;text-align: center;font-size: 13px;'><p style='margin-top:1px;'><a href='https://www.zikrabyte.com' target='_blank' style='text-decoration:none;color: #60d2ff;'>www.zikrabyte.com</a></p></td></tr></table></body></html>";

    				$config['protocol']    = 'smtp';
				    $config['smtp_host']    = 'ssl://smtp.gmail.com';
				    $config['smtp_port']    = '465';
				    $config['smtp_timeout'] = '60';

				    $config['smtp_user']    = 'chinmayapalai01@gmail.com'; 
				    $config['smtp_pass']    = 'XXXXX';

				    $config['charset']    = 'utf-8';
				    $config['newline']    = "\r\n";
				    $config['mailtype'] = 'html'; // or html
				    $config['validation'] = TRUE;

				    $this->email->initialize($config);
				    $this->email->set_mailtype("html");
				    $this->email->from($from);
				    $this->email->to($to);
				    $this->email->subject($subject);
				    $this->email->message($emailContent);
				    $this->email->send();
	
					redirect("users/payment");			
				}

			} else {
				echo "failed";
			}
	}

	public function index()
	{	

		$this->load->view('register');
	}

	public function successfull_page(){

		$this->load->view('successfull_page');
	}

	public function payment()
	{			
		$this->load->view('payment_gateway');
	}	

	public function paid_amount()
	{
		if(!$this->input->is_ajax_request()){
			exit('No direct script access allowed');
		} else {
			$this->load->model('User_Model');
			$email = $this->input->post('email');
			$amount = $this->input->post('amount');

			$data=['user_email_id' => $email, 'amount' => $amount, 'created_date' => date('Y-m-d H:i:s')];
			$insert_payment = $this->User_Model->insert_payment($data);
			if($insert_payment){
				echo "Success"; exit;
			}
		}
	}	
}
