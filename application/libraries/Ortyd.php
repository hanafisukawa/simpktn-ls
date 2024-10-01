<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Ortyd {

	const ALLOWED_ALGOS = ['default' => PASSWORD_DEFAULT, 'bcrypt' => PASSWORD_BCRYPT];
	protected $_cost = 10;
	protected $_algo = PASSWORD_DEFAULT;
	public $link_pins = 'https://api.pins.co.id/api/';
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('m_api_history');
		//if(function_exists('mcrypt_encrypt') === false){
			//throw new Exception('The Password library requires the Mcrypt extension.');
		//}
	}
	
	public function setMenu($module){
		
		$CI =& get_instance();
		$gid = $CI->session->userdata('group_id');
		
		if($gid == 1 || $gid == 2){
			$CI->db->select('master_menu.*');
			$CI->db->where('master_menu.module', $module);
			$query = $CI->db->get('master_menu');
			$query = $query->result_object();
			if(!$query){
				$datadetail = array(
					'name' 				=> $module,
					'description' 		=> $module,
					'module' 			=> $module,
					'url' 				=> $module,
					'slug' 				=> $this->sanitize($module,'master_menu'),
					'icon'				=> 'fa fa-database',
					'parent_id' 		=> 6,
					'sort' 				=> 99,
					'show' 				=> 1,
					'createdid'			=> 1,
					'created'			=> date('Y-m-d H:i:s'),
					'modifiedid'		=> 1,
					'modified'			=> date('Y-m-d H:i:s'),
					'active'			=> 1
				);
				
				$insert = $CI->db->insert('master_menu', $datadetail);	
				$insertid = $CI->db->insert_id();
				if($insert){
					$CI->db->select('users_groups_access.*');
					$CI->db->where('users_groups_access.gid', $gid);
					$CI->db->where('users_groups_access.menu_id', $insertid);
					$queryaccess = $CI->db->get('users_groups_access');
					$queryaccess = $queryaccess->result_object();
					if(!$queryaccess){
						$datadetail = array(
							'gid' 				=> $gid,
							'menu_id' 			=> $insertid,
							'view' 				=> 1,
							'update' 			=> 1,
							'delete'			=> 1,
							'insert' 			=> 1,
							'createdid'			=> 1,
							'created'			=> date('Y-m-d H:i:s'),
							'modifiedid'		=> 1,
							'modified'			=> date('Y-m-d H:i:s'),
							'active'			=> 1
						);
						
						$insert = $CI->db->insert('users_groups_access', $datadetail);	
						$insertid = $CI->db->insert_id();
					}else{
						$datadetail = array(
							'gid' 				=> $query[0]->gid,
							'menu_id' 			=> $query[0]->menu_id,
							'view' 				=> 1,
							'update' 			=> 1,
							'delete'			=> 1,
							'insert' 			=> 1,
							'createdid'			=> 1,
							'created'			=> date('Y-m-d H:i:s'),
							'modifiedid'		=> 1,
							'modified'			=> date('Y-m-d H:i:s'),
							'active'			=> 1
						);
						
						$CI->db->where('users_groups_access.gid', $gid);
						$CI->db->where('users_groups_access.menu_id', $insertid);
						$insert = $CI->db->update('users_groups_access', $datadetail);	
						$insertid = $query[0]->id;
					}
				}
			}else{
				$CI->db->select('users_groups_access.*');
				$CI->db->where('users_groups_access.gid', $gid);
				$CI->db->where('users_groups_access.menu_id', $query[0]->id);
				$queryaccess = $CI->db->get('users_groups_access');
				$queryaccess = $queryaccess->result_object();
				if(!$queryaccess){
						$datadetail = array(
							'gid' 				=> $gid,
							'menu_id' 			=> $query[0]->id,
							'view' 				=> 1,
							'update' 			=> 1,
							'delete'			=> 1,
							'insert' 			=> 1,
							'createdid'			=> 1,
							'created'			=> date('Y-m-d H:i:s'),
							'modifiedid'		=> 1,
							'modified'			=> date('Y-m-d H:i:s'),
							'active'			=> 1
						);
						
						$insert = $CI->db->insert('users_groups_access', $datadetail);	
						$insertid = $CI->db->insert_id();
				}else{
					$datadetail = array(
						'gid' 				=> $queryaccess[0]->gid,
						'menu_id' 			=> $queryaccess[0]->menu_id,
						'view' 				=> 1,
						'update' 			=> 1,
						'delete'			=> 1,
						'insert' 			=> 1,
						'createdid'			=> 1,
						'created'			=> date('Y-m-d H:i:s'),
						'modifiedid'		=> 1,
						'modified'			=> date('Y-m-d H:i:s'),
						'active'			=> 1
					);
						
					$CI->db->where('users_groups_access.id', $queryaccess[0]->id);
					$insert = $CI->db->update('users_groups_access', $datadetail);	
					$insertid = $queryaccess[0]->id;
				}
			}
		}
		
		
		
	}
	
	function ip_address() 
    {
		
		$this->CI->load->helper('cookie');
		$cookieData = $this->CI->input->cookie("ortyd_session_data_kadi");
		//echo $cookieData;

		return $cookieData;

    }
	
	public function getHistoryAkses($type = 1, $id_data = null){
		
		$CI =& get_instance();
		$userid = $CI->session->userdata('userid');
		if($userid == ''){
			$userid = 0;
		}
		
		$currentURL = current_url(); //http://myhost/main

		if(isset($_SERVER['QUERY_STRING'])){
			$params   = $_SERVER['QUERY_STRING']; //my_id=1,3
			$url = $currentURL . '?' . $params; 
		}else{
			$url = $currentURL;
		}
		
		$ip = $this->ip_address();
		
		if($ip != '' && $ip != null){
			$datenow = "'".date('Y-m-d')."'";
			$CI->db->select('data_history.*');
			$CI->db->where('ip', $ip);
			$CI->db->where('link', $url);
			$CI->db->where('CAST(date AS date) = '.$datenow,null );
			$CI->db->order_by('modified','DESC');
			$query = $CI->db->get('data_history');
			$query = $query->result_object();
			if($query){
				if($query[0]->visit_count == ''){
					$visit_count = 1;
				}else{
					$visit_count = (int)$query[0]->visit_count + 1;
				}
				
				$datadetail = array(
					'modifiedid'		=> $userid,
					'modified'			=> date('Y-m-d H:i:s'),
					'last_access'		=> date('Y-m-d H:i:s'),
					'visit_count'		=> $visit_count
				);
				
				$CI->db->where('ip', $ip);
				$CI->db->where('link', $url);
				$CI->db->where('CAST(date AS date) = '.$datenow,null );
				$insert = $CI->db->update('data_history', $datadetail);	
			
				return false;
			}
			
			
			//$ip = $_SERVER['REMOTE_ADDR'];
			//$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
			//if($details){
				//$city = $details->city;
				//$country = $details->country;
			//}else{
				//$city =null;
				//$country = null;
			//}
			
			$city =null;
			$country = null;
			

			$datadetail = array(
				'ip' 				=> $ip,
				'link' 				=> $url,
				'type' 				=> $type,
				'active' 			=> 1,
				'createdid'			=> $userid,
				'date' 				=> date('Y-m-d H:i:s'),
				'created'			=> date('Y-m-d H:i:s'),
				'modifiedid'		=> $userid,
				'modified'			=> date('Y-m-d H:i:s'),
				'last_access'		=> date('Y-m-d H:i:s'),
				'visit_count'		=> 1,
				'country'			=> $country,
				'city'				=> $city,
				'id_data'			=> $id_data
			);
			

													
			$insert = $CI->db->insert('data_history', $datadetail);	
		}

		return false;
	}
	
	public function getMeta($meta_key){
		
		$tablename = 'meta_value';
		$tableid = 'meta_key';
		$id= $meta_key;
		$table = 'general_setting';
		
		$CI =& get_instance();
		$tablenameas = $tablename.' as name';
		$CI->db->select($tablenameas);
		$CI->db->where($tableid, $id);
		$CI->db->order_by('modified','DESC');
		$query = $CI->db->get($table);
		$query = $query->result_object();
		if($query){
			return $query[0]->name;
		}else{
			return '-';
		}
	}
	
	public function getMeta_cover($meta_key){
		
		$tablename = 'cover';
		$tableid = 'meta_key';
		$id= $meta_key;
		$table = 'general_setting';
		
		$CI =& get_instance();
		$tablenameas = $tablename.' as name';
		$CI->db->select($tablenameas);
		$CI->db->where($tableid, $id);
		$CI->db->order_by('modified','DESC');
		$query = $CI->db->get($table);
		$query = $query->result_object();
		if($query){
			return $query[0]->name;
		}else{
			return '-';
		}
	}
	
	public function query_column_include($table, $exclude_new) {
		
		$exclude = array();
		if(count($exclude_new) > 0){
			$exclude = array_merge($exclude, $exclude_new);
		}
		
		$exclude_column = '';
		if(count($exclude) > 0){
			foreach ($exclude as $value) {
				$value = "'".$value."'";
				if($exclude_column != ''){
					$exclude_column = $exclude_column.','.$value;
				}else{
					$exclude_column = $value;
				}
			}
			$exclude_column = '('.$exclude_column.')';
			$wherein = ' AND column_name in '.$exclude_column.' ';
		}else{
			$wherein = ' ';
		}

		$CI =& get_instance();
		$query_column = $CI->db->query("SELECT
				column_name as name, column_name as id, character_octet_length as numbernya, data_type as type, is_nullable as is_nullable,numeric_precision as isnumber
			FROM
				INFORMATION_SCHEMA.COLUMNS 
			WHERE
				TABLE_SCHEMA = '".$CI->db->database."' 
				AND TABLE_NAME = '".$table."'
				".$wherein."
			ORDER BY column_comment * 1 ASC
		");
		$query_column = $query_column->result_array();
		if(count($query_column) > 0){
			return $query_column;
		}else{
			return null;
		}
		
	}
	
	public function query_column_filter($table, $exclude_new, $ordernya = null) {
		
		$exclude = array();
		if(count($exclude_new) > 0){
			$exclude = array_merge($exclude, $exclude_new);
		}
		
		$exclude_column = '';
		if(count($exclude) > 0){
			foreach ($exclude as $value) {
				$value = "'".$value."'";
				if($exclude_column != ''){
					$exclude_column = $exclude_column.','.$value;
				}else{
					$exclude_column = $value;
				}
			}
			$exclude_column = '('.$exclude_column.')';
			$wherein = ' AND column_name in '.$exclude_column.' ';
		}else{
			$wherein = ' ';
		}
		
		if($ordernya == null){
			$orderdata = " order by ordinal_position ";
		}else{
			$ordernya_list = '';
			$tags = explode(',',$ordernya);
			$xx=0;
			foreach($tags as $key) {
				if($xx==0){
					$ordernya_list = "'".$key."'";  
				}else{
					$ordernya_list = $ordernya_list.','."'".$key."'";    
				}
				
				$xx++;
			}

			$orderdata = " ORDER BY FIELD(column_name,".$ordernya_list.") ASC ";
		}

		$CI =& get_instance();
		$query_column = $CI->db->query("SELECT
				column_name as name, column_name as id, character_octet_length as numbernya, data_type as type, is_nullable as is_nullable,numeric_precision as isnumber
			FROM
				INFORMATION_SCHEMA.COLUMNS 
			WHERE
				TABLE_SCHEMA = '".$CI->db->database."' 
				AND TABLE_NAME = '".$table."'
				".$wherein."
				".$orderdata."
		");
		$query_column = $query_column->result_array();
		if(count($query_column) > 0){
			return $query_column;
		}else{
			return null;
		}
		
	}
	
	public function query_column_include_nosort($table, $exclude_new) {
		
		$exclude = array();
		if(count($exclude_new) > 0){
			$exclude = array_merge($exclude, $exclude_new);
		}
		
		$exclude_column = '';
		if(count($exclude) > 0){
			foreach ($exclude as $value) {
				$value = "'".$value."'";
				if($exclude_column != ''){
					$exclude_column = $exclude_column.','.$value;
				}else{
					$exclude_column = $value;
				}
			}
			$exclude_column = '('.$exclude_column.')';
			$wherein = ' AND column_name in '.$exclude_column.' ';
		}else{
			$wherein = ' ';
		}

		$CI =& get_instance();
		$query_column = $CI->db->query("SELECT
				column_name as name, column_name as id, character_octet_length as numbernya, data_type as type, is_nullable as is_nullable,numeric_precision as isnumber
			FROM
				INFORMATION_SCHEMA.COLUMNS 
			WHERE
				TABLE_SCHEMA = '".$CI->db->database."' 
				AND TABLE_NAME = '".$table."'
				".$wherein."
				order by ordinal_position
		");
		$query_column = $query_column->result_array();
		if(count($query_column) > 0){
			return $query_column;
		}else{
			return null;
		}
		
	}
	
	public function getviewlistform($module, $exclude){
			$this->CI->db->select('translate_view.*');
			$this->CI->db->where('translate_view.table',$module);
			$this->CI->db->where('translate_view.module',$module);
			$this->CI->db->where('translate_view.active',1);
			$this->CI->db->order_by('translate_view.modified','DESC');
			$this->CI->db->limit(1);
			$queryexclude = $this->CI->db->get('translate_view');
			$queryexclude = $queryexclude->result_object();
			if($queryexclude){
				$query_column = $this->query_column($module, $exclude, null, $queryexclude[0]->data_order_form);
			}else{
				$query_column = $this->query_column($module, $exclude, null, null);
			}
			
			return $query_column;
	}
	
	public function query_column($table, $exclude_new, $ordernya = null, $orderformnya = null) {
		
		$exclude = array();
		if(count($exclude_new) > 0){
			$exclude = array_merge($exclude, $exclude_new);
		}
		
		$exclude_column = '';
		if(count($exclude) > 0){
			foreach ($exclude as $value) {
				$value = "'".$value."'";
				if($exclude_column != ''){
					$exclude_column = $exclude_column.','.$value;
				}else{
					$exclude_column = $value;
				}
			}
			$exclude_column = '('.$exclude_column.')';
			$wherein = ' AND column_name not in '.$exclude_column.' ';
		}else{
			$wherein = ' ';
		}
		
		if($ordernya == null){
			
			if($orderformnya == null){
				$orderdata = " ORDER BY column_comment * 1 ASC ";
			}else{
				$ordernya_list = '';
				$tags = explode(',',$orderformnya);
				$xx=0;
				foreach($tags as $key) {
					if($xx==0){
						$ordernya_list = "'".$key."'";  
					}else{
						$ordernya_list = $ordernya_list.','."'".$key."'";    
					}
					
					$xx++;
				}

				$orderdata = " ORDER BY FIELD(column_name,".$ordernya_list.") ASC,  name ASC ";
			}
		
			
		}else{
			$ordernya_list = '';
			$tags = explode(',',$ordernya);
			$xx=0;
			foreach($tags as $key) {
				if($xx==0){
					$ordernya_list = "'".$key."'";  
				}else{
					$ordernya_list = $ordernya_list.','."'".$key."'";    
				}
				
				$xx++;
			}

			$orderdata = " ORDER BY FIELD(column_name,".$ordernya_list.") ASC, name ASC  ";
		}

		$CI =& get_instance();
		$query_column = $CI->db->query("SELECT
				column_name as name, column_name as id, character_octet_length as numbernya, data_type as type, is_nullable as is_nullable,numeric_precision as isnumber
			FROM
				INFORMATION_SCHEMA.COLUMNS 
			WHERE
				TABLE_SCHEMA = '".$CI->db->database."' 
				AND TABLE_NAME = '".$table."'
				".$wherein."
				".$orderdata."
		");
		$query_column = $query_column->result_array();
		if(count($query_column) > 0){
			return $query_column;
		}else{
			return null;
		}
		
	}
	
	
	public function query_column_nosort($table, $exclude_new, $ordernya = null) {
		
		$exclude = array();
		if(count($exclude_new) > 0){
			$exclude = array_merge($exclude, $exclude_new);
		}
		
		$exclude_column = '';
		if(count($exclude) > 0){
			foreach ($exclude as $value) {
				$value = "'".$value."'";
				if($exclude_column != ''){
					$exclude_column = $exclude_column.','.$value;
				}else{
					$exclude_column = $value;
				}
			}
			$exclude_column = '('.$exclude_column.')';
			$wherein = ' AND column_name not in '.$exclude_column.' ';
		}else{
			$wherein = ' ';
		}
		
		if($ordernya == null){
			$orderdata = " order by ordinal_position ";
		}else{
			$ordernya_list = '';
			$tags = explode(',',$ordernya);
			$xx=0;
			foreach($tags as $key) {
				if($xx==0){
					$ordernya_list = "'".$key."'";  
				}else{
					$ordernya_list = $ordernya_list.','."'".$key."'";    
				}
				
				$xx++;
			}

			$orderdata = " ORDER BY FIELD(column_name,".$ordernya_list.") ASC ";
		}

		$CI =& get_instance();
		$query_column = $CI->db->query("SELECT
				column_name as name, column_name as id, character_octet_length as numbernya, data_type as type, is_nullable as is_nullable,numeric_precision as isnumber
			FROM
				INFORMATION_SCHEMA.COLUMNS 
			WHERE
				TABLE_SCHEMA = '".$CI->db->database."' 
				AND TABLE_NAME = '".$table."'
				".$wherein."
				".$orderdata."
		");
		$query_column = $query_column->result_array();
		if(count($query_column) > 0){
			return $query_column;
		}else{
			return null;
		}
		
	}
	
	
	
	public function width_column($table,$column_name){
		
		$refdata = $this->getRefDataWidth($table,$column_name);
		if($refdata != null){
			return $refdata;
		}
			
		$CI =& get_instance();
		$query_column = $CI->db->query("SELECT
				column_name as name, column_name as id, character_octet_length as numbernya, data_type as type, is_nullable as is_nullable,numeric_precision as isnumber,column_comment  as column_comment
			FROM
				INFORMATION_SCHEMA.COLUMNS 
			WHERE
				 COLUMN_NAME = '".$column_name."' 
				AND TABLE_SCHEMA = '".$CI->db->database."' 
				AND TABLE_NAME = '".$table."'
			ORDER BY column_comment * 1 ASC
		");
		$query_column = $query_column->result_array();
		if(count($query_column) > 0){
			if(isset($query_column[0]['column_comment'])){
				$label = $query_column[0]['column_comment'];
				$label = explode('|',$label);
				if(count($label) > 0){
					if(isset($label[2])){
						if(is_numeric($label[2]) == true){
							$column_name = $label[2];
						}else{
							$column_name = '12';
						}
					}else{
						$column_name = '12';
					}
				}else{
					$column_name = '12';
				}
			}else{
				$column_name = '12';
			}
			
		}
		
		return $column_name;
	}
	
	public function get_table_reference($table,$column_name){
		
		if(getenv('DB_CONNECTION') == 'postgre'){
			
			
			$refdata = $this->getRefData($table,$column_name);
			if($refdata != null){
				return $refdata;
			}
			
			$column_ori = $column_name;
			$CI =& get_instance();
			$query_column = $CI->db->query("SELECT
					cols.column_name as name, 
					cols.column_name as id, 
					cols.character_octet_length as numbernya, 
					cols.data_type as type, cols.is_nullable as is_nullable,
					cols.numeric_precision as isnumber,
					(
						SELECT
							pg_catalog.col_description(c.oid, cols.ordinal_position::int)
						FROM
							pg_catalog.pg_class c
						WHERE
							c.oid = (SELECT (cols.table_name)::regclass::oid)
							AND c.relname = cols.table_name
					) AS column_comment
				FROM
					INFORMATION_SCHEMA.COLUMNS cols
				WHERE
					cols.COLUMN_NAME = '".$column_name."' 
					AND cols.TABLE_SCHEMA = 'public'
					AND cols.TABLE_NAME = '".$table."'
				ORDER BY (
					SELECT
						pg_catalog.col_description(c.oid, cols.ordinal_position::int)
					FROM
						pg_catalog.pg_class c
					WHERE
						c.oid = (SELECT (cols.table_name)::regclass::oid)
						AND c.relname = cols.table_name
				) ASC
			");
			
			$query_column = $query_column->result_array();
			if(count($query_column) > 0){
				if(isset($query_column[0]['column_comment'])){
					$label = $query_column[0]['column_comment'];
					$label = explode('|',$label);
					if(count($label) > 0){
						if(isset($label[3])){
							$tabel_ref = $label[3];
							if(isset($label[4])){
								$table_id = $label[4];
							}else{
								$table_id = 'id';
							}
							if(isset($label[5])){
								$table_name = $label[5];
							}else{
								$table_name = 'name';
							}
							return array($tabel_ref,$table_id,$table_name);
						}
					}
				}
			}
			
			$refdata = $this->getRefData($table,$column_name);
			if($refdata != null){
				return $refdata;
			}
			
			return null;
			
		}else{
			
			$refdata = $this->getRefData($table,$column_name);
			if($refdata != null){
				return $refdata;
			}
			
			$column_ori = $column_name;
			$CI =& get_instance();
			$query_column = $CI->db->query("SELECT
					column_name as name, column_name as id, character_octet_length as numbernya, data_type as type, is_nullable as is_nullable,numeric_precision as isnumber,column_comment  as column_comment
				FROM
					INFORMATION_SCHEMA.COLUMNS 
				WHERE
					 COLUMN_NAME = '".$column_name."' 
					AND TABLE_SCHEMA = '".$CI->db->database."' 
					AND TABLE_NAME = '".$table."'
				ORDER BY column_comment * 1 ASC
			");
			$query_column = $query_column->result_array();
			if(count($query_column) > 0){
				if(isset($query_column[0]['column_comment'])){
					$label = $query_column[0]['column_comment'];
					$label = explode('|',$label);
					if(count($label) > 0){
						if(isset($label[3])){
							$tabel_ref = $label[3];
							if(isset($label[4])){
								$table_id = $label[4];
							}else{
								$table_id = 'id';
							}
							if(isset($label[5])){
								$table_name = $label[5];
							}else{
								$table_name = 'name';
							}
							return array($tabel_ref,$table_id,$table_name);
						}
					}
				}
			}
			
			
			
			return null;
		
			
		}
		
	}
	
	public function translate_column($table,$column_name){
		
		$this->CI->db->select('translate.*');
		$this->CI->db->where('translate.meta_id',$column_name);
		$this->CI->db->where('translate.meta_table',$table);
		$this->CI->db->where('translate.active',1);
		$this->CI->db->order_by('translate.modified','DESC');
		$this->CI->db->limit(1);
		$query = $this->CI->db->get('translate');
		$query = $query->result_object();
		if($query){
			return $query[0]->meta_value;
		}
		
		$column_ori = $column_name;
		$CI =& get_instance();
		$query_column = $CI->db->query("SELECT
				column_name as name, column_name as id, character_octet_length as numbernya, data_type as type, is_nullable as is_nullable,numeric_precision as isnumber,column_comment  as column_comment
			FROM
				INFORMATION_SCHEMA.COLUMNS 
			WHERE
				 COLUMN_NAME = '".$column_name."' 
				AND TABLE_SCHEMA = '".$CI->db->database."' 
				AND TABLE_NAME = '".$table."'
			ORDER BY column_comment * 1 ASC
		");
		$query_column = $query_column->result_array();
		if(count($query_column) > 0){
			if(isset($query_column[0]['column_comment'])){
				$label = $query_column[0]['column_comment'];
				$label = explode('|',$label);
				if(count($label) > 0){
					if(isset($label[1])){
						$column_name = $label[1];
					}
				}
			}
		}
		
		if($column_name == $column_ori){
			return $this->translate_column_view($table,$column_name);
		}
		
		return $column_name;
	}
	
	
	public function translate_column_view($table,$column_name){
		
		$this->CI->db->select('translate.*');
		$this->CI->db->where('translate.meta_id',$column_name);
		$this->CI->db->where('translate.meta_table',$table);
		$this->CI->db->where('translate.active',1);
		$this->CI->db->order_by('translate.modified','DESC');
		$this->CI->db->limit(1);
		$query = $this->CI->db->get('translate');
		$query = $query->result_object();
		if($query){
			return $query[0]->meta_value;
		}
		
		if($column_name == 'jml_bast_selesai'){
			return "Jumlah BAST Selesai";
		}elseif($column_name == 'handover_type'){
			return "Tipe Handover";
		}elseif($column_name == 'file'){
			return "Dokumen";
		}elseif($column_name == 'invoice_type'){
			return "Dokumen Tipe";
		}elseif($column_name == 'status_invoice_name'){
			return "Status Invoice";
		}elseif($column_name == 'deskripsi_progres'){
			return "Deskripsi Progres";
		}
		
		$CI =& get_instance();
		$query_column = $CI->db->query("SELECT
				column_name as name, column_name as id, character_octet_length as numbernya, data_type as type, is_nullable as is_nullable,numeric_precision as isnumber,column_comment  as column_comment
			FROM
				INFORMATION_SCHEMA.COLUMNS 
			WHERE
				 COLUMN_NAME = '".$column_name."' 
				AND TABLE_SCHEMA = '".$CI->db->database."' 
				 AND column_comment != ''
			ORDER BY column_comment * 1 ASC
		");
		$query_column = $query_column->result_array();
		if(count($query_column) > 0){
			if(isset($query_column[0]['column_comment'])){
				$label = $query_column[0]['column_comment'];
				$label = explode('|',$label);
				if(count($label) > 0){
					if(isset($label[1])){
						$column_name = $label[1];
					}
				}
			}
			
		}
		
		return $column_name;
	}
	
	public function getDetailPagebySlug($slug){
		$this->CI->db->select('data_page.*,master_page_type.name as type_name');
		$this->CI->db->where('data_page.slug',$slug);
		$this->CI->db->where('data_page.active',1);
		$this->CI->db->where('data_page.is_publish',1);
		$this->CI->db->join('master_page_type','master_page_type.id = data_page.type','left');
		$this->CI->db->order_by('data_page.modified','DESC');
		$this->CI->db->limit(1);
		$query = $this->CI->db->get('data_page');
		$query = $query->result_array();
		if(count($query) > 0){
			return $query;
		}
		
		return null;
	}
	
	public function security_access($id, $table, $table_id) {
		
		$CI =& get_instance();
		
		$userid = $CI->session->userdata('userid');
		$gid = $CI->session->userdata('group_id');
		
		if($gid == 3){
			$area_kota_id = $this->select2_getname($userid,'users_data','id','area_kota_id');
			
			$CI->db->select('area_kota_id');
			$CI->db->where($table_id,$id);
			$CI->db->limit(1);
			$query = $CI->db->get($table);
			$query = $query->result_object();
			if($query){
				if($query[0]->area_kota_id == $area_kota_id){
					//redirect('dashboard?message=noaccess', 'refresh');
				}else{
					redirect('dashboard?message=noaccess', 'refresh');
				}
			}
		}

	}
	
	function sendMessage($content, $heading, $userID){
			$app_id_onesignal = 'addb86dd-20af-4bda-b713-97b35b464400';
			$this->CI->db->select('notif_id');
			$this->CI->db->where('id',$userID);
			$result = $this->CI->db->get('users_data');
			$result = $result->result_object();
			if($result){
				 if($result[0]->notif_id != ''){
					 
					$heading = array(
					   "en" => $heading
					);

					$content = array(
						"en" => $content
					);
					
					$fields = array(
						'app_id' => $app_id_onesignal,
						//'android_channel_id' => '2f24550a-5358-43af-9e81-ebb4ff455690',
						'include_aliases' => array(
							"external_id" => array($result[0]->notif_id)
						),
						"target_channel" => "push",
						'data' => array("foo" => "bar"),
						'contents' => $content,
						'priority' => 10,
						'headings' => $heading,
					);
					
					$fields = json_encode($fields);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
															   'Authorization: Basic YTVjMTljODUtOWMxNi00ODliLWE5ZjgtMWRhZDhlYTE0MzFk'));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, FALSE);
					curl_setopt($ch, CURLOPT_POST, TRUE);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

					$response = curl_exec($ch);
					curl_close($ch);
					return array("status" => 1,"message" => json_encode($response), "notif_id" => array($result[0]->notif_id));
				 }else{
					return array("status" => 0,"message" => 'Notif ID NUll', "notif_id" => array($result[0]->notif_id));
				 }
			}else{
				return array("status" => 0,"message" => 'User tidak ditemukan', "notif_id" => '');
			}
			
			
		}
	
	
	//SESSION CHECK
	
	function sendGCM($to_id,$title,$message) {
			$notif_id = $this->select2_getname($to_id,"users_data","id","notif_id");
			
			if($notif_id == ''){
				return false;
			}
			
			$SERVER_KEY = 'AAAAOoITJHs:APA91bHfDd55eoHMHpKiWsz_5ulY7WEbzfaeTh0zQP392l449FoGaSai5z9oBnM2z8HkPeQOZJ2AbuZCPirHEyit5Q0yr5wgCihth18l585LZJC5YRyhvdbXRMB-5g4KqTH8NqkVLpEe';
			
			$DEVICE_REG_TOKEN=$notif_id;
			
				$databosy = [
					'click_action' => base_url(),
					'url' =>  base_url(),
					'icon' => base_url('logo-text.png')
				  ];
			  
			  $msg = [
				'title' => $title,
				'body' => $message,
				'icon' => base_url('logo-text.png'),
				'click_action' => base_url(),
				'data' => $databosy
			  ];

			  $fields = [
				'to' => $DEVICE_REG_TOKEN,
				'notification' => $msg
			  ];
  
			
			$fields = json_encode($fields);
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

			$headers = array();
			$headers[] = 'Authorization: key='.$SERVER_KEY;
			$headers[] = 'Content-Type: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);
			return $result;
		}
		
	public function session_check() {
		$CI =& get_instance();
		$CI->load->library('curl');
		
		if(isset($_GET['tkey'])){
			$CI->session->sess_destroy();
		}
		
		$email_sso = $CI->session->userdata('email_sso');
		if($email_sso == '' || $email_sso == null){
			if(isset($_GET['tkey'])){
			
				//$CI->session->sess_destroy();
				
				$params = array(
							//'limit'		=>	10000,
							//'offset'	=>	0
				);
				
				$token = $_GET['tkey'];
				$data = $CI->curl->simple_get($this->link_pins.'cms/user/get-detail/',$params,array(
							CURLOPT_HTTPHEADER => array('Authorization:Bearer '.$token.''),
							CURLOPT_TIMEOUT => 50000,
							CURLOPT_SSL_VERIFYPEER => false
					)
				);
					
				$info = $CI->curl->info;
				$rowcode = $info['http_code'];
				
				//print_r($data);
				//die();
				if($data){
					$data = json_decode($data);
					$rowdata = (array)$data->data;
				
					$rowcode = $rowcode;
					if(count($rowdata) > 0){
						//print_r($rowdata);
						//die();
						$login = array(
							'key'  => $_GET['tkey'],
							'email_sso' => $rowdata['email']
						);
							
						$CI->session->set_userdata($login);
					}
				}
			}
		}else{
			if(isset($_GET['tkey'])){
				//$CI->session->sess_destroy();
			}
		}
		
		
		//die();
		$email_sso = $CI->session->userdata('email_sso');
		$userid = $CI->session->userdata('userid');
		$logged_in = $CI->session->userdata('logged_in');
		if ( !$userid && $logged_in != TRUE) {
			if(isset($_GET['tkey'])){
				if($email_sso != ''){
					//echo $email_sso;
					//die();
					redirect('login?email='.$email_sso, 'refresh');
				}else{
					redirect('https://one.pins.co.id/', 'refresh');
					die();
				}
			}else{
				redirect('login', 'refresh');
			}
			
		}

	}
	
	public function access_check($module) {
		$CI =& get_instance();
		$group_id = $CI->session->userdata('group_id');
		$this->setMenu($module);
		
		$CI->db->where('gid',$group_id);
		$CI->db->where('module',$module);
		$CI->db->where('view',1);
		$CI->db->join('master_menu','master_menu.id=users_groups_access.menu_id');
		$query = $CI->db->get('users_groups_access');
		$query = $query->result_object();
		if(!$query){
			if($module == 'dashboard'){
				#
			}else{
				redirect('dashboard?message=noaccess', 'refresh');
			}
			
		}
		
		return true;

	}
	
	public function parentmodule($module) {
		$CI =& get_instance();
		$CI->db->where('module',$module);
		$query = $CI->db->get('master_menu');
		$query = $query->result_object();
		if($query){
			return $query[0]->parent_id;
		}
		
		return null;

	}
	
	public function getmodulename($module) {
		$CI =& get_instance();
		$CI->db->where('module',$module);
		$query = $CI->db->get('master_menu');
		$query = $query->result_object();
		if($query){
			return $query[0]->name;
		}
		
		return null;

	}
	
	public function access_check_insert($module) {
		$CI =& get_instance();
		$group_id = $CI->session->userdata('group_id');
		
		$CI->db->where('gid',$group_id);
		$CI->db->where('module',$module);
		$CI->db->where('insert',1);
		$CI->db->join('master_menu','master_menu.id=users_groups_access.menu_id');
		$query = $CI->db->get('users_groups_access');
		$query = $query->result_object();
		if(!$query){
			if($module == 'dashboard'){
				#
			}else{
				redirect('dashboard?message=noaccess', 'refresh');
			}
			
		}
		
		return true;

	}
	
	public function getIconMenu($module) {
		$CI =& get_instance();
		$CI->db->where('module',$module);
		$CI->db->limit(1);
		$query = $CI->db->get('master_menu');
		$query = $query->result_object();
		if($query){
			return $query[0]->icon;
		}
		
		return 'fa fa-home';

	}
	
	public function access_check_view($module) {
		$CI =& get_instance();
		$group_id = $CI->session->userdata('group_id');
		
		$CI->db->where('gid',$group_id);
		$CI->db->where('module',$module);
		$CI->db->where('view',1);
		$CI->db->join('master_menu','master_menu.id=users_groups_access.menu_id');
		$query = $CI->db->get('users_groups_access');
		$query = $query->result_object();
		if(!$query){
			if($module == 'dashboard'){
				#
			}else{
				redirect('dashboard?message=noaccess', 'refresh');
			}
			
		}
		
		return true;

	}
	
	public function access_check_update($module) {
		$CI =& get_instance();
		$group_id = $CI->session->userdata('group_id');
		
		$CI->db->where('gid',$group_id);
		$CI->db->where('module',$module);
		$CI->db->where('update',1);
		$CI->db->join('master_menu','master_menu.id=users_groups_access.menu_id');
		$query = $CI->db->get('users_groups_access');
		$query = $query->result_object();
		if(!$query){
			if($module == 'dashboard'){
				#
			}else{
				redirect('dashboard?message=noaccess', 'refresh');
			}
			
		}
		
		return true;

	}
	
	public function access_check_delete($module) {
		$CI =& get_instance();
		$group_id = $CI->session->userdata('group_id');
		
		$CI->db->where('gid',$group_id);
		$CI->db->where('module',$module);
		$CI->db->where('delete',1);
		$CI->db->join('master_menu','master_menu.id=users_groups_access.menu_id');
		$query = $CI->db->get('users_groups_access');
		$query = $query->result_object();
		if(!$query){
			if($module == 'dashboard'){
				#
			}else{
				redirect('dashboard?message=noaccess', 'refresh');
			}
			
		}
		
		return true;

	}
	
	public function access_check_insert_data($module) {
		$CI =& get_instance();
		$group_id = $CI->session->userdata('group_id');
		
		$CI->db->where('gid',$group_id);
		$CI->db->where('module',$module);
		$CI->db->where('insert',1);
		$CI->db->join('master_menu','master_menu.id=users_groups_access.menu_id');
		$query = $CI->db->get('users_groups_access');
		$query = $query->result_object();
		if(!$query){
			return false;
		}
		
		return true;

	}
	
	public function access_check_view_data($module) {
		$CI =& get_instance();
		$group_id = $CI->session->userdata('group_id');
		
		$CI->db->where('gid',$group_id);
		$CI->db->where('module',$module);
		$CI->db->where('view',1);
		$CI->db->join('master_menu','master_menu.id=users_groups_access.menu_id');
		$query = $CI->db->get('users_groups_access');
		$query = $query->result_object();
		if(!$query){
			return false;
		}
		
		return true;

	}
	
	public function access_check_update_data($module) {
		$CI =& get_instance();
		$group_id = $CI->session->userdata('group_id');
		
		$CI->db->where('gid',$group_id);
		$CI->db->where('module',$module);
		$CI->db->where('update',1);
		$CI->db->join('master_menu','master_menu.id=users_groups_access.menu_id');
		$query = $CI->db->get('users_groups_access');
		$query = $query->result_object();
		if(!$query){
			return false;
		}
		
		return true;

	}

	public function access_check_delete_data($module) {
		$CI =& get_instance();
		$group_id = $CI->session->userdata('group_id');
		
		$CI->db->where('gid',$group_id);
		$CI->db->where('module',$module);
		$CI->db->where('delete',1);
		$CI->db->join('master_menu','master_menu.id=users_groups_access.menu_id');
		$query = $CI->db->get('users_groups_access');
		$query = $query->result_object();
		if(!$query){
			return false;
		}
		
		return true;

	}
	
	public function get_access_id(){
		$CI =& get_instance();
		return $CI->session->userdata('group_id');
	}
	
	//SELECT2 DATA
	
	public function select2_data_all($table,$tableid,$tablename,$q) {
		$CI =& get_instance();
		$tableidas = $tableid.' as id';
		$tablenameas = $tablename.' as name';
		$column = $tableidas.','.$tablenameas;
		$CI->db->select($column);
		$query = $CI->db->get($table);
		$query = $query->result_array();
		$data = array('items' => $query);
		return json_encode($data);
	}
	
	public function select2_data_filter_all($table,$tableid,$tablename,$q, $filter, $filterdata) {
		$CI =& get_instance();
		$tableidas = $tableid.' as id';
		$tablenameas = $tablename.' as name';
		$column = $tableidas.','.$tablenameas;
		$CI->db->select($column);
		$CI->db->where($filter, $filterdata);
		$query = $CI->db->get($table);
		$query = $query->result_array();
		$data = array('items' => $query);
		return json_encode($data);
	}
	
	public function select2_data_filter($table,$tableid,$tablename, $q, $filter, $filterdata) {
		$CI =& get_instance();
		$tableidas = $tableid.' as id';
		$tablenameas = $tablename.' as name';
		$column = $tableidas.','.$tablenameas;
		$CI->db->select($column);
		$CI->db->like($tablename, $q);
		$CI->db->where($filter, $filterdata);
		$query = $CI->db->get($table);
		$query = $query->result_array();
		$data = array('items' => $query);
		return json_encode($data);
	}

	public function select2_data($table,$tableid,$tablename,$q) {
		$CI =& get_instance();
		$tableidas = $tableid.' as id';
		$tablenameas = $tablename.' as name';
		$column = $tableidas.','.$tablenameas;
		$CI->db->select($column);
		$CI->db->like($tablename, $q);
		$query = $CI->db->get($table);
		$query = $query->result_array();
		$data = array('items' => $query);
		return json_encode($data);
	}
	
	public function select2_getname_all($id,$table,$tableid){
		$CI =& get_instance();
		//$tablenameas = $tablename.' as name';
		$CI->db->select('*');
		$CI->db->where($tableid, $id);
		$CI->db->order_by('modified','DESC');
		$query = $CI->db->get($table);
		$query = $query->result_object();
		if($query){
			return $query[0];
		}else{
			return null;
		}
	}
	
	public function select2_getname($id,$table,$tableid,$tablename){
		$CI =& get_instance();
		$tablenameas = $tablename.' as name';
		$CI->db->select($tablenameas);
		if($tableid != null && $id != null){
			$CI->db->where($tableid, $id);
		}
		
		$CI->db->order_by('modified','DESC');
		$query = $CI->db->get($table);
		$query = $query->result_object();
		if($query){
			return $query[0]->name;
		}else{
			return '-';
		}
	}
	
	public function select2_getname_menu($id,$table,$tableid,$tablename,$notnullid){
		$CI =& get_instance();
		$tablenameas = $tablename.' as name';
		$CI->db->select($tablenameas);
		$CI->db->where($tableid, $id);
		$CI->db->where($notnullid.' !=', '00000000-0000-0000-0000-000000000000');
		$CI->db->order_by('modified','DESC');
		$query = $CI->db->get($table);
		$query = $query->result_object();
		if($query){
			return $query[0]->name;
		}else{
			return '-';
		}
	}

	public function tgl_indo($tanggal){
		$bulan = array (
			'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tahun
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tanggal
	 
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}

	public function months_array($id)
	{
		$months_array=array(
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'Nopember',
			12 => 'Desember'
		);
	
			return $months_array[$id];
	}
	
	
	//DATATABLES DATA

	public function _get_datatables_query($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition,$wheretable,$wherecolumn,$groupby)
    {
		$CI =& get_instance();
		$CI->db->select($select);
		if(count($jointable) > 0){
			for($i = 0;$i < count($jointable);$i++){
				$CI->db->join($jointable[$i], $joindetail[$i], $joinposition[$i]);
			}
		}
        $CI->db->from($table);
		
		if(count($wheretable) > 0){
			for($i = 0;$i < count($wheretable);$i++){
				
				$explode = explode("|",$wheretable[$i]);
				if(count($explode) > 1){
					if($explode[1] == 'in'){
						$CI->db->where_in($explode[0], $wherecolumn[$i]);
					}elseif($explode[1] == 'notin'){
						$CI->db->where_not_in($explode[0], $wherecolumn[$i]);
					}elseif($explode[1] == 'or'){
						$CI->db->or_where($wheretable[$i], $wherecolumn[$i]);
					}else{
						$CI->db->where($wheretable[$i], $wherecolumn[$i]);
					}
				}else{
					$CI->db->where($wheretable[$i], $wherecolumn[$i]);
				}
						
				
			}
		}
 
        $i = 0;
     
        foreach ($column_search as $item)
        {
			if($_POST['search']['value'])
            {
                if($i===0)
                {
                    $CI->db->group_start();
                    $CI->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $CI->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($column_search) - 1 == $i)
                    $CI->db->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order']))
        {
            $CI->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($order))
        {
            $order = $order;
			if(count($order) > 0){
				foreach($order as $rows => $key){
					$CI->db->order_by($rows,$key);
				}
			}
            
        }
		
		if(count($groupby) > 0){
			$CI->db->group_by($groupby); 
		}
		
		 
		 
    }
 
    public function get_datatables($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition,$wheretable,$wherecolumn,$groupby)
    {
		$CI =& get_instance();
        $this->_get_datatables_query($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition,$wheretable,$wherecolumn,$groupby);
		
		
        if($_POST['length'] != -1)
        $CI->db->limit($_POST['length'], $_POST['start']);
        $query = $CI->db->get();
		//echo $CI->db->last_query();
        return $query->result();
    }
 
    public function count_filtered($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition,$wheretable,$wherecolumn,$groupby)
    {
		$CI =& get_instance();
        $this->_get_datatables_query($table,$column_order,$column_search,$order,$select,$jointable,$joindetail,$joinposition,$wheretable,$wherecolumn,$groupby);
        $query = $CI->db->get();
        return $query->num_rows();
    }
 
    public function count_all($table)
    {
		$CI =& get_instance();
        $CI->db->from($table);
        return $CI->db->count_all_results();
    }
	
	//PASSWORD ENCRYPT

	public function hash($password){
		return password_hash($password, $this->_algo, ['cost' => $this->_cost]);
	}

	public function set_cost($cost = 10){
		$this->_cost = $cost;
		return $this;
	}

	public function set_algo($algo = 'default'){
		if(!in_array($algo, array_keys(self::ALLOWED_ALGOS))){
			throw new Exception($algo ." is not allowed algo.");
		}
		$this->_algo = self::ALLOWED_ALGOS[$algo];
		return $this;
	}

	public function verify_hash($password, $hash){
		return password_verify($password, $hash);
	}
	
	
	public function upload_image_do($target_path, $file, $namefield){
		$CI =& get_instance();
		if($file){
			$CI->load->library('upload');
			$config['upload_path'] = $target_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$CI->upload->initialize($config);
			if($CI->upload->do_upload($namefield)){
				$file_data = $CI->upload->data();
				return $file_data['file_name'];
			}else{
				return null;
			}
		}
		 
	}
	
	function _clean_input_data($str)
	{
		$string = str_replace("&nbsp;", " ", $str);
		$string = str_replace("&ndash;", " ", $string);
		$string = htmlspecialchars(trim($string) ?? '');
		$string = html_entity_decode($string) ;
		$string = preg_replace('/<[^<|>]+?>/', ' ', htmlspecialchars_decode($string));
		$string = htmlentities($string, ENT_QUOTES, "UTF-8");
		return $string;
		
	}
	
	function _clean_special($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

	   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}
	
	function rupiah($angka){
	
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	 
	}
	
	function rupiahnonkoma($angka){
		if($angka == 0){
			$hasil_rupiah = " - ";
		}else{
			$hasil_rupiah = "" . number_format($angka,0,',','.');
		}
		
		return $hasil_rupiah;
	 
	}
	
	function sanitize($string,$table){
		
		if($string == null){
			$string = '';
		}
		$CI =& get_instance();
		// sanitize string, remove Latin chars like 'ç ' and add - instead of white-space
		// based on: http://stackoverflow.com/a/2103815/2275490
		$str= strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
		// check how often header exists in table "posts"
		// add counted suffix to pretty_url if already exists
		
		$x=1;
		$y=1;
		$strold = $str;
		while($x == 1) {
			//echo $str.'<br>';
			$CI->db->select('count(*) as total');
			$CI->db->where('lower(slug)', strtolower($str));
			$query = $CI->db->get($table);
			$query = $query->result_array();
			//echo $CI->db->last_query();;
			if(count($query)>0) {
				if($query[0]['total'] == 0){
					$x=2;
					//$str=$strold.'-'.$y;
					break;
				}else{
					$y++;
					$str=$strold.'-'.$y; // allways returns the latest number for same slug
					//echo $str;
					//$x=3;
				}
			}else{
				$x=2;
			}
		}

		return $str;                    
	}
	
	function getsanitizefieldid($string,$table){
		
		if($string == null){
			$string = '';
		}
		$CI =& get_instance();
		// sanitize string, remove Latin chars like 'ç ' and add - instead of white-space
		// based on: http://stackoverflow.com/a/2103815/2275490
		$str= strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
		// check how often header exists in table "posts"
		// add counted suffix to pretty_url if already exists
		
		$x=1;
		$y=1;
		$strold = $str;
		while($x == 1) {
			//echo $str.'<br>';
			$CI->db->select('count(*) as total');
			$CI->db->where('lower(field_detail_id)', strtolower($str));
			$query = $CI->db->get($table);
			$query = $query->result_array();
			//echo $CI->db->last_query();;
			if(count($query)>0) {
				if($query[0]['total'] == 0){
					$x=2;
					//$str=$strold.'-'.$y;
					break;
				}else{
					$y++;
					$str=$strold.'-'.$y; // allways returns the latest number for same slug
					//echo $str;
					//$x=3;
				}
			}else{
				$x=2;
			}
		}

		return $str;                    
	}
	
	function hari_ini($date){
		$date = date_create($date);
		$hari = date_format($date,"D");
	 
		switch($hari){
			case 'Sun':
				$hari_ini = "Minggu";
			break;
	 
			case 'Mon':			
				$hari_ini = "Senin";
			break;
	 
			case 'Tue':
				$hari_ini = "Selasa";
			break;
	 
			case 'Wed':
				$hari_ini = "Rabu";
			break;
	 
			case 'Thu':
				$hari_ini = "Kamis";
			break;
	 
			case 'Fri':
				$hari_ini = "Jumat";
			break;
	 
			case 'Sat':
				$hari_ini = "Sabtu";
			break;
			
			default:
				$hari_ini = "Tidak di ketahui";		
			break;
		}
 
	return $hari_ini.', '.date_format($date,"d F Y");
 
	}
	
	function getConfigPagging($url, $jumlah_data, $per_page, $segment, $uri_segment){
			
			$config['reuse_query_string'] = TRUE;
			$config['base_url'] = base_url().$url;
			$config['total_rows'] = $jumlah_data;
			$config['per_page'] = $per_page;
			$config["uri_segment"] = $uri_segment;  // uri parameter
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = floor($choice);
			// Membuat Style pagination untuk BootStrap v4
			$config['first_link']       = 'First';
			$config['last_link']        = 'Last';
			$config['next_link']        = '>';
			$config['prev_link']        = '<';
			$config['full_tag_open']    = '<div class="pagging text-center"><ul class="custom-pagination-style-1 pagination pagination-rounded pagination-md justify-content-center">';
			$config['full_tag_close']   = '</ul></div>';
			$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
			$config['num_tag_close']    = '</span></li>';
			$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
			$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
			$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
			$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
			$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
			$config['prev_tagl_close']  = '</span>Next</li>';
			$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
			$config['first_tagl_close'] = '</span></li>';
			$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
			$config['last_tagl_close']  = '</span></li>';
			
			return $config;
	}
	
	function buildTree($parentId) {
		$branch = array();
		
		$this->CI->db->select('master_menu_frontend.*');
		$this->CI->db->where("master_menu_frontend.parent",$parentId);
		$this->CI->db->where('master_menu_frontend.active',1);
		$this->CI->db->order_by('master_menu_frontend.sort','ASC');
		$query = $this->CI->db->get('master_menu_frontend');
		$query = $query->result_array();
		if($query){
			foreach ($query as $elements) {
				if ($elements['parent'] == $parentId) {
					$children = $this->buildTree($elements['id']);
					if ($children) {
						$elements['children'] = $children;
					}else{
						$elements['children'] = null;
					}
					$branch[] = $elements;
				}
			}
		}
		


		return $branch;
	}
 
	
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
			return $hasil.' rupiah';
		}elseif($nilai==0) {
			$hasil = '';
			return '-';
		} else {
			$hasil = trim($this->penyebut($nilai));
			return $hasil.' rupiah';
		}     		
		
	}
	
	function replacetitikkoma($nilai) {
		$pos = strrpos($nilai, ".");
		if ($pos === false) { // note: three equal signs
			$nilai = number_format((float)$nilai, 0, '.', '');
		}else{
			$nilai = number_format((float)$nilai, 3, '.', '');
			$nilai = str_replace('.',',',$nilai);
		}
		
		return $nilai;
		
	}
	
	
	function weeks($month, $year){
			$firstday = date("w", mktime(0, 0, 0, $month, 1, $year)); 
			$lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); 
			$count_weeks = 1 + ceil(($lastday-7+$firstday)/7);
			return $count_weeks;
		}
		
		function weeks_in_month($date) {
			$custom_date = strtotime( date('Y-m-d', strtotime($date)) ); 
			$week_start = date('Y-m-d', strtotime('this week last sunday', $custom_date));
			$week_end = date('Y-m-d', strtotime('this week next monday', $custom_date));
			
			$month = date("m",strtotime($week_end));
		
			return array(
					'month' => $month,
					'week_start' => $week_start,
					'week_end' => $week_end,
			);
		}
		
		function getDatefrommonth($datenya, $bulan_nya, $minggu_ke){
			$date_array = array();
			$month = $bulan_nya;
			while($month == $bulan_nya){
				$dateawal = $datenya;
				$weeknya2 = $this->weeks_in_month($datenya);
				$datenya = $weeknya2['week_end'];
				$month = $weeknya2['month'];
				$datanya = array(
					'start' => $dateawal,
					'end' => $datenya,
				);
				array_push($date_array, $datanya);
			}
			
			if(count($date_array) > 0){
				if(isset($date_array[$minggu_ke])){
					return $date_array[$minggu_ke];
				}else{
					return null;
				}
			}else{
				return null;
			}
			
		}
		
		
		function proses_upload_dok(){
			$user_id = $this->CI->input->post('user_id');
			$file_name = $this->CI->input->post('file_name');
			
			try {
		
				$dir = './file/'.date('Y').'/'.date('m').'/'.date('d');
					
				if(!file_exists($dir)){
					mkdir($dir,0755,true);
				}

				$path = 'file/'.date('Y').'/'.date('m').'/'.date('d');
				$config['upload_path']   = $dir;
				if($file_name != '' && $file_name != null){
					$namereplace = $_FILES["userfile"]['name'];
					$dname 	= 	explode(".", $namereplace);
					$ext 	= 	end($dname);
					//$namereplace = str_replace('.'.$ext, '', $namereplace);
					$namereplace = $this->_clean_special($file_name);
				}else{
					$namereplace = $_FILES["userfile"]['name'];
					$dname 	= 	explode(".", $namereplace);
					$ext 	= 	end($dname);
					$namereplace = str_replace('.'.$ext, '', $namereplace);
					$namereplace = $this->_clean_special($namereplace);
				}
				$config['file_name'] = $namereplace.'.'.$ext;
				$config['allowed_types'] = 'application/pdf|pdf|xls|xlsx|dwg|dxf|dwf|application/octet-stream|png|jpg|jpeg|gif|zip|rar';
				$this->CI->load->library('upload',$config);
				$size = 1;
				if($this->CI->upload->do_upload('userfile')){
					$token	=	$this->CI->input->post('token_foto');
					$nama	=	$this->CI->upload->data('file_name');
					$size	=	$this->CI->upload->data('file_size');
					
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
							
					$insert = $this->CI->db->insert('data_gallery',$data);
					$insertid = $this->CI->db->insert_id();
					
					if($insert){
						$result = array(
							"message" => "success",
							'id' => $insertid,
							'name' => $nama, 	
							'path' => base_url().$path .'/'.$nama, 							
							"extention" => strtolower($ext)
						);
						return json_encode($result);
					}else{
						$data['status'] = 'error';	
						$data['errors'] = 'Data not insert storage';
						$result = array("message" => "error", "m" => $data['errors']);
						return json_encode($result);
					}
					
						
				}else{
					$result = array("message" => "error", "m" => $this->CI->upload->display_errors());
					return json_encode($result);
				}
			}
			catch (Error $e) {
				$result = array("message" => "error",'id' => null);
				return json_encode($result);
			}
			catch (Exception $e) {
				$result = array("message" => "error",'id' => null);
				return json_encode($result);
			}
		}
		
		
		function proses_upload($files,$namapost,$module, $user_id, $token){
			
			$this->access_check($module);
			$dir = './file/'.date('Y').'/'.date('m').'/'.date('d');
			
			if(!file_exists($dir)){
			  mkdir($dir,0755,true);
			}

			$path = 'file/'.date('Y').'/'.date('m').'/'.date('d');
			$config['upload_path']   = $dir;
			$config['allowed_types'] = 'application/pdf|pdf|xls|xlsx|dwg|dxf|dwf|application/octet-stream|png|jpg|jpeg|gif|zip|rar';
			
			$name = $files;
			$dname 	= explode(".", $name);
			$ext 	= end($dname);
			$name = str_replace(".".$ext,'',$name);
			$name = $this->_clean_special($name).".".$ext;
			$config['file_name'] = strtolower($name);
			
			$this->CI->load->library('upload',$config);
			$size = 1;
			if($this->CI->upload->do_upload($namapost)){
				$token	=	$token;
				$nama	=	$this->CI->upload->data('file_name');
				$size	=	$this->CI->upload->data('file_size');
				$ext 	= 	$ext;
				
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
					
				$this->CI->db->insert('data_gallery',$data);
				$insertid = $this->CI->db->insert_id();
				
				$result = array("message" => "success",
								'id' => $insertid, 
								'path' => base_url().$dir .'/'.$nama, 
								'format' => $ext 
						);
				return json_encode($result);
				
			}else{
				$result = array("message" => "errors",'id' => 0);
				return json_encode($result);
			}

		}
		
		function select2custom($id,$name,$q,$table,$reference){
			
			if($table == 'master_kbli'){
				$selectnya = $id.' as id,'.$name.' as name, code as code';
			}elseif($table == 'data_perusahaan_register'){
				$selectnya = 'id as id, perusahaan_nama as name';
			}else{
				$selectnya = $id.' as id,'.$name.' as name';
			}
			
			$this->CI->db->select($selectnya);
			$this->CI->db->like($name, $q);
			
			
			if($table == 'master_kbli'){
				
				$this->CI->db->or_like('code', $q);
				
			}elseif($table == 'master_unit'){
				
				if($reference == 'SBU'){
					$this->CI->db->where('is_sbu',1);
					$this->CI->db->where('active',1);
				}else{
					$this->CI->db->where('active',1);
				}
				
				
			}elseif($table == 'master_status_pks'){
				
				if($reference == 'Progress PKS'){
					$this->CI->db->where_not_in('id',array(99,100));
					$this->CI->db->where('active',1);
				}else{
					$this->CI->db->where('active',1);
				}
				
				
			}elseif($table == 'master_area_provinsi'){
				
				$area_provinsi_id = $this->CI->session->userdata('area_provinsi_id');
				
				if($area_provinsi_id != '' && $area_provinsi_id != 0){
					$this->CI->db->where('id',$area_provinsi_id);
				}else{
					
				}
				$this->CI->db->where('active',1);
				$this->CI->db->order_by($name,'ASC');
				
			}elseif($table == 'data_perusahaan_register'){
				
				$table == 'vw_data_perusahaan';

				$this->CI->db->where('status_id',7);
				$this->CI->db->order_by($name,'ASC');
				
			}elseif($table == 'master_top_kondisi'){
				
				$area_provinsi_id = $this->CI->session->userdata('area_provinsi_id');
				
				if($reference == 1){
					$this->CI->db->where_in('id',array(1,2,3));
				}else{
					$this->CI->db->where_in('id',array(2));
				}
				$this->CI->db->where('active',1);
				$this->CI->db->order_by($name,'ASC');
				
			}elseif($table == 'master_area_kota'){
				
				if($reference != null && $reference != ''){
					$this->CI->db->where('area_provinsi_id',$reference);
				}
				
				
				$area_kota_id = $this->CI->session->userdata('area_kota_id');
				
				if($area_kota_id != '' && $area_kota_id != 0){
					$this->CI->db->where('id',$area_kota_id);
				}else{
					
				}
				$this->CI->db->where('active',1);
				$this->CI->db->order_by($name,'ASC');
			}elseif($table == 'master_area_kecamatan'){
				$this->CI->db->where('area_kota_id',$reference);
				$this->CI->db->where('active',1);
				$this->CI->db->order_by($name,'ASC');
			}elseif($table == 'master_area_desa'){
				$this->CI->db->where('area_kecamatan_id',$reference);
				$this->CI->db->where('active',1);
				$this->CI->db->order_by($name,'ASC');
			}elseif($table == 'users_data'  && $reference != ''){
				$this->CI->db->where('gid',$reference);
				$this->CI->db->where('active',1);
				$this->CI->db->order_by($name,'ASC');
			}elseif($table == 'users_data'  && $reference == ''){
				//$this->CI->db->where('gid',$reference);
				$this->CI->db->where('active',1);
				$this->CI->db->order_by($name,'ASC');
			}else{
				$this->CI->db->where('active',1);
				$data = array('items' => array());
			}
			
			$this->CI->db->limit(5);
			$query = $this->CI->db->get($table);
			$query = $query->result_array();
			if($query){
				$i=0;
				foreach ($query as $rows){
					$data[$i]['id'] = $rows['id'];
					
					if($table == 'master_kbli'){
						$data[$i]['name']= $rows['code']." | ".$rows['name'];
					}else{
						$data[$i]['name']= $rows['name'];
					}
					
					$i++;
				}
				$data = array('items' => $data);
			}else{
				$data = array('items' => array());
			}
			
			return json_encode($data);

			
		}
		
		function date_formatnya($date,$format){
			if($format == null){
				$format = "d F Y";
			}
			$date= date_create($date);
			return date_format($date,$format);
		}
		
		function setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id ,$is_wa){
			
			if($from_id && $to_id && $subject && $message){
				$data = array(
					'from_id'		=> $from_id,
					'to_id'			=> $to_id,
					'category_id'	=> $category_id,
					'subject'		=> $subject,
					'message'		=> $message,
					'data_id'		=> $data_id,
					//'note'			=> $note,
					'is_read'		=> 0,
					'is_email'		=> 1,
					'createdid'		=> $from_id,
					'created'		=> date('Y-m-d H:i:s'),
					'modifiedid'	=> $from_id,
					'modified'		=> date('Y-m-d H:i:s'),
				);
						
				$insert = $this->CI->db->insert('data_inbox',$data);
				$insertid = $this->CI->db->insert_id();	
				
				if($insert){
					$inbox_id = $insertid;
					//$pengirim = $this->select2_getname($from_id,'users_data','id','notelp');
					//$penerima = $this->select2_getname($to_id,'users_data','id','notelp');
					//$desc_project = $this->select2_getname($no_io,'vw_data_project','project_io','desc_project');
					//$comment = $subject;
					///$this->setWA($inbox_id, $pengirim, $penerima, $no_io, $no_kontrak, $no_bast, //$desc_project, $comment);
					$slug = $from_id.$to_id.'-'.date('YmdHis').rand(1000,9999).'-inbox';
					$data = array(
						'slug'			=> $slug,
						'modifiedid'	=> $from_id,
						'modified'		=> date('Y-m-d H:i:s')
					);
					
					$this->CI->db->where('data_inbox.id',$insertid);					
					$insert = $this->CI->db->update('data_inbox',$data);
					
					if($category_id == 97){
						$this->sendMessage($subject, 'Input Data', $to_id);
					}
				
				}
				
				return $insertid;
			}
			
			return null;
		}
		
		function setWA($inbox_id, $pengirim, $penerima, $no_io, $no_kontrak, $no_bast, $desc_project, $comment){
			
			if($penerima != ''){
			
				$params = array(
					'pengirim'		=>	$pengirim,
					'penerima'		=>	$penerima,
					'no_io'			=>	$no_io,
					'no_kontrak'	=>	$no_kontrak,
					'no_bast'		=>	$no_bast,
					'desc_project'	=>	$desc_project,
					'comment'		=>	$comment
				);
				
				$token = $this->CI->m_api_history->getToken($this->link_pins);
				
				$data = $this->CI->curl->simple_post($this->link_pins.'crm/project/notif',$params,array(
							CURLOPT_HTTPHEADER => array('Authorization:Bearer '.$token.''),
							CURLOPT_TIMEOUT => 50000,
							CURLOPT_SSL_VERIFYPEER => false
					)
				);
					
				$info = $this->CI->curl->info;
				$rowcode = $info['http_code'];
				
				//print_r($params);
				//print_r($info);
				//die();
				if($data){
					$data = json_decode($data);
					$rowdata = (array)$data;
				
					$rowcode = $rowcode;
					if(count($rowdata) > 0){
						//print_r($rowdata);
						//die();
						if($rowdata['status'] == 'Success'){
							$data = array(
								'is_wa'			=> 1,
								'modified'		=> date('Y-m-d H:i:s'),
							);
							
							$this->CI->db->where('data_inbox.id',$inbox_id);
							$insert = $this->CI->db->update('data_inbox',$data);
						}
						
					}
				}
			}
		}
		
		
		function getAksesEditNaming(){
			
			$CI =& get_instance();

			$user_id = $CI->session->userdata('userid');
			$gid = $this->select2_getname($user_id,'users_data','id','gid');
				 
			if($gid == 1 || $gid == 2){
				return true;
			}
			
			return false;
		}
		
	public function getviewlistcontrol($table, $module, $exclude){
			$this->CI->db->select('translate_view.*');
			$this->CI->db->where('translate_view.table',$table);
			$this->CI->db->where('translate_view.module',$module);
			$this->CI->db->where('translate_view.active',1);
			$this->CI->db->order_by('translate_view.modified','DESC');
			$this->CI->db->limit(1);
			$queryexclude = $this->CI->db->get('translate_view');
			$queryexclude = $queryexclude->result_object();
			if($queryexclude){
				if($queryexclude[0]->data != 'null' && $queryexclude[0]->data != '' && $queryexclude[0]->data != null){
					$exclude = json_decode($queryexclude[0]->data);
					if($queryexclude[0]->data_order != null && $queryexclude[0]->data_order != ''){
						$query_column = $this->query_column_filter($table, $exclude, $queryexclude[0]->data_order);
					}else{
						$query_column = $this->query_column_filter($table, $exclude, null);
					}
					
				}else{
					if ($this->str_conten($table, 'vw_')) { 
						if($queryexclude[0]->data_order != null && $queryexclude[0]->data_order != ''){
							$query_column = $this->query_column_nosort($table, $exclude, $queryexclude[0]->data_order);
						}else{
							$query_column = $this->query_column_nosort($table, $exclude, null);
						}
						
					}else{
						if($queryexclude[0]->data_order != null && $queryexclude[0]->data_order != ''){
							$query_column = $this->query_column($table, $exclude, $queryexclude[0]->data_order);
						}else{
							$query_column = $this->query_column($table, $exclude, null);
						}
						
					}
					
				}
			}else{
				if ($this->str_conten($table, 'vw_')) { 
					$query_column = $this->query_column_nosort($table, $exclude, null);
				}else{
					$query_column = $this->query_column($table, $exclude, null);
				}
					
			}
			
			return $query_column;
	}
	
	public function getTipeData($tabel,$table_id){
		$this->CI->db->select('translate.*');
		$this->CI->db->where('translate.meta_id',$table_id);
		$this->CI->db->where('translate.meta_table',$tabel);
		$this->CI->db->where('translate.active',1);
		$queryexclude = $this->CI->db->get('translate');
		$queryexclude = $queryexclude->result_object();
		if($queryexclude){
			return $queryexclude[0]->meta_tipe;
		}
		
		return null;
	}
	
	public function getFormatData($tabel,$table_id, $value){
		$text = $value;
		$this->CI->db->select('translate.*');
		$this->CI->db->where('translate.meta_id',$table_id);
		$this->CI->db->where('translate.meta_table',$tabel);
		$this->CI->db->where('translate.active',1);
		$queryexclude = $this->CI->db->get('translate');
		$queryexclude = $queryexclude->result_object();
		if($queryexclude){
			if($queryexclude[0]->meta_tipe == 'DATE'){
				$datenya = $this->validateDate($value, $format = 'Y-m-d H:i:s');
				if($datenya){
					$text = $this->format_date($value);
				}else{
					$datenya = $this->validateDate($value, $format = 'Y-m-d');
					if($datenya){
						$text = $this->format_date($value);
					}
				}
			}elseif($queryexclude[0]->meta_tipe == 'DATETIME'){
				$datenya = $this->validateDate($value, $format = 'Y-m-d H:i:s');
				if($datenya){
					$text = $this->format_datetime($value);
				}
			}elseif($queryexclude[0]->meta_tipe == 'CURRENCY'){
				$datenya = $this->validateAngka($value);
				if($datenya){
					$text = $this->rupiahnonkoma($value);
				}
			}elseif($queryexclude[0]->meta_tipe == 'FILE'){
				$variable = $value;
				if($variable != '' && $variable != null && $variable != '-'){
					$file = $this->getcoverdata($variable);
					if($file['message'] == 'success'){
						$text = '<a class="btn btn-sm btn-primary" target="_balnk" href="'.$file['data'][0]['path'].'"><i class="fa fa-download"></i> Download</a>';
					}else{
						$text = '-';
					}
				}
			}
		}
		
		return $text;
	}
	
	function getcoverdata($id){
			$fieldnya = array();
			//$perusahaan_id =$this->input->post('id');
			//$id =$this->input->post('id');
			//$tableid =$this->input->post('tableid');
			
			$this->CI->db->select('data_gallery.*');
			$this->CI->db->where('data_gallery.id',$id);
			$querystatus = $this->CI->db->get('data_gallery');
			$querystatus = $querystatus->result_object();
			//print_r($this->CI->db->last_query());
			if($querystatus){
				foreach ($querystatus as $rows) {
					$datanya = array(
						'id' => $rows->id,
						'name' => $rows->name, 	
						'path' => $rows->url_server.$rows->path,
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
	
	public function getRefData($tabel,$table_id){
		$this->CI->db->select('translate.*');
		$this->CI->db->where('translate.meta_id',$table_id);
		$this->CI->db->where('translate.meta_table',$tabel);
		$this->CI->db->where('translate.active',1);
		$queryexclude = $this->CI->db->get('translate');
		$queryexclude = $queryexclude->result_object();
		if($queryexclude){
			if($queryexclude[0]->meta_tipe == 'SELECT'){
				if($queryexclude[0]->meta_table_ref != null && $queryexclude[0]->meta_table_id_ref != null && $queryexclude[0]->meta_table_name_ref != null && $queryexclude[0]->meta_table_ref != '' && $queryexclude[0]->meta_table_id_ref != '' && $queryexclude[0]->meta_table_name_ref != ''){
					$tabel_ref = $queryexclude[0]->meta_table_ref;
					$table_id = $queryexclude[0]->meta_table_id_ref;
					$table_name = $queryexclude[0]->meta_table_name_ref;
					return array($tabel_ref,$table_id,$table_name);
				}
			}
		}
		
		return null;
	}
	
	public function getRefDataWidth($tabel,$table_id){
		$this->CI->db->select('translate.*');
		$this->CI->db->where('translate.meta_id',$table_id);
		$this->CI->db->where('translate.meta_table',$tabel);
		$this->CI->db->where('translate.active',1);
		$queryexclude = $this->CI->db->get('translate');
		$queryexclude = $queryexclude->result_object();
		if($queryexclude){
			if($queryexclude[0]->meta_size != '' && $queryexclude[0]->meta_size != null){
				return $queryexclude[0]->meta_size;
			}
		}
		
		return null;
	}
	
	function validateAngka($value){
		if(preg_match('/^\d+$/',$value ?? '')) {
			return true;
		} 
		
		return false;
	}
	
	function validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date ?? '');
		// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
		return $d && $d->format($format) === $date;
	}
	
	public function getviewlistcheck($tablenya, $exclude,$module){
		
		$modulview = "'".$module."'";
		$tabelview = "'".$tablenya."'";
												
		$li ='<div style="background: #dbdfe9;" class="menu-item px-3"><div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Daftar Kolom</div></div>';
		
		$ordernya = null;
		$this->CI->db->select('translate_view.*');
		$this->CI->db->where('translate_view.table',$tablenya);
		$this->CI->db->where('translate_view.module',$module);
		$this->CI->db->where('translate_view.active',1);
		$this->CI->db->order_by('translate_view.modified','DESC');
		$this->CI->db->limit(1);
		$queryexclude = $this->CI->db->get('translate_view');
		$queryexclude = $queryexclude->result_object();
		if($queryexclude){
			if($queryexclude[0]->data_order != null && $queryexclude[0]->data_order != ''){
				$ordernya = $queryexclude[0]->data_order;
			}
		}
			
		if ($this->str_conten($tablenya, 'vw_')) { 
			//$query_column = $this->getviewlistcontrol($tablenya, $module, $exclude);
			$exclude = array();
			$query_column = $this->query_column($tablenya, $exclude, $ordernya);
		}else{
			//$query_column = $this->getviewlistcontrol($tablenya, $module, $exclude);
			$exclude = array();
			$query_column = $this->query_column($tablenya, $exclude, $ordernya);
		}
				
	
												if($query_column){
													$x=1;
													foreach($query_column as $rows_column){
														$label_name = $this->translate_column($tablenya,$rows_column['name']);
														if($rows_column['name']){
															if($this->checkarrayview($tabelview, $modulview,$rows_column['name']) == true){
																$li = $li.'<div class="menu-item px-3"><div class="menu-content fs-6 text-dark fw-bold px-3 py-4"><input type="checkbox" name="checkbox_table[]" value="'.$rows_column['name'].'" checked="checked"> '.$label_name.'</div></div>';
															}else{
																$li = $li.'<div class="menu-item px-3"><div class="menu-content fs-6 text-dark fw-bold px-3 py-4"><input type="checkbox" name="checkbox_table[]" value="'.$rows_column['name'].'"> '.$label_name.'</div></div>';
															}
															
														}
														$x++;
													}
													
												}
												
		$li = $li.'<div class="menu-item px-3"><button onClick="savingTableView('.$modulview.','.$tabelview.')" type="button" class="btn btn-primary btn-view-list">Terapkan</button><button onClick="closeMenu()" type="button" class="btn btn-danger btn-view-list">Keluar</div>';
												
		return $li;
	}

	public function checkarrayview($tablenya, $module, $data_id){
		
		$tablenya = str_replace("'",'',$tablenya);
		$module = str_replace("'",'',$module);
		
		$this->CI->db->select('translate_view.*');
		$this->CI->db->where('translate_view.table',$tablenya);
		$this->CI->db->where('translate_view.module',$module);
		$this->CI->db->where('translate_view.active',1);
		$this->CI->db->order_by('translate_view.modified','DESC');
		$this->CI->db->limit(1);
		$queryexclude = $this->CI->db->get('translate_view');
		$queryexclude = $queryexclude->result_object();
		if($queryexclude){
			if($queryexclude[0]->data != 'null' && $queryexclude[0]->data != '' && $queryexclude[0]->data != null){
				$exclude = json_decode($queryexclude[0]->data, true);
				if (in_array($data_id, $exclude)){
					return true;
				}
			}	
		}

		return false;
	}	
	
	function commentNumber($data_id, $field_id, $type_id){
		$CI =& get_instance();
		$CI->db->select('count(data_perusahaan_detail_comment.id) as total');
		$CI->db->where('data_perusahaan_detail_comment.field_id', $field_id);
		$CI->db->where('data_perusahaan_detail_comment.detail_id', $data_id);
		$CI->db->where('data_perusahaan_detail_comment.type_id', $type_id);
		$CI->db->where('data_perusahaan_detail_comment.status_id', 1);
		$query = $CI->db->get('data_perusahaan_detail_comment');
		$query = $query->result_object();
		if($query){
			return $query[0]->total;
		}else{
			return 0;
		}
	}
	
	function getQuery($id){
		$CI =& get_instance();
		$CI->db->select('vw_query.query');
		$CI->db->where('vw_query.id', $id);
		$query = $CI->db->get('vw_query');
		$query = $query->result_object();
		if($query){
			return $query[0]->query;
		}else{
			return null;
		}
	}
	
	function selectQuery($id){
		
		$select = $this->getQuery($id);
		
		if($select != null){
			$CI =& get_instance();
			$query = $CI->db->query($select);
			$query = $query->result_object();
			if($query){
				return $query;
			}else{
				return $CI->db->error();
			}
		}
		
	}
	
	function getdatabyname($name,$table){
		$user_id = $this->CI->session->userdata('userid');
		
		$this->CI->db->where('lower(name)',strtolower($name));
		$query = $this->CI->db->get($table);
		$query = $query->result_object();
		if(!$query){
			$datarow = array(  
				'name'				=> $name,
				'description'		=> $name,
				'active'			=> 1,
				'createdid'			=> $user_id,
				'created'			=> date('Y-m-d H:i:s'),
				'modifiedid'		=> $user_id,
				'modified'			=> date('Y-m-d H:i:s'),
			);
								
			$insert = $this->CI->db->insert($table, $datarow);
			$insert_id = $this->CI->db->insert_id();
			if($insert){
				return $insert_id;
			}
		}else{
			return $query[0]->id;
		}
			
		return 0;
	}
	
	function format_date($date){
		$date=date_create($date ?? '');
		return date_format($date,"d M, Y");
	}
	
	function format_hanyadate($date){
		$date=date_create($date ?? '');
		return date_format($date,"Y-m-d");
	}
	
	function format_datetime($datetime){
		$datetime=date_create($datetime ?? '');
		return date_format($datetime,"d M, Y H:i:s");
	}

	function str_conten($haystack, $needle){
		if (!function_exists('str_contains')) {
			/**
			 * Check if substring is contained in string
			 *
			 * @param $haystack
			 * @param $needle
			 *
			 * @return bool
			 */
			return strpos($haystack ?? '', $needle ?? '');
		}else{
			return str_contains($haystack ?? '', $needle ?? '');
		}
	}
	
	public function sendEmail($email, $fullname, $subject, $message, $attachment){
		error_reporting(0);
		try {
			 $config = [
				'mailtype'  => 'html',
				'charset'   => 'utf-8',
				'protocol'  => 'smtp',
				'smtp_host' => 'smtp.hostinger.com',
				'smtp_user' => 'no-reply@nktdev.online',  // Email gmail
				'smtp_pass'   => 'ASKmppkbppp#123',  // Password gmail
				'smtp_crypto' => 'ssl',
				'starttls' => TRUE,
				'smtp_port'   => 465,
				'crlf'    => "\r\n",
				'newline' => "\r\n"
			];

			// Load library email dan konfigurasinya
			$this->CI->load->library('email', $config);

			// Email dan nama pengirim
			$this->CI->email->from('no-reply@nktdev.online', 'no-reply');

			// Email penerima
			$this->CI->email->to($email); // Ganti dengan email tujuan

			// Lampiran email, isi dengan url/path file
			//$this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

			// Subject email
			$this->CI->email->subject($subject);

			// Isi email
			$this->CI->email->message($message);

			if($attachment != null && $attachment != ''){
				$attched_file= base_url().$attachment;
				$this->CI->email->attach($attched_file);
			}
			

			//$this->email->print_debugger();
			
			// Tampilkan pesan sukses atau error
			if ($this->CI->email->send()) {
				$this->CI->email->clear(TRUE);
				return true;
			} else {
				//$this->CI->email->clear(TRUE);
				//return 0;
				return $this->CI->email->print_debugger();
			}
			
		}catch(Exception $e) {
			return false;
		}
		
		
	}
	
	function unformatrp($nilai){
		
		if($nilai == null){
			return null;
		}
		
		$this->CI->db->where('active',1);
		$query = $this->CI->db->get('master_currency');
		$query = $query->result_object();
		if($query){
			foreach($query as $rows){
				$nilai = str_replace($rows->code.'. ','',$nilai);
			}
		}
		
		$nilai = str_replace('.','',$nilai);
		$nilai = str_replace(',','.',$nilai);
		
		return $nilai;
	}
	
	public function convertimgtobase64($path){
			$path=$path;
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			$base64=base64_encode($data);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			return $base64;
			//echo '<img src="'.$base64.'" />';
	}
	
		
	function converting_generate($text, $data, $tipe_id){
			
			if($tipe_id == 1){
				
				$perusahaan_alamat = $this->select2_getname($data['nama_mitra'],'data_perusahaan_register','perusahaan_nama','perusahaan_alamat');
				
				$data['alamat_mitra'] = $perusahaan_alamat;
				
				$converstring = str_replace('[[nomor_spph]]',$data['nomor_spph'],$text);
				$converstring = str_replace('[[tanggal_spph]]',$data['tanggal_spph'],$converstring);
				$converstring = str_replace('[[nama_mitra]]',$data['nama_mitra'],$converstring);
				$converstring = str_replace('[[alamat_mitra]]',$data['alamat_mitra'],$converstring);
				$converstring = str_replace('[[nama_pekerjaan]]',$data['nama_pekerjaan'],$converstring);
				$converstring = str_replace('[[mekanisme_pembayaran]]',$data['mekanisme_pembayaran'],$converstring);
				$converstring = str_replace('[[nama_pic_drafter]]',$data['nama_pic_drafter'],$converstring);
				$converstring = str_replace('[[email_pic_drafter]]',$data['email_pic_drafter'],$converstring);
				$converstring = str_replace('[[hari_submit]]',$data['hari_submit'],$converstring);
				$converstring = str_replace('[[tanggal_submit]]',$data['tanggal_submit'],$converstring);
				$converstring = str_replace('[[jam_submit]]',$data['jam_submit'],$converstring);
				$converstring = str_replace('[[jangka_waktu]]',$data['jangka_waktu'],$converstring);
				$converstring = str_replace('[[nama_vp]]',$data['nama_vp'],$converstring);
				$converstring = str_replace('[[jabatan_vp]]',$data['jabatan_vp'],$converstring);
			}elseif($tipe_id == 2){
				$converstring = str_replace('[[nomor_spph]]',$data['nomor_spph'],$text);
				$converstring = str_replace('[[tanggal_spph]]',$data['tanggal_spph'],$converstring);
				$converstring = str_replace('[[nama_mitra]]',$data['nama_mitra'],$converstring);
				$converstring = str_replace('[[alamat_mitra]]',$data['alamat_mitra'],$converstring);
				$converstring = str_replace('[[nama_pekerjaan]]',$data['nama_pekerjaan'],$converstring);
				$converstring = str_replace('[[sph_nomor]]',$data['sph_nomor'],$converstring);
				$converstring = str_replace('[[sph_tanggal]]',$data['sph_tanggal'],$converstring);
				$converstring = str_replace('[[sph_nilai]]',$data['sph_nilai'],$converstring);
			}elseif($tipe_id == 3){
				$converstring = str_replace('[[nomor_spph]]',$data['nomor_spph'],$text);
				$converstring = str_replace('[[tanggal_spph]]',$data['tanggal_spph'],$converstring);
				$converstring = str_replace('[[nama_mitra]]',$data['nama_mitra'],$converstring);
				$converstring = str_replace('[[alamat_mitra]]',$data['alamat_mitra'],$converstring);
				$converstring = str_replace('[[nama_pekerjaan]]',$data['nama_pekerjaan'],$converstring);
				$converstring = str_replace('[[mekanisme_pembayaran]]',$data['mekanisme_pembayaran'],$converstring);
				$converstring = str_replace('[[nama_pic_drafter]]',$data['nama_pic_drafter'],$converstring);
				$converstring = str_replace('[[email_pic_drafter]]',$data['email_pic_drafter'],$converstring);
				$converstring = str_replace('[[hari_submit]]',$data['hari_submit'],$converstring);
				$converstring = str_replace('[[tanggal_submit]]',$data['tanggal_submit'],$converstring);
				$converstring = str_replace('[[jam_submit]]',$data['jam_submit'],$converstring);
				$converstring = str_replace('[[bulan_submit]]',$data['bulan_submit'],$converstring);
				$converstring = str_replace('[[tahun_submit]]',$data['tahun_submit'],$converstring);
				$converstring = str_replace('[[target_pengadaan]]',$data['target_pengadaan'],$converstring);
				$converstring = str_replace('[[pekerjaan_mulai]]',$data['pekerjaan_mulai'],$converstring);
				$converstring = str_replace('[[pekerjaan_selesai]]',$data['pekerjaan_selesai'],$converstring);
				$converstring = str_replace('[[lokasi_pekerjaan]]',$data['lokasi'],$converstring);
				$converstring = str_replace('[[ruang_lingkup]]',$data['ruang_lingkup'],$converstring);
				$converstring = str_replace('[[nama_vp]]',$data['nama_vp'],$converstring);
				$converstring = str_replace('[[jabatan_vp]]',$data['jabatan_vp'],$converstring);
				$converstring = str_replace('[[sph_nomor]]',$data['sph_nomor'],$converstring);
				$converstring = str_replace('[[sph_tanggal]]',$data['sph_tanggal'],$converstring);
				$converstring = str_replace('[[sph_nilai]]',$data['sph_nilai'],$converstring);
				$converstring = str_replace('[[nilai_kesepakatan]]',$data['nilai_kesepakatan'],$converstring);
				$converstring = str_replace('[[syarat_penagihan]]',$data['syarat_penagihan'],$converstring);
				$converstring = str_replace('[[dok_akhir]]',$data['dok_akhir'],$converstring);
			}elseif($tipe_id == 4 || $tipe_id == 5 || $tipe_id == 6){
				$converstring = str_replace('[[nama_mitra]]',$data['nama_mitra'],$text);
				$converstring = str_replace('[[alamat_mitra]]',$data['alamat_mitra'],$converstring);
				$converstring = str_replace('[[nama_pekerjaan]]',$data['nama_pekerjaan'],$converstring);
				$converstring = str_replace('[[bakn_tanggal]]',$data['bakn_tanggal'],$converstring);
				$converstring = str_replace('[[direktur_mitra]]',$data['direktur_mitra'],$converstring);
				$converstring = str_replace('[[jabatan_direktur_mitra]]',$data['jabatan_direktur_mitra'],$converstring);
				$converstring = str_replace('[[npwp]]',$data['npwp'],$converstring);
				$converstring = str_replace('[[nilai_kesepakatan]]',$data['nilai_kesepakatan'],$converstring);
			}elseif($tipe_id == 7){
				$converstring = str_replace('[[nomor_spph]]',$data['nomor_spph'],$text);
				$converstring = str_replace('[[tanggal_spph]]',$data['tanggal_spph'],$converstring);
				$converstring = str_replace('[[nama_mitra]]',$data['nama_mitra'],$converstring);
				$converstring = str_replace('[[alamat_mitra]]',$data['alamat_mitra'],$converstring);
				$converstring = str_replace('[[nama_pekerjaan]]',$data['nama_pekerjaan'],$converstring);
				$converstring = str_replace('[[mekanisme_pembayaran]]',$data['mekanisme_pembayaran'],$converstring);
				$converstring = str_replace('[[nama_pic_drafter]]',$data['nama_pic_drafter'],$converstring);
				$converstring = str_replace('[[email_pic_drafter]]',$data['email_pic_drafter'],$converstring);
				$converstring = str_replace('[[hari_submit]]',$data['hari_submit'],$converstring);
				$converstring = str_replace('[[tanggal_submit]]',$data['tanggal_submit'],$converstring);
				$converstring = str_replace('[[jam_submit]]',$data['jam_submit'],$converstring);
				$converstring = str_replace('[[bulan_submit]]',$data['bulan_submit'],$converstring);
				$converstring = str_replace('[[tahun_submit]]',$data['tahun_submit'],$converstring);
				$converstring = str_replace('[[target_pengadaan]]',$data['target_pengadaan'],$converstring);
				$converstring = str_replace('[[pekerjaan_mulai]]',$data['pekerjaan_mulai'],$converstring);
				$converstring = str_replace('[[pekerjaan_selesai]]',$data['pekerjaan_selesai'],$converstring);
				$converstring = str_replace('[[lokasi_pekerjaan]]',$data['lokasi'],$converstring);
				$converstring = str_replace('[[ruang_lingkup]]',$data['ruang_lingkup'],$converstring);
				$converstring = str_replace('[[nama_vp]]',$data['nama_vp'],$converstring);
				$converstring = str_replace('[[jabatan_vp]]',$data['jabatan_vp'],$converstring);
				$converstring = str_replace('[[sph_nomor]]',$data['sph_nomor'],$converstring);
				$converstring = str_replace('[[sph_tanggal]]',$data['sph_tanggal'],$converstring);
				$converstring = str_replace('[[sph_nilai]]',$data['sph_nilai'],$converstring);
				$converstring = str_replace('[[nilai_kesepakatan]]',$data['nilai_kesepakatan'],$converstring);
				$converstring = str_replace('[[nomorrekening]]',$data['nomorrekening'],$converstring);
				$converstring = str_replace('[[namarekening]]',$data['namarekening'],$converstring);
				$converstring = str_replace('[[bankrekening]]',$data['bankrekening'],$converstring);
				$converstring = str_replace('[[spk_nomor]]',$data['spk_nomor'],$converstring);
				$converstring = str_replace('[[spk_tanggal]]',$data['spk_tanggal'],$converstring);
				$converstring = str_replace('[[bakn_tanggal]]',$data['bakn_tanggal'],$converstring);
				$converstring = str_replace('[[syarat_penagihan]]',$data['syarat_penagihan'],$converstring);
				$converstring = str_replace('[[dok_akhir]]',$data['dok_akhir'],$converstring);
			}elseif($tipe_id == 8){
				
				
				
				$converstring = str_replace('[[nama_mitra]]',$data['nama_mitra'],$text);
				$converstring = str_replace('[[alamat_mitra]]',$data['alamat_mitra'],$converstring);
				$converstring = str_replace('[[nama_pekerjaan]]',$data['nama_pekerjaan'],$converstring);
				
				$converstring = str_replace('[[nama_pic_drafter]]',$data['nama_pic_drafter'],$converstring);
				$converstring = str_replace('[[email_pic_drafter]]',$data['email_pic_drafter'],$converstring);
				$converstring = str_replace('[[hari_submit]]',$data['hari_submit'],$converstring);
				$converstring = str_replace('[[tanggal_submit]]',$data['tanggal_submit'],$converstring);
				$converstring = str_replace('[[jam_submit]]',$data['jam_submit'],$converstring);
				$converstring = str_replace('[[bulan_submit]]',$data['bulan_submit'],$converstring);
				$converstring = str_replace('[[tahun_submit]]',$data['tahun_submit'],$converstring);
				
				$converstring = str_replace('[[nama_vp]]',$data['nama_vp'],$converstring);
				$converstring = str_replace('[[jabatan_vp]]',$data['jabatan_vp'],$converstring);
				$converstring = str_replace('[[dok_akhir]]',$data['dok_akhir'],$converstring);
				$converstring = str_replace('[[dok_akhir_nomor]]',$data['dok_akhir_nomor'],$converstring);
				$converstring = str_replace('[[dok_akhir_tanggal]]',$data['dok_akhir_tanggal'],$converstring);
				$converstring = str_replace('[[nilai_pekerjaan]]',$data['nilai_pekerjaan'],$converstring);
				$converstring = str_replace('[[nilai_progres]]',$data['nilai_progres'],$converstring);
				$converstring = str_replace('[[baut_tanggal]]',$data['baut_tanggal'],$converstring);
				
				
			}elseif($tipe_id == 9 || $tipe_id == 10){
				
				
				
				$converstring = str_replace('[[nama_mitra]]',$data['nama_mitra'],$text);
				$converstring = str_replace('[[alamat_mitra]]',$data['alamat_mitra'],$converstring);
				$converstring = str_replace('[[nama_pekerjaan]]',$data['nama_pekerjaan'],$converstring);
				
				$converstring = str_replace('[[nama_pic_drafter]]',$data['nama_pic_drafter'],$converstring);
				$converstring = str_replace('[[email_pic_drafter]]',$data['email_pic_drafter'],$converstring);
				$converstring = str_replace('[[hari_submit]]',$data['hari_submit'],$converstring);
				$converstring = str_replace('[[tanggal_submit]]',$data['tanggal_submit'],$converstring);
				$converstring = str_replace('[[jam_submit]]',$data['jam_submit'],$converstring);
				$converstring = str_replace('[[bulan_submit]]',$data['bulan_submit'],$converstring);
				$converstring = str_replace('[[tahun_submit]]',$data['tahun_submit'],$converstring);
				
				$converstring = str_replace('[[nama_vp]]',$data['nama_vp'],$converstring);
				$converstring = str_replace('[[jabatan_vp]]',$data['jabatan_vp'],$converstring);
				$converstring = str_replace('[[dok_akhir]]',$data['dok_akhir'],$converstring);
				$converstring = str_replace('[[dok_akhir_nomor]]',$data['dok_akhir_nomor'],$converstring);
				$converstring = str_replace('[[dok_akhir_tanggal]]',$data['dok_akhir_tanggal'],$converstring);
				$converstring = str_replace('[[nilai_pekerjaan]]',$data['nilai_pekerjaan'],$converstring);
				$converstring = str_replace('[[nilai_tagihan]]',$data['nilai_tagihan'],$converstring);
				$converstring = str_replace('[[kota]]',$data['kota'],$converstring);
				$converstring = str_replace('[[mekanisme_pembayaran]]',$data['mekanisme_pembayaran'],$converstring);
				$converstring = str_replace('[[tanggal_kwintansi]]',$data['tanggal_kwintansi'],$converstring);
				$converstring = str_replace('[[nomorrekening]]',$data['nomorrekening'],$converstring);
				$converstring = str_replace('[[namarekening]]',$data['namarekening'],$converstring);
				$converstring = str_replace('[[bankrekening]]',$data['bankrekening'],$converstring);
				
			}else{
				$converstring = $text;
			}
			
			
			return $converstring;
		}
		
		public function saveFormat(){
			$data_id = $this->CI->input->post('id');
			$perusahaan_id = $this->CI->input->post('perusahaan_id');	
			$id_nota_justi = $this->CI->input->post('id_nota_justi');	
			$tipe_id = $this->CI->input->post('tipe_id');
			
			$format = $this->CI->input->post('format');
			
			
			$this->CI->db->where('perusahaan_id',$perusahaan_id);
			$this->CI->db->where('data_id',$data_id);
			$this->CI->db->where('id_nota_justi',$id_nota_justi);
			$this->CI->db->where('tipe_id',$tipe_id);
			//$this->CI->db->where('active',1);
			$querygenerate = $this->CI->db->get('data_generate');
			$querygenerate = $querygenerate->result_object();
			if(!$querygenerate){
				$data = array(	
					'data_id'		=> $data_id,
					'perusahaan_id'	=> $perusahaan_id,
					'id_nota_justi'	=> $id_nota_justi,
					'tipe_id'		=> $tipe_id,
					'description'	=> $format,
					'active'		=> 1,
					'createdid'		=> $this->CI->session->userdata('userid'),
					'created'		=> date('Y-m-d H:i:s'),
					'modifiedid'	=> $this->CI->session->userdata('userid'),
					'modified'		=> date('Y-m-d H:i:s'),
				);
															
				$insert = $this->CI->db->insert('data_generate',$data);
				$insert_id = $this->CI->db->insert_id();
				if($insert){
					$result = array("message" => "success",'id' => $insert_id);
					return $result;
				}else{
					$result = array("message" => "error");
					return $result;
				}
			}else{
				
				$data = array(	
					'description'	=> $format,
					'active'		=> 1,
					'modifiedid'	=> $this->CI->session->userdata('userid'),
					'modified'		=> date('Y-m-d H:i:s'),
				);
				
				$this->CI->db->where('id',$querygenerate[0]->id);				
				$insert = $this->CI->db->update('data_generate',$data);
				$insert_id = $querygenerate[0]->id;
				if($insert){
					$result = array("message" => "success",'id' => $insert_id);
					return $result;
				}else{
					$result = array("message" => "error");
					return $result;
				}
				
			}
					
			
		}
		
		public function format_download($id){
			//$this->CI->load->helper('dompdf', 'file');
			$this->CI->load->library('pdfgenerator');
			
			$this->CI->db->where('id',$id);
			$querygenerate = $this->CI->db->get('data_generate');
			$querygenerate = $querygenerate->result_object();
			if($querygenerate){
				
				if($querygenerate[0]->tipe_id == 0){
					
						$this->CI->db->where('id',$id);
						$this->CI->db->where('active',1);
						$query = $this->CI->db->get('data_generate');
						$query = $query->result_object();
						if($query){
							$perusahaan_name = $this->select2_getname($query[0]->perusahaan_id,'data_perusahaan_register','id','slug');
							$data['title'] = 'GENERATE | STAR PINS';
							//$data['format'] = $query[0]->description;
							
							$data['description'] =$query[0]->description;
							$doc = new DOMDocument();
							$doc->loadHTML($data['description']);
							$tags = $doc->getElementsByTagName('img');
							foreach ($tags as $tag) {
								$old_src = $tag->getAttribute('src');
								$path=base_url().$old_src;
								$new_src_url = $this->convertimgtobase64($path);
								$tag->setAttribute('src', $new_src_url);
								$tag->setAttribute('data-src', $old_src);
							}
							$data['format'] = $doc->saveHTML();
							$data['name_file'] = 'GENERATE';
					
							return $data;
							
						}else{
							return null;
						}
						
				}else{
					
					$this->CI->db->where('id',$querygenerate[0]->id_nota_justi);
					if($querygenerate[0]->tipe_id == 1){
						$queryjustnot = $this->CI->db->get('data_nota_kebutuhan');
					}elseif($querygenerate[0]->tipe_id == 2){
						$queryjustnot = $this->CI->db->get('data_justifikasi_kebutuhan');
					}
					$queryjustnot = $queryjustnot->result_object();
					if($queryjustnot){
						
						$this->CI->db->where('id',$id);
						$this->CI->db->where('active',1);
						$query = $this->CI->db->get('data_generate');
						$query = $query->result_object();
						if($query){
							$perusahaan_name = $this->select2_getname($query[0]->perusahaan_id,'data_perusahaan_register','id','slug');
							$data['title'] = 'SPPH Pekerjaan '.$queryjustnot[0]->name.' untuk '.$perusahaan_name.' | STAR PINS';
							//$data['format'] = $query[0]->description;
							
							$data['description'] =$query[0]->description;
							$doc = new DOMDocument();
							$doc->loadHTML($data['description']);
							$tags = $doc->getElementsByTagName('img');
							foreach ($tags as $tag) {
								$old_src = $tag->getAttribute('src');
								$path=base_url().$old_src;
								$new_src_url = $this->convertimgtobase64($path);
								$tag->setAttribute('src', $new_src_url);
								$tag->setAttribute('data-src', $old_src);
							}
							$data['format'] = $doc->saveHTML();
							$data['name_file'] = 'Draft_SPPH_'.$perusahaan_name.'_'.$queryjustnot[0]->slug.'';
					
							return $data;
							
						}else{
							return null;
						}
						
					}
				
				}
				
			}
			
			
			return null;
			
		}
		
		function custom_number_format($n, $precision = 2) {
			if ($n < 1000) {
				// Anything less than a million
				$n_format = number_format($n);
			} else if ($n < 1000000) {
				// Anything less than a billion
				$n_format = number_format($n/ 1000, $precision) . ' rb';
			} else if ($n < 1000000000) {
				// Anything less than a billion
				$n_format = number_format($n/ 1000000, $precision) . ' jt';
			} else {
				// At least a billion
				$n_format = number_format($n/ 1000000000, $precision) . ' M';
			}

			return $n_format;
		}
		
			
		function getMasterRole($tipe, $iddata){
			$gid = $this->CI->session->userdata('group_id');
			
			if($gid == 1 || $gid == 2){
				return true;
			}
			
			if($tipe == 'input'){
				if($gid == 3){
					return true;
				}
			}elseif($tipe == 'izin_prinsip'){
				if($gid == 4){
					return true;
				}
			}elseif($tipe == 'director_pm'){
				if($gid == 4){
					return true;
				}
			}elseif($tipe == 'simpan_notakebutuhan'){
				if($gid == 8){
					return true;
				}
			}elseif($tipe == 'validasi_notakebutuhan'){
				if($gid == 4){
					return true;
				}
			}elseif($tipe == 'upload_bakn'){
				if($gid == 23 || $gid == 12){
					return true;
				}
			}elseif($tipe == 'input_selfassesment'){
				if($gid == 4){
					return true;
				}
			}elseif($tipe == 'hasil_selfassesment'){
				if($gid == 4){
					return true;
				}
			}elseif($tipe == 'validasi_selfassesment'){
				if($gid == 5 || $gid == 7){
					return true;
				}
			}elseif($tipe == 'validasi_selfassesment_mss'){
				if($gid == 7){
					return true;
				}
			}elseif($tipe == 'input_rpa'){
				if($gid == 9 || $gid == 24){
					return true;
				}
			}elseif($tipe == 'upload_rpa'){
				if($gid == 24|| $gid == 9){
					return true;
				}
			}elseif($tipe == 'validasi_rpa'){
				if($gid == 10){
					return true;
				}
			}elseif($tipe == 'radirtas'){
				if($gid == 11){
					return true;
				}
			}elseif($tipe == 'wbs'){
				if($gid == 4 || $gid == 6){
					return true;
				}
			}
				
				
			return false;
		}
		
		function getRangeDate($date1, $date2, $totaldaynya = 7){
			
			$totalday = 0;
			$date_range = array();
			$this->CI->db->where('db_date >=', $date1);
			$this->CI->db->where('db_date <=', $date2);
			$this->CI->db->where('weekend_flag', 'f');
			$this->CI->db->where('holiday_flag', 'f');
			$this->CI->db->order_by('db_date','ASC');
			$this->CI->db->group_by('db_date');
			$querybulan = $this->CI->db->get('master_calendar');
			$querybulan = $querybulan->result_object();
			if($querybulan){
				foreach($querybulan as $rowsbulan){
					$totalday = $totalday + 1; 
				}
			}
			
			$totaldayinclude = $totaldaynya - $totalday;
			$totaldayinclude = $totaldaynya + $totaldayinclude;
			if($totaldayinclude == 11){
				$totaldayinclude = $totaldayinclude;
			}else{
				$totaldayinclude = $totaldayinclude;
			}
			
			
			$datenew1 = $date2; //date from database 
			$str2 = date('Y-m-d', strtotime('-'.$totaldayinclude.' days', strtotime($datenew1))); 
			$date1 = $str2;
			
			$this->CI->db->where('db_date >=', $date1);
			$this->CI->db->where('db_date <=', $date2);
			$this->CI->db->where('weekend_flag', 'f');
			$this->CI->db->where('holiday_flag', 'f');
			$this->CI->db->order_by('db_date','ASC');
			$this->CI->db->group_by('db_date');
			$querybulan = $this->CI->db->get('master_calendar');
			$querybulan = $querybulan->result_object();
			if($querybulan){
				foreach($querybulan as $rowsbulan){
					array_push($date_range, $rowsbulan->db_date);
				}
			}
			
			return array($date1, $date2, $totaldayinclude, $totaldaynya, $date_range);	
			
		}
		
		function checkdaterange($date1, $date2){
			
			$datenew = $this->getRangeDate($date1, $date2);
			$date1 = $datenew[0];
			$date2 = $datenew[1];
			$totaldaynya = $datenew[3];
			$date_range = $datenew[4];
					
			$totalday = 0;
			$this->CI->db->where('db_date >=', $date1);
			$this->CI->db->where('db_date <=', $date2);
			$this->CI->db->where('weekend_flag', 'f');
			$this->CI->db->where('holiday_flag', 'f');
			$this->CI->db->order_by('db_date','ASC');
			$this->CI->db->group_by('db_date');
			$querybulan = $this->CI->db->get('master_calendar');
			$querybulan = $querybulan->result_object();
			if($querybulan){
				foreach($querybulan as $rowsbulan){
					$totalday = $totalday + 1; 
				}
			}
			
			if($totalday < 7) {
				//$this->checkdaterange($date1, $date2);
			}
			
			return array($date1, $date2, $date_range);	
		}
		
		
		function geocode($lat, $lon){

		   $details_url="https://maps.google.com/maps/api/geocode/json?latlng=".$lat.",".$lon."&key=AIzaSyB1anZ_H2UxTJ8Xl8eeofQXrocg7UJDoAw";

		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_URL, $details_url);
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		   $geoloc = json_decode(curl_exec($ch), true);

		   return $geoloc;

		}
		
		function geolinkmap($lat, $lon){

		   $details_url="https://www.google.com/maps/place/".$lat.','.$lon;

		   return $details_url;

		}
		
		

}
