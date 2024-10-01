<!--begin::Menu-->

<div class="menu-atas menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-400 fw-semibold my-5 my-lg-0 align-items-stretch px-2 px-lg-0" id="#kt_header_menu" data-kt-menu="true">
						

<?php 
	$this->db->select('master_menu.*');
	$this->db->where('parent_id',null);
	$this->db->where('master_menu.show',1);
	$this->db->where('users_groups_access.view',1);
	$this->db->where('gid',$this->session->userdata('group_id'));
	$this->db->join('users_groups_access','master_menu.id = users_groups_access.menu_id');
	$this->db->order_by('sort','asc');
	$query = $this->db->get('master_menu');
	$query = $query->result_object();
	if($query){
									
		foreach ($query as $rows) {
									
			$this->db->select('master_menu.*');
			$this->db->where('parent_id',$rows->id);
			$this->db->where('master_menu.show',1);
			$this->db->where('users_groups_access.view',1);
			$this->db->where('gid',$this->session->userdata('group_id'));
			$this->db->join('users_groups_access','master_menu.id = users_groups_access.menu_id');
			$this->db->order_by('sort','asc');
			$querychild = $this->db->get('master_menu');
			$count = $querychild->num_rows();
			$querychild = $querychild->result_object();
									
			if($count == 0){
			
							
?>

					<!--begin:Menu item-->
					<div id="menu_id_<?php echo $rows->id; ?>" class="<?php if(isset($module)){if($module == $rows->module){echo ' here ';}} ?> menu-item ">
						<!--begin:Menu link-->
						<a class="menu-link py-3" href="<?php echo base_url().$rows->url; ?>">
							<span class="menu-title"><?php echo $rows->name; ?><div class="notifnyamenu" id="menu_<?php echo $rows->module; ?>"></div></span>
							<span class="menu-arrow d-lg-none"></span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->
										
<?php 									
			}elseif($querychild && $count > 0){				
?>	
				
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="<?php if(isset($module)){if($module == $rows->module){echo ' here ';}} ?> menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2" >
						<!--begin:Menu link-->
						<span class="menu-link py-3">
							<span class="menu-title"><?php echo $rows->name; ?><div class="notifnyamenu" id="menu_<?php echo $rows->module; ?>"></div></span>
							<span class="menu-arrow d-lg-none"></span>
						</span>
						<!--end:Menu link-->
						
						
						<!--begin:Menu sub-->
						<div class="menu-sub sub-menu-custome menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px" style="max-height:300px;overflow: auto !important;">

							<?php
							foreach ($querychild as $rowschild) { ?>
									<!--begin:Menu item-->
									<div class="menu-item">
									<!--begin:Menu link-->
										<a class="menu-link py-3" href="<?php echo base_url($rowschild->url); ?>">
											<span class="menu-icon">
												<i class="<?php echo $rowschild->icon; ?>"></i>
											</span>
											<span class="menu-title"><?php echo $rowschild->name; ?><div class="notifnyamenu" id="menu_child_<?php echo str_replace(' ','_',trim($rowschild->name)); ?>"></div></span>
										</a>
									<!--end:Menu link-->
									</div>
							<?php } ?>
						<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
				
		
<?php		 }
						
		}
	}
?>

</div>
<!--end::Menu-->
										
								