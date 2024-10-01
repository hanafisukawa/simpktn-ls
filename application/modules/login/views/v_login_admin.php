<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page bg image-->
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid flex-lg-row">
				<!--begin::Aside-->
				<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
					<!--begin::Aside-->
					<div class="d-flex flex-center flex-lg-start flex-column">
						<!--begin::Logo-->
						<a href="#" class="mb-7">
							<img alt="Logo" style="max-width:300px" src="<?php echo base_url(); ?>logo-white.png" />
						</a>
						<!--end::Logo-->
						<!--begin::Title-->
						<h2 class="text-white fw-normal m-0">
							STAR PINS
						</h2>
						<!--end::Title-->
					</div>
					<!--begin::Aside-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
					<!--begin::Card-->
					<div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
						<!--begin::Wrapper-->
						<div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
							<!--begin::Form-->
							<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="" action="<?php echo $action; ?>" method="POST">
								<!--begin::Heading-->
								<div class="text-center mb-11">
									<!--begin::Title-->
									<h1 class="text-dark fw-bolder mb-3">
										STAR PINS akan membantu komunikasi pekerjaan anda dengan kami lebih cepat dan efektif.
									</h1>
									<!--end::Title-->
									<!--begin::Subtitle-->
									<div class="text-gray-500 fw-semibold fs-6">Login Akun Anda Sekarang !</div>
									<!--end::Subtitle=-->
								</div>
								<!--begin::Heading-->
								<!--begin::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Email-->
									<input type="text" placeholder="Masukan Alamat Email/Username Terdaftar" name="username" autocomplete="off" class="form-control form-control-sm bg-transparent" required />
									<!--end::Email-->
								</div>
								<!--end::Input group=-->
								<div class="fv-row mb-3">
									<!--begin::Password-->
									<input type="password" placeholder="Masukan Password Terdaftar" name="password" autocomplete="off" class="form-control form-control-sm bg-transparent" required />
									
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" required />
									<!--end::Password-->
								</div>
								<!--end::Input group=-->
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<div></div>
									<!--begin::Link-->
									<a href="#" class="link-primary">Lupa Password ?</a>
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Submit button-->
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
										<!--begin::Indicator label-->
										<span class="indicator-label">Masuk dan Akses Dashboard Anda</span>
										<!--end::Indicator label-->
										<!--begin::Indicator progress-->
										<span class="indicator-progress">Menunggu ...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										<!--end::Indicator progress-->
									</button>
								</div>
								<!--end::Submit button-->
								<!--begin::Sign up-->
								
								<!--end::Sign up-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->


	
	<script>
	
	$( document ).ready(function() {
		

		window.setTimeout( function() {
		  window.location.reload();
		}, 500000);
		
		$('#wrapper').height($(window).height());
		$('.card').height($(window).height() - 20);
		$('.card-body').height($(window).height() - 20);

		
	});

	function popuppem(){
		Swal.fire({
		  title: 'Pemberitahuan !',
		  text: 'Untuk mendapatkan username dan password atau mereset password dapat melalui administrator - ARSITAG',
		  imageUrl: '<?php echo base_url('logo.jpg'); ?>',
		  imageWidth: 400,
		  imageHeight: 200,
		  imageAlt: 'ARSITAG - BTPNS',
		})
	}
		
	
	
	 $(function() {
		 
      $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
		
         "use strict";
         $('input[type="checkbox"]').on('change', function(){
                $(this).parent().toggleClass("active")
                $(this).closest(".media").toggleClass("active");
            }); 
        $(window).on("load", function(){
            /* loading screen */
            $(".loader_wrapper").fadeOut("slow");
        });
		
		<?php 
		
		if(isset($_GET['message'])){
			if($_GET['message'] == 'error'){
		?>
			$.notify({
				title:"",
				message: '<i class="fa fa-times-circle"></i> Login error, Username or password error',
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
			}elseif($_GET['message'] == 'banned'){
		?>
			$.notify({
				title:"",
				message: '<i class="fa fa-times-circle"></i> Login error, Login Banned',
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
			}elseif($_GET['message'] == 'createerrors'){
		?>
			$.notify({
				title:"",
				message: '<i class="fa fa-times-circle"></i> ' + '<?php echo $_GET['errors']?>',
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
			}elseif($_GET['message'] == 'validate'){
		?>
			$.notify({
				title:"",
				message: '<i class="fa fa-times-circle"></i> Username/Email has not been activated',
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
			}elseif($_GET['message'] == 'success'){
		?>
			$.notify({
				title:"",
				message: '<i class="fa fa-times-circle"></i> Account Created, Please wait to validate admin',
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
			}
		}
	?>
	
					
    </script>
	