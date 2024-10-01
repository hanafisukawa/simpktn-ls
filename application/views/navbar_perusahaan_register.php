<!--begin::Navbar-->
							<div class="card mb-6 mb-xl-9">
								<div class="card-body pt-9 pb-0"  style="    padding-top: 10px !important;">
									<!--begin::Details-->
									<div class="d-flex flex-wrap flex-sm-nowrap mb-6 no-margin" style="    margin-bottom: 0 !important;">
										<!--begin::Image-->
										
										<div class="me-7">
											<div class="symbol symbol-100px symbol-lg-100px symbol-fixed position-relative">
												<img  src="<?php echo base_url(); ?>favicon.png" alt="image" />
												
												<div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
											</div>
										</div>
											
										<!--end::Image-->
										<!--begin::Wrapper-->
										<div class="flex-grow-1">
											<!--begin::Head-->
											<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
												<!--begin::Details-->
												<div class="d-flex flex-column">
													<!--begin::Status-->
													<div class="d-flex align-items-center mb-1">
														<a href="javascript:;" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3" id="header_perusahaan_tipe">-</a>
														<span class="badge badge-light-success me-auto" id="header_perusahaan_status">-</span>
													</div>
													<!--end::Status-->
													<!--begin::Description-->
													
													<!--end::Description-->
												</div>
												<div class="d-flex">

														<a style="margin-right:10px;" href="<?php echo base_url().$headurl; ?>" class="btn btn-sm btn-danger "> 
															<i class="fa fa-undo"></i> Kembali
														</a>
														
														<?php if($status_id == 2 || $status_id == 99 || $status_id == 7){ ?>
														
														
														<?php if($status_id == 2 || $status_id == 99 || $status_id == 7){ ?>
														<button id="kt_docs_formvalidation_text_draft" type="button" class="btn btn-sm btn-secondary pull-right">
															<i class="fa fa-save"></i> Simpan
														</button>
														<?php } ?>
														
														<?php if($status_id == 2 || $status_id == 99){ ?>
														<button id="kt_docs_formvalidation_text_submit" type="button" class="btn btn-sm  btn-primary pull-right">
															<i class="fa fa-save"></i> Simpan dan Kirim
														</button>
														<?php }else{ ?>
														<button id="kt_docs_formvalidation_text_submit" type="button" class="btn btn-sm  btn-primary pull-right" style="display:none">
															<i class="fa fa-save"></i> Simpan dan Kirim
														</button>
														<?php } ?>
														
														<?php } ?>
													
												</div>
												<!--end::Details-->
											</div>
											<!--end::Head-->
											<!--begin::Info-->
											<div class="d-flex flex-wrap justify-content-start">
												<!--begin::Stats-->
												<div class="d-flex flex-wrap">
													<!--begin::Stat-->
													<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
														
														<!--begin::Label-->
														<div class="fw-semibold fs-6 text-gray-400">Email</div>
														<!--end::Label-->
														
														<!--begin::Number-->
														<div class="d-flex align-items-center">
															<div class="fs-4 fw-bold" id="header_perusahaan_email"></div>
														</div>
														<!--end::Number-->
														
													</div>
													<!--end::Stat-->
													<!--begin::Stat-->
													<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
														
														<!--begin::Label-->
														<div class="fw-semibold fs-6 text-gray-400">Nomor Telepon</div>
														<!--end::Label-->
														
														<!--begin::Number-->
														<div class="d-flex align-items-center">
															<div class="fs-4 fw-bold" id="header_perusahaan_hp"></div>
														</div>
														<!--end::Number-->
														
													</div>
													<!--end::Stat-->

													<!--begin::Stat-->
													<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
														
														<!--begin::Label-->
														<div class="fw-semibold fs-6 text-gray-400">Jenis</div>
														<!--end::Label-->
														
														<!--begin::Number-->
														<div class="d-flex align-items-center">
															<div class="fs-4 fw-bold" id="header_perusahaan_jenis"></div>
														</div>
														<!--end::Number-->
														
													</div>
													<!--end::Stat-->
												</div>
												<!--end::Stats-->
												<!--begin::Users-->
												<div class="symbol-group symbol-hover mb-3" id="header_perusahaan_mitra">
													<!--begin::User-->
													
													<!--end::User-->
	
												</div>
												<!--end::Users-->
											</div>
											<!--end::Info-->
										</div>
										<!--end::Wrapper-->
									</div>
									<!--end::Details-->
									<div class="separator"></div>
									<!--begin::Nav-->
									<div style="overflow: auto;">
										<ul style="width:max-content" id="header_perusahaan_menu" class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
										
										</ul>
									</div>
									<!--end::Nav-->
								</div>
							</div>
							<!--end::Navbar-->
							
							<script>

function getHeaderPerusahaan(id){
	$.post('<?php echo base_url('login/getheaderperusahaan'); ?>',{ 
		id : id, 
		csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>" 
	}, function (data) {
		var obj = data
		
		if(obj.message == "success"){
			var datanya = obj.data;
			console.log(datanya)
			//$("#header_perusahaan_menu").html(datanya.spph_menu);
			$("#header_perusahaan_tipe").html(datanya.perusahaan_nama);
			$("#header_perusahaan_status").html(datanya.status_name);
			$("#header_perusahaan_email").html(datanya.perusahaan_email);
			$("#header_perusahaan_hp").html(datanya.perusahaan_hp);
			$("#header_perusahaan_name").html(datanya.perusahaan_tipe_name);
			$("#header_perusahaan_jenis").html(datanya.perusahaan_jenis_name);

		}else{
			
		}
	}, 'json');
}


</script>
