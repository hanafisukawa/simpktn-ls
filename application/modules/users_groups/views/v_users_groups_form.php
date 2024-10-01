<style>
.tableFixHead          { overflow: auto; height: 500px; }
.tableFixHead thead th { position: sticky; top: 0; z-index: 1; background: #f6a221;
    color: #fff !important; font-size:14px  !important;}

/* Just common table stuff. Really. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
</style>
	<?php

		$name = '';
		$description = '';
		$active = 1;

		if(isset($id)){
			if($id == 0){
				$id = '';
				$iddata = 0;
				$type = 'Buat Baru';
			}else{
				$id = $id;
				$iddata = $id;
				$type = 'Edit';
				if($datarow && $datarow != null){
					foreach ($datarow as $rows) {
						$name = $rows->name;
						$description = $rows->description;
						$active = $rows->active;
					}
				}
			}
		}else{
			$id = '';
			$iddata = 0;
			$type = 'Buat Baru';
		}
	?>

<div class="content">
	<div class="row">	
		<div class="col-sm-12">
			<div class="card card-flat">
				
				<div class="card-body">
			
					<form id="form<?php echo $iddata; ?>"  method="POST" action="<?php echo $action; ?>" enctype="multipart/form-data" class="">
							
							
							<div class="form-group">
								<label>Name</label>
                                <input type="text" name="name" class="form-control form-control-sm" value="<?php echo $name; ?>" aria-label="taxt rate" required /> 
                            </div>
							
							<div class="form-group">
								<label>Description</label>
                                <textarea class="form-control form-control-sm" name="description" aria-describedby="Description" rows="5" required><?php echo $description; ?></textarea>
                                
                            </div>
							
							<fieldset class="form-group">
								<label>Status</label>
                                <div class="form-check">
									<label class="">
									<input type="radio" class="form-check-input" name="active" id="optionsRadios1" value="1" <?php if($active == 1){echo 'checked="checked"';} ?>>
											<span class="radio-icon fuse-ripple-ready"></span>
											<span>Active</span>
                                    </label>
                                 </div>
                                <div class="form-check">
									<label class="">
									<input type="radio" class="form-check-input" name="active" id="optionsRadios2" value="0" <?php if($active == 0){echo 'checked="checked"';} ?>>
										<span class="radio-icon fuse-ripple-ready"></span>
										<span>Inactive</span>
									</label>
								</div>
                             </fieldset>
							 
							  <div class="card-footer table-responsive tableFixHead ">
									<h5 class="card-title">Role <small>Access</small></h5>
									<table class="table table-hover">
									  <thead>
										<tr>
										  <th scope="col"><strong>Menu Name</strong></th>
										  <th scope="col">View</th>
										  <th scope="col">Insert</th>
										  <th scope="col">Update</th>
										  <th scope="col">Delete</th>
										</tr>
									  </thead>
									  <tbody>
									  
									  <?php 	
										$this->db->select('master_menu.*');
										$this->db->where('parent_id',null);
										//$this->db->where('show',1);
										$this->db->order_by('sort','asc');
										$queryheadmenu = $this->db->get('master_menu');
										$queryheadmenu = $queryheadmenu->result_object();
										if($queryheadmenu){
											
										foreach($queryheadmenu as $rowsmenu) { ?>
										
										<?php 
											$view = $m_users_groups->getviewgid($iddata, $rowsmenu->id);
											$insert = $m_users_groups->getinsertgid($iddata, $rowsmenu->id);
											$update = $m_users_groups->getupdategid($iddata, $rowsmenu->id);
											$delete = $m_users_groups->getdeletegid($iddata, $rowsmenu->id);
											
											$this->db->select('master_menu.*');
											$this->db->where('parent_id',$rowsmenu->id);
											//$this->db->where('show',1);
											$this->db->order_by('sort','asc');
											$querychild = $this->db->get('master_menu');
											$count = $querychild->num_rows();
											$querychild = $querychild->result_object();
											if($count == 0){ 
												$disabled = '';
											}else{
												$disabled = 'disabled';
											}
										?>
										
										<tr style="background-color: #f6a221;color:#fff">
											<td><input type="text" name="menuid[]" style="display:none" value="<?php echo $rowsmenu->id; ?>" /><?php echo $rowsmenu->name; ?></td>
											<td><input type="checkbox" name="view[<?php echo $rowsmenu->id; ?>]" <?php if($view == 1){ echo 'checked'; } ?>  /></td>
											<td><input type="checkbox" name="insert[<?php echo $rowsmenu->id; ?>]" <?php if($insert == 1){ echo 'checked'; } ?>  <?php echo $disabled; ?> /></td>
											<td><input type="checkbox" name="update[<?php echo $rowsmenu->id; ?>]"  <?php if($update == 1){ echo "checked"; } ?>  <?php echo $disabled; ?> /></td>
											<td><input type="checkbox" name="delete[<?php echo $rowsmenu->id; ?>]"  <?php if($delete == 1){ echo "checked"; } ?>  <?php echo $disabled; ?> /></td>
										</tr>
										
										<?php 
										
													
										if($count != 0){ 
											foreach($querychild as $rowsmenuchild) {?>
												
												<?php 
													$view = $m_users_groups->getviewgid($iddata, $rowsmenuchild->id);
													$insert = $m_users_groups->getinsertgid($iddata, $rowsmenuchild->id);
													$update = $m_users_groups->getupdategid($iddata, $rowsmenuchild->id);
													$delete = $m_users_groups->getdeletegid($iddata, $rowsmenuchild->id);
												?>
										
												<tr>
												  <td><input type="text" name="menuid[]" style="display:none" value="<?php echo $rowsmenuchild->id; ?>" /><i class="fa fa-arrow-right"></i> <?php echo $rowsmenuchild->name; ?></td>
													<td><input type="checkbox" name="view[<?php echo $rowsmenuchild->id; ?>]" <?php if($view == 1){ echo 'checked'; } ?>  /></td>
													<td><input type="checkbox" name="insert[<?php echo $rowsmenuchild->id; ?>]" <?php if($insert == 1){ echo 'checked'; } ?>  /></td>
													<td><input type="checkbox" name="update[<?php echo $rowsmenuchild->id; ?>]" <?php if($update == 1){ echo "checked"; } ?>  /></td>
													<td><input type="checkbox" name="delete[<?php echo $rowsmenuchild->id; ?>]" <?php if($delete == 1){ echo "checked"; } ?>  /></td>
												</tr>
										
											<?php }
											}										
											?>
											
										
										
										<?php }
										} 
									 
									 ?>
										
									  </tbody>
									</table>
								  </div>

							 
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" required />
							
							<div class="card-footer">
								<a href="<?php echo base_url($headurl); ?>" class="btn btn-simpan">
									<i class="fa fa-undo"></i> Kembali
								</a>
								<button type="submit" class="btn btn-create pull-right">
									<i class="fa fa-save"></i> Kirim
								</button>
							</div>
							
							
					</form>
				</div>
			</div>
		</div>
	</div>
</div>