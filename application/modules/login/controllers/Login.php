<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {

		//CONFIG VARIABLE
		private $urlparent = 'login'; //NAME TABLE 
		private $identity_id = 'id'; //IDENTITY TABLE
		private $field = 'id'; // IDENTITY FROM NAME FOR GET ID
		private $slug_indentity = 'perusahaan_nama'; //NAME FIELD 
		private $sorting = 'modified'; // SORT FOR VIEW
		private $exclude = array('perusahaan_cp','perusahaan_alamat_cabang','perusahaan_file','created','modified','createdid','modifiedid','id','active','slug');
		private $exclude_table = array('perusahaan_cp','perusahaan_alamat_cabang','perusahaan_file','created','modified','createdid','modifiedid','id','active','slug');
		private $site_key = '6LfazkgqAAAAAEViHq8aUXY3SbL-OjTmdZd7GX8J'; // change this to yours
		private $secret_key = '6LfazkgqAAAAAK3iqGH_51lXXWnwKU58aNdmor-_'; // change this to yours
		//END CONFIG VARIABLE
		
		private $viewname;
		private $viewformname;
		private $viewformnameregister;
		private $tabledb;
		private $tableid;
		private $titlechilddb;
		private $headurldb;
		private $actionurl;
		private $actionurl_register;
		private $module;
		private $modeldb;
		
		
		public function __construct()
		{
			$this->tabledb = 'data_perusahaan_register';
			$this->tableid = $this->tabledb.'.id';
			$this->headurldb = $this->urlparent;
			$this->load->model('m_login','m_model_data');

			if(isset($_GET['tkey'])){
				//$this->ortyd->session_check();
			}
			//$this->ortyd->session_check();
		}
	
		function captcha_validation()
		{
			$secret_key = $this->secret_key; // change this to yours
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response='.$_POST['g-recaptcha-response'];
			$response = @file_get_contents($url);
			$data = json_decode($response, true);
			if($data['success'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	
		public function index()
		{
			$userid = 3;
			$logged_in = $this->session->userdata('logged_in');
			if ( $userid != null && $logged_in == TRUE) {
				redirect('dashboard?message=success', 'refresh');
			}else{
				//$aktivasi = $this->ortyd->generateAktivasi();
				//$data['generatelink'] = $aktivasi;
				if(isset($_GET['email'])){
					$email_sso = $_GET['email'];
				}else{
					$email_sso = $this->session->userdata('email_sso');
				}
				if($email_sso != ''){
					//$email_sso = $this->session->userdata('email_sso');
					$username = $email_sso;
					$password = $email_sso;
					$logindata = $this->m_model_data->check_login($username, $password);
					//echo $logindata;
					//die();
					if ( $logindata == 'success' || $logindata == 'validate' || $logindata == 'firstblood') {
						$userid = 3;
						$logged_in = $this->session->userdata('logged_in');
						if ( $userid != null && $logged_in == TRUE) {
							redirect('dashboard?message=success', 'refresh');
						}
					}
				}
			}
			
			$data['title'] = 'Login';
			$data['site_key'] = $this->site_key;
			$data['secret_key'] = $this->secret_key;
			$data['action'] = base_url().'login/submit';
			$this->template->load('login','login/views/v_login', $data);
		}
		
		public function term()
		{
			
			$data['title'] = 'Term & Condition STAR';
			$data['action'] = base_url().'login/submit';
			$this->template->load('login','login/views/v_term', $data);
		}
		
	
		public function submit()
		{
			
			$capcha = $this->captcha_validation();
			//$capcha = true;
			if($capcha == true){
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				

				if ($this->security->xss_clean($username)){
					$username = $this->ortyd->_clean_input_data($username);
					//$username = $this->ortyd->_clean_special($username);
				}
				
				if ($this->security->xss_clean($password)){
					$password = $this->ortyd->_clean_input_data($password);
					//$password = $this->ortyd->_clean_special($password);
				}
				
				$logindata = $this->m_model_data->check_login($username, $password);
				//print_r($logindata);
				//die();
				
				if($logindata == 'banned'){
					redirect('login?message=banned', 'refresh');
				}elseif($logindata == 'success'){
					redirect('dashboard?message=success', 'refresh');
				}elseif($logindata == 'validate'){
					redirect('login?message=validate', 'refresh');
				}elseif($logindata == 'firstblood'){
					redirect('users_password?message=change', 'refresh');
				}else{
					redirect('login?message=error', 'refresh');
				}
			}else{
				redirect('login?message=error_capcha', 'refresh');
			}
		}
		
		public function logout()
		{
			$this->load->helper('cookie');
			$domain = $_SERVER['HTTP_HOST'];
			$parts = explode('.', $domain);
			$domain = implode('.', array_slice($parts, count($parts)-2));
			
			delete_cookie('csrf_cookie_pins_filemanager',$domain,'/');
			$this->session->sess_destroy();
			redirect(base_url('login'), 'refresh');
			//redirect('https://one.pins.co.id', 'refresh');
		}
		
}
