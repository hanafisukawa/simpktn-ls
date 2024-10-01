<?php 
	if(!isset($readonlyselect)){
		$readonlyselect = '';
	}
	
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
		$selecttablename = 'id';
	}
?>
	<div draggable="true" class="drag-item col-lg-<?php echo $width_column; ?> py-3" id="<?php echo $rows_column['name'].'_header'; ?>">				
		<div class="form-group">
			<div class="row">
				<div class="col-lg-3">
					<label><?php echo $label_name; ?></label>
				</div>
				<div class="col-lg-9">
				
					<select class="form-control form-control-sm <?php if($rows_column['is_nullable'] == 'NO'){echo ' required ';} ?>" name="<?php echo $rows_column['name']; ?>" id="<?php echo $rows_column['name']; ?>" <?php if($rows_column['is_nullable'] == 'NO'){echo ' required';} ?> <?php echo $disable; ?>  placeholder="<?php echo 'Input '.$label_name_text; ?>" >
						<?php if($selecttablename != 'name') { ?>
							<option value="<?php echo ${$rows_column['name']}; ?>"><?php echo $this->ortyd->select2_getname(${$rows_column['name']},$table,'id',$selecttablename); ?></option>
						<?php }elseif(${$rows_column['name']} != '') { ?>
							<option value="<?php echo ${$rows_column['name']}; ?>"><?php echo $this->ortyd->select2_getname(${$rows_column['name']},$table,'id','name'); ?></option>
						<?php } ?>
					</select>
																			
					<script>
						$( document ).ready(function() {
															
							$("#"+'<?php echo $rows_column['name']; ?>').select2({	
								width: '100%',
								disabled:'<?php echo $readonlyselect; ?>',								
								ajax: {
									type: "POST",
									url: "<?php echo base_url($headurl.'/select2'); ?>",
									dataType: 'json',
									delay: 250,
									data: function (params) {
										return {
											q: params.term, // search term
											table: '<?php echo $table; ?>',
											<?php if($reference != ''){ ?>
												reference: $("#<?php echo $reference; ?>").val(), // search term
											<?php } ?>
											id:'<?php echo $selecttableid; ?>',
											name:'<?php echo $selecttablename; ?>',
											page: params.page,
											csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"
										};
									},
									processResults: function (data, params) {
										params.page = params.page || 1;
										return {
											results: $.map(data.items, function (item) {
												return {
													id: item.id,
													text: item.name
												}
											}),
											pagination: {
												more: (params.page * 30) < data.total_count
											}
										};
									},
									cache: true
								},
								placeholder: 'Pilih ' + '<?php echo $label_name_text; ?>'
							}).on("select2:select", function(e) { 
																
							})
						})
					</script>
		
				</div>
			</div>
			
		</div>
	</div>