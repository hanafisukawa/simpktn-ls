<?php

require(APPPATH . '/libraries/REST_Controller.php');

class Getdata extends REST_Controller
{
	private $modeldb = 'm_api';
	private $link_pins = 'https://api.pins.co.id/api/';

    function __construct()
    {
        parent::__construct();
		$this->load->library('curl'); 
		$this->load->model($this->modeldb);
		$this->load->model('m_api_history');
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
		header('Access-Control-Max-Age: 86400'); 
    }

	//http://localhost/dashboardom/dashboardom/api/getdata/getAlarm
	function getProject_get(){
		
		$is_update = 0;
		
		$token = $this->m_api_history->getToken($this->link_pins);

		if($this->input->get('user_id') != ''){
			$user_id = $this->input->get('user_id');
		}else{
			$user_id = 1;
		}
		
		
		if($this->input->get('month') == '' &&  $this->input->get('year') == ''){
			$month = (int)date('m');
			$year = (int)date('Y');
			$bulan = 0;
		}else{
			$month = (int)$this->input->get('month');
			$year = (int)$this->input->get('year');
			$bulan = (int)$this->input->get('bulan');
		}
		
		
		if($this->input->get('id_api') != ''){
			$id_api = $this->input->get('id_api');
			$running = $this->m_api_history->setrunning($id_api, $month, $year, $user_id);
		}else{
			$id_api = 1;
			$running = $this->m_api_history->setrunning($id_api, $month, $year, $user_id);
		}
		
		$running = 1;
		$rowcode = 404;
		
		if($running == 1){
			for($awal=1;$awal<=1;$awal++){
			
				$params = array(
						//'limit'		=>	10000,
						//'offset'	=>	0
				);
				
				$data = $this->curl->simple_get($this->link_pins.'crm/project/',$params,array(
						CURLOPT_HTTPHEADER => array('Authorization:Bearer '.$token.''),
						CURLOPT_TIMEOUT => 50000,
						CURLOPT_SSL_VERIFYPEER => false
					)
				);
				
				$info = $this->curl->info;
				$rowcode = $info['http_code'];
				//print_r($data);
				//die();
				
				if($data){
					$data = json_decode($data);
					if(isset($data->status)){
						$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
						die();
					}
					$rowdata = $data;
					$rowcode = $rowcode;
					//print_r($rowdata);
					if(count($rowdata) > 0){
						
						$datarowactive = array(  
							'active'=> 0,
						);
								
						$update = $this->db->update('data_project', $datarowactive);
						
						foreach($rowdata as $rows){
							
							$is_project = 0;
							
							$this->db->where('id',$rows->id);
							$query = $this->db->get('data_project');
							$query = $query->result_object();
							if(!$query){
								
								$is_update = 0;
								
								if(isset($rows->project)){
									if($rows->project != null){
										$is_project = 1;
									}
								}
								
								$datarow = array(  
									"id" 					=> ($rows->id != '' ? $rows->id : null),
									"am_id" 				=> ($rows->am_id != '' ? $rows->am_id : null),
									"ubis_id" 				=> ($rows->ubis_id != '' ? $rows->ubis_id : null),
									"status_crm_id" 		=> ($rows->status_id != '' ? $rows->status_id : null),
									"customer_id" 			=> ($rows->customer_inisiasi_id != '' ? $rows->customer_inisiasi_id : null),
									"customer_inisiasi_id" 	=> ($rows->customer_inisiasi_id != '' ? $rows->customer_inisiasi_id : null),
									"segment_id" 			=> ($rows->segment_id != '' ? $rows->segment_id : null),
									"portofolio_id" 		=> ($rows->portofolio_id != '' ? $rows->portofolio_id : null),
									"io_id" 				=> ($rows->io_id != '' ? $rows->io_id : null),
									"no_inisiasi" 			=> ($rows->no_inisiasi != '' ? $rows->no_inisiasi : null),
									"end_customer" 			=> ($rows->end_customer != '' ? $rows->end_customer : null),
									"channel" 				=> ($rows->channel != '' ? $rows->channel : null),
									"source" 				=> ($rows->source != '' ? $rows->source : null),
									"kategori" 				=> ($rows->kategori != '' ? $rows->kategori : null),
									"desc_project" 			=> ($rows->desc_project != '' ? $rows->desc_project : null),
									"reason" 				=> ($rows->reason != '' ? $rows->reason : null),
									"nilai_project" 		=> ($rows->nilai_project != '' ? $rows->nilai_project : null),
									"estimasi_revenue" 		=> ($rows->estimasi_revenue != '' ? $rows->estimasi_revenue : null),
									"start_date" 			=> (($rows->project->tanggal_mulai ?? '') != '' ? ($rows->project->tanggal_mulai ?? '') : null),
									"end_date" 				=> (($rows->project->tanggal_akhir ?? '') != '' ? $rows->project->tanggal_akhir : null),
									"tgl_target_win" 		=> ($rows->tgl_target_win != '' ? $rows->tgl_target_win : null),
									"tgl_closing" 			=> ($rows->tgl_closing != '' ? $rows->tgl_closing : null),
									"tgl_submission" 		=> ($rows->tgl_submission != '' ? $rows->tgl_submission : null),
									"submission_creator" 	=> ($rows->submission_creator != '' ? $rows->submission_creator : null),
									"submission_to" 		=> ($rows->submission_to != '' ? $rows->submission_to : null),
									"file_submission" 		=> ($rows->file_submission != '' ? $rows->file_submission : null),
									"file_inisiasi" 		=> ($rows->file_inisiasi != '' ? $rows->file_inisiasi : null),
									"procurement_to" 		=> ($rows->procurement_to != '' ? $rows->procurement_to : null),
									"created_at" 			=> ($rows->created_at != '' ? $rows->created_at : null),
									"updated_at" 			=> ($rows->updated_at != '' ? $rows->updated_at : null),
									"deleted_at" 			=> ($rows->deleted_at != '' ? $rows->deleted_at : null),
									"tender" 				=> ($rows->tender != '' ? $rows->tender : null),
									"product_category_id" 	=> ($rows->product_category_id != '' ? $rows->product_category_id : null),
									"product_solution_id" 	=> ($rows->product_solution_id != '' ? $rows->product_solution_id : null),
									"lkpp" 					=> ($rows->lkpp != '' ? $rows->lkpp : null),
									"nilai_cogs" 			=> ($rows->nilai_cogs != '' ? $rows->nilai_cogs : null),
									"nilai_penawaran" 		=> ($rows->nilai_penawaran != '' ? $rows->nilai_penawaran : null),
									"solution_id" 			=> ($rows->solution_id != '' ? $rows->solution_id : null),
									"manage_service" 		=> ($rows->manage_service != '' ? $rows->manage_service : null),
									"tgl_end_delivery" 		=> ($rows->tgl_end_delivery != '' ? $rows->tgl_end_delivery : null),
									"start_layanan" 		=> ($rows->start_layanan != '' ? $rows->start_layanan : null),
									"end_layanan" 			=> ($rows->end_layanan != '' ? $rows->end_layanan : null),
									"start_garansi" 		=> ($rows->start_garansi != '' ? $rows->start_garansi : null),
									"end_garansi" 			=> ($rows->end_garansi != '' ? $rows->end_garansi : null),
									"bud_id" 				=> ($rows->bud_id != '' ? $rows->bud_id : null),
									"nilai_kl" 				=> ($rows->nilai_kl != '' ? $rows->nilai_kl : null),
									"disposisi_str" 		=> ($rows->disposisi_str != '' ? $rows->disposisi_str : null),
									"disposisi_doc_str" 	=> ($rows->disposisi_doc_str != '' ? $rows->disposisi_doc_str : null),
									"obl_id" 				=> ($rows->obl_id != '' ? $rows->obl_id : null),
									"no_kl" 				=> ($rows->no_kl != '' ? $rows->no_kl : null),
									"is_draft" 				=> ($rows->is_draft != '' ? $rows->is_draft : null),
									"title_project" 		=> ($rows->title_project != '' ? $rows->title_project : null),
									"prosedure" 			=> ($rows->prosedure != '' ? $rows->prosedure : null),
									"prosedure_normal" 		=> ($rows->prosedure_normal != '' ? $rows->prosedure_normal : null),
									"end_customer_id" 		=> ($rows->end_customer_id != '' ? $rows->end_customer_id : null),
									"pic_customer" 		=> ($rows->pic_customer_new != '' ? $rows->pic_customer_new : null),
									"pic_end_customer" 		=> ($rows->pic_end_customer_new != '' ? $rows->pic_end_customer_new : null),
									"kbli_id" 				=> ($rows->kbli_id != '' ? $rows->kbli_id : null),
									"id_lop" 				=> ($rows->id_lop != '' ? $rows->id_lop : null),
									"cancel_category" 		=> ($rows->cancel_category != '' ? $rows->cancel_category : null),
									"lose_category" 		=> ($rows->lose_category != '' ? $rows->lose_category : null),
									"tgl_start_delivery" 	=> ($rows->tgl_start_delivery != '' ? $rows->tgl_start_delivery : null),
									"start_pemeliharaan" 	=> ($rows->start_pemeliharaan != '' ? $rows->start_pemeliharaan : null),
									"end_pemeliharaan" 		=> ($rows->end_pemeliharaan != '' ? $rows->end_pemeliharaan : null),
									"funel_id" 				=> ($rows->funel_id != '' ? $rows->funel_id : null),
									"dokumen_kelengkapan" 		=> ($rows->dokumen_kelengkapan != '' ? $rows->dokumen_kelengkapan : null),
									"won_category" 			=> ($rows->won_category != '' ? $rows->won_category : null),
									"is_solution" 			=> ($rows->is_solution != '' ? $rows->is_solution : null),
									"level" 				=> ($rows->level != '' ? $rows->level : null),
									"top_id" 				=> ($rows->top_id != '' ? $rows->top_id : null),
									"durasi_id" 			=> ($rows->durasi_id != '' ? $rows->durasi_id : null),
									"com" 					=> ($rows->com != '' ? $rows->com : null),
									"margin" 				=> ($rows->margin != '' ? $rows->margin : null),
									"indirect_cost" 		=> (($rows->jasbis->indirect_cost ?? '') != '' ? ($rows->jasbis->indirect_cost ?? '') : null),
									"cogs" 		=> (($rows->jasbis->cogs ?? '') != '' ? ($rows->jasbis->cogs ?? '') : null),
									"down_payment" 			=> ($rows->down_payment != '' ? $rows->down_payment : null),
									"harga_penawaran" 		=> ($rows->harga_penawaran != '' ? $rows->harga_penawaran : null),
									"tanggal_won" 			=> ($rows->tanggal_won != '' ? $rows->tanggal_won : null),
									"dokumen_kelengkapan_url" 		=> ($rows->dokumen_kelengkapan_url != '' ? $rows->dokumen_kelengkapan_url : null),
									"is_perpanjangan" 		=> ($rows->is_perpanjangan != '' ? $rows->is_perpanjangan : null),
									"jenis_perpanjangan" 		=> ($rows->jenis_perpanjangan != '' ? $rows->jenis_perpanjangan : null),
									"model_project" 		=> ($rows->model_project != '' ? $rows->model_project : null),
									"inisiasi_id_referensi" 		=> ($rows->inisiasi_id_referensi != '' ? $rows->inisiasi_id_referensi : null),
									"tanggal_kontrak" 		=> (($rows->project->tanggal_kl ?? '') != '' ? ($rows->project->tanggal_kl ?? '') : null),
									"tanggal_diterima" 		=> (($rows->project->tanggal_terima ?? '') != '' ? ($rows->project->tanggal_terima ?? '') : null),
									"nilai_kontrak" 		=> ($rows->nilai_kl != '' ? $rows->nilai_kl : null),
									"jenis_kontrak" 		=> ($rows->surat_perintah_kerja != '' ? $rows->surat_perintah_kerja : null),
									'is_project'			=> $is_project,
									"kriteria" 		=> (($rows->jasbis->kriteria_project ?? '') != '' ? ($rows->jasbis->kriteria_project ?? '') : null),
									//"pic_customer" 		=> (($rows->pic_customer[0]->id ?? '') != '' ? ($rows->pic_customer[0]->id ?? '') : null),
									//"pic_end_customer" 		=> (($rows->pic_end_customer[0]->id ?? '') != '' ? ($rows->pic_end_customer[0]->id ?? '') : null),
									'active'				=> 1,
									'createdid'				=> $user_id,
									'created'				=> date('Y-m-d H:i:s'),
									'modifiedid'			=> $user_id,
									'modified'				=> date('Y-m-d H:i:s')
								);
								
								$string = 'project'.'-'.$rows->id.'-'.$rows->io_id;
								$slug = $this->ortyd->sanitize($string,'data_project');
								$datarow = array_merge($datarow,
									array('slug' 	=> $slug)
								);
								
								$insert = $this->db->insert('data_project', $datarow);
								if($insert){

									//if(isset($rows->dokumen_kl)){
										//if($rows->dokumen_kl != null){
											
											//$project_id = $rows->id;
											//$wo_id = null;
											//$project_mitra_id = null;
											//$type = 1;
											//$path = $rows->dokumen_kl->path ?? '';
											
											//$this->m_api_history->saveDoc($project_id, $wo_id, //$project_mitra_id, $type, $path, null);

										//}
									//}
									
									if(isset($rows->jasbis)){
										if($rows->jasbis != null){
											
											if($rows->jasbis->p8_url != null){
												$project_id = $rows->id;
												$wo_id = null;
												$project_mitra_id = null;
												$type = 1;
												$path = $rows->jasbis->p8_url ?? '';
												
												$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path, null);
											}
											
											if($rows->jasbis->dokumen_url != null){
												$project_id = $rows->id;
												$wo_id = null;
												$project_mitra_id = null;
												$type = 2;
												$path = $rows->jasbis->dokumen_url ?? '';
												
												$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path, null);
											}
											
											if($rows->jasbis->ao_sid_url != null){
												$project_id = $rows->id;
												$wo_id = null;
												$project_mitra_id = null;
												$type = 14;
												$path = $rows->jasbis->ao_sid_url ?? '';
												
												$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path, null);
											}
											
										}
									}
									
									
									if(isset($rows->project)){
										if($rows->project != null){
											
											if(isset($rows->project->mitras)){
												if($rows->project->mitras != null){
													
													
													foreach($rows->project->mitras as $rowsmitra){
														//echo 'asasa';
														if(isset($rowsmitra->kontrak)){
															if($rowsmitra->kontrak != null){
																
																
																$project_id = $rows->id;
																$wo_id = null;
																$project_mitra_id = $rowsmitra->kontrak->project_mitra_id;
																$type = 3;
																$path = $rowsmitra->kontrak->file_url ?? '';
																$nomor = $rowsmitra->kontrak->no ?? '';
																
																$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path, $nomor);
																
															}
														}
													
													}
												}
											}
											
											

										}
									}
									
									if(isset($rows->io)){
										$io_id = $rows->io_id;
										$format = $rows->io;
										$this->m_api_history->setMasterIO($io_id, $format);
									}
									
									if(isset($rows->customer)){
										$customer_id = $rows->customer_id;
										$format = $rows->customer;
										$this->m_api_history->setCustomer($customer_id, $format);
									}
									
									if(isset($rows->end_customers)){
										$end_customer_id = $rows->end_customer_id;
										$format = $rows->end_customers;
										$this->m_api_history->setEndCustomer($end_customer_id, $format);
									}
									
									if(isset($rows->pic_customer)){
										$project_id = $rows->id;
										foreach($rows->pic_customer as $rowspic){
											$pic_customer = $rowspic->id ?? '';
											$format = $rowspic;
											$this->m_api_history->setPicCustomer($project_id, $format);
										}
									}
									
									if(isset($rows->pic_end_customer)){
										$project_id = $rows->id;
										foreach($rows->pic_end_customer as $rowspic){
											$pic_end_customer = $rowspic->id ?? '';
											$format = $rowspic;
											$this->m_api_history->setPicendCustomer($project_id, $format);
										}
									}
									
									if(isset($rows->ubis)){
										$ubis_id = $rows->ubis_id;
										$format = $rows->ubis;
										$this->m_api_history->setUnit($ubis_id, $format);
									}
									
									if(isset($rows->am)){
										$am_id = $rows->am_id;
										$format = $rows->am;
										$this->m_api_history->setAM($am_id, $format);
									}
									
									if(isset($rows->portofolio)){
										$portofolio_id = $rows->portofolio_id;
										$format = $rows->portofolio;
										$this->m_api_history->setPortfolio($portofolio_id, $format);
									}
									
									if(isset($rows->status)){
										$status_id = $rows->status_id;
										$format = $rows->status;
										$this->m_api_history->setStatus($status_id, $format);
									}
									
									if(isset($rows->segment)){
										$segment_id = $rows->segment_id;
										$format = $rows->segment;
										$this->m_api_history->setSegment($segment_id, $format);
									}
									
									if(isset($rows->funnel)){
										$funel_id = $rows->funel_id;
										$format = $rows->funnel;
										$this->m_api_history->setFunnel($funel_id, $format);
									}
									
									if(isset($rows->top)){
										$top_id = $rows->top_id;
										$format = $rows->top;
										$this->m_api_history->setTop($top_id, $format);
									}
									
									if(isset($rows->kbli)){
										$kbli_id = $rows->kbli_id;
										$format = $rows->kbli;
										$this->m_api_history->setKbli($kbli_id, $format);
									}
									
									if(isset($rows->wo)){
										$project_id = $rows->id;
										$format = $rows->wo;
										$this->m_api_history->setWO($project_id, $format, $rows, $is_project, $is_update);
									}else{
										$project_id = $rows->id;
										$format = $rows->wo;
										$this->m_api_history->setWO($project_id, $format, $rows, $is_project, $is_update);
									}
									
									if(isset($rows->project)){
										$project_id = $rows->id;
										$format = $rows->project;
										$this->m_api_history->setMitras($project_id, $rows);
									}
									
									if(isset($rows->down_payment)){
										if($rows->down_payment != '' && $rows->down_payment != 0){
											$io_id = $rows->io_id;
											$format = array(
												'project_id'		=> ($rows->id != '' ? $rows->id : null),
												'nilai'				=> ($rows->down_payment != '' ? $rows->down_payment : null),
											);
											
											$this->m_api_history->setDP($format, $is_update);
										}
										
										
									}
								}
								
							}else{
								
								$is_update = 1;
								
								if(isset($rows->project)){
									if($rows->project != null){
										$is_project = 1;
									}
								}
								
								$datarow = array(  
									"am_id" 				=> ($rows->am_id != '' ? $rows->am_id : null),
									"ubis_id" 				=> ($rows->ubis_id != '' ? $rows->ubis_id : null),
									"status_crm_id" 		=> ($rows->status_id != '' ? $rows->status_id : null),
									"customer_id" 			=> ($rows->customer_inisiasi_id != '' ? $rows->customer_inisiasi_id : null),
									"customer_inisiasi_id" 	=> ($rows->customer_inisiasi_id != '' ? $rows->customer_inisiasi_id : null),
									"segment_id" 			=> ($rows->segment_id != '' ? $rows->segment_id : null),
									"portofolio_id" 		=> ($rows->portofolio_id != '' ? $rows->portofolio_id : null),
									"io_id" 				=> ($rows->io_id != '' ? $rows->io_id : null),
									"no_inisiasi" 			=> ($rows->no_inisiasi != '' ? $rows->no_inisiasi : null),
									"end_customer" 			=> ($rows->end_customer != '' ? $rows->end_customer : null),
									"channel" 				=> ($rows->channel != '' ? $rows->channel : null),
									"source" 				=> ($rows->source != '' ? $rows->source : null),
									"kategori" 				=> ($rows->kategori != '' ? $rows->kategori : null),
									"desc_project" 			=> ($rows->desc_project != '' ? $rows->desc_project : null),
									"reason" 				=> ($rows->reason != '' ? $rows->reason : null),
									"nilai_project" 		=> ($rows->nilai_project != '' ? $rows->nilai_project : null),
									"estimasi_revenue" 		=> ($rows->estimasi_revenue != '' ? $rows->estimasi_revenue : null),
									"start_date" 			=> (($rows->project->tanggal_mulai ?? '') != '' ? ($rows->project->tanggal_mulai ?? '') : null),
									"end_date" 				=> (($rows->project->tanggal_akhir ?? '') != '' ? $rows->project->tanggal_akhir : null),
									"tgl_target_win" 		=> ($rows->tgl_target_win != '' ? $rows->tgl_target_win : null),
									"tgl_closing" 			=> ($rows->tgl_closing != '' ? $rows->tgl_closing : null),
									"tgl_submission" 		=> ($rows->tgl_submission != '' ? $rows->tgl_submission : null),
									"submission_creator" 	=> ($rows->submission_creator != '' ? $rows->submission_creator : null),
									"submission_to" 		=> ($rows->submission_to != '' ? $rows->submission_to : null),
									"file_submission" 		=> ($rows->file_submission != '' ? $rows->file_submission : null),
									"file_inisiasi" 		=> ($rows->file_inisiasi != '' ? $rows->file_inisiasi : null),
									"procurement_to" 		=> ($rows->procurement_to != '' ? $rows->procurement_to : null),
									"created_at" 			=> ($rows->created_at != '' ? $rows->created_at : null),
									"updated_at" 			=> ($rows->updated_at != '' ? $rows->updated_at : null),
									"deleted_at" 			=> ($rows->deleted_at != '' ? $rows->deleted_at : null),
									"tender" 				=> ($rows->tender != '' ? $rows->tender : null),
									"product_category_id" 	=> ($rows->product_category_id != '' ? $rows->product_category_id : null),
									"product_solution_id" 	=> ($rows->product_solution_id != '' ? $rows->product_solution_id : null),
									"lkpp" 					=> ($rows->lkpp != '' ? $rows->lkpp : null),
									"nilai_cogs" 			=> ($rows->nilai_cogs != '' ? $rows->nilai_cogs : null),
									"nilai_penawaran" 		=> ($rows->nilai_penawaran != '' ? $rows->nilai_penawaran : null),
									"solution_id" 			=> ($rows->solution_id != '' ? $rows->solution_id : null),
									"manage_service" 		=> ($rows->manage_service != '' ? $rows->manage_service : null),
									"tgl_end_delivery" 		=> ($rows->tgl_end_delivery != '' ? $rows->tgl_end_delivery : null),
									"start_layanan" 		=> ($rows->start_layanan != '' ? $rows->start_layanan : null),
									"end_layanan" 			=> ($rows->end_layanan != '' ? $rows->end_layanan : null),
									"start_garansi" 		=> ($rows->start_garansi != '' ? $rows->start_garansi : null),
									"end_garansi" 			=> ($rows->end_garansi != '' ? $rows->end_garansi : null),
									"bud_id" 				=> ($rows->bud_id != '' ? $rows->bud_id : null),
									"nilai_kl" 				=> ($rows->nilai_kl != '' ? $rows->nilai_kl : null),
									"disposisi_str" 		=> ($rows->disposisi_str != '' ? $rows->disposisi_str : null),
									"disposisi_doc_str" 	=> ($rows->disposisi_doc_str != '' ? $rows->disposisi_doc_str : null),
									"obl_id" 				=> ($rows->obl_id != '' ? $rows->obl_id : null),
									"no_kl" 				=> ($rows->no_kl != '' ? $rows->no_kl : null),
									"is_draft" 				=> ($rows->is_draft != '' ? $rows->is_draft : null),
									"title_project" 		=> ($rows->title_project != '' ? $rows->title_project : null),
									"prosedure" 			=> ($rows->prosedure != '' ? $rows->prosedure : null),
									"prosedure_normal" 		=> ($rows->prosedure_normal != '' ? $rows->prosedure_normal : null),
									"end_customer_id" 		=> ($rows->end_customer_id != '' ? $rows->end_customer_id : null),
									"pic_customer" 		=> ($rows->pic_customer_new != '' ? $rows->pic_customer_new : null),
									"pic_end_customer" 		=> ($rows->pic_end_customer_new != '' ? $rows->pic_end_customer_new : null),
									"kbli_id" 				=> ($rows->kbli_id != '' ? $rows->kbli_id : null),
									"id_lop" 				=> ($rows->id_lop != '' ? $rows->id_lop : null),
									"cancel_category" 		=> ($rows->cancel_category != '' ? $rows->cancel_category : null),
									"lose_category" 		=> ($rows->lose_category != '' ? $rows->lose_category : null),
									"tgl_start_delivery" 	=> ($rows->tgl_start_delivery != '' ? $rows->tgl_start_delivery : null),
									"start_pemeliharaan" 	=> ($rows->start_pemeliharaan != '' ? $rows->start_pemeliharaan : null),
									"end_pemeliharaan" 		=> ($rows->end_pemeliharaan != '' ? $rows->end_pemeliharaan : null),
									"funel_id" 				=> ($rows->funel_id != '' ? $rows->funel_id : null),
									"dokumen_kelengkapan" 		=> ($rows->dokumen_kelengkapan != '' ? $rows->dokumen_kelengkapan : null),
									"won_category" 			=> ($rows->won_category != '' ? $rows->won_category : null),
									"is_solution" 			=> ($rows->is_solution != '' ? $rows->is_solution : null),
									"level" 				=> ($rows->level != '' ? $rows->level : null),
									"top_id" 				=> ($rows->top_id != '' ? $rows->top_id : null),
									"durasi_id" 			=> ($rows->durasi_id != '' ? $rows->durasi_id : null),
									"com" 					=> ($rows->com != '' ? $rows->com : null),
									"margin" 				=> ($rows->margin != '' ? $rows->margin : null),
									"indirect_cost" 		=> (($rows->jasbis->indirect_cost ?? '') != '' ? ($rows->jasbis->indirect_cost ?? '') : null),
									"cogs" 		=> (($rows->jasbis->cogs ?? '') != '' ? ($rows->jasbis->cogs ?? '') : null),
									"down_payment" 			=> ($rows->down_payment != '' ? $rows->down_payment : null),
									"harga_penawaran" 		=> ($rows->harga_penawaran != '' ? $rows->harga_penawaran : null),
									"tanggal_won" 			=> ($rows->tanggal_won != '' ? $rows->tanggal_won : null),
									"dokumen_kelengkapan_url" 		=> ($rows->dokumen_kelengkapan_url != '' ? $rows->dokumen_kelengkapan_url : null),
									"is_perpanjangan" 		=> ($rows->is_perpanjangan != '' ? $rows->is_perpanjangan : null),
									"jenis_perpanjangan" 		=> ($rows->jenis_perpanjangan != '' ? $rows->jenis_perpanjangan : null),
									"model_project" 		=> ($rows->model_project != '' ? $rows->model_project : null),
									"inisiasi_id_referensi" 		=> ($rows->inisiasi_id_referensi != '' ? $rows->inisiasi_id_referensi : null),
									"tanggal_kontrak" 		=> (($rows->project->tanggal_kl ?? '') != '' ? ($rows->project->tanggal_kl ?? '') : null),
									"tanggal_diterima" 		=> (($rows->project->tanggal_terima ?? '') != '' ? ($rows->project->tanggal_terima ?? '') : null),
									"nilai_kontrak" 		=> ($rows->nilai_kl != '' ? $rows->nilai_kl : null),
									"jenis_kontrak" 		=> ($rows->surat_perintah_kerja != '' ? $rows->surat_perintah_kerja : null),
									"kriteria" 		=> (($rows->jasbis->kriteria_project ?? '') != '' ? ($rows->jasbis->kriteria_project ?? '') : null),
									//"pic_customer" 		=> (($rows->pic_customer[0]->id ?? '') != '' ? ($rows->pic_customer[0]->id ?? '') : null),
									//"pic_end_customer" 		=> (($rows->pic_end_customer[0]->id ?? '') != '' ? ($rows->pic_end_customer[0]->id ?? '') : null),
									'is_project'			=> $is_project,
									'active'				=> 1,
									'modifiedid'			=> $user_id,
									'modified'				=> date('Y-m-d H:i:s')
								);
								
								//$string = 'project'.'-'.$rows->id.'-'.$rows->io_id;
								//$slug = $this->ortyd->sanitize($string,'data_project');
								//$datarow = array_merge($datarow,
									//array('slug' 	=> $slug)
								//);
								
								$this->db->where('id',$rows->id);
								$update = $this->db->update('data_project', $datarow);
								
								if($update){
									
									
									
									//if(isset($rows->dokumen_kl)){
										//if($rows->dokumen_kl != null){
											
											//$project_id = $rows->id;
											//$wo_id = null;
											//$project_mitra_id = null;
											//$type = 1;
											//$path = $rows->dokumen_kl->path ?? '';
											
											//$this->m_api_history->saveDoc($project_id, $wo_id, //$project_mitra_id, $type, $path,null);

										//}
									//}
									
									if(isset($rows->jasbis)){
										if($rows->jasbis != null){
											
											if($rows->jasbis->p8_url != null){
												$project_id = $rows->id;
												$wo_id = null;
												$project_mitra_id = null;
												$type = 1;
												$path = $rows->jasbis->p8_url ?? '';
												
												$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path, null);
											}
											
											if($rows->jasbis->dokumen_url != null){
												$project_id = $rows->id;
												$wo_id = null;
												$project_mitra_id = null;
												$type = 2;
												$path = $rows->jasbis->dokumen_url ?? '';
												
												$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path,null);
											}
											
											if($rows->jasbis->ao_sid_url != null){
												$project_id = $rows->id;
												$wo_id = null;
												$project_mitra_id = null;
												$type = 14;
												$path = $rows->jasbis->ao_sid_url ?? '';
												
												$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path, null);
											}
											
										}
									}
									
									
									if(isset($rows->project)){
										if($rows->project != null){
											
											if(isset($rows->project->mitras)){
												if($rows->project->mitras != null){
													
													
													foreach($rows->project->mitras as $rowsmitra){
														//echo 'asasa';
														if(isset($rowsmitra->kontrak)){
															if($rowsmitra->kontrak != null){
																
																
																$project_id = $rows->id;
																$wo_id = null;
																$project_mitra_id = $rowsmitra->kontrak->project_mitra_id;
																$type = 3;
																$path = $rowsmitra->kontrak->file_url ?? '';
																$nomor = $rowsmitra->kontrak->no ?? '';
																
																$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path, $nomor);
																
															}
														}
													
													}
												}
											}
											
											

										}
									}
									
									if(isset($rows->io)){
										$io_id = $rows->io_id;
										$format = $rows->io;
										$this->m_api_history->setMasterIO($io_id, $format);
									}
									
									if(isset($rows->customer)){
										$customer_id = $rows->customer_id;
										$format = $rows->customer;
										$this->m_api_history->setCustomer($customer_id, $format);
									}
									
									if(isset($rows->end_customers)){
										$end_customer_id = $rows->end_customer_id;
										$format = $rows->end_customers;
										$this->m_api_history->setEndCustomer($end_customer_id, $format);
									}
									
									if(isset($rows->pic_customer)){
										$project_id = $rows->id;
										foreach($rows->pic_customer as $rowspic){
											$pic_customer = $rowspic->id ?? '';
											$format = $rowspic;
											$this->m_api_history->setPicCustomer($project_id, $format);
										}
									}
									
									if(isset($rows->pic_end_customer)){
										$project_id = $rows->id;
										foreach($rows->pic_end_customer as $rowspic){
											$pic_end_customer = $rowspic->id ?? '';
											$format = $rowspic;
											$this->m_api_history->setPicendCustomer($project_id, $format);
										}
									}
									
									if(isset($rows->ubis)){
										$ubis_id = $rows->ubis_id;
										$format = $rows->ubis;
										$this->m_api_history->setUnit($ubis_id, $format);
									}
									
									if(isset($rows->am)){
										$am_id = $rows->am_id;
										$format = $rows->am;
										$this->m_api_history->setAM($am_id, $format);
									}
									
									if(isset($rows->portofolio)){
										$portofolio_id = $rows->portofolio_id;
										$format = $rows->portofolio;
										$this->m_api_history->setPortfolio($portofolio_id, $format);
									}
									
									if(isset($rows->status)){
										$status_id = $rows->status_id;
										$format = $rows->status;
										$this->m_api_history->setStatus($status_id, $format);
									}
									
									if(isset($rows->segment)){
										$segment_id = $rows->segment_id;
										$format = $rows->segment;
										$this->m_api_history->setSegment($segment_id, $format);
									}
									
									if(isset($rows->funnel)){
										$funel_id = $rows->funel_id;
										$format = $rows->funnel;
										$this->m_api_history->setFunnel($funel_id, $format);
									}
									
									if(isset($rows->top)){
										$top_id = $rows->top_id;
										$format = $rows->top;
										$this->m_api_history->setTop($top_id, $format);
									}
									
									if(isset($rows->kbli)){
										$kbli_id = $rows->kbli_id;
										$format = $rows->kbli;
										$this->m_api_history->setKbli($kbli_id, $format);
									}
									
									if(isset($rows->wo)){
										$project_id = $rows->id;
										$format = $rows->wo;
										$this->m_api_history->setWO($project_id, $format, $rows, $is_project, $is_update);
									}else{
										$project_id = $rows->id;
										$format = $rows->wo;
										$this->m_api_history->setWO($project_id, $format, $rows, $is_project, $is_update);
									}
									
									if(isset($rows->project)){
										$project_id = $rows->id;
										$format = $rows->project;
										$this->m_api_history->setMitras($project_id, $rows);
									}
									
									
									if(isset($rows->down_payment)){
										if($rows->down_payment != '' && $rows->down_payment != 0){
											$io_id = $rows->io_id;
											$format = array(
												'project_id'		=> ($rows->id != '' ? $rows->id : null),
												'nilai'				=> ($rows->down_payment != '' ? $rows->down_payment : null),
											);
											
											$this->m_api_history->setDP($format, $is_update);
										}
										
										
									}
									
								}
								
							}
									
						}
						
						$row = count($rowdata);
						$updatepage = $this->m_api_history->updatepage($id_api, $month, $year, $awal, $row);
							 
					}else{
						$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
						break;
					}
					
				}else{
					$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
					break;
				}
				
			}
			
			$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
			$data['status'] = 'success';
			$this->response($data, 200);
		}else{
			$data['status'] = 'error';
			$data['errors'] = 'Script Running';
			$this->response($data, 200);
		}
		
	}
	
	
	function getUsers_get(){
		
		$token = $this->m_api_history->getToken($this->link_pins);
		
		if($this->input->get('user_id') != ''){
			$user_id = $this->input->get('user_id');
		}else{
			$user_id = 1;
		}
		
		
		if($this->input->get('month') == '' &&  $this->input->get('year') == ''){
			$month = (int)date('m');
			$year = (int)date('Y');
			$bulan = 0;
		}else{
			$month = (int)$this->input->get('month');
			$year = (int)$this->input->get('year');
			$bulan = (int)$this->input->get('bulan');
		}
		
		
		if($this->input->get('id_api') != ''){
			$id_api = $this->input->get('id_api');
			$running = $this->m_api_history->setrunning($id_api, $month, $year, $user_id);
		}else{
			$id_api = 3;
			$running = $this->m_api_history->setrunning($id_api, $month, $year, $user_id);
		}
		
		$running = 1;
		$rowcode = 404;
		
		if($running == 1){
			for($awal=1;$awal<=1;$awal++){
			
				$params = array(
						//'limit'		=>	10000,
						//'offset'	=>	0
				);
				
				$data = $this->curl->simple_get($this->link_pins.'cms/user/get',$params,array(
						CURLOPT_HTTPHEADER => array('Authorization:Bearer '.$token.''),
						CURLOPT_TIMEOUT => 50000,
						CURLOPT_SSL_VERIFYPEER => false
					)
				);
				
				$info = $this->curl->info;
				$rowcode = $info['http_code'];
				//print_r($data);
				//die();
				
				if($data){
					$data = json_decode($data);
					if(isset($data->status)){
						if($data->status == false){
							$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
							die();
						}
					}
					$rowdata = $data->data;
					$rowcode = $rowcode;
					//print_r($rowdata);
					if(count($rowdata) > 0){
						
						$datarowactive = array(  
							'active'=> 0,
						);
								
						//$this->db->where('month', $month);
						//$this->db->where('year', $year);
						//$update = $this->db->update('data_surveilance', $datarowactive);
						
						foreach($rowdata as $dataio){
							
							$format = array(
								'id'					=> ($dataio->id != '' ? $dataio->id : null),
								'name'					=> ($dataio->name != '' ? $dataio->name : null),
								'username'				=> ($dataio->username != '' ? $dataio->username : null),
								'email'					=> ($dataio->email != '' ? $dataio->email : null),
								'nik'					=> ($dataio->nik != '' ? $dataio->nik : null),
								'company'				=> ($dataio->company != '' ? $dataio->company : null),
								'workplace'				=> ($dataio->workplace != '' ? $dataio->workplace : null),
								'status_kepegawaian'	=> ($dataio->status_kepegawaian != '' ? $dataio->status_kepegawaian : null),
								'phone'					=> ($dataio->phone != '' ? $dataio->phone : null)
							);
								
							
							$this->db->where('email',$format['email']);
							$query = $this->db->get('users_data');
							$query = $query->result_object();
							if(!$query){
								
								
								$datarow = array(  
									'data_id'			=> ($format['id'] != '' ? $format['id'] : null),
									'fullname'			=> ($format['name'] != '' ? $format['name'] : null),
									'username'			=> ($format['username'] != '' ? $format['username'] : null),
									'password'			=> 'created',
									'email'				=> ($format['email'] != '' ? $format['email'] : null),
									'notelp'			=> ($format['phone'] != '' ? $format['phone'] : null),
									'gid'				=> 3,
									'validate'			=> 0,
									'nik'				=> ($format['nik'] != '' ? $format['nik'] : null),
									'company'			=> ($format['company'] != '' ? $format['company'] : null),
									'workplace'			=> ($format['workplace'] != '' ? $format['workplace'] : null),
									'status_kepegawaian'=> ($format['status_kepegawaian'] != '' ? $format['status_kepegawaian'] : null),
									'banned'			=> 0,
									'active'			=> 1,
									'createdid'			=> 1,
									'created'			=> date('Y-m-d H:i:s'),
									'modifiedid'		=> 1,
									'modified'			=> date('Y-m-d H:i:s'),
								);
								
								$insert = $this->db->insert('users_data', $datarow);
								if($insert){
									
									if(isset($rows->image)){
										if($rows->image != null){
											
											$path = $rows->image->link ?? '';
											
											//$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path);

										}
									}
									
								}
								
							}else{
								
								$datarow = array(  
									'data_id'			=> ($format['id'] != '' ? $format['id'] : null),
									'fullname'			=> ($format['name'] != '' ? $format['name'] : null),
									'notelp'			=> ($format['phone'] != '' ? $format['phone'] : null),
									'nik'				=> ($format['nik'] != '' ? $format['nik'] : null),
									'company'			=> ($format['company'] != '' ? $format['company'] : null),
									'workplace'			=> ($format['workplace'] != '' ? $format['workplace'] : null),
									'status_kepegawaian'=> ($format['status_kepegawaian'] != '' ? $format['status_kepegawaian'] : null),
									'active'			=> 1,
									'modifiedid'		=> 1,
									'modified'			=> date('Y-m-d H:i:s'),
								);
								
								$this->db->where('email',$format['email']);
								$update = $this->db->update('users_data', $datarow);
								
								if($update){
									
									if(isset($rows->image)){
										if($rows->image != null){
											
											$path = $rows->image->link ?? '';
											
											//$this->m_api_history->saveDoc($project_id, $wo_id, $project_mitra_id, $type, $path);

										}
									}
									
								}
								
							}
									
						}
						
						$row = count($rowdata);
						$updatepage = $this->m_api_history->updatepage($id_api, $month, $year, $awal, $row);
							 
					}else{
						$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
						break;
					}
					
				}else{
					$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
					break;
				}
				
			}
			
			$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
			
		}else{
			echo 'Running';
		}
		
	}
	
	
	function getUnit_get(){
		
		$token = $this->m_api_history->getToken($this->link_pins);
		
		if($this->input->get('user_id') != ''){
			$user_id = $this->input->get('user_id');
		}else{
			$user_id = 1;
		}
		
		
		if($this->input->get('month') == '' &&  $this->input->get('year') == ''){
			$month = (int)date('m');
			$year = (int)date('Y');
			$bulan = 0;
		}else{
			$month = (int)$this->input->get('month');
			$year = (int)$this->input->get('year');
			$bulan = (int)$this->input->get('bulan');
		}
		
		
		if($this->input->get('id_api') != ''){
			$id_api = $this->input->get('id_api');
			$running = $this->m_api_history->setrunning($id_api, $month, $year, $user_id);
		}else{
			$id_api = 2;
			$running = $this->m_api_history->setrunning($id_api, $month, $year, $user_id);
		}
		
		$running = 1;
		$rowcode = 404;
		
		if($running == 1){
			for($awal=1;$awal<=1;$awal++){
			
				$params = array(
						//'limit'		=>	10000,
						//'offset'	=>	0
				);
				
				$data = $this->curl->simple_get($this->link_pins.'cms/unit/get',$params,array(
						CURLOPT_HTTPHEADER => array('Authorization:Bearer '.$token.''),
						CURLOPT_TIMEOUT => 50000,
						CURLOPT_SSL_VERIFYPEER => false
					)
				);
				
				$info = $this->curl->info;
				$rowcode = $info['http_code'];
				//print_r($data);
				//die();
				
				if($data){
					$data = json_decode($data);
					if(isset($data->status)){
						if($data->status == false){
							$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
							die();
						}
					}
					$rowdata = $data->data;
					$rowcode = $rowcode;
					//print_r($rowdata);
					if(count($rowdata) > 0){
						
						$datarowactive = array(  
							'active'=> 0,
						);
								
						//$this->db->where('month', $month);
						//$this->db->where('year', $year);
						//$update = $this->db->update('data_surveilance', $datarowactive);
						
						foreach($rowdata as $dataio){
							
							$format = array(
								'id'					=> ($dataio->id != '' ? $dataio->id : null),
								'name'					=> ($dataio->name != '' ? $dataio->name : null),
								'description'			=> ($dataio->name != '' ? $dataio->name : null),
								'cost_center'			=> ($dataio->cost_center != '' ? $dataio->cost_center : null)
							);
								
							
							$this->db->where('id',$format['id']);
							$query = $this->db->get('master_unit');
							$query = $query->result_object();
							if(!$query){
								
								
								$datarow = array(  
									'id'			=> ($format['id'] != '' ? $format['id'] : null),
									'name'			=> ($format['name'] != '' ? $format['name'] : null),
									'description'	=> ($format['name'] != '' ? $format['name'] : null),
									'cost_center'	=> ($format['cost_center'] != '' ? $format['cost_center'] : null),
									'active'			=> 1,
									'createdid'			=> 1,
									'created'			=> date('Y-m-d H:i:s'),
									'modifiedid'		=> 1,
									'modified'			=> date('Y-m-d H:i:s'),
								);
								
								$insert = $this->db->insert('master_unit', $datarow);
								if($insert){
									
								}
								
							}else{
								
								$datarow = array(  
									'id'			=> ($format['id'] != '' ? $format['id'] : null),
									'name'			=> ($format['name'] != '' ? $format['name'] : null),
									'description'	=> ($format['name'] != '' ? $format['name'] : null),
									'cost_center'	=> ($format['cost_center'] != '' ? $format['cost_center'] : null),
									'active'			=> 1,
									'modifiedid'		=> 1,
									'modified'			=> date('Y-m-d H:i:s'),
								);
								
								$this->db->where('id',$format['id']);
								$update = $this->db->update('master_unit', $datarow);
								
								if($update){
									
								}
								
							}
									
						}
						
						$row = count($rowdata);
						$updatepage = $this->m_api_history->updatepage($id_api, $month, $year, $awal, $row);
							 
					}else{
						$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
						break;
					}
					
				}else{
					$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
					break;
				}
				
			}
			
			$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
			
		}else{
			echo 'Running';
		}
		
	}
	
	
	function gettarget_get(){
		
		$token = $this->m_api_history->getToken($this->link_pins);
		
		if($this->input->get('user_id') != ''){
			$user_id = $this->input->get('user_id');
		}else{
			$user_id = 1;
		}
		
		
		if($this->input->get('month') == '' &&  $this->input->get('year') == ''){
			$month = (int)date('m');
			$year = (int)date('Y');
			$bulan = 0;
		}else{
			$month = (int)$this->input->get('month');
			$year = (int)$this->input->get('year');
			$bulan = (int)$this->input->get('bulan');
		}
		
		
		if($this->input->get('id_api') != ''){
			$id_api = $this->input->get('id_api');
			$running = $this->m_api_history->setrunning($id_api, $month, $year, $user_id);
		}else{
			$id_api = 4;
			$running = $this->m_api_history->setrunning($id_api, $month, $year, $user_id);
		}
		
		$running = 1;
		$rowcode = 404;
		
		if($running == 1){
			for($awal=1;$awal<=1;$awal++){
			
				$params = array(
						'year'		=>	$year,
						//'offset'	=>	0
				);
				
				$data = $this->curl->simple_get($this->link_pins.'crm/targetsales/get/by-year',$params,array(
						CURLOPT_HTTPHEADER => array('Authorization:Bearer '.$token.''),
						CURLOPT_TIMEOUT => 50000,
						CURLOPT_SSL_VERIFYPEER => false
					)
				);
				
				$info = $this->curl->info;
				$rowcode = $info['http_code'];
				//print_r($data);
				//die();
				
				if($data){
					$data = json_decode($data);
					if(isset($data->status)){
						if($data->status == false){
							$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
							die();
						}
					}
					$rowdata = $data->data;
					$rowcode = $rowcode;
					//print_r($rowdata);
					if(count($rowdata) > 0){
						
						$datarowactive = array(  
							'active'=> 0,
						);
								
						//$this->db->where('month', $month);
						$this->db->where('tahun_id', $year);
						$update = $this->db->update('data_project_target', $datarowactive);
						
						foreach($rowdata as $dataio){
							
							$bulan_id = null;
							$tahun_id = null;
							
							$date = ($dataio->date != '' ? $dataio->date : null);
							if($date != ''){
								$datenya = explode('-',$date);
								if($datenya){
									$bulan_id = (int)$datenya[1];
									$tahun_id = (int)$datenya[0];
								}
							}
							
							$format = array(
								'ref_id'	=> ($dataio->id != '' ? $dataio->id : null),
								'unit_id'	=> ($dataio->unit_id != '' ? $dataio->unit_id : null),
								'date'		=> $date,
								'bulan_id'	=> $bulan_id,
								'tahun_id'	=> $tahun_id,
								'nilai'		=> ($dataio->nilai != '' ? $dataio->nilai : null)
							);
								
							
							$this->db->where('ref_id',$format['ref_id']);
							$query = $this->db->get('data_project_target');
							$query = $query->result_object();
							if(!$query){
								
								$datarow = array(  
									'ref_id'			=> ($format['ref_id'] != '' ? $format['ref_id'] : null),
									'unit_id'	=> ($format['unit_id'] != '' ? $format['unit_id'] : null),
									'date'	=> ($format['date'] != '' ? $format['date'] : null),
									'bulan_id'	=> ($format['bulan_id'] != '' ? $format['bulan_id'] : null),
									'tahun_id'	=> ($format['tahun_id'] != '' ? $format['tahun_id'] : null),
									'nilai'	=> ($format['nilai'] != '' ? $format['nilai'] : null),
									'active'			=> 1,
									'createdid'			=> 1,
									'created'			=> date('Y-m-d H:i:s'),
									'modifiedid'		=> 1,
									'modified'			=> date('Y-m-d H:i:s'),
								);
								
								$insert = $this->db->insert('data_project_target', $datarow);
								if($insert){
									
								}
								
							}else{
								
								$datarow = array(  
									'ref_id'			=> ($format['ref_id'] != '' ? $format['ref_id'] : null),
									'unit_id'	=> ($format['unit_id'] != '' ? $format['unit_id'] : null),
									'date'	=> ($format['date'] != '' ? $format['date'] : null),
									'bulan_id'	=> ($format['bulan_id'] != '' ? $format['bulan_id'] : null),
									'tahun_id'	=> ($format['tahun_id'] != '' ? $format['tahun_id'] : null),
									'nilai'	=> ($format['nilai'] != '' ? $format['nilai'] : null),
									'active'			=> 1,
									'createdid'			=> 1,
									'created'			=> date('Y-m-d H:i:s'),
									'modifiedid'		=> 1,
									'modified'			=> date('Y-m-d H:i:s'),
								);
								
								$this->db->where('ref_id',$format['ref_id']);
								$update = $this->db->update('data_project_target', $datarow);
								
								if($update){
									
								}
								
							}
									
						}
						
						$row = count($rowdata);
						$updatepage = $this->m_api_history->updatepage($id_api, $month, $year, $awal, $row);
							 
					}else{
						$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
						break;
					}
					
				}else{
					$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
					break;
				}
				
			}
			
			$setstop = $this->m_api_history->setstop($id_api, $month, $year, $rowcode, $user_id);
			
		}else{
			echo 'Running';
		}
		
	}
	
	
	function expired_get(){
		
		$queryexpired = $this->db->get('vw_data_perusahaan_expired');
		$queryexpired = $queryexpired->result_object();
		if($queryexpired){
			foreach($queryexpired as $rows){
				
				$this->db->where('data_perusahaan_detail_comment.detail_id',$rows->detail_id);
				$this->db->where('data_perusahaan_detail_comment.status_id',1);
				$this->db->where('data_perusahaan_detail_comment.comment','Expired');
				$queryexpireddata = $this->db->get('data_perusahaan_detail_comment');
				$queryexpireddata = $queryexpireddata->result_object();
				if(!$queryexpireddata){
					
					$data = array(
						'detail_id'		=> $rows->detail_id,
						'comment'		=> 'Expired',
						'status_id'		=> 1,
						'status_data_id'=> 7,
						'type_id'		=> 1,
						'createdid'		=> $this->session->userdata('userid'),
						'created'		=> date('Y-m-d H:i:s'),
						'modifiedid'	=> $this->session->userdata('userid'),
						'modified'		=> date('Y-m-d H:i:s')
					);
							
					$insert = $this->db->insert('data_perusahaan_detail_comment',$data);
					$insertid = $this->db->insert_id();
					
				}
			}
		}

	}
	
}