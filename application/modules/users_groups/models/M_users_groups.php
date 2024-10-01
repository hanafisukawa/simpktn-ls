<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_users_groups extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}

		public function get_data_byid($ID, $tabledb, $tableid){
			$this->db->select('*');
			$this->db->where($tableid, $ID);
			$query = $this->db->get($tabledb);
			$query = $query->result_object();
			if($query){
				return $query;
			}else{
				return null;
			}
		}
		
		function getviewgid($gid,$menu_id){
			$this->db->select('view as data');
			$this->db->where('users_groups_access.gid', $gid);
			$this->db->where('users_groups_access.menu_id',$menu_id);
			$query = $this->db->get('users_groups_access');
			$query = $query->result_object();
			if($query){
				return $query[0]->data;
			}else{
				return 0;
			}
		}
		
		function getinsertgid($gid,$menu_id){
			$this->db->select('insert as data');
			$this->db->where('users_groups_access.gid', $gid);
			$this->db->where('users_groups_access.menu_id',$menu_id);
			$query = $this->db->get('users_groups_access');
			$query = $query->result_object();
			if($query){
				return $query[0]->data;
			}else{
				return 0;
			}
		}
		
		function getupdategid($gid,$menu_id){
			$this->db->select('update as data');
			$this->db->where('users_groups_access.gid', $gid);
			$this->db->where('users_groups_access.menu_id',$menu_id);
			$query = $this->db->get('users_groups_access');
			$query = $query->result_object();
			if($query){
				return $query[0]->data;
			}else{
				return 0;
			}
		}
		
		function getdeletegid($gid,$menu_id){
			$this->db->select('delete as data');
			$this->db->where('users_groups_access.gid', $gid);
			$this->db->where('users_groups_access.menu_id',$menu_id);
			$query = $this->db->get('users_groups_access');
			$query = $query->result_object();
			if($query){
				return $query[0]->data;
			}else{
				return 0;
			}
		}
	
}	