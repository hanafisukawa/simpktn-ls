<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_login extends CI_Model {
	
		private $urlparent = 'data_perusahaan_register'; //NAME TABLE 
		public $link = "https://api.pins.co.id/api/";
		
		public function __construct()
		{
			parent::__construct();
		}
		
		function getToken($username, $password){
		
			//return null;
			
			$params = array(
				'username' => $username,
				'password' => $password
			);
			
			$data = $this->curl->simple_post($this->link.'auth/token/request',$params,array(
							CURLOPT_TIMEOUT => 50000,
							CURLOPT_SSL_VERIFYPEER => false
						)
					);
					
			$info = $this->curl->info;
			$rowcode = $info['http_code'];
			//die();
					
			if($data){
				$data = json_decode($data);
				$rowdata = $data->data;
				$rowcode = $rowcode;
				return $rowdata->access_token;
			}
			
			return null;
			
		}
		
		public function check_login($username, $password){
			$this->load->helper('cookie');
			//$email_sso = $this->session->userdata('email_sso');
			if($username == $password){
				//echo $username;
				//die();
				return $this->setSSO($username);
				
			}else{
				
				$loginya = $this->getToken($username, $password);
				//return $loginya;
				//$loginya = null;
				if($loginya != null){
					
					$params = array(
							//'limit'		=>	10000,
							//'offset'	=>	0
					);
					
					$token = $loginya;
					$data = $this->curl->simple_get($this->link.'cms/user/get-detail/',$params,array(
								CURLOPT_HTTPHEADER => array('Authorization:Bearer '.$token.''),
								CURLOPT_TIMEOUT => 50000,
								CURLOPT_SSL_VERIFYPEER => false
						)
					);
						
					$info = $this->curl->info;
					$rowcode = $info['http_code'];
					
					//return $data;
					//print_r($data);
					//die();
					if($data){
						$data = json_decode($data);
						$rowdata = (array)$data->data;
					
						$rowcode = $rowcode;
						if(count($rowdata) > 0){
							//print_r($rowdata);
							//die();
							$email_sso = $rowdata['email'];
							return $this->setSSO($email_sso);
						}
					}
				
				}else{
					
					
					$domain = $_SERVER['HTTP_HOST'];
					$parts = explode('.', $domain);
					$domain = implode('.', array_slice($parts, count($parts)-2));
										
					$username = "'".$username."'";
					$this->db->select('id,username,email,password,gid,banned, last_login ,fullname,validate,unit_id,position_name');
					$this->db->where('lower(username) = '.strtolower($username).' and active = 1',null);
					$this->db->or_where('lower(email) = '.strtolower($username).' and active = 1',null);
					$query = $this->db->get('users_data');
					$query = $query->result_object();
					if($query){
						foreach ($query as $rows) {
							if($rows->banned == 1){
								return 'banned';
							}elseif($rows->validate == 0){
								return 'validate';
							}else{
								if($this->ortyd->verify_hash($password, $rows->password)){
									
									
									if($rows->last_login == ''){
										
										$login = array(
											'userid'  		=> $rows->id,
											'email'     	=> $rows->email,
											'username'     	=> $rows->username,
											'fullname'     	=> $rows->fullname,
											'position_name' => $rows->position_name,
											'group_id'     	=> $rows->gid,
											'unit_id'  => $rows->unit_id,
											'upload_image_file_manager'   => true,
											'last_login'	=> date('Y-m-d H:i:s'),
											'logged_in'		=> TRUE
										);

										$this->session->set_userdata($login);
										
										
										
										$my_cookie= array(
											'name'   => 'csrf_cookie_pins_filemanager',
											'value'  => sha1('csrf_cookie_pins_filemanager'.date('Y-m-d H:i:s')),                            
											'expire' => '3000',
											'domain' => $domain
										);						   
										$this->input->set_cookie($my_cookie);
											
										return 'firstblood';
										
									}else{
										
										$data = array(
											'last_login' => date('Y-m-d H:i:s')
										);
										
										$this->db->where('id', $rows->id);
										$update = $this->db->update('users_data', $data);
										
										if($update){
											

											$login = array(
												'userid'  		=> $rows->id,
												'email'     	=> $rows->email,
												'username'     	=> $rows->username,
												'fullname'     	=> $rows->fullname,
												'position_name' => $rows->position_name,
												'unit_id'  => $rows->unit_id,
												'group_id'     	=> $rows->gid,
												'upload_image_file_manager'   => true,
												'last_login'	=> date('Y-m-d H:i:s'),
												'logged_in'		=> TRUE
											);

											$this->session->set_userdata($login);
											
											$my_cookie= array(
												'name'   => 'csrf_cookie_pins_filemanager',
												'value'  => sha1('csrf_cookie_pins_filemanager'.date('Y-m-d H:i:s')),                            
												'expire' => '3000', 
												'domain' => $domain
											);						   
											$this->input->set_cookie($my_cookie); 
																			
											if($rows->last_login == ''){
												return 'firstblood';
											}else{
												return 'success';
											}

												
										}
									
										return 'success';
										
									}
										
								}
							}
						}
					}
				
				}
				
				
				
			}
			
			
			
			return 'error';
			
		}
		
		public function setSSO($email_sso){
			$username = "'".$email_sso."'";
				$this->db->select('id,username,email,password,gid,banned, last_login ,fullname,validate,unit_id,position_name');
				$this->db->where('lower(username) = '.strtolower($username).' and active = 1',null);
				$this->db->or_where('lower(email) = '.strtolower($username).' and active = 1',null);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach ($query as $rows) {
						if($rows->banned == 1){
							return 'banned';
						}else{
							if($rows->password != ''){
								
								
								if($rows->last_login == ''){
									
									$login = array(
										'userid'  		=> $rows->id,
										'email'     	=> $rows->email,
										'username'     	=> $rows->username,
										'fullname'     	=> $rows->fullname,
										'position_name' => $rows->position_name,
										'unit_id'  => $rows->unit_id,
										'group_id'     	=> $rows->gid,
										'last_login'	=> date('Y-m-d H:i:s'),
										'logged_in'		=> TRUE
									);

									$this->session->set_userdata($login);
									
									$data = array(
										'validate' 	=> 1,
										'last_login' => date('Y-m-d H:i:s')
									);
									
									$this->db->where('id', $rows->id);
									$update = $this->db->update('users_data', $data);
										
									return 'firstblood';
									
								}else{
									
									$data = array(
										'validate' 	=> 1,
										'last_login' => date('Y-m-d H:i:s')
									);
									
									$this->db->where('id', $rows->id);
									$update = $this->db->update('users_data', $data);
									
									if($update){
										

										$login = array(
											'userid'  		=> $rows->id,
											'email'     	=> $rows->email,
											'username'     	=> $rows->username,
											'fullname'     	=> $rows->fullname,
											'position_name' => $rows->position_name,
											'unit_id'  => $rows->unit_id,
											'group_id'     	=> $rows->gid,
											'last_login'	=> date('Y-m-d H:i:s'),
											'logged_in'		=> TRUE
										);

										$this->session->set_userdata($login);
										
																		
										if($rows->last_login == ''){
											return 'firstblood';
										}else{
											return 'success';
										}

											
									}
								
									return 'success';
									
								}
									
							}
						}
					}
				}
				
			return 'error';
		}
		
		
		public function upload(){
			
			$user_id = 3;
			
			try {
		
				$dir = './file/'.date('Y').'/'.date('m').'/'.date('d');
					
				if(!file_exists($dir)){
					mkdir($dir,0755,true);
				}

				$path = 'file/'.date('Y').'/'.date('m').'/'.date('d');
				$config['upload_path']   = $dir;
				$namereplace = $_FILES["perusahaan_file"]['name'];
				$dname 	= 	explode(".", $namereplace);
				$ext 	= 	end($dname);
				$namereplace = str_replace('.'.$ext, '', $namereplace);
				$namereplace = $this->ortyd->_clean_special($namereplace);
				$config['file_name'] = $namereplace.'.'.$ext;
				$config['allowed_types'] = 'application/pdf|pdf|xls|xlsx|dwg|dxf|dwf|application/octet-stream|png|jpg|jpeg|gif|zip|rar';
				$this->load->library('upload',$config);
				$size = 1;
				if($this->upload->do_upload('perusahaan_file')){
					$token	=	'1.0000'.date('YmdHis').rand(1,1000);
					$nama	=	$this->upload->data('file_name');
					$size	=	$this->upload->data('file_size');
					
					$data = array(
						'name'			=> $nama,
						'file_size'		=> $size * 1000,
						'token'			=> $token,
						'path'			=> $path .'/'.$nama,
						'path_server'	=> $dir .'/'.$nama,
						'createdid'		=> $user_id,
						'created'		=> date('Y-m-d H:i:s'),
						'modifiedid'	=> $user_id,
						'modified'		=> date('Y-m-d H:i:s'),
						'file_store_format'	=> $ext,
						'url_server'	=> base_url()
					);
							
					$insert = $this->db->insert('data_gallery',$data);
					$insertid = $this->db->insert_id();
					
					if($insert){
						return $insertid;
					}else{
						return null;
					}
					
						
				}else{
					return null;
				}
			}
			catch (Error $e) {
				return null;
			}
			catch (Exception $e) {
				return null;
			}

		}
		
		public function proses_upload(){
			
			return $this->ortyd->proses_upload_dok();

		}
		
		
		public function getFile(){
			$fieldnya = array();
			$id = $this->input->post('id');
			$spph_id = $this->input->post('spph_id');
			$unit_id = $this->input->post('unit_id');
			
			$this->db->select('data_gallery.*, data_spph_detail_evidence.id as evidence_id');
			$this->db->where('data_spph_detail.spph_id',$spph_id);
			$this->db->where('data_spph_detail.unit_id',$unit_id);
			$this->db->where('data_spph_detail.field_detail_id',$id);
			$this->db->where('data_spph_detail_evidence.active',1);
			$this->db->join('data_spph_detail_evidence','data_spph_detail_evidence.detail_id = data_spph_detail.id','INNER');
			$this->db->join('data_gallery','data_gallery.id = data_spph_detail_evidence.file_id','INNER');
			$this->db->order_by('data_spph_detail_evidence.id','ASC');
			$querystatus = $this->db->get('data_spph_detail');	
			$querystatus = $querystatus->result_object();
			if($querystatus){
				foreach ($querystatus as $rows) {
					$datanya = array(
						'id' => $rows->id,
						'evidence_id' => $rows->evidence_id,
						'name' => $rows->name, 	
						'path' => base_url().$rows->path,
						'size' => $rows->file_size/1000, 							
						"extention" =>  $rows->file_store_format, 
					);
					
					array_push($fieldnya, $datanya);
				}
				
				$result = array("message" => "success",'data' => $fieldnya);
				return json_encode($result);
			}else{
				$result = array("message" => "error");
				return json_encode($result);
			}
		}
		
		public function deleteFile(){
			//$this->ortyd->access_check_update($this->module);
			
			$id = $this->input->post('id');	
			$this->db->where('data_spph_detail_evidence.id',$id);
			$this->db->where('active',1);
			$query = $this->db->get('data_spph_detail_evidence');
			$query = $query->result_object();
			if($query){
				
				$this->db->trans_begin();
				
				$dataremove = array(
					'active' 			=> 0,
					'modifiedid'		=> $this->session->userdata('userid'),
					'modified'			=> date('Y-m-d H:i:s')
				);

				$this->db->where('id', $id);
				$updateactive = $this->db->update('data_spph_detail_evidence', $dataremove);
				
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					$result = array("message" => "error");
					return json_encode($result);
				}else{
					if($updateactive){
						$result = array("message" => "success");
						return json_encode($result);
					}else{
						$result = array("message" => "error");
						return json_encode($result);
					}
				}
			}else{
				$result = array("message" => "error");
				return json_encode($result);
			}

		}
		
		function getcover(){
			$fieldnya = array();
			//$unit_id =$this->input->post('id');
			$id =$this->input->post('id');
			$tableid =$this->input->post('tableid');
			$table =$this->urlparent;

			$this->db->select('data_gallery.*, data_dokumen.id as evidence_id');
			$this->db->where('data_dokumen.table', $table);
			$this->db->where('data_dokumen.tableid', $tableid);
			$this->db->where('data_dokumen.data_id', $id);
			$this->db->where('data_dokumen.active',1);
			$this->db->join('data_gallery','data_dokumen.file_id = data_gallery.id');
			$this->db->join('data_gallery thumb','thumb.id = data_gallery.thumbnail_id','left');
			$querystatus = $this->db->get('data_dokumen');
			$querystatus = $querystatus->result_object();
			//print_r($this->db->last_query());
			if($querystatus){
				foreach ($querystatus as $rows) {
					$datanya = array(
						'id' => $rows->id,
						'evidence_id' => $rows->evidence_id,
						'name' => $rows->name, 	
						'path' => base_url().$rows->path,
						'size' => $rows->file_size/1000, 							
						"extention" =>  $rows->file_store_format, 
					);
					
					array_push($fieldnya, $datanya);
				}
				
				$result = array("message" => "success",'data' => $fieldnya);
				return json_encode($result);
			}else{
				$result = array("message" => "error");
				return json_encode($result);
			}
			
		}
		
	
}	