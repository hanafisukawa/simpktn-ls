<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class M_api_notif extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	

	function setInboxData($data_array){
		
		$tipe_id = $data_array['tipe_id'];
		
		if($tipe_id == 1){ //NEW LOP
			$jenis_user_id = 1;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 2){ //NEW F1
			$jenis_user_id = 2;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 3){ //NEW Izin Prinsip
			$jenis_user_id = 3;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 4){ //NEW F2
			$jenis_user_id = 4;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 5){ //NEW SPPH
			$jenis_user_id = 5;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 97){ //NEW SPPH
			$jenis_user_id = 97;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 6){ //NEW Nota Kebutuhan
			$jenis_user_id = 6;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 7){ //validasi Nota Kebutuhan
			$jenis_user_id = 7;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 8){ //Upload BAKN
			$jenis_user_id = 8;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 9){ //Upload BAKN
			$jenis_user_id = 9;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 10){ //Upload BAKN
			$jenis_user_id = 10;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 11){ //Upload BAKN
			$jenis_user_id = 11;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 12){ //Upload BAKN
			$jenis_user_id = 12;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 13){ //Upload BAKN
			$jenis_user_id = 13;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 14){ //Radirtas
			$jenis_user_id = 14;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 15){ //Upload BAKN
			$jenis_user_id = 15;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 16){ //WBS
			$jenis_user_id = 16;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 17){ //WBS
			$jenis_user_id = 17;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 18){ //WBS
			$jenis_user_id = 18;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 19){ //WBS
			$jenis_user_id = 19;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 50){ //WBS
			$jenis_user_id = 50;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 51){ //WBS
			$jenis_user_id = 51;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 52){ //Assesment
			$jenis_user_id = 52;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 53){ //RISK BERES
			$jenis_user_id = 53;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 54){ //RISK BERES
			$jenis_user_id = 54;
			$this->getUsers($jenis_user_id, $data_array);
		}elseif($tipe_id == 55){ //RISK BERES
			$jenis_user_id = 55;
			$this->getUsers($jenis_user_id, $data_array);
		}
	}
	
	function getUsers($jenis_user_id, $data_array){
		
		if($jenis_user_id == 1){ //F0
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(6); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Input LoP '.$lop['lop_no'].' baru dimasukkan oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan input LoP ['.$lop['lop_no'].'] baru dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Input LoP '.$lop['lop_no'].' baru dimasukkan oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan input LoP ['.$lop['lop_no'].'] baru dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = $lop['am_id']; //AM
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Input LoP '.$lop['lop_no'].' F0';
					$message = 'Dear AM '.$rows['fullname'].'<br><br>
					
								Selamat LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah F0.<br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
				}
			}
			
		}elseif($jenis_user_id == 2){ //F0
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(6); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F0 ke F1 oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan update LoP ['.$lop['lop_no'].'] F0 ke F1 dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F0 ke F1 oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan update LoP ['.$lop['lop_no'].'] F0 ke F1 dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = $lop['am_id']; //AM
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Input LoP '.$lop['lop_no'].' F0';
					$message = 'Dear AM '.$rows['fullname'].'<br><br>
					
								Selamat LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah F1.<br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
				}
			}
		}elseif($jenis_user_id == 3){ //PADA WEB Izin Prinsip
		
			if($data_array['status_id'] == 100 ){
				$lop_id = $data_array['data_id'];
				$lop = $this->getDetailLOP($lop_id);
				$gid = $lop['am_id']; //AM
				$this->db->select('users_data.*');
				$this->db->where_in('users_data.id', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_array();
				if($query){
					foreach($query as $rows){
						
						$from_id = $data_array['user_id'];
						$to_id = $rows['id'];
						
						$category_id = 1; //NEW LOP
						$subject = 'Update LoP '.$lop['lop_no'].' Izin Prinsip Tidak Disetujui';
						$message = 'Dear AM '.$rows['fullname'].'<br><br>
						
									Pada tanggal '.$lop['tanggal_input'].', Izin Prinsip LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Tidak Disetujui. <br>
									Silakan lakukan pengecekan aplikasi STAR Anda.<br><br>
									
									Terima kasih<br><br>
									Regards,<br>
									STAR System';
									
						$data_id = $lop_id;
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
						$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
					}
				}
			}else{
				$lop_id = $data_array['data_id'];
				$lop = $this->getDetailLOP($lop_id);
				$gid = $lop['am_id']; //AM
				$this->db->select('users_data.*');
				$this->db->where_in('users_data.id', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_array();
				if($query){
					foreach($query as $rows){
						
						$from_id = $data_array['user_id'];
						$to_id = $rows['id'];
						
						$category_id = 1; //NEW LOP
						$subject = 'Update LoP '.$lop['lop_no'].' Izin Prinsip Telah Disetujui';
						$message = 'Dear AM '.$rows['fullname'].'<br><br>
						
									Pada tanggal '.$lop['tanggal_input'].', Izin Prinsip LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Telah Disetujui serta PIC Pre Sales anda adalah '.$lop['pic_presales_name'].',  silahkan lanjutkan update ke Funnel F2 .<br>
									Silakan lakukan pengecekan aplikasi STAR Anda.<br><br>
									
									Terima kasih<br><br>
									Regards,<br>
									STAR System';
									
						$data_id = $lop_id;
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
						$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
					}
				}
			}
			
			
		}elseif($jenis_user_id == 4){ //F2
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(4,6); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F1 ke F2 oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan update LoP ['.$lop['lop_no'].'] F1 ke F2 dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = $lop['am_id']; //AM
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' SPPH Input';
					$message = 'Dear AM '.$rows['fullname'].'<br><br>
					
								Silahkan update dokumen SPPH/RKS/Sejenis pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Untuk dapat melanjutkan pada proses selanjutnya. .<br>
								Silakan lakukan pengecekan aplikasi STAR Anda.<br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
				}
			}
			
		}elseif($jenis_user_id == 5){ //INPUT SPPH
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(6); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' upload SPPH oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan upload SPPH/RKS/Sejenis pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' upload SPPH oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan upload SPPH/RKS/Sejenis pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = $lop['am_id']; //AM
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Project Calc Submit';
					$message = 'Dear AM '.$rows['fullname'].'<br><br>
					
								Input project calc pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Telah terkirim ke SBU.<br><br>
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
				}
			}
			
			//$lop_id = $data_array['data_id'];
			//$lop = $this->getDetailLOP($lop_id);
			$gid = array(8); //PIC Pre Sales
			$pic_presales_id = $lop['pic_presales_id']; //PIC Pre Sales
			$this->db->select('users_data.*');
			//$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.gid', $pic_presales_id);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Input Notakebutuhan untuk LoP '.$lop['lop_no'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Silahkan melakukan upload notakebutuahn pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] dan silahkan berkoordinasi dengan AM '.$lop['am_fullname'].'.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
		}elseif($jenis_user_id == 97){ //INPUT Project Calc
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = $lop['am_id']; //AM
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Project Calc Input';
					$message = 'Dear AM '.$rows['fullname'].'<br><br>
					
								Silahkan input project calc pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Untuk dapat melanjutkan pada proses selanjutnya. .<br>
								Silakan lakukan pengecekan aplikasi STAR Anda.<br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
				}
			}
			
			//$lop_id = $data_array['data_id'];
			//$lop = $this->getDetailLOP($lop_id);
			$gid = array(8); //PIC Pre Sales
			$pic_presales_id = $lop['pic_presales_id']; //PIC Pre Sales
			$this->db->select('users_data.*');
			//$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.gid', $pic_presales_id);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Input Notakebutuhan untuk LoP '.$lop['lop_no'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Silahkan koordinasi terkait project calc pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] dan silahkan berkoordinasi dengan AM '.$lop['am_fullname'].'.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
		}elseif($jenis_user_id == 6){ //NOTA KEBUTUHAN
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Input Nota Kebutuhan oleh '.$lop['pic_presales_name'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', PIC '.$lop['pic_presales_name'].' melakukan input Nota Kebutuhan pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 7){ //Validasi KEBUTUHAN
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(12); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Input BAKN Mitra oleh Sourcing';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Silahkan melakukan input BKAN Mitra pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 8){ //Mengisi Seft Assesment
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Mengisi Seft Assesment';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', Sourcing melakukan upload BAKN pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] proses LoP dapat dilanjutkan ke Self Assesment.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 9){ //Validasi Self Assesment
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(5); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Validasi Self Assesment';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', Self Assesment pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah di buat silahkan lakukan validasi data untuk melanjutkan proses selanjutnya.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 10){ //INPUT Self Assesment
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(9,10); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Self Assesment Selesai';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', Self Assesment pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah di selesai di lakukan silakan melakukan proses selanjutnya untuk LoP ini.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 11){ //INPUT Self Assesment
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(9,10); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' RPA Input';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah di selesai input form RPA, silakan melakukan proses selanjutnya terkait TTD semua satgas dan lakukan upload RPA TTD untuk LoP ini.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 12){ //INPUT Self Assesment
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(9,10); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' RPA Upload TTD';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah di selesai upload form RPA TTD, silakan melakukan proses selanjutnya untuk LoP ini.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 13){ //INPUT Self Assesment
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(11); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' RPA Selesai';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah di selesai RPA, silakan melakukan proses selanjutnya untuk LoP ini.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 14){ //hasil Radirtas
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Hasil Radirtas';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah di selesai Radirtas, silakan melakukan proses selanjutnya untuk LoP ini.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Input PM dan Co PM';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah di selesai Radirtas, silakan melakukan proses selanjutnya terkait pemilihan PM dan Co PM untuk LoP ini.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 15){ //INPUT WBS
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(5); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Input WBS';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah di selesai Penunjukan PM dan CO Pm, silakan melakukan proses selanjutnya untuk menginput WBS pada LoP ini.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Input WBS';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] telah di selesai Penunjukan PM dan CO Pm, silakan melakukan proses selanjutnya untuk menginput WBS pada LoP ini.<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 16){ //F3 FOrm
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = $lop['am_id']; //AM
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F3 Input';
					$message = 'Dear AM '.$rows['fullname'].'<br><br>
					
								Silahkan update data F3 pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Untuk dapat melanjutkan pada proses selanjutnya.<br>
								Silakan lakukan pengecekan aplikasi STAR Anda.<br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
				}
			}
			
		}elseif($jenis_user_id == 17){ //F2
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(6); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F2 ke F3 oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan update LoP ['.$lop['lop_no'].'] F2 ke F3 dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F2 ke F3 oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan update LoP ['.$lop['lop_no'].'] F2 ke F3 dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = $lop['am_id']; //AM
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Input F4';
					$message = 'Dear AM '.$rows['fullname'].'<br><br>
					
								Silahkan update kebutuhan F4 LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Untuk dapat melanjutkan pada proses selanjutnya. .<br>
								Silakan lakukan pengecekan aplikasi STAR Anda.<br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
				}
			}
			
		}elseif($jenis_user_id == 18){ //F2
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(6); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F3 ke F4 oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan update LoP ['.$lop['lop_no'].'] F3 ke F4 dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F3 ke F4 oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan update LoP ['.$lop['lop_no'].'] F3 ke F4 dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = $lop['am_id']; //AM
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Input F5';
					$message = 'Dear AM '.$rows['fullname'].'<br><br>
					
								Silahkan update kebutuhan F5 LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Untuk dapat melanjutkan pada proses selanjutnya. .<br>
								Silakan lakukan pengecekan aplikasi STAR Anda.<br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
				}
			}
			
		}elseif($jenis_user_id == 19){ //F2
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(6); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F4 ke F5 oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan update LoP ['.$lop['lop_no'].'] F4 ke F5 dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['am_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' F4 ke F5 oleh AM '.$lop['am_fullname'];
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].', AM '.$lop['am_fullname'].' melakukan update LoP ['.$lop['lop_no'].'] F4 ke F5 dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = $lop['am_id']; //AM
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $data_array['user_id'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Input POST F5';
					$message = 'Dear AM '.$rows['fullname'].'<br><br>
					
								Silahkan update kebutuhan POST F5 LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Untuk dapat melanjutkan pada proses selanjutnya. .<br>
								Silakan lakukan pengecekan aplikasi STAR Anda.<br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					$this->sendMessage('LoP '.$lop['lop_no'].' Update', 'LoP Update', $to_id);
				}
			}
			
		}elseif($jenis_user_id == 50){ //F0
			$customer_id = $data_array['data_id'];
			$customer = $this->getDetailCustomer($customer_id);
			$gid = array(6); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			
			if($query){
				foreach($query as $rows){
					
					$from_id = $customer['am_id'];
					$to_id = $rows['id'];
					
					
					
					$category_id = 2; //NEW LOP
					$subject = 'Input Customer '.$customer['name'].' baru dimasukkan oleh AM ';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$customer['tanggal_input'].', AM melakukan input customer ['.$customer['name'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$customer['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $customer_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
			
			$gid = array(4); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$this->db->where('users_data.unit_id', $lop['sbu_id']);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			
			if($query){
				foreach($query as $rows){
					
					$from_id = $customer['am_id'];
					$to_id = $rows['id'];
					
					
					
					$category_id = 2; //NEW LOP
					$subject = 'Input Customer '.$customer['name'].' baru dimasukkan oleh AM ';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$customer['tanggal_input'].', AM melakukan input customer ['.$customer['name'].'] .<br>
								Silakan lakukan pengecekan pada link berikut.<br><br>
								
								<a href="'.$customer['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $customer_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 51){ //F0
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = $data_array['user_id']; //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Approval RPA';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].',Form RPA pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Telah di buat.<br>
								Silakan lakukan pengecekan dan validasi RPA pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 52){ //F0
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = $data_array['user_id']; //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Approval Self Assesment';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].',Form Self Assesment pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Telah di buat.<br>
								Silakan lakukan pengecekan dan validasi Self Assesment pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 53){ //F0
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(10); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Approval RPA';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].',Form RPA pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Telah di lakukan approval oleh semua bagian.<br>
								Silakan lakukan pengecekan dan validasi RPA pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 54){ //F0
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = $data_array['user_id']; //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.id', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Input Analisa RPA';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].',Form RPA pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Telah di kirim oleh Risk Management.<br>
								Silakan lakukan pengisian dan validasi RPA pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}elseif($jenis_user_id == 55){ //F0
			$lop_id = $data_array['data_id'];
			$lop = $this->getDetailLOP($lop_id);
			$gid = array(9,24); //ROLE SBU MGR dan MS MGR
			$this->db->select('users_data.*');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_array();
			if($query){
				foreach($query as $rows){
					
					$from_id = $lop['modifiedid'];
					$to_id = $rows['id'];
					
					$category_id = 1; //NEW LOP
					$subject = 'Update LoP '.$lop['lop_no'].' Approval RPA Selesai';
					$message = 'Dear '.$rows['fullname'].'<br><br>
					
								Pada tanggal '.$lop['tanggal_input'].',Form RPA pada LoP ['.$lop['lop_no'].'] dengan Customer '.$lop['customer_name'].' dan nama LoP ['.$lop['lop_nama'].'] Telah di lakukan approval oleh semua bagian.<br>
								Silakan lakukan input kesimpulan dan validasi RPA pada link berikut.<br><br>
								
								<a href="'.$lop['link'].'">Klik Disini untuk detail LoP</a><br><br>
								
								Terima kasih<br><br>
								Regards,<br>
								STAR System';
								
					$data_id = $lop_id;
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}
		}		
	}
	
	function getDetailLOP($lop_id){
		$data = [];
		$this->db->select('data_lop.*, am_user.fullname as am_fullname, customer.name as customer_name');
		$this->db->where('data_lop.id', $lop_id);
		$this->db->join('users_data am_user','am_user.id = data_lop.user_id','left');
		$this->db->join('master_customer customer','customer.id = data_lop.customer_id','left');
		$query = $this->db->get('data_lop');
		$query = $query->result_array();
		if($query){
			foreach ($query as $rows){
				$data['id'] = $rows['id'];
				$data['lop_no'] = $rows['lop_no'];
				$data['lop_nama'] = $rows['lop_nama'];
				$data['sbu_id'] = $rows['sbu_id'];
				$data['am_id'] = $rows['user_id'];
				$data['pic_presales_id'] = $rows['pic_presales_id'];
				$data['pic_presales_name'] = $this->ortyd->select2_getname($data['pic_presales_id'],'users_data','id','fullname');
				$data['am_fullname'] = $rows['am_fullname'];
				$data['customer_name'] = $rows['customer_name'];
				$data['tanggal_input'] = $this->ortyd->format_date($rows['modified']);
				$data['link'] = base_url_site.'data_lop/editdata/'.$rows['slug'];
				$data['modifiedid'] = $rows['modifiedid'];
			}
		}else{
			$data = null;
		}
		
		return $data;
	}
	
	
	function getDetailCustomer($customer_id){
		$data = [];
		$this->db->select('master_customer.*');
		$this->db->where('master_customer.id', $customer_id);
		$query = $this->db->get('master_customer');
		$query = $query->result_array();
		if($query){
			foreach ($query as $rows){
				$data['id'] = $rows['id'];
				$data['name'] = $rows['name'];
				$data['am_id'] = $rows['modifiedid'];
				$data['tanggal_input'] = $this->ortyd->format_date($rows['modified']);
				$data['link'] = base_url_site.'master_customer/editdata/'.$rows['slug'];
				$data['modifiedid'] = $rows['modifiedid'];
			}
		}else{
			$data = null;
		}
		
		return $data;
	}
	
	
	function setInboxLOP($status_id, $data_array){
			
		if($status_id == 2){ //NEW LOP
			$gid = array(4,6);
			$this->db->select('users_data.id as user_id');
			$this->db->where_in('users_data.gid', $gid);
			$query = $this->db->get('users_data');
			$query = $query->result_object();
			if($query){
				foreach($query as $rows){
					$from_id = $data_array['from_id'];
					$to_id = $rows->user_id;
					$category_id = 1;
						//$subject = $data_array['subject'];
						//$message = $data_array['message'];
						
					$subject = 'Input LOP baru dimasukkan oleh AM';
					$message = 'Dear Manager SBU<br><br>
								Pada tanggal xx, AM melakukan input LOP baru dengan<br>
								status NEW CUSTOMER.<br>
								Silakan lakukan pengecekan.<br><br>
								Terima kasih<br><br>
								Regards,<br>
								MAST System';
								
								
					$data_id = $data_array['data_id'];
					$is_wa = 0;
					$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
				}
			}	
				
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.id', $data_array['from_id']);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $from_id;
						$category_id = 1;
						//$subject = $data_array['subject'];
						//$message = $data_array['message'];
						
						$subject = 'Input LOP baru';
						$message = 'Dear AM<br><br>
								Pada tanggal xx, LOP Anda telah update ke F0<br>
								status NEW CUSTOMER.<br>
								Terima kasih<br><br>
								Regards,<br>
								MAST System';
								
								
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 3){ //NEW LOP
				$gid = array(4,6);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 2;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						
						$subject = 'LOP status F0 naik status menjadi F1';
						$message = 'Dear Manager SBU<br><br>
								LOP dengan nomor xx sudah naik status menjadi F1<br>
								Silakan lakukan pengecekan.<br><br>
								Terima kasih<br><br>
								Regards,<br>
								MAST System';
								
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}	
				
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.id', $data_array['from_id']);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $from_id;
						$category_id = 1;
						//$subject = $data_array['subject'];
						//$message = $data_array['message'];
						
						$subject = 'Input LOP baru';
						$message = 'Dear AM<br><br>
								Pada tanggal xx, LOP Anda telah update ke F1<br>
								status NEW CUSTOMER.<br>
								Terima kasih<br><br>
								Regards,<br>
								MAST System';
								
								
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 4){ //NEW LOP
				$gid = array(4,6);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 3;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						
						$subject = 'LOP status F0 naik status menjadi F2';
						$message = 'Dear Manager SBU<br><br>
								LOP dengan nomor xx sudah naik status menjadi F2<br>
								Silakan lakukan pengecekan.<br><br>
								Terima kasih<br><br>
								Regards,<br>
								MAST System';
								
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}

				$gid = array(4);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 3;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						
						$subject = 'LOP status F0 naik status menjadi F2';
						$message = 'Dear Manager SBU<br><br>
								LOP dengan nomor xx sudah naik status menjadi F2<br>
								Silakan lakukan pengecekan dan segera persiapan proses<br>
								dan dokumen untuk Self Assesment.<br>
								Terima kasih<br><br>
								Regards,<br>
								MAST System';
								
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
				
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.id', $data_array['from_id']);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $from_id;
						$category_id = 1;
						//$subject = $data_array['subject'];
						//$message = $data_array['message'];
						
						$subject = 'Input LOP baru';
						$message = 'Dear AM<br><br>
								Pada tanggal xx, LOP Anda telah update ke F2<br>
								status NEW CUSTOMER.<br>
								Terima kasih<br><br>
								Regards,<br>
								MAST System';
								
								
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 5){ //NEW LOP
				$gid = array(5);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 4;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 6){ //NEW LOP
				$gid = array(5);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 5;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 7){ //NEW LOP
				$gid = array(8);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 6;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						
						$subject = 'Mohon review dokumen yang disiapkan PIC Presales';
						$message = 'Dear Manager SBU<br><br>
							Presales sudah mempersiapkan dokumen untuk LOP xx.<br>
							Mohon lakukan proses review.<br><br>
							Terima kasih';
								
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 8){ //NEW LOP
				$gid = array(4);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 7;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 9){ //NEW LOP
				$gid = array(5);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 8;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 13){ //NEW LOP
				$gid = array(9);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 9;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 14){ //NEW LOP
				$gid = array(9);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 9;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}
				
			}elseif($status_id == 15){ //NEW LOP
				$gid = array(1,2,3,4,5,6,7,8,9,10);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 12;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}	
			}elseif($status_id == 16){ //NEW LOP
				$gid = array(1,2,3,4,5,6,7,8,9,10);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 13;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}	
			}elseif($status_id == 17){ //NEW LOP
				$gid = array(1,2,3,4,5,6,7,8,9,10);
				$this->db->select('users_data.id as user_id');
				$this->db->where_in('users_data.gid', $gid);
				$query = $this->db->get('users_data');
				$query = $query->result_object();
				if($query){
					foreach($query as $rows){
						$from_id = $data_array['from_id'];
						$to_id = $rows->user_id;
						$category_id = 14;
						$subject = $data_array['subject'];
						$message = $data_array['message'];
						$data_id = $data_array['data_id'];
						$is_wa = 0;
						$this->ortyd->setInbox($from_id, $to_id, $category_id, $subject, $message, $data_id,$is_wa);
					}
				}	
			}
		}
		
	function kirimemail(){

		$this->db->select('data_inbox.*');
		$this->db->where('data_inbox.is_email', 1);
		$this->db->where('data_inbox.email_date is null', null);
		$query = $this->db->get('data_inbox');
		$query = $query->result_object();
		if($query){
			foreach($query as $rows){
				$this->db->select('*');
				$this->db->where_in('users_data.id', $rows->to_id);
				$queryuser = $this->db->get('users_data');
				$queryuser = $queryuser->result_object();
				if($queryuser){
					foreach($queryuser as $rowsuser){
						$email = $rowsuser->email;
						$fullname = $rowsuser->fullname;
						$subject = $rows->subject;
						$message = $rows->message;
						$attachment = null;
						$sending = $this->ortyd->sendEmail($email, $fullname, $subject, $message, $attachment);
						if($sending){
							$data = array(	
								'email_date'	=> date('Y-m-d H:i:s')
							);
							
							$this->db->where('id',$rows->id);				
							$insert = $this->db->update('data_inbox',$data);
						}
					}		
				}
			}		
		}
		
		return true;
	}
	
	function sendMessage($content, $heading, $userID){
			$app_id_onesignal = 'addb86dd-20af-4bda-b713-97b35b464400';
			$this->db->select('notif_id');
			$this->db->where('id',$userID);
			$result = $this->db->get('users_data');
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
		
}
