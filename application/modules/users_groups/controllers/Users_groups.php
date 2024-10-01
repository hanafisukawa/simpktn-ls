<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_groups extends MX_Controller {

		private $urlparent = 'users_groups';
		private $viewname = 'users_groups/views/v_users_groups';
		private $viewformname = 'users_groups/views/v_users_groups_form';
		private $tabledb = 'users_groups';
		private $tableid = 'users_groups.id';
		private $titlechilddb = 'Role';
		private $headurldb = 'users_groups';
		private $actionurl = 'users_groups/actionusers_groups';
		private $module = 'users_groups';
		private $modeldb = 'm_users_groups';
		
		public function __construct()
		{
			$this->ortyd->session_check();
			$this->ortyd->access_check($this->module);
			$this->load->model($this->modeldb);
			$this->titlechilddb = $this->ortyd->getmodulename($this->module);
		}
		
		public function index()
		{
			$data['title'] = $this->titlechilddb;
			$data['module'] = $this->module;
			$data['headurl'] = $this->headurldb;
			$data['linkdata'] = $this->urlparent.'/get_data_users_groups';
			$data['linkcreate'] = $this->urlparent.'/createusers_groups';
			$this->template->load('main',$this->viewname, $data);
		}
		
		function get_data_users_groups(){

			$activateddata = array('Inactive','Active');
			$table = $this->tabledb;
			$column_order = array(null,'name','description','active', null);
			$column_search = array('name','description');
			$order = array('level' => 'ASC');
			$select = '*';
			
			$jointable = array();
			$joindetail = array();
			$joinposition = array();
			
			$wherecolumn = array();
			$wheredetail = array();
			
			array_push($wherecolumn, 'active');
			array_push($wheredetail, $this->input->post('active'));
			
				
			$groupby = array();
		
			$list = $this->ortyd->get_datatables($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition, $wherecolumn,$wheredetail,$groupby);
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $rows) {
				$no++;
				$row = array();
				
				if($this->ortyd->access_check_update_data($this->module)){

					$editdata = '<a class="dropdown-item" href="'.base_url().$this->urlparent.'/editusers_groups/'.$rows->id.'">
										<i class="fa fa-edit"></i> Edit
									</a> ';
									
					$restoredata = '<a href="javascript:;" class="dropdown-item" onClick="restoredata('.$rows->id.')">
										<i class="fa fa-trash-restore"></i> Restore
									</a>';
						
				}else{
					$editdata = '';
					$actionassign = '';
					$restoredata = '<a class="dropdown-item">
										No Action
									</a>';
				}
					
					
				if($this->ortyd->access_check_delete_data($this->module)){
					$deletedata = '<a href="javascript:;" class="dropdown-item" onClick="deletedata('.$rows->id.')">
										<i class="fa fa-trash"></i> Delete
									</a>';
						
				}else{
					if($editdata == ''){
						$deletedata = '<a class="dropdown-item">
										No Action
									</a>';
					}else{
						$deletedata = '';
					}
					
				}
				
				if($rows->active == 1){
					$status = '<span class="label label-success">'.$activateddata[$rows->active].'</span>';
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
									'.$deletedata.'
								</div>
								<!--end::Menu item-->
					
								
							</div>
							<!--end::Menu-->
							
						
				
					';
				}else{
					$status =  '<span class="label label-danger">'.$activateddata[$rows->active].'</span>';
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
				$row[] = $rows->name;
				$row[] = $rows->description;
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
		
		public function createusers_groups()
		{
			$this->ortyd->access_check_insert($this->module);
			$data['title'] = 'Buat Baru '.$this->titlechilddb;;
			$data['id'] = null;
			$data['data'] = null;
			$data['headurl'] = $this->headurldb;
			$data['module'] = $this->module;
			$data['m_users_groups'] = $this->m_users_groups;
			$data['action'] = base_url().$this->actionurl.'/0';
			$this->template->load('main',$this->viewformname, $data);
		}
		
		public function editusers_groups($ID)
		{
			$this->ortyd->access_check_update($this->module);
			$data['title'] = 'Edit '.$this->titlechilddb;
			$data['id'] = $ID;
			$data['headurl'] = $this->headurldb;
			$data['module'] = $this->module;
			$data['m_users_groups'] = $this->m_users_groups;
			$data['datarow'] = $this->m_users_groups->get_data_byid($data['id'], $this->tabledb, $this->tableid);
			$data['action'] = base_url().$this->actionurl.'/'.$data['id'];
			$this->template->load('main',$this->viewformname, $data);
		}
		
		public function actionusers_groups($id){
			

			if($id != 0){
				$this->ortyd->access_check_update($this->module);
				$data = array(
						'name' 				=> $this->input->post('name'),
						'description' 		=> $this->input->post('description'),
						'active' 			=> $this->input->post('active'),
						'modifiedid'		=> $this->session->userdata('userid'),
						'modified'			=> date('Y-m-d H:i:s')
				);

				$this->db->where('id', $id);
				$update = $this->db->update($this->tabledb, $data);
				
				if($update){
					
					$menuid = $this->input->post('menuid');
					$view = $this->input->post('view');
					$insertdata = $this->input->post('insert');
					$updatedata = $this->input->post('update');
					$delete = $this->input->post('delete');
					
					//print_r($menuid);
					//die();
					if(count($menuid) > 0){
						foreach( $menuid as $key => $n ) {
							
							
							if(isset($view[$menuid[$key]])){
								$viewid = 1;
							}else{
								$viewid = 0;
							}
							
							if(isset($insertdata[$menuid[$key]])){
								$insertid = 1;
							}else{
								$insertid = 0;
							}
							
							if(isset($updatedata[$menuid[$key]])){
								$updateid = 1;
							}else{
								$updateid = 0;
							}
							
							if(isset($delete[$menuid[$key]])){
								$deleteid = 1;
							}else{
								$deleteid = 0;
							}
							
							
							$this->db->where('menu_id',$menuid[$key]);
							$this->db->where('gid', $id);
							$queryrole = $this->db->get('users_groups_access');
							$queryrole = $queryrole->result_object();
							if(!$queryrole){
								
									$datarole = array(
												'gid' 				=> $id,
												'menu_id' 			=> $menuid[$key],
												'view' 				=> $viewid,
												'insert' 			=> $insertid,
												'update' 			=> $updateid,
												'delete' 			=> $deleteid,
												'createdid'			=> $this->session->userdata('userid'),
												'created'			=> date('Y-m-d H:i:s'),
												'modifiedid'		=> $this->session->userdata('userid'),
												'modified'			=> date('Y-m-d H:i:s')
									);
									
									
									$insert = $this->db->insert('users_groups_access', $datarole);
									
									
							}else{
									
									$datarole = array(
												'gid' 				=> $id,
												'menu_id' 			=> $menuid[$key],
												'view' 				=> $viewid,
												'insert' 			=> $insertid,
												'update' 			=> $updateid,
												'delete' 			=> $deleteid,
												'createdid'			=> $this->session->userdata('userid'),
												'created'			=> date('Y-m-d H:i:s'),
												'modifiedid'		=> $this->session->userdata('userid'),
												'modified'			=> date('Y-m-d H:i:s')
									);
									
									$this->db->where('id', $queryrole[0]->id);
									$update = $this->db->update('users_groups_access', $datarole);
									
							}

							
							//$this->approvedata($key, $checking[$key], $pmid, $notes[$key]);
						}
					}

					redirect($this->headurldb.'?message=success', 'refresh');
				}else{
					redirect($this->headurldb.'?message=error', 'refresh');
				}
				
			}else{
				$this->ortyd->access_check_insert($this->module);
				$data = array(
						'name' 				=> $this->input->post('name'),
						'description' 		=> $this->input->post('description'),
						'active' 			=> $this->input->post('active'),
						'createdid'			=> $this->session->userdata('userid'),
						'created'			=> date('Y-m-d H:i:s'),
						'modifiedid'		=> $this->session->userdata('userid'),
						'modified'			=> date('Y-m-d H:i:s')
				);

				$insert = $this->db->insert($this->tabledb, $data);
				$insert_id = $this->db->insert_id();
				
				if($insert){
					
					$menuid = $this->input->post('menuid');
					$view = $this->input->post('view');
					$insertdata = $this->input->post('insert');
					$updatedata = $this->input->post('update');
					$delete = $this->input->post('delete');
					
					if(count($menuid) > 0){
						foreach( $menuid as $key => $n ) {
							
							
							if(isset($view[$menuid[$key]])){
								$viewid = 1;
							}else{
								$viewid = 0;
							}
							
							if(isset($insertdata[$menuid[$key]])){
								$insertid = 1;
							}else{
								$insertid = 0;
							}
							
							if(isset($updatedata[$menuid[$key]])){
								$updateid = 1;
							}else{
								$updateid = 0;
							}
							
							if(isset($delete[$menuid[$key]])){
								$deleteid = 1;
							}else{
								$deleteid = 0;
							}
							
							
							$this->db->where('menu_id',$menuid[$key]);
							$this->db->where('gid', $insert_id);
							$queryrole = $this->db->get('users_groups_access');
							$queryrole = $queryrole->result_object();
							if(!$queryrole){
								
									$datarole = array(
												'gid' 				=> $insert_id,
												'menu_id' 			=> $menuid[$key],
												'view' 				=> $viewid,
												'insert' 			=> $insertid,
												'update' 			=> $updateid,
												'delete' 			=> $deleteid,
												'createdid'			=> $this->session->userdata('userid'),
												'created'			=> date('Y-m-d H:i:s'),
												'modifiedid'		=> $this->session->userdata('userid'),
												'modified'			=> date('Y-m-d H:i:s')
									);
									
									$insert = $this->db->insert('users_groups_access', $datarole);
									
									
							}else{
									
									$datarole = array(
												'gid' 				=> $insert_id,
												'menu_id' 			=> $menuid[$key],
												'view' 				=> $viewid,
												'insert' 			=> $insertid,
												'update' 			=> $updateid,
												'delete' 			=> $deleteid,
												'createdid'			=> $this->session->userdata('userid'),
												'created'			=> date('Y-m-d H:i:s'),
												'modifiedid'		=> $this->session->userdata('userid'),
												'modified'			=> date('Y-m-d H:i:s')
									);
									
									$this->db->where('id', $queryrole[0]->id);
									$update = $this->db->update('users_groups_access', $datarole);
									
							}

							
							//$this->approvedata($key, $checking[$key], $pmid, $notes[$key]);
						}
					}
					
					redirect($this->headurldb.'?message=success', 'refresh');
				}else{
					redirect($this->headurldb.'?message=error', 'refresh');
				}
				
			}
		}
		
		public function removedata(){
			$this->ortyd->access_check_delete($this->module);
			$id = $this->input->post('id');	

			$this->db->where('id',$id);
			$this->db->where('active',1);
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
		
}
