<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">
			<i class="<?php echo $this->ortyd->getIconMenu($module); ?>"></i>
			<?php echo $title; ?>
		</h4>
	</div>
	<div class="col-md-7 align-self-center text-right">
		<div class="d-flex justify-content-end align-items-center">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="breadcrumb-item active"><?php echo $title; ?></li>
				</ol>
		</div>
	</div>
</div>

	<?php

		$username = '';
		$password = '';
		$email = '';
		$gid = '';
		$active = 1;
		$banned = 0;
		$notelp = '';
		$fullname = '';
		$signature = '';
		$user_id_ref = '';
		
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
						$username = $rows->username;
						$password = null;
						$email = $rows->email;
						$gid = $rows->gid;
						$active = $rows->active;
						$banned = $rows->banned;
						$notelp = $rows->notelp;
						$fullname = $rows->fullname;
						$signature = $rows->signature;
						$user_id_ref = $rows->user_id_ref;
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
				
					<form id="dataForm"  method="POST" action="<?php echo $action; ?>" enctype="multipart/form-data">
							
							
							<div class="col-md-12 ">	
									
									<div class="form-group row">
										<div class="col-lg-5 col-md-5">
										
											<div class="col-lg-12 col-md-12 form-group">
												<label>Cover/Photo</label><br>
												<div class="dropzone text-center align-items-center" id="coverupload">
													<div class="dz-default dz-message" data-dz-message>
														<h3 class="mb-0"><i class="fa fa-cloud-download"></i></h3><p>Upload Image Cover</p>
													</div>
												</div>
											</div>
											
											<div class="col-lg-12 col-md-12 form-group" style="display:none">
												<label>Role *</label>
												<select class="form-control form-control-sm" name="gid" id="gid" required>
													<?php if($gid != '') { ?>
														<option value="<?php echo $gid; ?>">
															<?php echo $this->ortyd->select2_getname($gid,'users_groups','id','name'); ?>
														</option>
													<?php } ?>
												</select>
											</div>
											
											<div class="col-lg-12 col-md-12 form-group">
												<label>Username *</label>
												 <input type="text" name="username" class="form-control form-control-sm" value="<?php echo $username; ?>" aria-label="taxt rate" required readonly /> 
												
											</div>
										
											
											<div class="col-lg-12 col-md-12 form-group">
												<label>Password </label>
												 <input type="password" name="password" class="form-control form-control-sm" value="<?php echo $password; ?>" aria-label="taxt rate" /> 
												
											</div>
											
											<div class="col-lg-12 col-md-12 form-group" id="user_ref">   
													<label>User Referensi</label>
													<select class="form-control form-control-sm" name="user_id_ref" id="user_id_ref">
														<?php if($user_id_ref != '') { ?>
															<option value="<?php echo $user_id_ref; ?>">
																<?php echo $this->ortyd->select2_getname($user_id_ref,'users_data','id','fullname'); ?>
															</option>
														<?php } ?>
													</select>
											</div>
											
											<div class="col-lg-12 col-md-12 form-group">   
												<img style="width: 100%;" src="<?php echo $signature; ?>" />
											</div>
	
										</div>
										
										<div class="col-lg-7 col-md-7">
										
											
											<div class="col-lg-12 col-md-12 form-group">
												<label>Fullname *</label>
												 <input type="text" name="fullname" class="form-control form-control-sm" value="<?php echo $fullname; ?>" aria-label="taxt rate" required /> 
												
											</div>
											
												
											<div class="col-lg-12 col-md-12 form-group">
												<label>Email *</label>
												 <input type="email" name="email" class="form-control form-control-sm" value="<?php echo $email; ?>" aria-label="taxt rate" required readonly /> 
												
											</div>
											
											
											<div class="col-lg-12 col-md-12 form-group">
												<label>No. Telp *</label>
												 <input type="text" name="notelp" class="form-control form-control-sm" value="<?php echo $notelp; ?>" aria-label="taxt rate" required /> 
												
											</div>
															
											<div class="col-lg-12 col-md-12 form-group">   
												 <div id="signature-padi" class="m-signature-pad" style="border: 1px solid #000;">
													<div id="anoyaro"> FILL IN SIGNATURE USING MOUSE COURSOR </div>
													<div class="m-signature-pad--body">
													  <canvas style="width:100% !Important;height:300px !Important"></canvas>
													</div>
													<div class="m-signature-pad--footer">
													  <button type="button" class="button clear" data-action="clear">BERSIHKAN</button>
													</div>
													<input type="text" name="signature" id="signature-img" value="<?php echo $signature; ?>" style="display:none"/>
												  </div>
											</div>

											<fieldset class="col-lg-12 col-md-12 form-group" style="display:none">
												<label>Banned</label>
												<div class="form-check">
													<label class="">
													<input type="radio" class="form-check-input" name="banned" value="1" <?php if($banned == 1){echo 'checked="checked"';} ?>>
															<span class="radio-icon fuse-ripple-ready"></span>
															<span>Banned</span>
													</label>
												 </div>
												<div class="form-check">
													<label class="">
													<input type="radio" class="form-check-input" name="banned" value="0" <?php if($banned == 0){echo 'checked="checked"';} ?>>
														<span class="radio-icon fuse-ripple-ready"></span>
														<span>Not Banned</span>
													</label>
												</div>
											 </fieldset>
											
											<fieldset class="col-lg-12 col-md-12 form-group" style="display:none">
												<label>Status</label>
												<div class="form-check">
													<label class="">
													<input type="radio" class="form-check-input" name="active" value="1" <?php if($active == 1){echo 'checked="checked"';} ?>>
															<span class="radio-icon fuse-ripple-ready"></span>
															<span>Active</span>
													</label>
												 </div>
												<div class="form-check">
													<label class="">
													<input type="radio" class="form-check-input" name="active" value="0" <?php if($active == 0){echo 'checked="checked"';} ?>>
														<span class="radio-icon fuse-ripple-ready"></span>
														<span>Not Active</span>
													</label>
												</div>
											 </fieldset>
											 
										</div>
										
									</div>
									
									
									
									
							</div>
			
							
							<div class="card-footer">
								<a href="<?php echo base_url($headurl); ?>" class="btn btn-danger fuse-ripple-ready">
									<i class="fa fa-undo"></i> Kembali
								</a>
							
								<button type="button" class="btn btn-primary fuse-ripple-ready pull-right" onClick="save()">
									<i class="fa fa-save"></i> Kirim
								</button>
							</div>
							
					</form>
				</div>
			</div>
		</div>
	</div>
</div>




<script>


function save(){
	
	var dataURL = canvas.toDataURL();

	if(dataURL == 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAnAAAACWCAYAAABekbUVAAAHwUlEQVR4Xu3WQQ0AAAwCseHf9HRc0ikgZQ92jgABAgQIECBAICWwVFphCRAgQIAAAQIEzoDzBAQIECBAgACBmIABFytMXAIECBAgQICAAecHCBAgQIAAAQIxAQMuVpi4BAgQIECAAAEDzg8QIECAAAECBGICBlysMHEJECBAgAABAgacHyBAgAABAgQIxAQMuFhh4hIgQIAAAQIEDDg/QIAAAQIECBCICRhwscLEJUCAAAECBAgYcH6AAAECBAgQIBATMOBihYlLgAABAgQIEDDg/AABAgQIECBAICZgwMUKE5cAAQIECBAgYMD5AQIECBAgQIBATMCAixUmLgECBAgQIEDAgPMDBAgQIECAAIGYgAEXK0xcAgQIECBAgIAB5wcIECBAgAABAjEBAy5WmLgECBAgQIAAAQPODxAgQIAAAQIEYgIGXKwwcQkQIECAAAECBpwfIECAAAECBAjEBAy4WGHiEiBAgAABAgQMOD9AgAABAgQIEIgJGHCxwsQlQIAAAQIECBhwfoAAAQIECBAgEBMw4GKFiUuAAAECBAgQMOD8AAECBAgQIEAgJmDAxQoTlwABAgQIECBgwPkBAgQIECBAgEBMwICLFSYuAQIECBAgQMCA8wMECBAgQIAAgZiAARcrTFwCBAgQIECAgAHnBwgQIECAAAECMQEDLlaYuAQIECBAgAABA84PECBAgAABAgRiAgZcrDBxCRAgQIAAAQIGnB8gQIAAAQIECMQEDLhYYeISIECAAAECBAw4P0CAAAECBAgQiAkYcLHCxCVAgAABAgQIGHB+gAABAgQIECAQEzDgYoWJS4AAAQIECBAw4PwAAQIECBAgQCAmYMDFChOXAAECBAgQIGDA+QECBAgQIECAQEzAgIsVJi4BAgQIECBAwIDzAwQIECBAgACBmIABFytMXAIECBAgQICAAecHCBAgQIAAAQIxAQMuVpi4BAgQIECAAAEDzg8QIECAAAECBGICBlysMHEJECBAgAABAgacHyBAgAABAgQIxAQMuFhh4hIgQIAAAQIEDDg/QIAAAQIECBCICRhwscLEJUCAAAECBAgYcH6AAAECBAgQIBATMOBihYlLgAABAgQIEDDg/AABAgQIECBAICZgwMUKE5cAAQIECBAgYMD5AQIECBAgQIBATMCAixUmLgECBAgQIEDAgPMDBAgQIECAAIGYgAEXK0xcAgQIECBAgIAB5wcIECBAgAABAjEBAy5WmLgECBAgQIAAAQPODxAgQIAAAQIEYgIGXKwwcQkQIECAAAECBpwfIECAAAECBAjEBAy4WGHiEiBAgAABAgQMOD9AgAABAgQIEIgJGHCxwsQlQIAAAQIECBhwfoAAAQIECBAgEBMw4GKFiUuAAAECBAgQMOD8AAECBAgQIEAgJmDAxQoTlwABAgQIECBgwPkBAgQIECBAgEBMwICLFSYuAQIECBAgQMCA8wMECBAgQIAAgZiAARcrTFwCBAgQIECAgAHnBwgQIECAAAECMQEDLlaYuAQIECBAgAABA84PECBAgAABAgRiAgZcrDBxCRAgQIAAAQIGnB8gQIAAAQIECMQEDLhYYeISIECAAAECBAw4P0CAAAECBAgQiAkYcLHCxCVAgAABAgQIGHB+gAABAgQIECAQEzDgYoWJS4AAAQIECBAw4PwAAQIECBAgQCAmYMDFChOXAAECBAgQIGDA+QECBAgQIECAQEzAgIsVJi4BAgQIECBAwIDzAwQIECBAgACBmIABFytMXAIECBAgQICAAecHCBAgQIAAAQIxAQMuVpi4BAgQIECAAAEDzg8QIECAAAECBGICBlysMHEJECBAgAABAgacHyBAgAABAgQIxAQMuFhh4hIgQIAAAQIEDDg/QIAAAQIECBCICRhwscLEJUCAAAECBAgYcH6AAAECBAgQIBATMOBihYlLgAABAgQIEDDg/AABAgQIECBAICZgwMUKE5cAAQIECBAgYMD5AQIECBAgQIBATMCAixUmLgECBAgQIEDAgPMDBAgQIECAAIGYgAEXK0xcAgQIECBAgIAB5wcIECBAgAABAjEBAy5WmLgECBAgQIAAAQPODxAgQIAAAQIEYgIGXKwwcQkQIECAAAECBpwfIECAAAECBAjEBAy4WGHiEiBAgAABAgQMOD9AgAABAgQIEIgJGHCxwsQlQIAAAQIECBhwfoAAAQIECBAgEBMw4GKFiUuAAAECBAgQMOD8AAECBAgQIEAgJmDAxQoTlwABAgQIECBgwPkBAgQIECBAgEBMwICLFSYuAQIECBAgQMCA8wMECBAgQIAAgZiAARcrTFwCBAgQIECAgAHnBwgQIECAAAECMQEDLlaYuAQIECBAgAABA84PECBAgAABAgRiAgZcrDBxCRAgQIAAAQIGnB8gQIAAAQIECMQEDLhYYeISIECAAAECBAw4P0CAAAECBAgQiAkYcLHCxCVAgAABAgQIGHB+gAABAgQIECAQEzDgYoWJS4AAAQIECBAw4PwAAQIECBAgQCAmYMDFChOXAAECBAgQIGDA+QECBAgQIECAQEzAgIsVJi4BAgQIECBAwIDzAwQIECBAgACBmIABFytMXAIECBAgQICAAecHCBAgQIAAAQIxAQMuVpi4BAgQIECAAIEHT64AlxItUlEAAAAASUVORK5CYII='){
		//$('#signature-img').val('');
	}else{
		$('#signature-img').val(dataURL);
	}
	
	
	$.ajax({
	  type: 'POST',
	  url: $("#dataForm").attr("action"),
	  data: $("#dataForm").serialize(), 
	  //or your custom data either as object {foo: "bar", ...} or foo=bar&...
	  success: function(response) { 
		var obj = JSON.parse(response);
		if(obj.message == 'success'){
			window.location.href = "<?php echo base_url('users_data/view?message=success');?>"
		}else{
			window.location.href = "<?php echo base_url('users_data/view?message=error');?>"
		}

	  },
	});
}

var wrapper = document.getElementById("signature-padi"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    saveButton = wrapper.querySelector("[data-action=save]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas);

clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
});



	$(document).ready(function() {
		
		
		<?php 
					if(isset($_GET['message'])){
						if($_GET['message'] == 'success'){
					?>
						$.notify({
							title:"",
							message: '<i class="fa fa-check-circle"></i> Saving data success',
							},{
							// settings
							element: 'body',
							position: null,
							type: "success",
						   placement: {
								from: "bottom",
								align: "right"
							}
						});     
					
					<?php
						}else{
					?>

						$.notify({
							title:"",
							message: '<i class="fa fa-times-circle"></i> Saving data error',
							},{
							// settings
							element: 'body',
							position: null,
							type: "danger",
						   placement: {
								from: "bottom",
								align: "right"
							}
						});     
						
					<?php
						}
					}
					?>
					
		$('#area_provinsi_id').prop('disabled', true);
		$('#area_kota_id').prop('disabled', true);
		$('#gid').prop('disabled', true);
		

		$("#area_provinsi_id").select2({	
		ajax: {
			type: "POST",
			url: "<?php echo base_url($headurl.'/select2_area_provinsi'); ?>",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
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
		placeholder: 'Search for a Provinsi'
	}).on("select2:select", function(e) { 
		$('#area_kota_id').val(0).trigger('change');
	})
	
	$("#area_kota_id").select2({	
		ajax: {
			type: "POST",
			url: "<?php echo base_url($headurl.'/select2_area_kota'); ?>",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, // search term
					provinsi_id: $('#area_provinsi_id').val(),
					page: params.page
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
		placeholder: 'Search for a Kab/Kota'
	}).on("select2:select", function(e) { 

	})
	
	$("#user_id_ref").select2({	
		width : '100%',
		multiple: false,
		ajax: {
			type: "POST",
			url: "<?php echo base_url($headurl.'/select2_user_ref'); ?>",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, // search term
					kota_id: $('#area_kota_id').val(),
					page: params.page
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
		placeholder: 'Search for a User Referensi'
	}).on("select2:select", function(e) { 
		
	})
		
			$("#gid").select2({
			
				ajax: {
					type: "POST",
					url: "<?php echo base_url($headurl.'/select2_gid'); ?>",
							dataType: 'json',
							delay: 250,
							data: function (params) {
							  return {
								q: params.term, // search term
								page: params.page
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
						  placeholder: 'Search for a Role'
				})
				
	});
	
	
	Dropzone.autoDiscover = false;
	var limit = 0;
					
	var foto_upload_cover= new Dropzone("#coverupload",{
			url: "<?php echo base_url($headurl.'/proses_upload') ?>",
			maxFiles: 1,
			maxFilesize: 1000,
			method:"post",
			acceptedFiles:"image/*",
			createImageThumbnails: true,
			paramName:"userfile",
			dictInvalidFileType:"Type file ini tidak dizinkan",
			addRemoveLinks:true,
			thumbnailWidth:"250",
            thumbnailHeight:"250",
			init: function() {
				this.on("maxfilesexceeded", function(file){
					limit = 1;
				});
				this.on("success", function(file, response) {
					if(limit == 0){
						var obj = $.parseJSON(response)
						//console.log(obj.message);
						$('#dataForm').append('<input style="display:none" type="text" id="cover' + obj.id +'" class="form-control form-control-sm" name="cover" value="' + obj.id +'" />');
					}			
				})
			}
	});
	
	//Event ketika Memulai mengupload
	foto_upload_cover.on("sending",function(a,b,c){
		a.token=Math.random();
		c.append("token_foto",a.token); //Menmpersiapkan token untuk masing masing foto
	});
	
	//Event ketika foto dihapus
	foto_upload_cover.on("removedfile",function(a){
		
		bootbox.confirm({
			message: "Are you sure delete permanently this cover ? ",
			buttons: {
				confirm: {
					label: 'Yes',
					className: 'btn-success'
				},
				cancel: {
					label: 'No',
					className: 'btn-danger'
				}
			},
			callback: function (result) {
				
				if(result == true){
					var token=a.token;	
					$.ajax({
						type:"post",
						data:{token:token,id:<?php echo $iddata; ?>},
						url:"<?php echo base_url($headurl.'/remove_foto') ?>",
						cache:false,
						dataType: 'json',
						success: function(data){
							//console.log(data);
							document.getElementById("cover" + data.id).remove();
						},
						error: function(){
							console.log("Error");
						}
					});
				}else{
					
					
					$.post('<?php echo base_url($headurl.'/getcover'); ?>',{id : <?php echo $iddata; ?>}, function (data) {
						if(data != 'null'){
							var obj = jQuery.parseJSON(data);
							console.log(obj[0].name);
							for (var key in obj) {
								var mockFile = { name: obj[key].name, size: obj[key].size, token: obj[key].token };
								foto_upload_cover.options.addedfile.call(foto_upload_cover, mockFile);
								foto_upload_cover.options.thumbnail.call(foto_upload_cover, mockFile, "<?php echo base_url(); ?>" + obj[key].path);
								foto_upload_cover.emit("complete", mockFile);
							}
						}
					});
	
				}
				
		
			}
		});


	});
	
	
	
	$.post('<?php echo base_url($headurl.'/getcover'); ?>',{id : <?php echo $iddata; ?>}, function (data) {
						
		if(data != 'null'){
			var obj = jQuery.parseJSON(data);
			console.log(obj[0].name);
			for (var key in obj) {
				var mockFile = { name: obj[key].name, size: obj[key].size, token: obj[key].token };
				foto_upload_cover.options.addedfile.call(foto_upload_cover, mockFile);
				foto_upload_cover.options.thumbnail.call(foto_upload_cover, mockFile, "<?php echo base_url(); ?>" + obj[key].path);
				foto_upload_cover.emit("complete", mockFile);
			}
		}
	});
	
</script>