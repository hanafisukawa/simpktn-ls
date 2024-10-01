<!--begin::Navbar-->
							<div class="card mb-6 mb-xl-9">
								<div class="card-body pt-9 pb-0">
									<!--begin::Details-->
									<div class="row no-margin">
										
										<div class="col-lg-12">
											<!--begin::Head-->
											<div class="row" style="    margin-bottom: 5px;">
												<!--begin::Details-->
												
												<!--begin::Wrapper-->
										
												<div class="col-lg-10">
												
												
													<!--begin::Status-->
													<div style="font-size: 10px;" class="text-gray-400" id="header_lop_funnel"></div>
													<div class="d-flex align-items-center mb-1">
														<a href="javascript:;" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3" id="header_lop_no">-</a>
														<span class="badge me-auto" id="header_lop_nama">-</span>
													</div>
													
													<!--end::Status-->
													<!--begin::Description-->
													<span class="symbol-group symbol-hover mb-3" id="header_spph_mitra">
													<!--begin::User-->
													
													<!--end::User-->
	
													</span>
													
													<!--end::Description-->
													
													
												
												</div>
												

												<div class="col-lg-2" id="btn-aksi-submit">
												
												</div>
												<!--end::Details-->
											</div>
											<!--end::Head-->

										</div>
										<!--end::Wrapper-->
									</div>
									<!--end::Details-->
									<div class="separator"></div>
									<!--begin::Nav-->
									<ul id="header_lop_menu" class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
									
									</ul>
									<!--end::Nav-->
								</div>
							</div>
							<!--end::Navbar-->
							
<script>
							
$( document ).ready(function() {
	$('#btn-aksi-action').hide();
	$('#btn-aksi-submit').html($('#btn-aksi-action').html())
	$('#btn-aksi-action').html('')
})

function getHeaderLOP(id,tipe,iddata = null){
	$.post('<?php echo base_url('data_lop/getheaderlop'); ?>',{ 
		lop_id : id, 
		tipe : tipe, 
		iddata : iddata,
		csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>" 
	}, function (data) {
		var obj = data
		
		if(obj.message == "success"){
			var datanya = obj.data;
			console.log(datanya)
			$("#header_lop_menu").html(datanya.lop_menu);
			$("#header_lop_no").html(datanya.lop_no);
			$("#header_lop_nama").html(datanya.lop_nama);
			$("#header_lop_funnel").html(datanya.lop_funnel);
		}else{
			
		}
	}, 'json');
}


</script>
