<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_data extends MX_Controller {

		private $urlparent = 'users_data';
		private $viewname = 'users_data/views/v_users_data';
		private $viewformname = 'users_data/views/v_users_data_form';
		private $viewformnameview = 'users_data/views/v_users_data_view';
		private $viewformnamenoldap = 'users_data/views/v_users_data_noldap_form';
		private $tabledb = 'users_data';
		private $tableid = 'users_data.id';
		private $titlechilddb = 'Users';
		private $headurldb = 'users_data';
		private $actionurl = 'users_data/actionusers_data';
		private $actionurl2 = 'users_data/actioneditusers_data';
		private $actionurlnoldap = 'users_data/actionusersnoldap_data';
		private $module = 'users_data';
		private $modeldb = 'm_users_data';
		
		public function __construct()
		{
			$this->ortyd->session_check();
			$this->ortyd->access_check($this->module);
			$this->load->model($this->modeldb);
			$this->titlechilddb = $this->ortyd->getmodulename($this->module);
		}
		
		public function index()
		{
			
			if($this->session->userdata('group_id') == 3){
				redirect($this->headurldb.'/view', 'refresh');
			}
			
			$data['title'] = $this->titlechilddb;
			$data['module'] = $this->module;
			$data['headurl'] = $this->headurldb;
			$data['linkdata'] = $this->urlparent.'/get_data_users_data';
			$data['linkcreate'] = $this->urlparent.'/createusers_data';
			$data['linkcreatenoldap'] = $this->urlparent.'/createusersnoldap_data';
			$this->template->load('main',$this->viewname, $data);
		}
		
		public function view()
		{
			$ID = $this->session->userdata('userid');
			$this->ortyd->access_check_update($this->module);
			$data['title'] = 'Edit '.$this->titlechilddb;
			$data['id'] = $ID;
			$data['headurl'] = $this->headurldb;
			$data['module'] = $this->module;
			$data['modeldb'] = $this->m_users_data;
			$data['linkdata'] = $this->urlparent.'/get_data_users_data_pasar';
			$data['datarow'] = $this->m_users_data->get_data_byid($data['id'], $this->tabledb, $this->tableid);
			$data['action'] = base_url().$this->actionurl2.'/'.$data['id'];
			$this->template->load('main',$this->viewformnameview, $data);
		}
		
		function get_data_users_data(){
			$wib = "'07:00:00'";
			$activedata = array('Inactive','Active');
			$validateData = array('No','Yes');
			$table = $this->tabledb;
			$column_order = array(null,'fullname','email','users_groups.name','online_date_wib','last_login','validate','active', null);
			$column_search = array('fullname','email','users_groups.name');
			$order = array('online_date' => 'DESC');
			$select = 'users_data.*,  DATE_SUB(users_data.last_login, interval - '.$wib.' hour) as last_login_wib, users_groups.name as group_name, DATE_SUB(users_data.online_date, interval - '.$wib.' hour) as online_date_wib';
			
			$jointable = array('users_groups');
			$joindetail = array('users_groups.id = users_data.gid');
			$joinposition = array('inner');
			
			$wherecolumn = array();
			$wheredetail = array();
			
			
				
			if( $this->input->post('active') == 0){
					array_push($wherecolumn, 'users_data.active');
					array_push($wheredetail, 0);
					
					array_push($wherecolumn, 'banned');
					array_push($wheredetail, 0);
					
					
			}elseif( $this->input->post('active') == 2){
					
					array_push($wherecolumn, 'banned');
					array_push($wheredetail, 1);
	
			}elseif( $this->input->post('active') == 3){
					
					array_push($wherecolumn, 'validate');
					array_push($wheredetail, 0);
					
					array_push($wherecolumn, 'users_data.active');
					array_push($wheredetail, 1);
	
			}elseif( $this->input->post('active') == 4){
					
					array_push($wherecolumn, 'banned');
					array_push($wheredetail, 0);
					
					array_push($wherecolumn, 'users_data.active');
					array_push($wheredetail, 1);
	
			}else{
					
					array_push($wherecolumn, 'users_data.active');
					array_push($wheredetail, $this->input->post('active'));	
					
					array_push($wherecolumn, 'banned');
					array_push($wheredetail, 0);
			
					array_push($wherecolumn, 'users_groups.id|notin');
					array_push($wheredetail, array(1));
					
			}

				
	
			
			$groupby = array();
		
			$list = $this->ortyd->get_datatables($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition, $wherecolumn,$wheredetail,$groupby);
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $rows) {
				$no++;
				$row = array();
				
				if($this->ortyd->access_check_update_data($this->module)){

					$editdata = '<a class="dropdown-item" href="'.base_url().$this->urlparent.'/editusers_data/'.$rows->id.'">
										<i class="fa fa-edit"></i> Edit
									</a> ';

									
					$restoredata = '<a href="javascript:;" class="dropdown-item" onClick="restoredata('.$rows->id.')">
										<i class="fa fa-trash-restore"></i> Restore
									</a>';
									
					$restoredatabanned = '<a href="javascript:;" class="dropdown-item" onClick="restorebanneddata('.$rows->id.')">
										<i class="fa fa-check-circle-o"></i> Remove Banned
									</a>';
									
					$banneddata = '<a href="javascript:;" class="dropdown-item" onClick="banneddata('.$rows->id.')">
										<i class="fa fa-ban"></i> Banned
									</a>';
									
					if($rows->validate == 0){
						$validatenya = '<a href="javascript:;" class="dropdown-item" onClick="validatedata('.$rows->id.')">
										<i class="fa fa-check"></i> Activation
									</a>';
					}else{
						$validatenya = '';
					}
						
				}else{
					$editdata = '';
					$validatenya = '';
					$actionassign = '';
					$banneddata =  '';
					$restoredata = '<a class="dropdown-item">
										No Action
									</a>';
					$restoredatabanned = '<a class="dropdown-item">
										No Action
									</a>';
				}
					
					
				if($this->ortyd->access_check_delete_data($this->module)){
					$deletedata = '<a href="javascript:;" class="dropdown-item" onClick="deletedata('.$rows->id.')">
										<i class="fa fa-trash"></i> Delete
									</a>';
						
					
				}else{
					if($editdata == '' && $banneddata == ''){
						$deletedata = '<a class="dropdown-item">
										No Action
									</a>';
					}else{
						$deletedata = '';
					}
					
				}

				if($rows->active == 1 && $rows->banned == 0){
					$status = '<span class="label label-success">'.$activedata[$rows->active].'</span>';
					$action = '
			
						 
						  <a href="#" class="btn btn-sm btn-primary btn-active-light-primary btn-flex btn-center btn-sm menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="top-end">
							Action
							<i class="ki-duotone ki-down fs-5 ms-1"></i>                    
							</a>
							<!--begin::Menu-->
							<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
							
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									'.$editdata.'
								</div>
								<!--end::Menu item-->
								
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									'.$banneddata.'
								</div>
								<!--end::Menu item-->
								
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									'.$validatenya.'
								</div>
								<!--end::Menu item-->
								
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									'.$deletedata.'
								</div>
								<!--end::Menu item-->
								
							</div>
							<!--end::Menu-->
				
					';
					
				}elseif($rows->banned == 1){
					$status = '<span class="label label-warning">Banned</span>';
					$action = '
						  
						   <a href="#" class="btn btn-sm btn-primary btn-active-light-primary btn-flex btn-center btn-sm menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="top-end">
							Action
							<i class="ki-duotone ki-down fs-5 ms-1"></i>                    
							</a>
							<!--begin::Menu-->
							<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
							
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									'.$restoredatabanned.'
								</div>
								<!--end::Menu item-->
								
							</div>
							<!--end::Menu-->
				
					';
					
				}else{
					
					$status = '<span class="label label-danger">'.$activedata[$rows->active].'</span>';
					$action = '
				
						 <a href="#" class="btn btn-sm btn-primary btn-active-light-primary btn-flex btn-center btn-sm menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="top-end">
							Action
							<i class="ki-duotone ki-down fs-5 ms-1"></i>                    
							</a>
							<!--begin::Menu-->
							<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
							
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									'.$restoredata.'
								</div>
								<!--end::Menu item-->
								
							</div>
							<!--end::Menu-->
				
					';
					
				}
				
				$row[] = $action;
				$row[] = $rows->fullname;
				$row[] = $rows->email;
				$row[] = $rows->group_name;
				$row[] = $rows->online_date_wib;
				$row[] = $rows->last_login_wib;
				if($rows->validate == 1){
					$row[] = '<span class="label label-success">'.$validateData[$rows->validate].'</span>';
				}else{
					$row[] = '<span class="label label-danger">'.$validateData[$rows->validate].'</span>';
				}
				$row[] = $status;
				
				
				$data[] = $row;
			}
			
	 
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->ortyd->count_filtered($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition, $wherecolumn,$wheredetail,$groupby),
				"recordsFiltered" => $this->ortyd->count_filtered($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition, $wherecolumn,$wheredetail,$groupby),
				"data" => $data,
			);
			
			echo json_encode($output);
		}
		
	
		public function removeevidence(){
			$user_id = $this->input->post('user_id');	
			$id = $this->input->post('id');	
			
			$delete = $this->db->delete('users_data_pasar',array('user_id'=>$user_id, 'pasar_id'=>$id));
			if($delete){
				$result = array("message" => "success");
				echo json_encode($result);
			}else{
				$result = array("message" => "error");
				echo json_encode($result);
			}
		}
		
		public function createusers_data()
		{
			$this->ortyd->access_check_insert($this->module);
			$data['title'] = 'Buat Baru '.$this->titlechilddb;;
			$data['id'] = null;
			$data['data'] = null;
			$data['module'] = $this->module;
			$data['modeldb'] = $this->m_users_data;
			$data['headurl'] = $this->headurldb;
			$data['linkdata'] = $this->urlparent.'/get_data_users_data_pasar';
			$data['action'] = base_url().$this->actionurl.'/0';
			$this->template->load('main',$this->viewformname, $data);
		}
		
		
		public function editusers_data($ID)
		{
			
			if($this->session->userdata('group_id') == 3){
				redirect($this->headurldb.'/view', 'refresh');
			}
			
			$this->ortyd->access_check_update($this->module);
			$data['title'] = 'Edit '.$this->titlechilddb;
			$data['id'] = $ID;
			$data['headurl'] = $this->headurldb;
			$data['module'] = $this->module;
			$data['modeldb'] = $this->m_users_data;
			$data['linkdata'] = $this->urlparent.'/get_data_users_data_pasar';
			$data['datarow'] = $this->m_users_data->get_data_byid($data['id'], $this->tabledb, $this->tableid);
			$data['action'] = base_url().$this->actionurl.'/'.$data['id'];
			$this->template->load('main',$this->viewformname, $data);
		}
		
		public function actionusers_data($id){
			
			if($this->input->post('user_id_ref') == ''){
				$user_id_ref = null;
			}else{
				$user_id_ref = $this->input->post('user_id_ref');
			}
			
			if($id != 0){
				$this->ortyd->access_check_update($this->module);
				$data = array(
						'username' 			=> $this->input->post('username'),
						'fullname' 			=> $this->input->post('fullname'),
						'email' 			=> $this->input->post('email'),
						'notelp' 			=> $this->input->post('notelp'),
						'gid' 				=> $this->input->post('gid'),
						'active' 			=> $this->input->post('active'),
						'user_id_ref' 		=> $user_id_ref,
						'banned' 			=> $this->input->post('banned'),
						'createdid'			=> $this->session->userdata('userid'),
						'created'			=> date('Y-m-d H:i:s'),
						'modifiedid'		=> $this->session->userdata('userid'),
						'modified'			=> date('Y-m-d H:i:s')
				);

				
				$datapassword = array(
					'password' => $this->ortyd->hash($this->input->post('password'))
				);
				
				if($this->input->post('password') != ''){
					$data = array_merge($data,$datapassword);
				}
				
				$datacover = array(
					'cover' => $this->input->post('cover')
				);
				
				if($this->input->post('cover') != ''){
					$data = array_merge($data,$datacover);
				}

				$datasignature = array(
					'signature' => $this->input->post('signature')
				);
				
				if($this->input->post('signature') != ''){
					$data = array_merge($data,$datasignature);
				}
				
				$this->db->where('id', $id);
				$update = $this->db->update($this->tabledb, $data);
				
				if($update){
					$result = array("message" => "success", "id" => $id, 'type' => 'update');
					echo json_encode($result);
					
				}else{
					$result = array("message" => "error");
					echo json_encode($result);
				}
				
			}else{
				$this->ortyd->access_check_insert($this->module);
				
				
				$data = array(
						'username' 			=> $this->input->post('username'),
						'fullname' 			=> $this->input->post('fullname'),
						'password' 			=> $this->ortyd->hash($this->input->post('password')),
						'email' 			=> $this->input->post('email'),
						'notelp' 			=> $this->input->post('notelp'),
						'gid' 				=> $this->input->post('gid'),
						'active' 			=> $this->input->post('active'),
						'user_id_ref' 		=> $user_id_ref,
						'banned' 			=> $this->input->post('banned'),
						'cover' 			=> $this->input->post('cover'),
						'createdid'			=> $this->session->userdata('userid'),
						'created'			=> date('Y-m-d H:i:s'),
						'modifiedid'		=> $this->session->userdata('userid'),
						'modified'			=> date('Y-m-d H:i:s')
				);
				
				$datasignature = array(
					'signature' => $this->input->post('signature')
				);
				
				if($this->input->post('signature') != ''){
					$data = array_merge($data,$datasignature);
				}

				$insert = $this->db->insert($this->tabledb, $data);
				$insert_id = $this->db->insert_id();
				
				if($insert){
					$result = array("message" => "success", "id" => $insert_id, 'type' => 'insert');
					echo json_encode($result);
					
					//redirect($this->headurldb.'?message=success', 'refresh');
				}else{
					
					$result = array("message" => "error");
					echo json_encode($result);
					
					//redirect($this->headurldb.'?message=error', 'refresh');
				}
				
			}
		}
		
		public function actioneditusers_data($id){
			
			if($this->input->post('user_id_ref') == ''){
				$user_id_ref = null;
			}else{
				$user_id_ref = $this->input->post('user_id_ref');
			}
			
			if($id != 0){
				$this->ortyd->access_check_update($this->module);
				$data = array(
						'username' 			=> $this->input->post('username'),
						'fullname' 			=> $this->input->post('fullname'),
						'email' 			=> strtolower($this->input->post('email')),
						'notelp' 			=> $this->input->post('notelp'),
						'user_id_ref' 		=> $user_id_ref,
						'active' 			=> $this->input->post('active'),
						'banned' 			=> $this->input->post('banned'),
						'createdid'			=> $this->session->userdata('userid'),
						'created'			=> date('Y-m-d H:i:s'),
						'modifiedid'		=> $this->session->userdata('userid'),
						'modified'			=> date('Y-m-d H:i:s')
				);

				
				$datapassword = array(
					'password' => $this->ortyd->hash($this->input->post('password'))
				);
				
				if($this->input->post('password') != ''){
					$data = array_merge($data,$datapassword);
				}
				
				$datacover = array(
					'cover' => $this->input->post('cover')
				);
				
				if($this->input->post('cover') != ''){
					$data = array_merge($data,$datacover);
				}

				$datasignature = array(
					'signature' => $this->input->post('signature')
				);
				
				if($this->input->post('signature') != ''){
					$data = array_merge($data,$datasignature);
				}
				
				$this->db->where('id', $id);
				$update = $this->db->update($this->tabledb, $data);
				
				if($update){
					$result = array("message" => "success", "id" => $id, 'type' => 'update');
					echo json_encode($result);
					
				}else{
					
					$result = array("message" => "error");
					echo json_encode($result);
				}
				
			}else{
				$result = array("message" => "error");
				echo json_encode($result);
			}
		}
		
		public function removedata(){
			$this->ortyd->access_check_delete($this->module);
			$id = $this->input->post('id');	

			$this->db->where('id',$id);
			$this->db->where('active',1);
			$this->db->where('banned',0);
			$query = $this->db->get($this->tabledb);
			$query = $query->result_object();
			if($query){
				
				$dataremove = array(
					'active' 			=> 0,
					'modifiedid'		=> $this->session->userdata('userid'),
					'modified'			=> date('Y-m-d H:i:s')
				);
										
				$this->db->where('id', $id);
				$updateactive = $this->db->update($this->tabledb, $dataremove);
				
				if($updateactive){
					$result = array("message" => "success");
					echo json_encode($result);
				}else{
					$result = array("message" => "error");
					echo json_encode($result);
				}
			
			}else{
				$result = array("message" => "error");
				echo json_encode($result);
			}

		}
		
		public function banneddata(){
			$this->ortyd->access_check_update($this->module);
			$id = $this->input->post('id');	

			$this->db->where('id',$id);
			$this->db->where('banned',0);
			$query = $this->db->get($this->tabledb);
			$query = $query->result_object();
			if($query){
				
				$dataremove = array(
					'banned' 		=> 1,
					'modifiedid'		=> $this->session->userdata('userid'),
					'modified'			=> date('Y-m-d H:i:s')
				);
										
				$this->db->where('id', $id);
				$updateactive = $this->db->update($this->tabledb, $dataremove);
				
				if($updateactive){
					$result = array("message" => "success");
					echo json_encode($result);
				}else{
					$result = array("message" => "error");
					echo json_encode($result);
				}
			
			}else{
				$result = array("message" => "error");
				echo json_encode($result);
			}

		}
		
		
		public function validatedata(){
			$this->ortyd->access_check_update($this->module);
			$id = $this->input->post('id');	

			$this->db->where('id',$id);
			$this->db->where('validate',0);
			$query = $this->db->get($this->tabledb);
			$query = $query->result_object();
			if($query){
				
				$dataremove = array(
					'validate' 			=> 1,
					'modifiedid'		=> $this->session->userdata('userid'),
					'modified'			=> date('Y-m-d H:i:s')
				);
										
				$this->db->where('id', $id);
				$updateactive = $this->db->update($this->tabledb, $dataremove);
				
				if($updateactive){
					$result = array("message" => "success");
					echo json_encode($result);
				}else{
					$result = array("message" => "error");
					echo json_encode($result);
				}
			
			}else{
				$result = array("message" => "error");
				echo json_encode($result);
			}

		}
		
		public function restoredata(){
			$this->ortyd->access_check_update($this->module);
			$id = $this->input->post('id');	

			$this->db->where('id',$id);
			$this->db->where('active',0);
			$query = $this->db->get($this->tabledb);
			$query = $query->result_object();
			if($query){
				
				$dataremove = array(
					'active' 			=> 1,
					'modifiedid'		=> $this->session->userdata('userid'),
					'modified'			=> date('Y-m-d H:i:s')
				);
										
				$this->db->where('id', $id);
				$updateactive = $this->db->update($this->tabledb, $dataremove);
				
				if($updateactive){
					$result = array("message" => "success");
					echo json_encode($result);
				}else{
					$result = array("message" => "error");
					echo json_encode($result);
				}
			
			}else{
				$result = array("message" => "error");
				echo json_encode($result);
			}

		}
		
		public function restorebanneddata(){
			$this->ortyd->access_check_update($this->module);
			$id = $this->input->post('id');	

			$this->db->where('id',$id);
			$this->db->where('banned',1);
			$query = $this->db->get($this->tabledb);
			$query = $query->result_object();
			if($query){
				
				$dataremove = array(
					'banned' 			=> 0,
					'modifiedid'		=> $this->session->userdata('userid'),
					'modified'			=> date('Y-m-d H:i:s')
				);
										
				$this->db->where('id', $id);
				$updateactive = $this->db->update($this->tabledb, $dataremove);
				
				if($updateactive){
					$result = array("message" => "success");
					echo json_encode($result);
				}else{
					$result = array("message" => "error");
					echo json_encode($result);
				}
			
			}else{
				$result = array("message" => "error");
				echo json_encode($result);
			}

		}
		
		public function select2_gid() {
			$q = $this->input->post('q');
			if(!$q){
				$q = '';
			}
			$this->db->select('id as id, name as name');
			$this->db->like('name', $q);
			$this->db->where('active', 1);
			$this->db->where_not_in('id', array(1));
			$query = $this->db->get('users_groups');
			$query = $query->result_array();
			if($query){
				$i=0;
				$data = Array();
				foreach ($query as $rows){
					$data[$i]['id'] = (int)$rows['id'];
					$data[$i]['name']= $rows['name'];
					$i++;
				}
				$data = array('items' => $data);
			}else{
				$data = array('items' => array());
			}
			
			echo json_encode($data);
		}
		
		
		function proses_upload(){
			$this->ortyd->access_check($this->module);
			$dir = './file/'.date('Y').'/'.date('m').'/'.date('d');
			
			if(!file_exists($dir)){
			  mkdir($dir,0755,true);
			}

			$path = 'file/'.date('Y').'/'.date('m').'/'.date('d');
			$config['upload_path']   = $dir;
			$config['allowed_types'] = 'gif|jpg|png|ico';
			$this->load->library('upload',$config);
			$size = 1;
			if($this->upload->do_upload('userfile')){
				$token	=	$this->input->post('token_foto');
				$nama	=	$this->upload->data('file_name');
				$size	=	$this->upload->data('file_size');
				
				$data = array(
					'name'			=> $nama,
					'file_size'		=> $size * 1000,
					'token'			=> $token,
					'path'			=> $path .'/'.$nama,
					'path_server'	=> $dir .'/'.$nama,
					'createdid'		=> $this->session->userdata('userid'),
					'created'		=> date('Y-m-d H:i:s'),
					'modifiedid'	=> $this->session->userdata('userid'),
					'modified'		=> date('Y-m-d H:i:s')
				);
					
				$this->db->insert('data_gallery',$data);
				$insertid = $this->db->insert_id();
				
				$result = array("message" => "success",'id' => $insertid);
				echo json_encode($result);
				
			}

		}
	
	
		//Untuk menghapus foto
		function remove_foto(){

			//Ambil token foto
			$token=$this->input->post('token');
			$id=$this->input->post('id');
			$foto=$this->db->get_where('data_gallery',array('token'=>$token));


			if($foto->num_rows()>0){
				$hasil=$foto->row();
				$nama_foto=$hasil->name;
				if(file_exists($file=$hasil->path_server)){
					unlink($file);
				}
				$this->db->delete('data_gallery',array('token'=>$token));
				
				$dataremove = array(
					'cover' 			=> null
				);
											
				$this->db->where('id', $id);
				$updateactive = $this->db->update($this->tabledb, $dataremove);
					

				$result = array("message" => "success",'id' => $hasil->id);
				echo json_encode($result);

			}

		}
		
		function getcover(){
			
			$id=$this->input->post('id');
			$this->db->select('data_gallery.name as name, data_gallery.path, data_gallery.token, data_gallery.file_size as size');
			$this->db->where('users_data.id', $id);
			$this->db->join('data_gallery', 'users_data.cover = data_gallery.id');
			$query = $this->db->get('users_data');
			$query = $query->result_object();

			if($query){
				echo json_encode($query);
			}else{
				echo json_encode(null);
			}
			
		}

		public function select2_user_ref() {
			
			$q = $this->input->post('q');

			if(!$q){
				$q = '';
			}
			$this->db->select('id, fullname as name');
			$this->db->like('fullname', $q);
			$this->db->where('active',1);
			$this->db->where('banned',0);
			$this->db->where_in('gid',array(2,3));
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				$i=0;
				foreach ($query as $rows){
					$data[$i]['id'] = (int)$rows['id'];
					$data[$i]['name']= $rows['name'];
					$i++;
				}
				$data = array('items' => $data);
			}else{
				$data = array('items' => array());
			}
			
			echo json_encode($data);
			
		}

}
