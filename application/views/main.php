<?php
	$currency = 'IDR';
?>
<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.2.0
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href=""/>
		<title>
			<?php 
				if(isset($title)){ 
					echo $title;
				}else{ 
					echo 'Dashboard';
				}; 
			?> | STAR PINS
		</title> 
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="" />
		<meta property="og:title" content="" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="STAR | PINS" />
		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.png" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>themes/ortyd/vendors/select2/css/select2.min.css" type="text/css" rel="stylesheet">
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/vendors/sweetalert2-main/sweetalert2.min.css" rel="stylesheet">
		
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/vendors/star-rating/dist/star-rating.css" rel="stylesheet">
		
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/css/style.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
		
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/jquery/jquery-3.2.1.min.js"></script>
		<!--begin::Javascript-->
		<script>var hostUrl = "<?php echo base_url(); ?>themes/ortyd/assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/js/scripts.bundle.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/sweetalert2-main/sweetalert2.all.min.js"></script> 
		<script type="text/javascript" src="<?php echo base_url(); ?>themes/ortyd/assets/js/custom/bootbox.min.js" type="text/javascript"></script> 
		<script type="text/javascript" src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/select2/js/select2.min.js" ></script> 
		<script type="text/javascript" src="<?php echo base_url(); ?>themes/ortyd/assets/js/custom/signature_pad.js" type="text/javascript"></script> 
		
		<?php if($this->session->userdata('group_id') == 3){ ?>
		<style>
		
		[data-bs-theme=light] body:not(.app-blank) {
			background-image: url(<?php echo base_url(); ?>themes/ortyd/assets/media/patterns/header-bg-2.jpg) !important;
		}
		

		.menu-atas {
			display:none !important;
		}
		

		
		#kt_body {
			//padding-top:30px;
		}
		
		

		</style>
		<?php }else{ ?>
		<style>
		
		[data-bs-theme=light] body:not(.app-blank) {
			background: #93C6E7;
			//background-image: url('<?php echo 'https://wallpapers.com/images/featured/abstract-background-6m6cjbifu3zpfv84.jpg';?>') !important;
		}
		</style>
		<?php } ?>
		
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/ckeditor/ckeditor.js"></script>
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/fusionchart/fusioncharts.js" type="text/javascript" ></script>
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/fusionchart/fusioncharts.jqueryplugin.js" type="text/javascript" ></script>
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/fusionchart/themes/fusioncharts.theme.fusion.js" type="text/javascript" ></script>
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/star-rating/dist/star-rating.js" type="text/javascript" ></script>
		
		<link href="<?php echo base_url(); ?>themes/ortyd/assets/vendors/progress-bar/loading-bar.min.css" rel="stylesheet">
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/progress-bar/loading-bar.min.js" type="text/javascript"></script> 
		
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-NYSJQS0PNT"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-NYSJQS0PNT');
		</script>


	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header align-items-stretch mb-5 mb-lg-10" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container-xxl d-flex align-items-center">
							<!--begin::Heaeder menu toggle-->
							<div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
								<div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
									<i class="ki-duotone ki-abstract-14 fs-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
							</div>
							<!--end::Heaeder menu toggle-->
							<!--begin::Header Logo-->
							<div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
								<a href="<?php echo base_url(); ?>">
									<img alt="Logo" src="<?php echo base_url(); ?>logo-text.png" class="logo-default h-25px" />
									<img alt="Logo" src="<?php echo base_url(); ?>logo-text.png" class="logo-sticky h-25px" />
								</a>
							</div>
							<!--end::Header Logo-->
							<!--begin::Wrapper-->
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
								
								<?php require_once('navbar.php'); ?>
								
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					
					<!--Begin::Content-->
						<?php require_once($template_contents.'.php'); ?>
					<!--End::Content-->
					
					<!--begin::Footer-->
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted fw-semibold me-1"><?php echo date('Y'); ?>&copy;</span>
								<a href="#" target="_blank" class="text-gray-800 text-hover-primary">pins.co.id</a>
							</div>
							<!--end::Copyright-->

						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->

		<!--end::Main-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop-->
		
		
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->

		
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/js/custom/uploads.js"></script>
		
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/js/widgets.bundle.js"></script>
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/js/custom/widgets.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/bootstrap-typehead/bootstrap3-typeahead.min.js" ></script> 
		<script src="<?php echo base_url(); ?>themes/ortyd/assets/vendors/autoNumeric-next/src/autoNumeric.min.js" type="text/javascript"></script> 
		
		<script>
			$( document ).ready(function() {
				KTMenu.createInstances();
			});
		</script>
		
		<script>
			
				$( document ).ready(function() {
					
					<?php
							$this->db->select('data_absensi.*, date(tanggal) as datenya');
							$this->db->where('user_id', $this->session->userdata('userid'));
							$this->db->where('type', 'Website');
							$this->db->order_by('date(tanggal)','DESC');
							$this->db->limit(1);
							$queryabsen = $this->db->get('data_absensi');
							$queryabsen = $queryabsen->result_object();
							if($queryabsen){
								$last_absen = $queryabsen[0]->datenya;
							}else{
								$date = date('Y-m-d');
								$date = strtotime($date);
								$date = strtotime("-1 day", $date);
								$last_absen = date('Y-m-d', $date);
							}
							
							if($last_absen != date('Y-m-d')){
								
					?>
					
							<?php if($this->session->userdata("position_name") != null && $this->session->userdata("position_name") != ''){
								
								$position_name = $this->session->userdata("position_name");
								
							}else{
								
								$position_name =  $this->ortyd->select2_getname($this->session->userdata("group_id"),"users_groups","id","name"); 
							}
							
							?>
							
							Swal.fire({
									  title: 'Selamat Datang Kembali <br> <?php echo $this->session->userdata("fullname"); ?>',
									  text: '',
									  html:
										'Anda login sebagai <?php echo $position_name; ?>',
									  imageUrl: '<?php echo base_url('logo.jpg'); ?>',
									  imageWidth: 160,
									  imageHeight: 50,
									  allowOutsideClick: false,
									  imageAlt: 'Telkom PINS',
									  confirmButtonText:'<i class="ti ti-angle-double-right"></i> Memulai Aplikasi Sekarang',
							}).then((result) => {
							  /* Read more about isConfirmed, isDenied below */
							  if (result.isConfirmed) {
								  
								  $.post('<?php echo base_url('dashboard/saveAbsen'); ?>',{
									user_id : '<?php echo $this->session->userdata('userid'); ?>',
									csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"
								}, function (data) {
									var obj = jQuery.parseJSON(data);
									if(obj.message == 'success'){
										jumlah = obj.data
										$('#menu_data_perusahaan_register').html(jumlah.total_mitra);
										$('#menu_child_Pra_Registrasi').html(jumlah.total_mitra_pra);
										$('#menu_child_Input_Registrasi').html(jumlah.total_mitra_input);
										$('#menu_child_Vendor').html(jumlah.total_mitra_verified);
										$('#menu_data_nota_kebutuhan').html(jumlah.total_nota_kebutuhan);
										$('#menu_data_justifikasi_kebutuhan').html(jumlah.total_justifikasi_kebutuhan);
										$('#menu_data_spph').html(jumlah.total_spph);
										$('#menu_data_spk').html(jumlah.total_spk);
										$('#menu_data_bast').html(jumlah.total_bast);
										$('#menu_data_invoice').html(jumlah.total_invoice);
									}
								})
					
								Swal.fire("Saved!", "", "success");
							  }
							});
					
					
					<?php } ?>
					
					<?php if(($this->session->userdata('tipe_data') != '' && $this->session->userdata('tipe_data') != null)){ ?>
					
						<?php if($this->session->userdata('tipe_data') == 'Inbound') { ?>
							$('#nota_kebutuhan_count').addClass('displayNone');
							$('#menu_id_24').hide()
						<?php }elseif($this->session->userdata('tipe_data') == 'Outbound') { ?>
							$('#justi_kebutuhan_count').addClass('displayNone');
							$('#menu_id_25').hide()
						<?php } ?>
						
					<?php } ?>
					
					if ($(".numeric-rp")[0]){
			
						new AutoNumeric.multiple('.numeric-rp', 
							{ 
								currencySymbol : '<?php echo $currency; ?>. ',
								unformatOnSubmit: true,
								allowDecimalPadding: false,
								watchExternalChanges: true,
												digitGroupSeparator: '.',
												decimalCharacter : ',',	
							}
						);
					
					}
					
					$(".datetime").daterangepicker({
							singleDatePicker: true,
							showDropdowns: true,
							minYear: 1901,
							maxYear: parseInt(moment().format("YYYY"),12),
							locale: {
							  format: 'YYYY-MM-DD'
							}
						}, function(start, end, label) {
							
						}
					);
					
					$(".datepickertime").daterangepicker({
						singleDatePicker: true,
						timePicker: true,
						showDropdowns: true,
						timePicker24Hour:true,
						opens: 'auto',
						drops: 'auto',
						parentEl: ".swal2-popup",
						minYear: 1901,
						maxYear: parseInt(moment().format("YYYY"),12),
						locale: {
							format: 'YYYY-MM-DD HH:mm:00'
						}
					}, function(start, end, label) {
									
					});
			
					setTimeout(function(){
						is_online()
						
						const deg = Math.floor(Math.random() *360);
				  
						const gradient = "linear-gradient(" + deg + "deg, " + "#" + createHex() + ", " + "#" + createHex() +")";
						//document.getElementById("header-color").style.background = gradient;
						//document.getElementById("left-sidebar").style.background = gradient;
						
						
					}, 100);
					
					setInterval(function(){ 
					
						const deg = Math.floor(Math.random() *360);
				  
						const gradient = "linear-gradient(" + deg + "deg, " + "#" + createHex() + ", " + "#" + createHex() +")";
						//document.getElementById("header-color").style.background = gradient;
						//document.getElementById("left-sidebar").style.background = gradient;
						
						is_online()

					}, 30000);

					
					getcountingmenu()
					
				});
				
				function is_online(){
					$.post('<?php echo base_url('dashboard/isonline'); ?>',{
						csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"
					}, function (data) {
						//console.log(data);
						if(data){
							var obj = jQuery.parseJSON(data);
							if(obj.message == 'success'){
								
							}else if(obj.message == 'notlogin'){
								window.location.reload();
							}
						}else{
							window.location.reload();
						}
					})
				}
				
				function getcountingmenu(){
					$.post('<?php echo base_url('dashboard/getcount'); ?>',{
						csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"
					}, function (data) {
						var obj = jQuery.parseJSON(data);
						if(obj.message == 'success'){
							jumlah = obj.data
							$('#menu_data_perusahaan_register').html(jumlah.total_mitra);
							$('#menu_child_Pra_Registrasi').html(jumlah.total_mitra_pra);
							$('#menu_child_Input_Registrasi').html(jumlah.total_mitra_input);
							$('#menu_child_Vendor').html(jumlah.total_mitra_verified);
							$('#menu_data_nota_kebutuhan').html(jumlah.total_nota_kebutuhan);
							$('#menu_data_justifikasi_kebutuhan').html(jumlah.total_justifikasi_kebutuhan);
							$('#menu_data_spph').html(jumlah.total_spph);
							$('#menu_data_spk').html(jumlah.total_spk);
							$('#menu_data_bast').html(jumlah.total_bast);
							$('#menu_data_invoice').html(jumlah.total_invoice);
						}
					})
				}
				
				function createHex() {
				  var hexCode1 = "";
				  var hexValues1 = "0123456789abcdef";
				  
				  for ( var i = 0; i < 6; i++ ) {
					hexCode1 += hexValues1.charAt(Math.floor(Math.random() * hexValues1.length));
				  }
				  return hexCode1;
				}
	  
		</script>
		
		
		<canvas id="pdf-canvas_data" width="400" style="display:none"></canvas>
		<script>

		var __PDF_DOC_GEN,
			__CURRENT_PAGE_GEN,
			__TOTAL_PAGES_GEN,
			__PAGE_RENDERING_IN_PROGRESS_GEN = 0,
			__CANVAS_GEN = $('#pdf-canvas_data').get(0),
			__CANVAS_GEN_CTX_GEN = __CANVAS_GEN.getContext('2d');

		function showPDF_GEN(div,pdf_url,id,type = null) {
			PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
				__PDF_DOC_GEN = pdf_doc;
				__TOTAL_PAGES_GEN = __PDF_DOC_GEN.numPages;
				// Show the first page
				var user_id = '<?php echo $this->session->userdata('userid'); ?>'
				showPage_gen(1, user_id, id,div,type);
			}).catch(function(error) {

				alert(error.message);
			});;
		}

		function showPage_gen(page_no, user_id, id,div,type = null) {
			__PAGE_RENDERING_IN_PROGRESS_GEN = 1;
			__CURRENT_PAGE_GEN = page_no;
			// Fetch the page
			__PDF_DOC_GEN.getPage(page_no).then(function(page) {
				// As the canvas is of a fixed width we need to set the scale of the viewport accordingly
				var scale_required = __CANVAS_GEN.width / page.getViewport(1).width;

				// Get viewport of the page at required scale
				var viewport = page.getViewport(scale_required);

				// Set canvas height
				__CANVAS_GEN.height = viewport.height;

				var renderContext = {
					canvasContext: __CANVAS_GEN_CTX_GEN,
					viewport: viewport
				};
				
				// Render the page contents in the canvas
				page.render(renderContext).then(function() {
					__PAGE_RENDERING_IN_PROGRESS_GEN = 0;
					var img = __CANVAS_GEN.toDataURL("image/png");
					//console.log(img);
					
					$.post("<?php echo fileserver_url.'uploadBase64_new'; ?>",{image64 : img, user_id : user_id, id: id, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"}, function (response) {
						//var obj = $.parseJSON(response)
						var obj = response;
						console.log(obj)
						if(type == 'renderclass'){
							$("#" + div + ' .dz-preview .dz-image_'+ id +' img').attr("src", obj.url_server + obj.path);
						}else{
							$("#" + div + ' .dz-preview .dz-image img').attr("src", obj.url_server + obj.path);
						}
						
						
						//console.log(response);
					})
				});
			});
		}

		</script>
		
		
		<script>
		var loadingupload
		function loadingopen(){
			loadingupload = bootbox.dialog({
				title: 'Uploading Data ...',
				message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>',
				className: 'loadingdialog',
				closeButton: false
			});
		}
		
		function loadingclose(){
			//loadingupload.find('.bootbox-body').html('Upload');
			setTimeout(function(){
				loadingupload.modal('hide'); 
			}, 2000);
		}
		
		
		
		</script>
		
		
		<script>
		var loadingprogress
		function loadingopenprog(){
			loadingprogress = bootbox.dialog({
				title: 'Loading ...',
				message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>',
				className: 'loadingdialog',
				closeButton: false
			});
		}
		
		function loadingcloseprog(){
			//loadingupload.find('.bootbox-body').html('Upload');
			setTimeout(function(){
				loadingprogress.modal('hide'); 
			}, 2000);
		}
		
		
		
		</script>
		
		<script>

		function changeTitle(table_change, table_change_id, labelname = null){
			
					html=
						'<div class="col-lg-16" style="text-align:left;margin-top:30px">'+
							'<div class="form-group">'+
								'<label>NAMA</label>'+
								'<input type="text" class="form-control form-control-sm" id="value" placeholder="Value" value="'+labelname+'" />'+
							'</div>'+
							'<div class="form-group">'+
									'<label>SIZE</label>'+
									'<select class="form-control form-control-sm" id="size" >'+
										'<option value="6">MID</option>'+
										'<option value="12">FULL</option>'+
										'<option value="3">1/4</option>'+
										'<option value="4">1/3</option>'+
									'</select>'+
								'</div>'+
							'<div class="form-group">'+
								'<label>ONLY NAME</label>'+
								'<select class="form-control form-control-sm" id="only" >'+
									'<option value="1">YES</option>'+
									'<option value="0">NO</option>'+
								'</select>'+
							'</div>'+
							
							'<div style="display:none" id="form_detail_tablenya">'+
								'<div class="form-group">'+
									'<label>TIPE</label>'+
									'<select class="form-control form-control-sm" id="tipe" >'+
										'<option value="TEXT">TEXT</option>'+
										'<option value="TEXTAREA">TEXTAREA</option>'+
										'<option value="NUMBER">NUMBER</option>'+
										'<option value="DATE">DATE</option>'+
										'<option value="DATETIME">DATETIME</option>'+
										'<option value="CURRENCY">CURRENCY</option>'+
										'<option value="SELECT">SELECT</option>'+
										'<option value="FILE">FILE</option>'+
										'<option value="LINK">LINK</option>'+
									'</select>'+
								'</div>'+
								'<div id="table_ref_form" style="display:none">'+
									'<div class="form-group">'+
										'<label>TABLE REF</label>'+
										'<input type="text" class="form-control form-control-sm" id="table_ref" placeholder="Table Ref" value="" />'+
									'</div>'+
									'<div class="form-group">'+
										'<label>TABLE ID</label>'+
										'<input type="text" class="form-control form-control-sm" id="table_id_ref" placeholder="Table ID Ref" value="" />'+
									'</div>'+
									'<div class="form-group">'+
										'<label>TABLE NAME</label>'+
										'<input type="text" class="form-control form-control-sm" id="table_name_ref" placeholder="Table Name Ref" value="" />'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>';
			
				
			Swal.fire({
				title: 'Update Naming ?',
				icon:'question',
				html:html,
				heightAuto: false,	
				showCloseButton: true,
				showCancelButton: true,
				showDenyButton: false,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: '<i class="fa fa-edit"></i> Update',
				denyButtonText: '<i class="fa fa-undo"></i> Kembalikan',
				focusConfirm: false,
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				preConfirm: () => {
					const size = Swal.getPopup().querySelector('#size').value
					const value = Swal.getPopup().querySelector('#value').value
					const only = Swal.getPopup().querySelector('#only').value
					const tipe = Swal.getPopup().querySelector('#tipe').value
					const table_ref = Swal.getPopup().querySelector('#table_ref').value
					const table_id_ref = Swal.getPopup().querySelector('#table_id_ref').value
					const table_name_ref = Swal.getPopup().querySelector('#table_name_ref').value
					
					if (!value) {
						Swal.showValidationMessage('Isi Naming')
					}else if (!tipe) {
						Swal.showValidationMessage('Isi Tipe')
					}else if (!only) {
						Swal.showValidationMessage('Isi Tipe Ubah')
					}

					return { value: value,tipe: tipe,table_ref: table_ref,table_id_ref: table_id_ref,table_name_ref: table_name_ref,only: only,size: size}
				},
				willOpen: () => {
					
					$('#only').on('change',function(){
						if($('#only').val() == "0"){
							$('#form_detail_tablenya').show();
						}else{
							$('#form_detail_tablenya').hide();
						}
						
					})
					
					$('#tipe').on('change',function(){
						if($('#tipe').val() == "SELECT"){
							$('#table_ref_form').show();
						}else{
							$('#table_ref_form').hide();
						}
						
					})
					

				}
			}).then((result) => {

				console.log(result)
				if (result.isConfirmed) {
					var value = result.value.value
					var tipe = result.value.tipe
					var table_ref = result.value.table_ref
					var table_id_ref = result.value.table_id_ref
					var table_name_ref = result.value.table_name_ref
					var only = result.value.only
					var size = result.value.size
					
					var save = saveKonfirmasinaming(table_change, table_change_id, value,tipe,table_ref,table_id_ref,table_name_ref,only,size);
					
				  }
						
			})
		}

		function saveKonfirmasinaming(table_change, table_change_id, value,tipe,table_ref,table_id_ref,table_name_ref,only,size){
			
			if(value == '' || value == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi naming',
					footer: ''
				})
			}else if(tipe == '' || tipe == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi Tipe',
					footer: ''
				})
			}else if(table_change == '' || table_change == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi Tabel',
					footer: ''
				})
			}else if(table_change_id == '' || table_change_id == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi Table ID',
					footer: ''
				})
			}else if(only == '' || only == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi TIPE ID',
					footer: ''
				})
			}else{
			
				$.post('<?php echo base_url('dashboard/updatenaming'); ?>',{
						size : size,
						value : value,
						tipe : tipe,
						only : only,
						table_ref : table_ref,
						table_id_ref : table_id_ref,
						table_name_ref : table_name_ref,
						table_change : table_change,
						table_change_id :table_change_id,
						csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"
				},function (data) {	
						if(data != 'null'){
							var obj = jQuery.parseJSON(data);
							if(obj.status == 'success'){
								
								let timerInterval
								Swal.fire({
								title: 'Saving Data',
									html: 'Loading <b></b> milliseconds.',
									timer: 100,
									timerProgressBar: true,
									didOpen: () => {
										Swal.showLoading()
										const b = Swal.getHtmlContainer().querySelector('b')
										timerInterval = setInterval(() => {
											b.textContent = Swal.getTimerLeft()
										}, 100)
									},
									willClose: () => {
										clearInterval(timerInterval)
									}
								}).then((result) => {
									/* Read more about handling dismissals below */
									if (result.dismiss === Swal.DismissReason.timer) {
										
										location.reload();

										
										//window.location.href = '<?php echo base_url('data_proposal/editdata/')?>'+obj.slug;
									}
								})
										
							}else{
								
								Swal.fire({
									icon: 'error',
									title: 'Kesalahan...',
									text: 'Ada sesuatu yang salah!',
								})
								
							}
						}
				})
			
			}
		}


		function savingTableView(modulview, tabelview){
			
			var array = []
			var checkboxes = document.getElementsByName("checkbox_table[]");

			for (var i = 0; i < checkboxes.length; i++) {
				if ( checkboxes[i].checked ) {
					array.push(checkboxes[i].value)
				}
			}
			
			if(modulview == '' || modulview == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi modulview',
					footer: ''
				})
			}else if(tabelview == '' || tabelview == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi tabelview',
					footer: ''
				})
			}else{
			
				$.post('<?php echo base_url('dashboard/updateview'); ?>',{
						modulview : modulview,
						tabelview : tabelview,
						dataview :array,
						csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"
				},function (data) {	
						if(data != 'null'){
							var obj = jQuery.parseJSON(data);
							if(obj.status == 'success'){
								
								let timerInterval
								Swal.fire({
								title: 'Saving Data',
									html: 'Loading <b></b> milliseconds.',
									timer: 100,
									timerProgressBar: true,
									didOpen: () => {
										Swal.showLoading()
										const b = Swal.getHtmlContainer().querySelector('b')
										timerInterval = setInterval(() => {
											b.textContent = Swal.getTimerLeft()
										}, 100)
									},
									willClose: () => {
										clearInterval(timerInterval)
									}
								}).then((result) => {
									/* Read more about handling dismissals below */
									if (result.dismiss === Swal.DismissReason.timer) {
										
										location.reload();

										
										//window.location.href = '<?php echo base_url('data_proposal/editdata/')?>'+obj.slug;
									}
								})
										
							}else{
								
								Swal.fire({
									icon: 'error',
									title: 'Kesalahan...',
									text: 'Ada sesuatu yang salah!',
								})
								
							}
						}
				})
			
			}
		}
		
		function savingTableViewOrder(modulview, tabelview, array, tableorder){
			
			if(modulview == '' || modulview == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi modulview',
					footer: ''
				})
			}else if(tabelview == '' || tabelview == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi tabelview',
					footer: ''
				})
			}else if(tableorder == '' || tableorder == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi tableorder',
					footer: ''
				})
			}else{
			
				$.post('<?php echo base_url('dashboard/updatevieworder'); ?>',{
						modulview : modulview,
						tabelview : tabelview,
						tableorder : tableorder,
						dataview :array,
						csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"
				},function (data) {	
						if(data != 'null'){
							var obj = jQuery.parseJSON(data);
							if(obj.status == 'success'){
								
								let timerInterval
								Swal.fire({
								title: 'Saving Data',
									html: 'Loading <b></b> milliseconds.',
									timer: 100,
									timerProgressBar: true,
									didOpen: () => {
										Swal.showLoading()
										const b = Swal.getHtmlContainer().querySelector('b')
										timerInterval = setInterval(() => {
											b.textContent = Swal.getTimerLeft()
										}, 100)
									},
									willClose: () => {
										clearInterval(timerInterval)
									}
								}).then((result) => {
									/* Read more about handling dismissals below */
									if (result.dismiss === Swal.DismissReason.timer) {
										
										//location.reload();

										
										//window.location.href = '<?php echo base_url('data_proposal/editdata/')?>'+obj.slug;
									}
								})
										
							}else{
								
								Swal.fire({
									icon: 'error',
									title: 'Kesalahan...',
									text: 'Ada sesuatu yang salah!',
								})
								
							}
						}
				})
			
			}
		}
		
		
		
		function savingTableViewOrderForm(modulview, tabelview, array, tableorder){
			
			if(modulview == '' || modulview == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi modulview',
					footer: ''
				})
			}else if(tabelview == '' || tabelview == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi tabelview',
					footer: ''
				})
			}else if(tableorder == '' || tableorder == null){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Isi tableorder',
					footer: ''
				})
			}else{
			
				$.post('<?php echo base_url('dashboard/updatevieworderform'); ?>',{
						modulview : modulview,
						tabelview : tabelview,
						tableorder : tableorder,
						dataview :array,
						csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"
				},function (data) {	
						if(data != 'null'){
							var obj = jQuery.parseJSON(data);
							if(obj.status == 'success'){
								
								let timerInterval
								Swal.fire({
								title: 'Saving Data',
									html: 'Loading <b></b> milliseconds.',
									timer: 100,
									timerProgressBar: true,
									didOpen: () => {
										Swal.showLoading()
										const b = Swal.getHtmlContainer().querySelector('b')
										timerInterval = setInterval(() => {
											b.textContent = Swal.getTimerLeft()
										}, 100)
									},
									willClose: () => {
										clearInterval(timerInterval)
									}
								}).then((result) => {
									/* Read more about handling dismissals below */
									if (result.dismiss === Swal.DismissReason.timer) {
										
										//location.reload();

										
										//window.location.href = '<?php echo base_url('data_proposal/editdata/')?>'+obj.slug;
									}
								})
										
							}else{
								
								Swal.fire({
									icon: 'error',
									title: 'Kesalahan...',
									text: 'Ada sesuatu yang salah!',
								})
								
							}
						}
				})
			
			}
		}
		
		
		function stripHtml(html)
		{
		   let tmp = document.createElement("DIV");
		   tmp.innerHTML = html;
		   return tmp.textContent || tmp.innerText || "";
		}

		    

   
	let draggedItem = null;
	let targetItemData = null;
    // Drag start event handler
    function handleDragStart(event) {
      draggedItem = event.target;
      event.dataTransfer.effectAllowed = 'move';
      event.dataTransfer.setData('text/html', draggedItem.innerHTML);
      event.target.style.opacity = '0.5';
    }

    // Drag over event handler
    function handleDragOver(event) {
      event.preventDefault();
      event.dataTransfer.dropEffect = 'move';
      targetItem = event.target;
      if (targetItem !== draggedItem && targetItem.classList.contains('drag-item')) {
        const boundingRect = targetItem.getBoundingClientRect();
        const offset = boundingRect.y + (boundingRect.height / 2);
		//console.log(targetItem.id)
		//console.log(targetItem.classList.contains('drag-item'))
        if (targetItem.classList.contains('drag-item')) {
		  targetItemData = event;
          targetItem.style.borderBottom = 'solid 2px red';
          targetItem.style.borderTop = '';
        } else {
          targetItem.style.borderTop = 'solid 2px #000';
          targetItem.style.borderBottom = '';
        }
      }
    }

    // Drop event handler
    function handleDrop(event) {
		//console.log(event.target);
     // event.preventDefault();
		targetItem = targetItemData.target;
	  //console.log(targetItem.id)
	  //console.log(draggedItem.id)
	  
	  if (targetItem !== draggedItem && targetItem.classList.contains('drag-item')) {
        if (event.clientY > targetItem.getBoundingClientRect().top + (targetItem.offsetHeight / 2)) {
           targetItem.parentNode.insertBefore(draggedItem, targetItem.nextSibling);
		   //swap(draggedItem, targetItem.nextSibling);
        } else {
		   targetItem.parentNode.insertBefore(draggedItem, targetItem);
           //swap(draggedItem, targetItem);
        }
      }
	  
      targetItem.style.borderTop = '';
      targetItem.style.borderBottom = '';
      draggedItem.style.opacity = '';
      draggedItem = null;
	  getAlldiv()
    }
	
	function swap(node1, node2) {
		const afterNode2 = node2.nextElementSibling;
		const parent = node2.parentNode;
		node1.replaceWith(node2);
		parent.insertBefore(node1, afterNode2);
	}
	
	function getAlldiv(){
		 //console.log($('div'));  
    // [<div id="outer"><div id="inner"></div></div>], [<div id="inner"></div>]

			 var datacolumnnya = [];
			 var images = $('#dragList').find("draggable");
			 console.log(images.prevObject[0].children.length);
			 var data = images.prevObject[0].children;
			 for(x=0;x<=data.length;x++){
				 
				try {
					if (typeof data[x].draggable !== "undefined") {
						if(data[x].draggable == true){
							text = data[x].id;
							$("#" + text).css("border","none");
							$("#" + text).css("border-color","none");
							$("#" + text).css("opacity","1");
							text = text.replace("_header", "");
							console.log(text)
							datacolumnnya[x] = text;
						}
					}
				} catch (err) {
				   break;
				}

				
				
			 }
			 
			const myArray = datacolumnnya.toString();
            var myJsonString = JSON.stringify(myArray);
            console.log(myArray)
			savingTableViewOrderForm('<?php echo $module; ?>','<?php echo $module; ?>', datacolumnnya, myArray)
			// 0: <div id="outer"><div id="inner"></div></div>
			// 1: <div id="inner"></div>
	}


		</script>
		
		


		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>