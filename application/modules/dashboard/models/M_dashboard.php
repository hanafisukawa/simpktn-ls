<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_dashboard extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
		}
		
		function uploadBase64_new()
		{

					$file = $this->input->post('image64');
					$user_id = $this->input->post('user_id');
					$id = $this->input->post('id');
					
					$dir = './file/thumbnail/'.date('Y').'/'.date('m').'/'.date('d');
					
					if(!file_exists($dir)){
					  mkdir($dir,0755,true);
					}

					$path = 'file/thumbnail/'.date('Y').'/'.date('m').'/'.date('d');

					if (preg_match('/^data:image\/(\w+);base64,/', $file, $type)) {
						$file = substr($file, strpos($file, ',') + 1);
						$type = strtolower($type[1]); // jpg, png, gif

						if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
							$data['status'] = 'error';	
							$data['errors'] = 'Invalid Image Type';
							return $json_encode($data);
							die();
						}

						$file = base64_decode($file);

						if ($file === false) {
							$data['status'] = 'error';	
							$data['errors'] = 'base64_decode failed';
							return $json_encode($data);
							die();
						}
					} else {
						$data['status'] = 'error';	
						$data['errors'] = 'did not match data URI with image data';
						return $json_encode($data);
						die();
					}
					
					$nama = date('YmdHis').$user_id.'.'.$type;
					$status = file_put_contents($path .'/'.$nama,$file);
					if($status){
						$token	=	'0.'.date('YmdHis').$user_id;
						$size	=	(int)(strlen(rtrim($file, '=')) * 3 / 4) / 1000;
						
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
							'url_server'	=> base_url()
						);
							
						$insert = $this->db->insert('data_gallery',$data);
						$insertid = $this->db->insert_id();
						
						if($insert){
							
							$this->db->where('data_gallery.id', $id);
							$querystatus = $this->db->get('data_gallery');	
							$querystatus = $querystatus->result_object();
							if($querystatus){
								$dataremove = array(
									'thumbnail_id' 	=> $insertid,
									'modifiedid'	=> $user_id,
									'modified'		=> date('Y-m-d H:i:s')
								);
															
								$this->db->where('data_gallery.id', $querystatus[0]->id);
								$updateactive = $this->db->update('data_gallery', $dataremove);
								
								$data['status'] = 'success';	
								$data['errors'] = '-';
								$data['id'] = $insertid;
							
							}else{
								$data['status'] = 'error';	
								$data['errors'] = 'Data not insert review';
							}
							
							
						}else{
							$data['status'] = 'error';	
							$data['errors'] = 'Data not insert storage';
						}
					}else{
						$data['status'] = 'error';	
						$data['errors'] = 'Upload Errors';
					}
				
			return json_encode($data);
		}
		
		
		public function proses_upload(){
			
			return $this->ortyd->proses_upload_dok();

		}
		
		
		function getcover($urlparent){
			$fieldnya = array();
			//$perusahaan_id =$this->input->post('id');
			$id =$this->input->post('id');
			$tableid =$this->input->post('tableid');
			$table =$urlparent;

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
		
		public function deleteFile(){
			//$this->ortyd->access_check_update($this->module);
			
			$id =$this->input->post('id');
			$tableid =$this->input->post('tableid');
			$table =$this->urlparent;
			
			
			$this->db->where('data_dokumen.table', $table);
			$this->db->where('data_dokumen.tableid', $tableid);
			$this->db->where('data_dokumen.data_id', $id);
			$this->db->where('active',1);
			$query = $this->db->get('data_dokumen');
			$query = $query->result_object();
			if($query){
				
				$this->db->trans_begin();
				
				$dataremove = array(
					'active' 			=> 0,
					'modifiedid'		=> $this->session->userdata('userid'),
					'modified'			=> date('Y-m-d H:i:s')
				);

				$this->db->where('id', $id);
				$updateactive = $this->db->update('data_dokumen', $dataremove);
				
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
		
		
		public function saveEvidence($data_id, $urlparent){
			
			$evidence = $this->input->post('evidence');
			$table = $urlparent;

			if($evidence != '' && $evidence != null){
				$evidence_detail = $evidence;
				foreach( $evidence_detail as $key_ev => $n_ev ) {
					if($n_ev != ''){
						
						$datadetail_ev = array(
								$key_ev 				=> $n_ev,
								'active' 				=> 1,
								'modifiedid'			=> $this->session->userdata('userid'),
								'modified'				=> date('Y-m-d H:i:s')
						);
															
						$this->db->where('id', $data_id);
						$update = $this->db->update($table, $datadetail_ev);
						
						$this->db->where('data_dokumen.table', $table);
						$this->db->where('data_dokumen.tableid', $key_ev);
						$this->db->where('data_dokumen.file_id', $n_ev);
						$queryev = $this->db->get('data_dokumen');
						$queryev = $queryev->result_object();
						if(!$queryev){
							$datadetail_ev = array(
								'table' 				=> $table,
								'tableid' 				=> $key_ev,
								'file_id' 				=> $n_ev,
								'data_id' 				=> $data_id,
								'active' 				=> 1,
								'createdid'				=> $this->session->userdata('userid'),
								'created'				=> date('Y-m-d H:i:s'),
								'modifiedid'			=> $this->session->userdata('userid'),
								'modified'				=> date('Y-m-d H:i:s')
							);
														
							$insert_ev = $this->db->insert('data_dokumen', $datadetail_ev);
						}else{
							$datadetail_ev = array(
								'table' 				=> $table,
								'tableid' 				=> $key_ev,
								'file_id' 				=> $n_ev,
								'data_id' 				=> $data_id,
								'active' 				=> 1,
								'modifiedid'			=> $this->session->userdata('userid'),
								'modified'				=> date('Y-m-d H:i:s')
							);
															
							$this->db->where('data_dokumen.id', $queryev[0]->id);
							$update = $this->db->update('data_dokumen', $datadetail_ev);
						}
					}
				}
			}
		}
		
		
		function getcoverdata($id){
			$fieldnya = array();
			//$perusahaan_id =$this->input->post('id');
			//$id =$this->input->post('id');
			//$tableid =$this->input->post('tableid');
			
			$this->db->select('data_gallery.*');
			$this->db->where('data_gallery.id',$id);
			$querystatus = $this->db->get('data_gallery');
			$querystatus = $querystatus->result_object();
			//print_r($this->db->last_query());
			if($querystatus){
				foreach ($querystatus as $rows) {
					$datanya = array(
						'id' => $rows->id,
						'name' => $rows->name, 	
						'path' => base_url().$rows->path,
						'size' => $rows->file_size/1000, 							
						"extention" =>  $rows->file_store_format, 
					);
					
					array_push($fieldnya, $datanya);
				}
				
				$result = array("message" => "success",'data' => $fieldnya);
				return $result;
			}else{
				$result = array("message" => "error");
				return $result;
			}
			
		}
		
}	