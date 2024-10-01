<!--begin::Toolbar-->
<div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
	<!--begin::Container-->
	<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
		<!--begin::Page title-->
		<div class="page-title d-flex flex-column me-3">
			<!--begin::Title-->
			<h1 class="d-flex text-white fw-bold my-1 fs-3"><?php echo $title; ?></h1>
			<!--end::Title-->
			<!--begin::Breadcrumb-->
			<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
				<!--begin::Item-->
				<li class="breadcrumb-item text-white opacity-75">
					<a href="<?php echo base_url(); ?>" class="text-white text-hover-primary">Home</a>
				</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item">
					<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
				</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item text-white opacity-75">
					<?php echo $title; ?>
				</li>
				<!--end::Item-->
			</ul>
			<!--end::Breadcrumb-->
		</div>
		<!--end::Page title-->
	</div>
	<!--end::Container-->
</div>
<!--end::Toolbar-->

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
	<!--begin::Post-->
	<div class="content flex-row-fluid" id="kt_content">
		<div class="card">
			<div class="row">
				<div class="col-sm-12">
					<div class="card-header tabbable" style="padding:0">
						<ul  class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" role="tablist" style="margin:0;margin-left:10px">
							<li class="nav-item mt-2" onClick="get_data(1);"> 
								<a class="nav-link" data-toggle="tab" href="javascript:;" role="tab">
								<i class="fa fa-list-ol"></i> &nbsp;Daftar <?php echo $title; ?></a> 
							</li>
							<li class="nav-item mt-2" onClick="get_data(3);"> 
								<a class="nav-link" data-toggle="tab" href="javascript:;" role="tab">
								<i class="fa fa-check"></i>  &nbsp;Membutuhkan Aktivasi</a> 
							</li>
							<li class="nav-item mt-2" onClick="get_data(2);"> 
								<a class="nav-link" data-toggle="tab" href="javascript:;" role="tab">
								<i class="fa fa-ban"></i>  &nbsp;Banned</a> 
							</li>
							<li class="nav-item mt-2" onClick="get_data(4);"> 
								<a class="nav-link" data-toggle="tab" href="javascript:;" role="tab">
								<i class="fa fa-list"></i>  &nbsp;Aktif</a> 
							</li>
							<li class="nav-item mt-2" onClick="get_data(0);" > 
								<a class="nav-link" data-toggle="tab" href="javascript:;" role="tab">
								<i class="fa fa-trash"></i> &nbsp;Sampah</a> 
							</li>
					</ul>
				</div>
				<div class="card-body">
				
					<div class="table-responsive">
						<table id="datatablett" class="table table-striped align-middle table-row-dashed fs-6 gy-5">
							<thead>
								<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
									<th>Action</th>
									<th>Fullname</th>
									<th>Email</th>
									<th>Role</th>
									<th>Online</th>
									<th>Last Login</th>
									<th>Validate</th>
									<th>Status</th>
								</tr>
							 </thead>
							 <tbody class="text-gray-600 fw-semibold">
							 </tbody>
						</table>
					</div>
					<script type="text/javascript">
						var table;
						var type = 1;
						$(document).ready(function() {
							
							table = $('#datatablett').DataTable({ 
									"drawCallback": function( settings ) {
										 KTMenu.createInstances();
									},
									"rowCallback": function( row, data ) {
												var key = 0;
												for (const theArray in data) {
													if(key == 0){
														$('td:eq('+ key +')', row).addClass('dtkenolbtn');
													} if(key == 1){
														$('td:eq('+ key +')', row).addClass('dtkenol');

														break
													}
													key = key +1
												}

											},
											"responsive": false,
											"scrollY":false,
											"scrollX":true,
											"scrollCollapse":true,
											"dom"	: '<"row"<"col-md-6 text-left"B><"col-md-6 text-right"f>>rt<"row"<"col-md-3"l><"col-md-3 text-right"i><"col-md-6"p>>',
											"buttons" : [ 
											{
												className: 'btn btn-primary',
												text: '<i class="fa fa-copy"></i> Salin',
												extend: 'copy'
											}, 
											{
												text: '<i class="fa fa-download"></i> Download Excel',
												extend: 'excel',
												action: newExportAction
											},
											<?php if($this->ortyd->access_check_insert_data($module)) { ?>
											{
												text: '<i class="fa fa-edit"></i> Buat Baru',
												action: function ( e, dt, node, config ) {
													window.location.href = '<?php echo $linkcreate; ?>';
												}
											},
											<?php } ?>
											],
											"oLanguage" : {
												"sProcessing": "<div class='load1 load-wrapper'><div class='loader'>Getting Data ...</div></div>",
												 "oPaginate" : {
													"sFirst": "<<",
													"sPrevious": "<",
													"sNext": ">", 
													"sLast": ">>" 
												},
												"sSearch": '<i class="fa fa-search"></i>',
												"sSearchPlaceholder": 'Cari ...'
											},
											"fixedColumns":   {
											leftColumns: 2,
										},
										"sPaginationType": "full_numbers",
										"lengthMenu": [[5, 10, 25, 50, 100, 500, 1000], [5, 10, 25, 50, 100, 500, 1000]],
										"processing": true,
										"serverSide": true,
										"order": [],
									"ajax": {
										"url": "<?php echo base_url($linkdata); ?>",
										"type": "POST",
										"data": function ( d ) {
											d.active = type;
											d.csrf_ortyd_vms_name = "<?php echo $this->security->get_csrf_hash(); ?>";
										}
									},
									"columnDefs": [
											{ 
												"targets": [ 0,0 ],
												"width": '10px',
												"orderable": false,
											}
									],
							});
								
								
												 
						});
						
						var oldExportAction = function (self, e, dt, button, config) {
								if (button[0].className.indexOf('buttons-excel') >= 0) {
									if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
										$.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
									}
									else {
										$.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
									}
								} else if (button[0].className.indexOf('buttons-print') >= 0) {
									$.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
								}
							};

							var newExportAction = function (e, dt, button, config) {
								var self = this;
								var oldStart = dt.settings()[0]._iDisplayStart;

								dt.one('preXhr', function (e, s, data) {
									// Just this once, load all data from the server...
									data.start = 0;
									data.length = 2147483647;

									dt.one('preDraw', function (e, settings) {
										// Call the original action function 
										oldExportAction(self, e, dt, button, config);

										dt.one('preXhr', function (e, s, data) {
											// DataTables thinks the first item displayed is index 0, but we're not drawing that.
											// Set the property to what it was before exporting.
											settings._iDisplayStart = oldStart;
											data.start = oldStart;
										});

										// Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
										setTimeout(dt.ajax.reload, 0);

										// Prevent rendering of the full data to the DOM
										return false;
									});
								});

								// Requery the server with the new one-time export settings
								dt.ajax.reload();
							};
						
						function get_data(data){
							type = data;
							table.draw();
						}
						
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
						
						function deletedata(id){
												
							var boxdelete = bootbox.confirm({
								title: "Confirm Action",
								message: "Do you want to delete this data ?",
								buttons: {
									cancel: {
										label: '<i class="fa fa-times"></i> Cancel'
									},
									confirm: {
										label: '<i class="fa fa-check"></i> Confirm'
									}
								},
								callback: function (result) {
									if(result==true){
											$.post('<?php echo base_url($headurl.'/removedata'); ?>',{ id : id }, function (data) {
												if(data.message == "success"){
													table.draw();
													boxdelete.modal('hide'); 
													
													$.notify({
														title:"",
														message: '<i class="fa fa-check-circle"></i> Deleting data success',
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
													
												}else{
													
													table.draw();
													boxdelete.modal('hide'); 
													$.notify({
														title:"",
														message: '<i class="fa fa-times-circle"></i> Deleting data error',
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
													
												}
												
											}, 'json');
																
									}
								}
							});
		
						}
						
						
						function banneddata(id){
												
							var boxdelete = bootbox.confirm({
								title: "Confirm Action",
								message: "Do you want to ban this user ?",
								buttons: {
									cancel: {
										label: '<i class="fa fa-times"></i> Cancel'
									},
									confirm: {
										label: '<i class="fa fa-check"></i> Confirm'
									}
								},
								callback: function (result) {
									if(result==true){
											$.post('<?php echo base_url($headurl.'/banneddata'); ?>',{ id : id }, function (data) {
												if(data.message == "success"){
													table.draw();
													boxdelete.modal('hide'); 
													
													$.notify({
														title:"",
														message: '<i class="fa fa-check-circle"></i> Banned data success',
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
													
												}else{
													
													table.draw();
													boxdelete.modal('hide'); 
													$.notify({
														title:"",
														message: '<i class="fa fa-times-circle"></i> Ban data error',
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
													
												}
												
											}, 'json');
																
									}
								}
							});
		
						}
						
						
						function validatedata(id){
												
							var boxdelete = bootbox.confirm({
								title: "Confirm Action",
								message: "Do you want to activated this user ?",
								buttons: {
									cancel: {
										label: '<i class="fa fa-times"></i> Cancel'
									},
									confirm: {
										label: '<i class="fa fa-check"></i> Confirm'
									}
								},
								callback: function (result) {
									if(result==true){
											$.post('<?php echo base_url($headurl.'/validatedata'); ?>',{ id : id }, function (data) {
												if(data.message == "success"){
													table.draw();
													boxdelete.modal('hide'); 
													
													$.notify({
														title:"",
														message: '<i class="fa fa-check-circle"></i> Activation user success',
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
													
												}else{
													
													table.draw();
													boxdelete.modal('hide'); 
													$.notify({
														title:"",
														message: '<i class="fa fa-times-circle"></i> Activation user  error',
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
													
												}
												
											}, 'json');
																
									}
								}
							});
		
						}
						
						function restoredata(id){
												
							var boxdelete = bootbox.confirm({
								title: "Confirm Action",
								message: "Do you want to restore this data ?",
								buttons: {
									cancel: {
										label: '<i class="fa fa-times"></i> Cancel'
									},
									confirm: {
										label: '<i class="fa fa-check"></i> Confirm'
									}
								},
								callback: function (result) {
									if(result==true){
											$.post('<?php echo base_url($headurl.'/restoredata'); ?>',{ id : id }, function (data) {
												if(data.message == "success"){
													table.draw();
													boxdelete.modal('hide'); 
													
													$.notify({
														title:"",
														message: '<i class="fa fa-check-circle"></i> Restore data success',
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
													
												}else{
													
													table.draw();
													boxdelete.modal('hide'); 
													$.notify({
														title:"",
														message: '<i class="fa fa-times-circle"></i> Restore data error',
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
													
												}
												
											}, 'json');
																
									}
								}
							});
		
						}
						
						function restorebanneddata(id){
												
							var boxdelete = bootbox.confirm({
								title: "Confirm Action",
								message: "Do you want to active this users ?",
								buttons: {
									cancel: {
										label: '<i class="fa fa-times"></i> Cancel'
									},
									confirm: {
										label: '<i class="fa fa-check"></i> Confirm'
									}
								},
								callback: function (result) {
									if(result==true){
											$.post('<?php echo base_url($headurl.'/restorebanneddata'); ?>',{ id : id }, function (data) {
												if(data.message == "success"){
													table.draw();
													boxdelete.modal('hide'); 
													
													$.notify({
														title:"",
														message: '<i class="fa fa-check-circle"></i> Active data success',
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
													
												}else{
													
													table.draw();
													boxdelete.modal('hide'); 
													$.notify({
														title:"",
														message: '<i class="fa fa-times-circle"></i> Active data error',
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
													
												}
												
											}, 'json');
																
									}
								}
							});
		
						}

						</script>
										
				</div>
			</div>
		</div>
	</div>
</div>
</div>
