<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
	//CONFIG VARIABLE
		private $urlparent = 'dashboard'; //NAME TABLE 
		private $identity_id = 'slug'; //IDENTITY TABLE
		private $field = 'slug'; // IDENTITY FROM NAME FOR GET ID
		private $slug_indentity = 'name'; //NAME FIELD 
		private $sorting = 'modified'; // SORT FOR VIEW
		private $exclude = array('color','history_id','status_id','created','modified','createdid','modifiedid','id','active','slug');
		private $exclude_table = array('color','history_id','status_id','created','modified','createdid','modifiedid','id','active','slug');
		//END CONFIG VARIABLE
		
		private $viewname;
		private $viewformname;
		private $tabledb;
		private $tableid;
		private $titlechilddb;
		private $headurldb;
		private $actionurl;
		private $module;
		private $modeldb;

		public function __construct()
		{
			
			
			$this->viewname = $this->urlparent.'/views/v_dashboard';
			$this->viewformname = $this->urlparent.'/views/v_data_form';
			$this->tabledb = $this->urlparent;
			$this->tableid = $this->urlparent.'.id';
			$this->titlechilddb = strtoupper($this->urlparent);
			$this->headurldb = $this->urlparent;
			$this->actionurl = $this->urlparent.'/actiondata';
			$this->module = $this->urlparent;
			$this->modeldb = 'm_dashboard';

			$this->load->model('m_dashboard_popup');
			$this->load->model($this->modeldb,'m_model_data');
			$this->titlechilddb = $this->ortyd->getmodulename($this->module);
			
			$this->ortyd->session_check();
			$this->ortyd->access_check($this->module);
		}
		
		public function index()
		{
			$data['title'] = $this->titlechilddb;
			$data['module'] = $this->module;
			$data['tabledb'] = $this->tabledb;
			$data['identity_id'] = $this->identity_id;
			$data['exclude_table'] = $this->exclude_table;
			$data['headurl'] = $this->headurldb;
			$data['linkdata'] = $this->urlparent.'/get_data';
			$data['linkcreate'] = $this->urlparent.'/createdata';
			$this->template->load('main',$this->viewname, $data);
		}
		
		function action_tipe(){
			$input = $this->input->post('input');
			$this->session->set_userdata('tipe_data', $input);

			$result = array("message" => "success");
			echo json_encode($result);
		}
		
		function setminiside(){
			if($this->session->userdata('hassidelarge') == 1){
				$klik = 0;
				$this->session->set_userdata('hassidelarge', 0);
			}else{
				$klik = 1;
				$this->session->set_userdata('hassidelarge', 1);
			}
			
			$result = array("message" => "success", "data" => $klik);
			echo json_encode($result);
		}
		
		function isonline(){
			
			$userid = $this->session->userdata('userid');
			$logged_in = $this->session->userdata('logged_in');
			if ( !$userid && $logged_in != TRUE) {
				$result = array("message" => "notlogin");
				echo json_encode($result);
			}else{
				$data = array(
					'online_date' => date('Y-m-d H:i:s')
				);
									
				$this->db->where('id', $this->session->userdata('userid'));
				$update = $this->db->update('users_data', $data);
				if($update){
					$result = array("message" => "success", "data" => $update);
					echo json_encode($result);
				}else{
					$result = array("message" => "error");
					echo json_encode($result);
				}
			}
		}
		
		
		function getcount(){
			
			$totalmitra = 0;
			$totalmitrapra = 0;
			$totalmitrainput = 0;
			$totalmitraverified = 0;
			$totalnotakebutuhan = 0;
			$totaljustifikasikebutuhan = 0;
			$totalspph = 0;
			$totalspk = 0;
			$totalbast = 0;
			$totalinvoice = 0;
			
			$this->db->select('count(vw_data_perusahaan.id) as jumlah');
			$this->db->where_in('vw_data_perusahaan.status_id',array(1,2,7));
			$query = $this->db->get('vw_data_perusahaan');
			$query = $query->result_object();
			if($query){
				$totalmitra = $query[0]->jumlah;
			}
			
			$this->db->select('count(vw_data_perusahaan.id) as jumlah');
			$this->db->where_in('vw_data_perusahaan.status_id',array(1));
			$query = $this->db->get('vw_data_perusahaan');
			$query = $query->result_object();
			if($query){
				$totalmitrapra = $query[0]->jumlah;
			}
			
			$this->db->select('count(vw_data_perusahaan.id) as jumlah');
			$this->db->where_in('vw_data_perusahaan.status_id',array(2,3,4,5,6));
			$query = $this->db->get('vw_data_perusahaan');
			$query = $query->result_object();
			if($query){
				$totalmitrainput = $query[0]->jumlah;
			}
			
			$this->db->select('count(vw_data_perusahaan.id) as jumlah');
			$this->db->where_in('vw_data_perusahaan.status_id',array(7));
			$query = $this->db->get('vw_data_perusahaan');
			$query = $query->result_object();
			if($query){
				$totalmitraverified = $query[0]->jumlah;
			}
			
			$this->db->select('count(vw_data_nota_kebutuhan.id) as jumlah');
			if( $this->session->userdata('group_id') != 1 && $this->session->userdata('group_id') != 2 && $this->session->userdata('group_id') != 4){
				$this->db->where('vw_data_nota_kebutuhan.createdid',$this->session->userdata('userid'));
			}
			$this->db->where('vw_data_nota_kebutuhan.spph_id is null',null);
			$query = $this->db->get('vw_data_nota_kebutuhan');
			$query = $query->result_object();
			if($query){
				$totalnotakebutuhan = $query[0]->jumlah;
			}
			
			$this->db->select('count(vw_data_justifikasi_kebutuhan.id) as jumlah');
			if( $this->session->userdata('group_id') != 1 && $this->session->userdata('group_id') != 2 && $this->session->userdata('group_id') != 4){
				$this->db->where('vw_data_justifikasi_kebutuhan.createdid',$this->session->userdata('userid'));
			}
			$this->db->where('vw_data_justifikasi_kebutuhan.spph_id is null',null);
			$query = $this->db->get('vw_data_justifikasi_kebutuhan');
			$query = $query->result_object();
			if($query){
				$totaljustifikasikebutuhan = $query[0]->jumlah;
			}
			
			$this->db->select('count(vw_data_spph.id) as jumlah');
			$this->db->where_in('vw_data_spph.status_id',array(0,1));
			if(($this->session->userdata('tipe_data') != '' && $this->session->userdata('tipe_data') != null)){
				$this->db->where('vw_data_spph.tipe_spph',$this->session->userdata('tipe_data'));
			} 
			$query = $this->db->get('vw_data_spph');
			$query = $query->result_object();
			if($query){
				$totalspph = $query[0]->jumlah;
			}
			
			$this->db->select('count(vw_data_spph.id) as jumlah');
			$this->db->where('vw_data_spph.spk_id is not null',null);
			if(($this->session->userdata('tipe_data') != '' && $this->session->userdata('tipe_data') != null)){
				$this->db->where('vw_data_spph.tipe_spph',$this->session->userdata('tipe_data'));
			}
			$this->db->where_in('vw_data_spph.status_id',array(6,7));
			$query = $this->db->get('vw_data_spph');
			$query = $query->result_object();
			if($query){
				$totalspk = $query[0]->jumlah;
			}
			
			$this->db->select('count(vw_data_bast.bast_id) as jumlah');
			$this->db->where('vw_data_bast.bast_nilai is not null',null);
			$this->db->where('vw_data_bast.kondisi_id !=',1);
			if(($this->session->userdata('tipe_data') != '' && $this->session->userdata('tipe_data') != null)){
				$this->db->where('vw_data_bast.tipe_spph',$this->session->userdata('tipe_data'));
			} 
			$query = $this->db->get('vw_data_bast');
			$query = $query->result_object();
			if($query){
				$totalbast = $query[0]->jumlah;
			}
			
			$this->db->select('count(vw_data_invoice.invoice_id) as jumlah');
			$this->db->where('vw_data_invoice.invoice_id is not null',null);
			//$this->db->where('vw_data_invoice.status_id',4);
			if(($this->session->userdata('tipe_data') != '' && $this->session->userdata('tipe_data') != null)){
				$this->db->where('vw_data_invoice.tipe_spph',$this->session->userdata('tipe_data'));
			} 
			$query = $this->db->get('vw_data_invoice');
			$query = $query->result_object();
			if($query){
				$totalinvoice = $query[0]->jumlah;
			}
			
			$datanya = array(
				'total_mitra' => $totalmitra,
				'total_mitra_pra' => $totalmitrapra,
				'total_mitra_input' => $totalmitrainput,
				'total_mitra_verified' => $totalmitraverified,
				'total_nota_kebutuhan' => $totalnotakebutuhan,
				'total_justifikasi_kebutuhan' => $totaljustifikasikebutuhan,
				'total_spph' => $totalspph,
				'total_spk' => $totalspk,
				'total_bast' => $totalbast,
				'total_invoice' => $totalinvoice
			);
			
			$result = array("message" => "success", "data" => $datanya);
			
			echo json_encode($result);
		}
		
		
		function uploadBase64_new()
		{
			echo $this->m_dashboard->uploadBase64_new();
		}
		
		public function select2() {
			
			$table = $this->input->post('table');
			$id = $this->input->post('id');
			$name = $this->input->post('name');
			$reference = $this->input->post('reference');
			$q = $this->input->post('q');
			
			if($table == 'master_unit'){
				$reference = 'SBU';
			}
			
			if(!$q){
				$q = '';
			}
			
			echo $this->ortyd->select2custom($id,$name,$q,$table,$reference);
			
		}
		
		public function updatenaming(){
			
			$only = $this->input->post('only');
			$size = $this->input->post('size');
			$meta_value = $this->input->post('value');
			$meta_tipe = $this->input->post('tipe');
			$meta_table = $this->input->post('table_change');
			$meta_id = $this->input->post('table_change_id');
			$meta_table_ref = $this->input->post('table_ref') ?? null;
			$meta_table_id_ref = $this->input->post('table_id_ref') ?? null;
			$meta_table_name_ref = $this->input->post('table_name_ref') ?? null;
			
			$this->db->where('meta_id',$meta_id);
			$this->db->where('meta_table',$meta_table);
			$query = $this->db->get('translate');
			$query = $query->result_object();
			if(!$query){
				$datacmcode = array(
					'meta_size' 	=> $size,
					'meta_tipe' 	=> $meta_tipe,
					'meta_value' 	=> $meta_value,
					'meta_table' 	=> $meta_table,
					'meta_table_ref' 		=> $meta_table_ref,
					'meta_table_id_ref' 	=> $meta_table_id_ref,
					'meta_table_name_ref' 	=> $meta_table_name_ref,
					'meta_id' 		=> $meta_id,
					'created' 		=> date('Y-m-d H:i:s'),
					'createdid' 	=> $this->session->userdata('userid'),
					'modified' 		=> date('Y-m-d H:i:s'),
					'modifiedid' 	=> $this->session->userdata('userid'),
					'active' 		=> 1
				);
									
				$updatecmcode = $this->db->insert('translate', $datacmcode);
				if($updatecmcode){
					$result = array("status" => "success");
					echo json_encode($result);
				}else{
					$result = array("status" => "error");
					echo json_encode($result);
				}
			
			}else{
				
				if($meta_tipe == 'SELECT'){
					
					if($only == '1'){
						$datacmcode = array(
							'meta_size' 	=> $size,
							'meta_value' 	=> $meta_value,
							'meta_table' 	=> $meta_table,
							'meta_id' 		=> $meta_id,
							'modified' 		=> date('Y-m-d H:i:s'),
							'modifiedid' 	=> $this->session->userdata('userid'),
							'active' 		=> 1
						);
					}else{
						$datacmcode = array(
							'meta_size' 	=> $size,
							'meta_tipe' 	=> $meta_tipe,
							'meta_value' 	=> $meta_value,
							'meta_table' 	=> $meta_table,
							'meta_table_ref' 		=> $meta_table_ref,
							'meta_table_id_ref' 	=> $meta_table_id_ref,
							'meta_table_name_ref' 	=> $meta_table_name_ref,
							'meta_id' 		=> $meta_id,
							'modified' 		=> date('Y-m-d H:i:s'),
							'modifiedid' 	=> $this->session->userdata('userid'),
							'active' 		=> 1
						);
					}
					
				}else{
					
					if($only == '1'){
						$datacmcode = array(
							'meta_size' 	=> $size,
							'meta_value' 	=> $meta_value,
							'meta_table' 	=> $meta_table,
							'meta_id' 		=> $meta_id,
							'modified' 		=> date('Y-m-d H:i:s'),
							'modifiedid' 	=> $this->session->userdata('userid'),
							'active' 		=> 1
						);
					}else{
						$datacmcode = array(
							'meta_size' 	=> $size,
							'meta_tipe' 	=> $meta_tipe,
							'meta_value' 	=> $meta_value,
							'meta_table' 	=> $meta_table,
							'meta_id' 		=> $meta_id,
							'modified' 		=> date('Y-m-d H:i:s'),
							'modifiedid' 	=> $this->session->userdata('userid'),
							'active' 		=> 1
						);
					}
					
					
				}
				

				$this->db->where('id',$query[0]->id);				
				$updatecmcode = $this->db->update('translate', $datacmcode);
				if($updatecmcode){
					$result = array("status" => "success");
					echo json_encode($result);
				}else{
					$result = array("status" => "error");
					echo json_encode($result);
				}
			}
				
		}
		
		
		public function updateview(){
			//die();
			
			$modulview = $this->input->post('modulview');
			$tabelview = $this->input->post('tabelview');
			$dataview = json_encode($this->input->post('dataview'));
			
			$this->db->where('module',$modulview);
			$this->db->where('table',$tabelview);
			$query = $this->db->get('translate_view');
			$query = $query->result_object();
			if(!$query){
				$datacmcode = array(
					'module' 		=> $modulview,
					'table' 		=> $tabelview,
					'data' 			=> $dataview,
					'created' 		=> date('Y-m-d H:i:s'),
					'createdid' 	=> $this->session->userdata('userid'),
					'modified' 		=> date('Y-m-d H:i:s'),
					'modifiedid' 	=> $this->session->userdata('userid'),
					'active' 		=> 1
				);
									
				$updatecmcode = $this->db->insert('translate_view', $datacmcode);
				if($updatecmcode){
					$result = array("status" => "success");
					echo json_encode($result);
				}else{
					$result = array("status" => "error");
					echo json_encode($result);
				}
			
			}else{
				
				$datacmcode = array(
					'module' 		=> $modulview,
					'table' 		=> $tabelview,
					'data' 			=> $dataview,
					'modified' 		=> date('Y-m-d H:i:s'),
					'modifiedid' 	=> $this->session->userdata('userid'),
					'active' 		=> 1
				);
				

				$this->db->where('id',$query[0]->id);				
				$updatecmcode = $this->db->update('translate_view', $datacmcode);
				if($updatecmcode){
					$result = array("status" => "success");
					echo json_encode($result);
				}else{
					$result = array("status" => "error");
					echo json_encode($result);
				}
			}
		}
		
		
		public function saveAbsen(){
			//die();
			
			$user_id = $this->input->post('user_id');

			$this->db->where('user_id',$user_id);
			$this->db->where('type', 'Website');
			$this->db->where('tanggal',date('Y-m-d'));
			$query = $this->db->get('data_absensi');
			$query = $query->result_object();
			if(!$query){
				$datacmcode = array(
					'user_id' 			=> $user_id,
					'latitude' 			=> null,
					'longitude' 		=> null,
					'type' 				=> 'Website',
					'tanggal' 			=> date('Y-m-d'),
					'slug' 				=> $user_id.date('YmdHis').rand(1000,9999),
					'active'			=> 1,
					'createdid'			=> $user_id,
					'modifiedid'		=> $user_id,
					'created'			=> date('Y-m-d H:i:s'),
					'modified'			=> date('Y-m-d H:i:s')
				);
									
				$updatecmcode = $this->db->insert('data_absensi', $datacmcode);
				if($updatecmcode){
					$result = array("status" => "success");
					echo json_encode($result);
				}else{
					$result = array("status" => "error");
					echo json_encode($result);
				}
			
			}else{
				
				$result = array("status" => "error");
				echo json_encode($result);
				
			}
		}
		
		public function updatevieworder(){
			//die();
			
			$modulview = $this->input->post('modulview');
			$tabelview = $this->input->post('tabelview');
			$tableorder = $this->input->post('tableorder');
			$dataview = json_encode($this->input->post('dataview'));
			
			$this->db->where('module',$modulview);
			$this->db->where('table',$tabelview);
			$query = $this->db->get('translate_view');
			$query = $query->result_object();
			if(!$query){
				$datacmcode = array(
					'module' 		=> $modulview,
					'table' 		=> $tabelview,
					'data' 			=> $dataview,
					'data_order' 	=> $tableorder,
					'created' 		=> date('Y-m-d H:i:s'),
					'createdid' 	=> $this->session->userdata('userid'),
					'modified' 		=> date('Y-m-d H:i:s'),
					'modifiedid' 	=> $this->session->userdata('userid'),
					'active' 		=> 1
				);
									
				$updatecmcode = $this->db->insert('translate_view', $datacmcode);
				if($updatecmcode){
					$result = array("status" => "success");
					echo json_encode($result);
				}else{
					$result = array("status" => "error");
					echo json_encode($result);
				}
			
			}else{
				
				$datacmcode = array(
					'module' 		=> $modulview,
					'table' 		=> $tabelview,
					'data' 			=> $dataview,
					'data_order' 	=> $tableorder,
					'modified' 		=> date('Y-m-d H:i:s'),
					'modifiedid' 	=> $this->session->userdata('userid'),
					'active' 		=> 1
				);
				

				$this->db->where('id',$query[0]->id);				
				$updatecmcode = $this->db->update('translate_view', $datacmcode);
				if($updatecmcode){
					$result = array("status" => "success");
					echo json_encode($result);
				}else{
					$result = array("status" => "error");
					echo json_encode($result);
				}
			}
		}
		
		public function updatevieworderform(){
			//die();
			
			$modulview = $this->input->post('modulview');
			$tabelview = $this->input->post('tabelview');
			$tableorder = $this->input->post('tableorder');
			$dataview = json_encode($this->input->post('dataview'));
			
			$this->db->where('module',$modulview);
			$this->db->where('table',$tabelview);
			$query = $this->db->get('translate_view');
			$query = $query->result_object();
			if(!$query){
				$datacmcode = array(
					'module' 		=> $modulview,
					'table' 		=> $tabelview,
					'data_order_form' 	=> $tableorder,
					'created' 		=> date('Y-m-d H:i:s'),
					'createdid' 	=> $this->session->userdata('userid'),
					'modified' 		=> date('Y-m-d H:i:s'),
					'modifiedid' 	=> $this->session->userdata('userid'),
					'active' 		=> 1
				);
									
				$updatecmcode = $this->db->insert('translate_view', $datacmcode);
				if($updatecmcode){
					$result = array("status" => "success");
					echo json_encode($result);
				}else{
					$result = array("status" => "error");
					echo json_encode($result);
				}
			
			}else{
				
				$datacmcode = array(
					'module' 		=> $modulview,
					'table' 		=> $tabelview,
					'data_order_form' 	=> $tableorder,
					'modified' 		=> date('Y-m-d H:i:s'),
					'modifiedid' 	=> $this->session->userdata('userid'),
					'active' 		=> 1
				);
				

				$this->db->where('id',$query[0]->id);				
				$updatecmcode = $this->db->update('translate_view', $datacmcode);
				if($updatecmcode){
					$result = array("status" => "success");
					echo json_encode($result);
				}else{
					$result = array("status" => "error");
					echo json_encode($result);
				}
			}
		}
		
		public function getheader(){
			
			$module = $this->input->post('id');
			
			$datanya = array();
			$this->db->where('master_menu.module',$module);
			$query = $this->db->get('master_menu');
			$query = $query->result_object();
			if($query){

				foreach($query as $rows){
					
					$datanya = array(
						'name' 				=> $rows->name,
						'description' 		=> $rows->description,
						'icon' 				=> '<i class="'.$rows->icon.'"></i>'
					);
				}
				$result = array("message" => "success","data"=> $datanya);
				echo json_encode($result);
			}else{
				$result = array("message" => "error");
				echo json_encode($result);
			}
				
		}
		
		public function getColumn(){
			echo $this->m_dashboard_popup->getColumn();
		}
		
		public function getColumnDetail(){
			echo $this->m_dashboard_popup->getColumnDetail();
		}
		
		
		public function projectbysales(){
			
			$tahun = $this->input->post('tahun');
			$tipe = $this->input->post('project_tipe');
			$tipenya = $tipe.' '.$tahun;
			
			$datalabel = [];
			$dataisi = [];
			$datavalue = [];
			
			$this->db->select('*');
			$querybulan = $this->db->get('master_bulan');
			$querybulan = $querybulan->result_object();
			if($querybulan){
				foreach($querybulan as $rowsbulan){
					$datalabelnya = [
						"label" => $rowsbulan->code
					];
					
					array_push($datalabel,$datalabelnya);
				}
			}
			
			if($tipe == 'SALES'){
				$querytipe = array($tipenya,'TARGET 2024', 'OUTLOOK '.$tahun);
			}else{
				$querytipe = array($tipenya,'TARGET 2024', 'OUTLOOK '.$tahun);
			}
			
			if($querytipe){
				foreach($querytipe as $rowsdata){
					
					if($rowsdata == $tipenya){
						$color = '#f66d44';
					}elseif($rowsdata == 'TARGET 2024'){
						$color = '#e6f69d';
					}else{
						$color = '#64c2a6';
					}
					
					$datavalue = [];
					$this->db->select('*');
					$querybulan = $this->db->get('master_bulan');
					$querybulan = $querybulan->result_object();
					if($querybulan){
						foreach($querybulan as $rowsbulan){
							
							if($rowsdata == $tipenya){
								$dash='0';
								$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.'.$rowsbulan->code.') as total_sales');
								$this->db->where('master_legend', $tipenya);
								$query = $this->db->get('vw_dashboard_tmp');
								$query = $query->result_object();
								if($query){
									$values = $query[0]->total_sales;
								}else{
									$values = 0;
								}
							}elseif($rowsdata == 'TARGET 2024'){
								$dash='0';
								$this->db->select('sum(vw_dashboard_tmp_target.'.$rowsbulan->code.') as total_sales');
								//$this->db->where('vw_dashboard_tmp_target', 'SALES 2023');
								$query = $this->db->get('vw_dashboard_tmp_target');
								$query = $query->result_object();
								if($query){
									$values = $query[0]->total_sales;
								}else{
									$values = 0;
								}
							}elseif($rowsdata == 'OUTLOOK 2024'){
								$dash='1';
								$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.'.$rowsbulan->code.') as total_sales');
								$this->db->where('master_legend', 'REVENUE 2024');
								//$this->db->where_in('funnel', array('F3. Bidding','F4. Negotiation'));
								$query = $this->db->get('vw_dashboard_tmp');
								$query = $query->result_object();
								if($query){
									$values = $query[0]->total_sales;
								}else{
									$values = 0;
								}
							}elseif($rowsdata == 'OUTLOOK 2023'){
								$dash='1';
								$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.'.$rowsbulan->code.') as total_sales');
								$this->db->where('master_legend', 'LOP 2023');
								$this->db->where_in('funnel', array('F3. Bidding','F4. Negotiation'));
								$query = $this->db->get('vw_dashboard_tmp');
								$query = $query->result_object();
								if($query){
									$values = $query[0]->total_sales;
								}else{
									$values = 0;
								}
							}elseif($rowsdata == 'OUTLOOK'){
								$dash='1';
								$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.'.$rowsbulan->code.') as total_sales');
								$this->db->where('master_legend', 'LOP 2024');
								$this->db->where_in('funnel', array('F3. Bidding','F4. Negotiation'));
								$query = $this->db->get('vw_dashboard_tmp');
								$query = $query->result_object();
								if($query){
									$values = $query[0]->total_sales;
								}else{
									$values = 0;
								}
							}else{
								$dash='0';
								$values = 0;
							}
							
							$datalabelnya = [
								"dashed" => $dash,
								"allowDrag" => "0",
								"value" => $values 
							];
							
							array_push($datavalue,$datalabelnya);
						}
					}
			
					
					$dataisinya = [
						"seriesname" => $rowsdata,
						"color"=> $color,
						"anchorBgColor"=> $color,
						"allowDrag"=> "0",
						"data" => $datavalue 
					];

							
					array_push($dataisi,$dataisinya);
				}
			}else{
				$datalabelnya = [
					"label" => ''
				];
							
				$dataisinya = [
					"seriesname" => "Sales 2024",
					"color"=> "#feae65",
					"anchorBgColor"=> "#2d87bb",
					"allowDrag"=> "0",
					"data" => $datavalue 
				];
								
				array_push($dataisi,$dataisinya);
			}

			$jayParsedAry = [
			   "message" => "success", 
			   "data" => $datalabel,
			   "data5" => $dataisi, 
			   "total" => "149.57 M" 
			]; 
			
			echo json_encode($jayParsedAry);
	
		}
		
		function projectbychannel(){
			
			$tahun = $this->input->post('tahun');
			$tipe = $this->input->post('project_tipe');
			$tipenya = $tipe.' '.$tahun;
			
			$datalabel = [];
			$dataisi = [];
			$datavalue = [];
			
			$this->db->select('*');
			$querybulan = $this->db->get('master_bulan');
			$querybulan = $querybulan->result_object();
			if($querybulan){
				foreach($querybulan as $rowsbulan){
					$datalabelnya = [
						"label" => $rowsbulan->code
					];
					
					array_push($datalabel,$datalabelnya);
				}
			}
			
			
		
			$query = $this->db->get('master_channel');
			$query = $query->result_object();
			//echo $this->db->last_query();
			if($query){
				foreach($query as $rowsdata){
					
					$datavalue = [];
					$this->db->select('*');
					$querybulan = $this->db->get('master_bulan');
					$querybulan = $querybulan->result_object();
					if($querybulan){
						foreach($querybulan as $rowsbulan){
							
							$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.'.$rowsbulan->code.') as total_sales');
							$this->db->where('channel', $rowsdata->name);
							$this->db->where('master_legend', $tipenya);
							$query = $this->db->get('vw_dashboard_tmp');
							$query = $query->result_object();
							if($query){
								$values = $query[0]->total_sales;
							}else{
								$values = 0;
							}
							
							$datalabelnya = [
								"displayValue" => $rowsdata->name.' | '.$this->ortyd->custom_number_format((float)$query[0]->total_sales)." | ".$query[0]->total_io, 
								"value" => $values 
							];
							
							array_push($datavalue,$datalabelnya);
						}
					}
			
					$dataisinya = [
						"seriesname" => $rowsdata->name, 
						"color" => $rowsdata->color, 
						"data" => $datavalue 
					];

							
					array_push($dataisi,$dataisinya);
				}
			}else{
				$datalabelnya = [
					"label" => ''
				];
							
				$dataisinya = [
					"seriesname" => "GTMA", 
					"color" => "#feae65", 
					"data" => $datavalue 
				];
								
				array_push($dataisi,$dataisinya);
			}

			$jayParsedAry = [
			   "message" => "success", 
			   "data" => $datalabel,
			   "data5" => $dataisi, 
			   "total" => "149.57 M" 
			]; 
			
			echo json_encode($jayParsedAry);
	
		}
		
	function projectbyfunnel() {
	
		$tahun = $this->input->post('tahun');
		$tipe = $this->input->post('project_tipe');
		$tipenya = $tipe.' '.$tahun;
			
		$datafunnel = array();
		$funnel = array('F0. Lead','F1. Opportunity','F2. Proposal','F3. Bidding','F4. Negotiation','F5. Won','-');
		$funnel_width = array(50,40,30,20,10,1,0);
		$funnel_color = array('#97c5ff','#c7deff','#a9dbff','#baeafe','#def1ff','#f8f8f8','#fff');
		
		$x=0;
		foreach ($funnel as $rows) {
			$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.total_sales) as total_sales');
			$this->db->where('funnel', $rows);
			$this->db->where('master_legend', $tipenya);
			$query = $this->db->get('vw_dashboard_tmp');
			$query = $query->result_object();
			//echo $this->db->last_query();

			if($query){
				foreach($query as $rowsdata){
					
					$datafunnelnya = [
						"label" => $rows, 
						"displayValue" => $rows." ".$this->ortyd->custom_number_format((float)$rowsdata->total_sales)." | ".$rowsdata->total_io." Nomor IO", 
						"color" => $funnel_color[$x],
						"value" => $funnel_width[$x]
					];
					
					array_push($datafunnel,$datafunnelnya);
				}
			}else{
				$datafunnelnya = [
					"label" => $rows, 
					"displayValue" => "", 
					"color" => $funnel_color[$x],
					"value" => $funnel_width[$x]
				];
					
				array_push($datafunnel,$datafunnelnya);
			}
			
			$x++;
		}
		
		$jayParsedAry = [
			 "message" => "success", 
			 "data" => $datafunnel,
			 "total" => "1.37 rb" 
		];
		
		echo json_encode($jayParsedAry);

	}
	
	function projectbyam() {
		
		$tahun = $this->input->post('tahun');
		$tipe = $this->input->post('project_tipe');
		$tipenya = $tipe.' '.$tahun;
		
		$datalabel = [];
		$dataisi = [];
		$this->db->select('nama_am, count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.total_sales) as total_sales');
		$this->db->where('master_legend', $tipenya);
		$this->db->group_by('nama_am,master_legend');
		$this->db->order_by('total_sales','DESC');
		$this->db->limit(10);
		$query = $this->db->get('vw_dashboard_tmp');
		$query = $query->result_object();
			//echo $this->db->last_query();

		if($query){
			foreach($query as $rowsdata){
					
					$datalabelnya = [
						"label" => $rowsdata->nama_am
					];
					
					$dataisinya = [
						"displayValue" => $this->ortyd->custom_number_format((float)$rowsdata->total_sales)." | ".$rowsdata->total_io,
						"value" => (float)$rowsdata->total_sales
					];
					
					array_push($datalabel,$datalabelnya);
					array_push($dataisi,$dataisinya);
			}
		}else{
				$datalabelnya = [
					"label" => ''
				];
				
				$dataisinya = [
					"displayValue"  => '',
					"value"  => 0
				];
					
			array_push($datalabel,$datalabelnya);
			array_push($dataisi,$dataisinya);
		}
			
		$jayParsedAry = [
		   "message" => "success", 
		   "data" => $datalabel,
		   "data5" => [
				[
					"seriesname" => "Value Project", 
					"color" => "#c7deff", 
					"data" => $dataisi
				] 
			], 
		   "total" => "149.57 M" 
		]; 
		
		echo json_encode($jayParsedAry);

			
	}
	
	function projectbyubis() {
		
		$tahun = $this->input->post('tahun');
		$tipe = $this->input->post('project_tipe');
		$tipenya = $tipe.' '.$tahun;
		
		$datafunnel = array();
		$funnel = array('Professional Services','CPE Integrator','Seat Management','Other');
		$funnel_color = array('#f66d44','#feae65','#e6f69d','#64c2a6');
		
		$x=0;
		foreach ($funnel as $rows) {
			$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.total_sales) as total_sales');
			$this->db->where('sbu', $rows);
			$this->db->where('master_legend', $tipenya);
			$query = $this->db->get('vw_dashboard_tmp');
			$query = $query->result_object();
			//echo $this->db->last_query();

			if($query){
				foreach($query as $rowsdata){
					
					$datafunnelnya = [
						"label" => $rows, 
						"displayValue" => $rows." ".$this->ortyd->custom_number_format((float)$rowsdata->total_sales)." | ".$rowsdata->total_io." Nomor IO", 
						"color" => $funnel_color[$x],
						"value" => (float)$rowsdata->total_sales
					];
					
					array_push($datafunnel,$datafunnelnya);
				}
			}else{
				$datafunnelnya = [
					"label" => $rows, 
					"displayValue" => "", 
					"color" => $funnel_color[$x],
					"value" => (float)$rowsdata->total_sales
				];
					
				array_push($datafunnel,$datafunnelnya);
			}
			
			$x++;
		}
		
		$jayParsedAry = [
			 "message" => "success", 
			 "data" => $datafunnel,
			 "total" => "1.37 rb" 
		];
		
		echo json_encode($jayParsedAry);
		
	}
	
	function projectbyportfolio() {
		
		$tahun = $this->input->post('tahun');
		$tipe = $this->input->post('project_tipe');
		$tipenya = $tipe.' '.$tahun;
		
		$datalabel = [];
			$dataisi = [];
			$datavalue = [];
			
			$this->db->select('*');
			$querybulan = $this->db->get('master_bulan');
			$querybulan = $querybulan->result_object();
			if($querybulan){
				foreach($querybulan as $rowsbulan){
					$datalabelnya = [
						"label" => $rowsbulan->code
					];
					
					array_push($datalabel,$datalabelnya);
				}
			}
			
			
		
			$query = $this->db->get('master_portfolio');
			$query = $query->result_object();
			//echo $this->db->last_query();
			if($query){
				foreach($query as $rowsdata){
					
					$datavalue = [];
					$this->db->select('*');
					$querybulan = $this->db->get('master_bulan');
					$querybulan = $querybulan->result_object();
					if($querybulan){
						foreach($querybulan as $rowsbulan){
							
							$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.'.$rowsbulan->code.') as total_sales');
							$this->db->where('lower(portofolio)', strtolower($rowsdata->name));
							$this->db->where('master_legend', $tipenya);
							$query = $this->db->get('vw_dashboard_tmp');
							$query = $query->result_object();
							if($query){
								$values = $query[0]->total_sales;
							}else{
								$values = 0;
							}
							
							$datalabelnya = [
								"displayValue" => $rowsdata->name.' | '.$this->ortyd->custom_number_format((float)$query[0]->total_sales)." | ".$query[0]->total_io, 
								"value" => $values 
							];
							
							array_push($datavalue,$datalabelnya);
						}
					}
			
					$dataisinya = [
						"seriesname" => $rowsdata->name, 
						"color" => $rowsdata->color, 
						"data" => $datavalue 
					];

							
					array_push($dataisi,$dataisinya);
				}
			}else{
				$datalabelnya = [
					"label" => ''
				];
							
				$dataisinya = [
					"seriesname" => "GTMA", 
					"color" => "#feae65", 
					"data" => $datavalue 
				];
								
				array_push($dataisi,$dataisinya);
			}

			$jayParsedAry = [
			   "message" => "success", 
			   "data" => $datalabel,
			   "data5" => $dataisi, 
			   "total" => "149.57 M" 
			]; 
			
			echo json_encode($jayParsedAry);
	}
	
	function projectbyrecuring() {
		
		$tahun = $this->input->post('tahun');
		$tipe = $this->input->post('project_tipe');
		$tipenya = $tipe.' '.$tahun;
		
		$datalabel = [];
			$dataisi = [];
			$datavalue = [];
			
			$this->db->select('*');
			$querybulan = $this->db->get('master_bulan');
			$querybulan = $querybulan->result_object();
			if($querybulan){
				foreach($querybulan as $rowsbulan){
					$datalabelnya = [
						"label" => $rowsbulan->code
					];
					
					array_push($datalabel,$datalabelnya);
				}
			}
			
			
		
			$query = $this->db->get('master_recuring');
			$query = $query->result_object();
			//echo $this->db->last_query();
			if($query){
				foreach($query as $rowsdata){
					
					$datavalue = [];
					$this->db->select('*');
					$querybulan = $this->db->get('master_bulan');
					$querybulan = $querybulan->result_object();
					if($querybulan){
						foreach($querybulan as $rowsbulan){
							
							$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.'.$rowsbulan->code.') as total_sales');
							$this->db->where('lower(term_of_payment)', strtolower($rowsdata->name));
							$this->db->where('master_legend', $tipenya);
							$query = $this->db->get('vw_dashboard_tmp');
							$query = $query->result_object();
							if($query){
								$values = $query[0]->total_sales;
							}else{
								$values = 0;
							}
							
							$datalabelnya = [
								"displayValue" => $rowsdata->name.' | '.$this->ortyd->custom_number_format((float)$query[0]->total_sales)." | ".$query[0]->total_io, 
								"value" => $values 
							];
							
							array_push($datavalue,$datalabelnya);
						}
					}
			
					$dataisinya = [
						"seriesname" => $rowsdata->name, 
						"color" => $rowsdata->color, 
						"data" => $datavalue 
					];

							
					array_push($dataisi,$dataisinya);
				}
			}else{
				$datalabelnya = [
					"label" => ''
				];
							
				$dataisinya = [
					"seriesname" => "GTMA", 
					"color" => "#feae65", 
					"data" => $datavalue 
				];
								
				array_push($dataisi,$dataisinya);
			}

			$jayParsedAry = [
			   "message" => "success", 
			   "data" => $datalabel,
			   "data5" => $dataisi, 
			   "total" => "149.57 M" 
			]; 
			
			echo json_encode($jayParsedAry);
	}
	
	function projectbysustain() {
		
		$tahun = $this->input->post('tahun');
		$tipe = $this->input->post('project_tipe');
		$tipenya = $tipe.' '.$tahun;
		
		$datalabel = [];
			$dataisi = [];
			$datavalue = [];
			
			$this->db->select('*');
			$querybulan = $this->db->get('master_bulan');
			$querybulan = $querybulan->result_object();
			if($querybulan){
				foreach($querybulan as $rowsbulan){
					$datalabelnya = [
						"label" => $rowsbulan->code
					];
					
					array_push($datalabel,$datalabelnya);
				}
			}
			
			
		
			$query = $this->db->get('master_sustain');
			$query = $query->result_object();
			//echo $this->db->last_query();
			if($query){
				foreach($query as $rowsdata){
					
					$datavalue = [];
					$this->db->select('*');
					$querybulan = $this->db->get('master_bulan');
					$querybulan = $querybulan->result_object();
					if($querybulan){
						foreach($querybulan as $rowsbulan){
							
							$this->db->select('count(vw_dashboard_tmp.io_referensi) as total_io, sum(vw_dashboard_tmp.'.$rowsbulan->code.') as total_sales');
							$this->db->where('lower(kualifikasi)', strtolower($rowsdata->name));
							$this->db->where('master_legend', $tipenya);
							$query = $this->db->get('vw_dashboard_tmp');
							$query = $query->result_object();
							if($query){
								$values = $query[0]->total_sales;
							}else{
								$values = 0;
							}
							
							$datalabelnya = [
								"displayValue" => $rowsdata->name.' | '.$this->ortyd->custom_number_format((float)$query[0]->total_sales)." | ".$query[0]->total_io, 
								"value" => $values 
							];
							
							array_push($datavalue,$datalabelnya);
						}
					}
			
					$dataisinya = [
						"seriesname" => $rowsdata->name, 
						"color" => $rowsdata->color, 
						"data" => $datavalue 
					];

							
					array_push($dataisi,$dataisinya);
				}
			}else{
				$datalabelnya = [
					"label" => ''
				];
							
				$dataisinya = [
					"seriesname" => "GTMA", 
					"color" => "#feae65", 
					"data" => $datavalue 
				];
								
				array_push($dataisi,$dataisinya);
			}

			$jayParsedAry = [
			   "message" => "success", 
			   "data" => $datalabel,
			   "data5" => $dataisi, 
			   "total" => "149.57 M" 
			]; 
			
			echo json_encode($jayParsedAry);
	}
	
}
