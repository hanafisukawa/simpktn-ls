
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
						
							<!--begin::Row-->
							<div class="row gx-6 gx-xl-9">
								<!--begin::Col-->
								<div class="col-lg-12">
									<!--begin::Summary-->
									<div class="card card-flush h-lg-100">

										<!--begin::Card body-->
										<div class="card-body p-9 pt-5">
				
					<form id="Form" class="form-material"  method="POST" action="<?php echo $action; ?>" enctype="multipart/form-data">
							
							<div class="col-md-12 ">	
								<div class="row">
										
										<div class="col-lg-12 col-md-12">
											
											<div class="col-lg-16 col-md-12 form-group">
												<label>Password Anda Sekarang <span toggle="#password-field-old" class="fa fa-fw fa-eye field-icon toggle-password"></span></label>
												 <input style="text-transform: none !important;" id="password-field-old" type="password" name="passwordlama" class="form-control form-control-sm" required placeholder="Password Lama" /> 
												 
												
												
											</div>
											
											<div class="col-lg-16 col-md-12 form-group">
												<label>Password Baru <span toggle="#password-field-new" class="fa fa-fw fa-eye field-icon toggle-password"></span></label>
												 <input style="text-transform: none !important;" id="password-field-new" type="password" name="password" class="form-control form-control-sm" minlength=8 required placeholder="Password Baru"  /> 
												
												
												 
											</div>
											
											<div class="col-lg-16 col-md-12 form-group">
												<label>Konfirmasi Password Baru  <span toggle="#password-field-conf" class="fa fa-fw fa-eye field-icon toggle-password"></span></label>
												 <input style="text-transform: none !important;" id="password-field-conf" type="password" name="konfirmasi" class="form-control form-control-sm" minlength=8 required placeholder="Password Baru Konfirmasi" /> 
												
												
												 
											</div>
											
											<div class="col-lg-16 col-md-12 form-group" style="    font-size: 13px;
    padding: 10px;
    font-style: italic;">
												  Password Baru dan Password harus sama<br>
												  Password Harus minimal 8 Karakter<br>
												  Password Membutuhkan minimal 1 Hurup Kecil<br>
												  Password Membutuhkan minimal 1 Hurup Kapital<br>
												  Password Membutuhkan minimal 1 Angka<br>
											</div>
											
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" required />
											
										</div>
									</div>
							</div>
							
							<div class="card-footer">
								<button type="button" id="submitdata" class="btn btn-primary fuse-ripple-ready">
									<i class="fa fa-save"></i> Ganti Password
								</button>
							</div>
							
					</form>
				</div>
			</div>
		</div>
	</div>
		</div>
	</div>
<script>
	<?php 
	
	if(isset($_GET['message'])){
			if($_GET['message'] == 'success'){
		?>
			$.notify({
				title:"",
				message: '<i class="fa fa-check-circle"></i> Change password success',
				},{
							// settings
				element: 'body',
				position: null,
				type: "success",
				placement: {
					from: "top",
					align: "center"
				}
			});     
						
		<?php
			}elseif($_GET['message'] == 'passerror'){
		?>
			$.notify({
				title:"",
				message: '<i class="fa fa-check-circle"></i> Old password is wrong',
				},{
							// settings
				element: 'body',
				position: null,
				type: "danger",
				placement: {
					from: "top",
					align: "center"
				}
			});     
						
		<?php
			}elseif($_GET['message'] == 'passerrornosame'){
		?>
			$.notify({
				title:"",
				message: '<i class="fa fa-check-circle"></i> Confirmation password not match',
				},{
							// settings
				element: 'body',
				position: null,
				type: "danger",
				placement: {
					from: "top",
					align: "center"
				}
			});     
						
		<?php
			}elseif($_GET['message'] == 'error'){
		?>
			$.notify({
				title:"",
				message: '<i class="fa fa-check-circle"></i> Change password error',
				},{
							// settings
				element: 'body',
				position: null,
				type: "danger",
				placement: {
					from: "top",
					align: "center"
				}
			});     
						
		<?php
			}
		}
	?>
	
	
	$(".toggle-password").click(function() {

	  $(this).toggleClass("fa-eye fa-eye-slash");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
		input.attr("type", "text");
	  } else {
		input.attr("type", "password");
	  }
	});
	
			
					
			var forminput = document.getElementById('Form');
			const submitButton = document.getElementById('submitdata');
			submitButton.addEventListener('click', function (e) {
				var requiredattrdata = [];
				var datanya;
				var requiredattr = 0;
				Swal.fire({
				  title: "Apakah anda yakin akan mengirim data ?",
				  showDenyButton: false,
				  showCancelButton: true,
				  confirmButtonText: "Iya",
				  cancelButtonText: "Tidak",
				  //denyButtonText: `Don't save`
				}).then((result) => {
				  /* Read more about isConfirmed, isDenied below */
				  if (result.isConfirmed) {
					
					loadingopen()
				
					// Prevent default button action
					e.preventDefault();
					var error = false;
					var message = '';
					
					for(var i=0; i < forminput.elements.length; i++){
						if((forminput.elements[i].value === '' && forminput.elements[i].hasAttribute('required')) || (forminput.elements[i].value === '0' && forminput.elements[i].hasAttribute('required')) || (forminput.elements[i].value == 0 && forminput.elements[i].hasAttribute('required')) || (forminput.elements[i].value == 'Rp. 0' && forminput.elements[i].hasAttribute('required')) ){
							console.log(forminput.elements[i].attributes)
							datanya = forminput.elements[i].attributes['placeholder'].nodeValue;
							datanya = datanya.replaceAll(/<\/[^>]+(>|$)/g, "");
							requiredattrdata.push(stripHtml(datanya) + '<br>')
							requiredattr = 1;
						}
					}
					
					x = $('#password-field-conf').val();
					y = $('#password-field-new').val();
					console.log(y.search(/[a-z]/))
					
					if (y != x) {
					  message = "password Baru dan Password Baru Konfirmasi tidak sama";
					  datanya = message;
					  datanya = datanya.replaceAll(/<\/[^>]+(>|$)/g, "");
					  requiredattrdata.push(stripHtml(datanya) + '<br>')
					  requiredattr = 1;
					}
					if (y.length < 8) {
					  message = "Password Harus minimal 8 Karakter ";
					  datanya = message;
					  datanya = datanya.replaceAll(/<\/[^>]+(>|$)/g, "");
					  requiredattrdata.push(stripHtml(datanya) + '<br>')
					  requiredattr = 1;
					}
					if (y.search(/[a-z]/) == -1) {
					  message = "Password Membutuhkan minimal 1 Hurup Kecil";
					  datanya = message;
					  datanya = datanya.replaceAll(/<\/[^>]+(>|$)/g, "");
					  requiredattrdata.push(stripHtml(datanya) + '<br>')
					  requiredattr = 1;
					}
					if (y.search(/[A-Z]/) == -1) {
					  message = "Password Membutuhkan minimal 1 Hurup Kapital";
					  datanya = message;
					  datanya = datanya.replaceAll(/<\/[^>]+(>|$)/g, "");
					  requiredattrdata.push(stripHtml(datanya) + '<br>')
					  requiredattr = 1;
					}
					if (y.search (/[0-9]/) == -1) {
					  message = "Password Membutuhkan minimal 1 Angka";
					  datanya = message;
					  datanya = datanya.replaceAll(/<\/[^>]+(>|$)/g, "");
					  requiredattrdata.push(stripHtml(datanya) + '<br>')
					  requiredattr = 1;
					}


					if(requiredattr == 0){
						$.post('<?php echo $action; ?>', $('#Form').serialize(),function (data) {
						console.log(data)
							if(data.status == "success"){
								
								Swal.fire({
									text: "Data berhasil disimpan!",
									icon: "success",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								});
								
								//getField()
								loadingclose()
								
								setTimeout(() => {
									window.location.href = '<?php echo base_url(); ?>'; //Will take you to Google.
								}, 2000);
								
							}else{
								
								Swal.fire({
									text: "Data tidak berhasil disimpan! " + data.errors,
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Tutup",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								});
								
								//getField()
								loadingclose()
								
							}
						}, 'json');
					}else{
						
						console.log(requiredattrdata.toString())
						datanya = requiredattrdata.toString().replaceAll(",","");
						Swal.fire({
							html: "Masih ada data belum terisi:<br>" +datanya,
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Lanjutkan Pengisian",
							customClass: {
								confirmButton: "btn btn-primary"
							}
						});
						
						//getField()
						loadingclose()
					}
				
				  } else if (result.isDenied) {
					Swal.fire("Changes are not saved", "", "info");
				  }
				});
			
			})

	
	</script>
	
	