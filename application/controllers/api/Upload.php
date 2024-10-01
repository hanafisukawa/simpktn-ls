<?php

require(APPPATH . '/libraries/REST_Controller.php');
require(APPPATH . '/libraries/simple_html_dom.php');


class Upload extends REST_Controller
{

	private $modeldb = 'm_api';
    function __construct()
    {
        parent::__construct();
		$this->load->model($this->modeldb);
		$this->load->model('m_api_history');
		//$this->load->helper(['jwt', 'authorization']); 
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: false');
		header('Access-Control-Allow-Headers: Origin ,Content-Type,authorization');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header('Access-Control-Max-Age: 86400'); 
		$method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

	
	function uploadBase64_new_post()
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
				$this->response($data, 405);
				die();
			}

			$file = base64_decode($file);

			if ($file === false) {
				$data['status'] = 'error';	
				$data['errors'] = 'base64_decode failed';
				$this->response($data, 405);
				die();
			}
		} else {
			$data['status'] = 'error';	
			$data['errors'] = 'did not match data URI with image data';
			$this->response($data, 405);
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
				'file_store_format'	=> $type,
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
					$data['errors'] = 'Data inserted storage';
						
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
		$this->response($data, 200);
    }
	
	public function proses_upload_post(){
			
		echo $this->ortyd->proses_upload_dok();

	}
	
	function remove_file_post(){

		//Ambil token file
		$user_id = $this->input->post('user_id');
		$token=$this->input->post('token');
		$file=$this->db->get_where('data_gallery',array('token'=>$token));
			
		if($file->num_rows()>0){
			$hasil=$file->row();
			$nama_foto=$hasil->name;
				
			$dataremove = array(
				'active' 			=> 0,
				'modifiedid'		=> $user_id,
				'modified'			=> date('Y-m-d H:i:s')
			);
										
			$this->db->where('token', $token);
			$updateactive = $this->db->update('data_gallery', $dataremove);

			if($updateactive){
						
				$result = array("message" => "success");
				echo json_encode($result);
						
			}else{
				$data['status'] = 'error';	
				$data['errors'] = 'Data not insert storage';
				$result = array("message" => "error", "m" => $data['errors']);
				echo json_encode($result);
			}

		}

	}
	
	public function proses_upload_proposal_post(){
			
		$user_id = $this->input->post('user_id');
		$project_id = $this->input->post('project_id');
		$dokumen_id = $this->input->post('dokumen_id');
		$wo_id = $this->input->post('wo_id');

		try {
	
			$dir = './file/project/'.$project_id.'/dokumen/'.date('Y').'/'.date('m').'/'.date('d');
				
			if(!file_exists($dir)){
				mkdir($dir,0755,true);
			}

			$path = 'file/project/'.$project_id.'/dokumen/'.date('Y').'/'.date('m').'/'.date('d');
			$config['upload_path']   = $dir;
			
			$namereplace = $_FILES["userfile"]['name'];
			$dname 	= 	explode(".", $namereplace);
			$ext 	= 	end($dname);
			$namereplace = str_replace('.'.$ext, '', $namereplace);
			$namereplace = $this->m_api->_clean_special($namereplace);
			$config['file_name'] = $namereplace.'.'.$ext;
			
			$config['allowed_types'] = 'application/pdf|pdf|xls|xlsx|dwg|dxf|dwf|application/octet-stream|png|jpg|jpeg|gif';
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
						
					$this->db->where('data_project_dokumen.project_id', $project_id);
					$this->db->where('data_project_dokumen.dokumen_id', $dokumen_id);
					$querystatus = $this->db->get('data_project_dokumen');	
					$querystatus = $querystatus->result_object();
					if($querystatus){
						
						$datafile = array(
							'file_id' 		=> $insertid,
							'project_id' 	=> $project_id,
							'dokumen_id' 	=> $dokumen_id,
							'wo_id' 		=> $wo_id,
							'deskripsi' 	=> 'Upload',
							'active' 		=> 1,
							'modifiedid'	=> $user_id,
							'modified'		=> date('Y-m-d H:i:s')
						);
														
						$this->db->where('data_project_dokumen.id', $querystatus[0]->id);
						$updateactive = $this->db->update('data_project_dokumen', $datafile);
						
					}else{
						
						$datafile = array(
							'file_id' 		=> $insertid,
							'project_id' 	=> $project_id,
							'dokumen_id' 	=> $dokumen_id,
							'deskripsi' 	=> 'Upload',
							'wo_id' 		=> $wo_id,
							'active' 		=> 1,
							'modifiedid'	=> $user_id,
							'modified'		=> date('Y-m-d H:i:s'),
							'createdid'		=> $user_id,
							'created'		=> date('Y-m-d H:i:s')
						);
						
						$insert = $this->db->insert('data_project_dokumen', $datafile);
						
					}
					
					$result = array("message" => "success",'id' => $insertid, "extention" => strtolower($ext));
					echo json_encode($result);
						
				}else{
					$data['status'] = 'error';	
					$data['errors'] = 'Data not insert storage';
					$result = array("message" => "error", "m" => $data['errors']);
					echo json_encode($result);
				}
			}else{
				$result = array("message" => "error", "m" => $this->upload->display_errors());
				echo json_encode($result);
			}
		}
		catch (Error $e) {
			$result = array("message" => "error",'id' => null);
			echo json_encode($result);
		}
		catch (Exception $e) {
			$result = array("message" => "error",'id' => null);
			echo json_encode($result);
		}

	}
	
	
	public function proses_upload_baut_post(){
		
		$uploadfile = $_FILES["userfile"];
		$user_id = $this->input->post('user_id');
		$project_id = $this->input->post('project_id');
		$project_mitra_id_ref = $this->input->post('project_mitra_id');
		$project_mitra_id = $this->ortyd->select2_getname($project_mitra_id_ref,'data_project_mitra','ref_id','id');
		$dokumen_id = $this->input->post('dokumen_id');
		$wo_id = $this->input->post('wo_id');

		try {
	
			$dir = './file/project/'.$project_id.'/dokumen/'.date('Y').'/'.date('m').'/'.date('d');
				
			if(!file_exists($dir)){
				mkdir($dir,0755,true);
			}

			$path = 'file/project/'.$project_id.'/dokumen/'.date('Y').'/'.date('m').'/'.date('d');
			$config['upload_path']   = $dir;
			
			$namereplace = $_FILES["userfile"]['name'];
			$dname 	= 	explode(".", $namereplace);
			$ext 	= 	end($dname);
			$namereplace = str_replace('.'.$ext, '', $namereplace);
			$namereplace = $this->m_api->_clean_special($namereplace);
			$config['file_name'] = $namereplace.'.'.$ext;
			
			$config['allowed_types'] = 'application/pdf|pdf|xls|xlsx|dwg|dxf|dwf|application/octet-stream';
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
						
					$this->db->where('data_project_dokumen.project_id', $project_id);
					$this->db->where('data_project_dokumen.dokumen_id', $dokumen_id);
					$this->db->where('data_project_dokumen.project_mitra_id', $project_mitra_id);
					$querystatus = $this->db->get('data_project_dokumen');	
					$querystatus = $querystatus->result_object();
					if($querystatus){
						
						$datafile = array(
							'file_id' 		=> $insertid,
							'project_id' 	=> $project_id,
							'project_mitra_id' 	=> $project_mitra_id,
							'dokumen_id' 	=> $dokumen_id,
							'wo_id' 		=> $wo_id,
							'deskripsi' 	=> 'Upload',
							'active' 		=> 1,
							'modifiedid'	=> $user_id,
							'modified'		=> date('Y-m-d H:i:s')
						);
														
						$this->db->where('data_project_dokumen.id', $querystatus[0]->id);
						$updateactive = $this->db->update('data_project_dokumen', $datafile);
						
					}else{
						
						$datafile = array(
							'file_id' 		=> $insertid,
							'project_id' 	=> $project_id,
							'dokumen_id' 	=> $dokumen_id,
							'project_mitra_id' 	=> $project_mitra_id,
							'deskripsi' 	=> 'Upload',
							'wo_id' 		=> $wo_id,
							'active' 		=> 1,
							'modifiedid'	=> $user_id,
							'modified'		=> date('Y-m-d H:i:s'),
							'createdid'		=> $user_id,
							'created'		=> date('Y-m-d H:i:s')
						);
						
						$insert = $this->db->insert('data_project_dokumen', $datafile);
						
					}
					
					$tanggal = date('Y-m-d');
					$file = $dir .'/'.$nama;
					$detail_file = $this->upload->data();
					//$idnya = 0;
					$idnya = $this->m_api_history->saveBAUT($project_mitra_id_ref,'TEST-001',$tanggal,$file,$detail_file);
					
					$result = array("message" => "success","idnya" => $idnya,'id' => $insertid, "extention" => strtolower($ext));
					echo json_encode($result);
						
				}else{
					$data['status'] = 'error';	
					$data['errors'] = 'Data not insert storage';
					$result = array("message" => "error", "m" => $data['errors']);
					echo json_encode($result);
				}
			}else{
				$result = array("message" => "error", "m" => $this->upload->display_errors());
				echo json_encode($result);
			}
		}
		catch (Error $e) {
			$result = array("message" => "error",'id' => null);
			echo json_encode($result);
		}
		catch (Exception $e) {
			$result = array("message" => "error",'id' => null);
			echo json_encode($result);
		}

	}
	
	function remove_file_proposal_post(){

		//Ambil token file
		$user_id = $this->input->post('user_id');
		$project_id = $this->input->post('project_id');
		$dokumen_id = $this->input->post('dokumen_id');
		$token=$this->input->post('token');
		$file=$this->db->get_where('data_gallery',array('token'=>$token));
			
		if($file->num_rows()>0){
			$hasil=$file->row();
			$nama_foto=$hasil->name;
				
			$dataremove = array(
				'active' 			=> 0,
				'modifiedid'		=> $user_id,
				'modified'			=> date('Y-m-d H:i:s')
			);
										
			$this->db->where('token', $token);
			$updateactive = $this->db->update('data_gallery', $dataremove);

			if($updateactive){
						
				$this->db->where('data_project_dokumen.project_id', $project_id);
				$this->db->where('data_project_dokumen.dokumen_id', $dokumen_id);
				$querystatus = $this->db->get('data_project_dokumen');	
				$querystatus = $querystatus->result_object();
				if($querystatus){
						
					$datafile = array(
						'file_id' 		=> null,
						'active' 		=> 1,
						'modifiedid'	=> $user_id,
						'modified'		=> date('Y-m-d H:i:s')
					);
														
					$this->db->where('data_project_dokumen.id', $querystatus[0]->id);
					$updateactive = $this->db->update('data_project_dokumen', $datafile);
						
				}
					
				$result = array("message" => "success");
				echo json_encode($result);
						
			}else{
				$data['status'] = 'error';	
				$data['errors'] = 'Data not insert storage';
				$result = array("message" => "error", "m" => $data['errors']);
				echo json_encode($result);
			}

		}

	}
	
	function proses_upload_dokumen_faq_post(){

			$dir = './file/faq/'.date('Y').'/'.date('m').'/'.date('d');
			$user_id = $this->input->post('user_id');
			
			if(!file_exists($dir)){
				mkdir($dir,0755,true);
			}

			$path = 'file/faq/'.date('Y').'/'.date('m').'/'.date('d');
			
			$config['upload_path']   = $dir;
				
			$namereplace = $_FILES["userfile"]['name'];
			$dname 	= 	explode(".", $namereplace);
			$ext 	= 	end($dname);
			$namereplace = str_replace('.'.$ext, '', $namereplace);
			$namereplace = $this->m_api->_clean_special($namereplace);
			$config['file_name'] = $namereplace.'.'.$ext;
				
			$config['allowed_types'] = 'application/pdf|pdf|xls|xlsx|dwg|dxf|dwf|application/octet-stream|png|jpg|jpeg|gif';
			$this->load->library('upload',$config);

			if($this->upload->do_upload('userfile')){
				$token=$this->input->post('token_foto');
				$nama=$this->upload->data('file_name');
				$size=$this->upload->data('file_size');
				
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
					
				$this->db->insert('data_gallery',$data);
				$insertid = $this->db->insert_id();
				
				$result = array("message" => "success",'id' => $insertid);
				echo json_encode($result);
				
			}
		}
		
		function remove_file_modal_post(){

		//Ambil token file
			$user_id = $this->input->post('user_id');
			$token=$this->input->post('token');
			$file=$this->db->get_where('data_gallery',array('token'=>$token));
			
			if($file->num_rows()>0){
				$hasil=$file->row();
				$nama_foto=$hasil->name;
				
				$dataremove = array(
					'active' 			=> 0,
					'modifiedid'		=> $user_id,
					'modified'			=> date('Y-m-d H:i:s')
				);
										
				$this->db->where('token', $token);
				$updateactive = $this->db->update('data_gallery', $dataremove);
				
				$dataremovemonthly = array(
					'active' 			=> 0,
					'modifiedid'		=> $user_id,
					'modified'			=> date('Y-m-d H:i:s')
				);
										
				$this->db->where('file_id', $hasil->id);
				$updateactive = $this->db->update('data_ticket_file', $dataremovemonthly);
				
				$result = array("message" => "success",'id' => $hasil->id);
				echo json_encode($result);

			}

		}
	
		
}