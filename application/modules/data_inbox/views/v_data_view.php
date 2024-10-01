
<?php
	
	$exclude = $exclude;
	$query_column = $this->ortyd->query_column($module, $exclude);
	if($query_column){
		foreach($query_column as $rows_column){
			if($rows_column['name'] == 'active'){
				${$rows_column['name']} = 1;
			}else{
				${$rows_column['name']} = null;
			}
		}
		$tanggal = date('Y-m-d');
		if(isset($id)){
			if($id == '0'){
				$id = '';
				$iddata = 0;
				$typedata = 'Buat';
			}else{
				$id = $id;
				$iddata = $id;
				$typedata = 'Edit';
				if($datarow && $datarow != null){
					foreach($query_column as $rows_column){
						foreach ($datarow as $rows) {
							${$rows_column['name']} = $rows->{$rows_column['name']};
						}
					}
				}
			}
		}else{
			$id = '';
			$iddata = 0;
			$typedata = 'Buat';
		}
	}else{
		$newURL = base_url($module);
		header('Location: '.$newURL);
	}
	
	$created = $this->ortyd->select2_getname($iddata,'vw_data_inbox','id','created');
	$created = date_create($created);
	$created = date_format($created,'d F Y H:i:s');
	$ticket_no = $this->ortyd->select2_getname($iddata,'vw_data_inbox','id','from_fullname');
	$pelapor = $this->ortyd->select2_getname($iddata,'vw_data_inbox','id','from_fullname');
?>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
	<!--begin::Post-->
	<div class="content flex-row-fluid" id="kt_content">				
		<?php include(APPPATH."views/navbar_header_form.php"); ?>			
		<!--begin::Row-->
		<div class="row gx-6 gx-xl-9">
			<!--begin::Col-->
			<div class="col-lg-12">
				<!--begin::Summary-->
				<div class="card card-custom gutter-b example example-compact">
					<div class="card-body">
						
						
							<div class="row">	
						<?php
							if($query_column){
								$indentitas = 0;
								foreach($query_column as $rows_column){ 
								
									$disable = ' readonly="readonly" ';
									$editheader = '';
									$tipe_data = $this->ortyd->getTipeData($module,$rows_column['name']);
									$width_column = $this->ortyd->width_column($module,$rows_column['name']);
									$label_name = $this->ortyd->translate_column($module,$rows_column['name']);
									$label_name_text = $label_name;
									if($rows_column['name']){
										$table_change = "'".$module."'";
										$table_change_id = "'".$rows_column['name']."'";
										//$editheader = ' <span style="cursor:pointer" onClick="changeTitle('.$table_change.','.$table_change_id.')"><i class="fa fa-edit"></i></span>';
										if($this->ortyd->getAksesEditNaming() == true){
											$label_name = $label_name.$editheader;
										}else{
											$label_name = $label_name;
										}
									}
									if($rows_column['is_nullable'] == 'NO'){
										$label_name = $label_name.'';
									} 
									
									if($rows_column['type'] == 'text' || $rows_column['type'] == 'longtext'){ ?>
									
										
										<?php if($rows_column['name'] == 'id'){ ?>
											
											
											
										<?php }else{ ?>
										
											<?php if($rows_column['name'] == 'keterangan'){ ?>
											
											<div class="col-lg-<?php echo $width_column; ?> py-3">
												<div class="form-group">
													<label><?php echo $label_name; ?></label>
													<div class="ticket-font-view"><?php echo ${$rows_column['name']}; ?></div>
												</div>
											</div>

											<?php }else{ ?>
										
											<div class="col-lg-<?php echo $width_column; ?> py-3">
												<div class="form-group">
													<label><?php echo $label_name; ?></label>
													<div class="ticket-font-view"><?php echo ${$rows_column['name']}; ?></div>
												</div>
											</div>
											
											<?php } ?>
										
										<?php } ?>
								
								
								<?php }elseif($rows_column['name'] == 'date'){ ?>
									
										<div class="col-lg-<?php echo $width_column; ?> py-3">
											<div class="form-group">
												<label><?php echo $label_name; ?></label>
												<div class="ticket-font-view"><?php echo ${$rows_column['name']}; ?></div>
											</div>
										</div>
										
								<?php }elseif($rows_column['name'] == 'tanggal'){ ?>
								
										<div class="col-lg-4 py-3">
											<div class="form-group">
												<label><?php echo 'Nomor Tiket'; ?></label>
												<div class="ticket-font-view"><?php echo $ticket_no; ?></div>
											</div>
										</div>
										
										<div class="col-lg-8 py-3">
											<div class="form-group">
												<label><?php echo 'Pelapor'; ?></label>
												<div class="ticket-font-view"><?php echo $pelapor; ?></div>
											</div>
										</div>
									
										<div class="col-lg-<?php echo $width_column; ?> py-3">
											<div class="form-group">
												<label><?php echo $label_name; ?></label>
												<div class="ticket-font-view"><?php echo $created; ?></div>
											</div>
										</div>
									
								<?php }elseif($rows_column['name'] == 'email'){ ?>
									
										<div class="col-lg-<?php echo $width_column; ?> py-3">
											<div class="form-group">
												<label><?php echo $label_name; ?></label>
												<div class="ticket-font-view"><?php echo ${$rows_column['name']}; ?></div>
											</div>
										</div>
									
								<?php }elseif($rows_column['name'] == 'nomor'){ ?>
									
										<div class="col-lg-<?php echo $width_column; ?> py-3">
											<div class="form-group">
												<label><?php echo $label_name; ?></label>
												<div class="ticket-font-view"><?php echo ${$rows_column['name']}; ?></div>
											</div>
										</div>
									
								<?php }else{ ?>
								
										<?php if($tipe_data == 'FILE' || $rows_column['name'] == 'file_id'){ ?>
								
										<?php 
											include(APPPATH."views/common/uploadformside.php");
										?>
								
									<?php }elseif($tipe_data == 'SELECT' || $this->ortyd->str_conten($rows_column['name'], '_id') == TRUE){ ?>
										
									<?php 
												$table_references = $this->ortyd->get_table_reference($module,$rows_column['name']);
												if($table_references != null){ 
													$table = $table_references[0];
													$reference = '';
													$selecttableid = $table_references[1];
													$selecttablename = $table_references[2];
												}else{
													$table = $module;
													$reference = '';
													$selecttableid = 'id';
													$selecttablename = 'name';
												}
												
												${$rows_column['name']} = $this->ortyd->select2_getname(${$rows_column['name']},$table,'id',$selecttablename);
										?>
									
											<div class="col-lg-<?php echo $width_column; ?> py-3">
													<div class="form-group">
														<label><?php echo $label_name; ?></label>
														<div class="ticket-font-view"><?php echo ${$rows_column['name']}; ?></div> 
													</div>
												</div>
												
									<?php }elseif($rows_column['name'] == 'urutan'){ ?>
			
										<div class="col-lg-<?php echo $width_column; ?> py-3">
											<div class="form-group">
												<label><?php echo $label_name; ?></label>
												<div class="ticket-font-view"><?php echo ${$rows_column['name']}; ?></div>
											</div>
										</div>
									
									
									<?php }else{ ?>
								
										<div class="col-lg-<?php echo $width_column; ?> py-3">
											<div class="form-group">
												<label><?php echo $label_name; ?></label>
												<div class="ticket-font-view"><?php echo ${$rows_column['name']}; ?></div>
											</div>
										</div>
									
									<?php } ?>
									
								

								<?php }
									$indentitas++;
								}
							} ?>

							
							<div class="card-footer col-lg-12 py-3" id="btn-cancel-submit">
	
							</div>
								
							</div>	
							
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$( document ).ready(function() {
	
		setTimeout(function() {
			$('.dropzone-panel').hide();
			$('.dropzone-toolbar').hide();
			$('.dropzone-text-muted').hide();
		}, 500);
		
})
</script>

