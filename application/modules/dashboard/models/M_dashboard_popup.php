<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_dashboard_popup extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
		}
		
		
		public function getColumn(){
			$column = array();
			$filter = $this->input->post('filter');
			$id =  $this->input->post('id');
			$categories = $this->input->post('categories');
			$dataset = $this->input->post('dataset');
			$columndata = 1;
			
			if($id || !$id){
				
				if($id){
					$table = 'vw_dashboard_tmp';
					$exclude = array('color','history_id','status_id','created','modified','createdid','modifiedid','id','active','slug');
				}else{
					$table = 'vw_dashboard_tmp';
					$exclude = array('color','history_id','status_id','created','modified','createdid','modifiedid','id','active','slug');
				}
				$columndata == 1;
				
				if($columndata == 1){
					
					$query_column = $this->ortyd->query_column($table, $exclude);
						//return $this->db->last_query();
						if($query_column){
							array_push($column, array("title" =>'No', "className" => "alignleft"));
							foreach($query_column as $rows){
								$label_name = $this->ortyd->translate_column($table,$rows['name']);
								array_push($column, array("title" => $label_name, "className" => "alignleft"));
							}
						}
					
				}
				
				
				
			}
			
			return json_encode($column);
		}
		
		public function getColumnDetail(){
			//$filter = $this->input->post('filter');
			$id =  $this->input->post('id');
			$categories = $this->input->post('categories');
			$dataset = $this->input->post('dataset');
			$tahun = $this->input->post('tahun');
			$project_tipe = $this->input->post('project_tipe');
			$tipenya = $project_tipe.' '.$tahun;
			
			$filter = array(
				"tahun" => $tahun,
				"project_tipe" => $project_tipe,
				"tipenya" => $tipenya
			);

			if($id || !$id){
				if($id){
					
					$table = 'vw_dashboard_tmp';
					$exclude = array('color','history_id','status_id','created','modified','createdid','modifiedid','id','active','slug');
					$sorting = 'id';
					$data = 1;
					
					return $this->getdetail($id, $table, $exclude, $sorting , $data, $categories, $dataset,$filter);
					
				}else{
					
					$table = 'vw_dashboard_tmp';
					$exclude = array('color','history_id','status_id','created','modified','createdid','modifiedid','id','active','slug');
					$sorting = 'id';
					$data = 0;
					
					return $this->getdetail($id, $table, $exclude, $sorting , $data, $categories, $dataset,$filter);
				}
				
			}
			
		}
		
		
		function getdetail($id, $table, $exclude, $sorting , $data, $categories, $dataset,$filter){

			if($id == 0){
				

			}else{
				
				$query_column = $this->ortyd->query_column($table, $exclude);
				if($query_column){
					$ordernya = array(null);
					$searchnya = array();
					foreach($query_column as $rowsdata){
						array_push($ordernya,$rowsdata['name']);
						array_push($searchnya,$rowsdata['name']);
					}
					$column_order = $ordernya;
					$column_search = $searchnya;
				}else{
					$column_order = array(null);
					$column_search = array(null);
				}
				
				$order = array($table.'.'.$sorting => 'DESC');
				$select = $table.'.*';
				
				$jointable = array();
				$joindetail = array();
				$joinposition = array();
				
				$wherecolumn = array();
				$wheredetail = array();

				if($id == 5){

					if($categories != '0' && $categories != ''){
						
						array_push($wherecolumn, $table.'.'.$categories.' !=');
						array_push($wheredetail, 0);
					
						//array_push($wherecolumn, $table.'.bulan_won');
						//array_push($wheredetail, $categories);
						
					}else{
						
					}
					
					if($dataset != '0' && $dataset != ''){
						array_push($wherecolumn, 'lower('.$table.'.channel)');
						array_push($wheredetail, strtolower($dataset));
					}

				}elseif($id == 6){

					if($categories != '0' && $categories != ''){
						
						array_push($wherecolumn, $table.'.'.$categories.' !=');
						array_push($wheredetail, 0);
					
						//array_push($wherecolumn, $table.'.bulan_won');
						//array_push($wheredetail, $categories);
						
					}else{
						
					}
					
					if($dataset != '0' && $dataset != ''){
						array_push($wherecolumn, 'lower('.$table.'.portofolio)');
						array_push($wheredetail, strtolower($dataset));
					}

				}elseif($id == 7){

					if($categories != '0' && $categories != ''){
						
						array_push($wherecolumn, $table.'.'.$categories.' !=');
						array_push($wheredetail, 0);
					
						//array_push($wherecolumn, $table.'.bulan_won');
						//array_push($wheredetail, $categories);
						
					}else{
						
					}
					
					if($dataset != '0' && $dataset != ''){
						array_push($wherecolumn, 'lower('.$table.'.term_of_payment)');
						array_push($wheredetail, strtolower($dataset));
					}

				}elseif($id == 8){

					if($categories != '0' && $categories != ''){
						
						array_push($wherecolumn, $table.'.'.$categories.' !=');
						array_push($wheredetail, 0);
					
						//array_push($wherecolumn, $table.'.bulan_won');
						//array_push($wheredetail, $categories);
						
					}else{
						
					}
					
					if($dataset != '0' && $dataset != ''){
						array_push($wherecolumn, 'lower('.$table.'.kualifikasi)');
						array_push($wheredetail, strtolower($dataset));
					}

				}elseif($id == 9){

					if($categories != '0' && $categories != ''){
						
						array_push($wherecolumn, $table.'.nama_am');
						array_push($wheredetail, $categories);
					
						//array_push($wherecolumn, $table.'.bulan_won');
						//array_push($wheredetail, $categories);
						
					}else{
						
					}
					
					if($dataset != '0' && $dataset != ''){
						//array_push($wherecolumn, $table.'.lower(kualifikasi)');
						//array_push($wheredetail, strtolower($dataset));
					}

				}elseif($id == 10){

					if($categories != '0' && $categories != ''){
						
						array_push($wherecolumn, $table.'.sbu');
						array_push($wheredetail, $categories);
					
						//array_push($wherecolumn, $table.'.bulan_won');
						//array_push($wheredetail, $categories);
						
					}else{
						
					}
					
					if($dataset != '0' && $dataset != ''){
						//array_push($wherecolumn, $table.'.lower(kualifikasi)');
						//array_push($wheredetail, strtolower($dataset));
					}

				}
				
				//$tahun = $this->input->post('tahun');
				//$tipe = $this->input->post('project_tipe');
				//$tipenya = $tipe.' '.$tahun;
		
				array_push($wherecolumn, $table.'.master_legend');
				array_push($wheredetail, $filter['tipenya']);

				$groupby = array();
			
				$list = $this->ortyd->get_datatables($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition, $wherecolumn,$wheredetail,$groupby);
				$data = array();
				$no = $_POST['start'];
				//echo $this->db->last_query();
				foreach ($list as $rows) {
					$rows = (array) $rows;
					$no++;
					$row = array();
					$row[] = $no;
					if($query_column){
						foreach($query_column as $rowsdata){
							if($rowsdata['name']){
								$variable = $rows[$rowsdata['name']];
								$row[] = $variable;
							}else{
								$variable = $rows[$rowsdata['name']];
								$row[] = $variable;
							}
							
						}
					}

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
			
		}
		
	
}	