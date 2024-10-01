<!--begin::Navbar-->
								<div class="d-flex align-items-stretch" id="kt_header_nav">
									<!--begin::Menu wrapper-->
									<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
										<?php require_once('menu.php'); ?>
									</div>
									<!--end::Menu wrapper-->
								</div>
								<!--end::Navbar-->
								<!--begin::Toolbar wrapper-->
								<div class="topbar d-flex align-items-stretch flex-shrink-0">

								
								<div class="app-navbar-item ms-1 ms-md-4">
									<!--begin::Menu- wrapper-->
									<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px position-relative" id="kt_drawer_chat_toggle" style="background: azure;" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_menu_item_wow" >
										<i class="ki-duotone ki-message-text-2 fs-2" style="color:red">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
										<span class="bullet bullet-dot bg-danger h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
									</div>
									<!--begin::Menu-->
									<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications" style="">
										<!--begin::Heading-->
										<div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
											<!--begin::Title-->
											<h3 class="fw-semibold px-9 mt-10 mb-6">Notifications
											<span class="fs-8 opacity-75 ps-3"></span></h3>
											<!--end::Title-->
											<!--begin::Tabs-->
											<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9" role="tablist">
												<li class="nav-item" role="presentation">
													<a class="nav-link opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_1" aria-selected="true" tabindex="-1" role="tab">Inbox</a>
												</li>
												<li class="nav-item" role="presentation">
													<a class="nav-link opacity-75 opacity-state-100 pb-4 " data-bs-toggle="tab" href="#kt_topbar_notifications_2" aria-selected="false" role="tab">Ticket</a>
												</li>
												<li class="nav-item" role="presentation">
													<a class="nav-link opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_3" aria-selected="false" tabindex="-1" role="tab">Logs</a>
												</li>
											</ul>
											<!--end::Tabs-->
										</div>
										<!--end::Heading-->
										<!--begin::Tab content-->
										<div class="tab-content">
											<!--begin::Tab panel-->
											<div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
												<!--begin::Items-->
												<div class="scroll-y mh-325px my-5 px-8">
												
													<?php
													$this->db->where('to_id', $this->session->userdata('userid'));
													$this->db->where('is_read',0);
													$this->db->where('active',1);
													$this->db->order_by('created','DESC');
													$this->db->limit(5);
													$querynotif = $this->db->get('vw_data_inbox');
													$querynotif = $querynotif->result_object();
													
													if($querynotif){
														foreach($querynotif as $rows){ 
															
													?>
													
													
													<!--begin::Item-->
													<div class="d-flex flex-stack py-4">
														<!--begin::Section-->
														<div class="d-flex align-items-center">
															<!--begin::Symbol-->
															<div class="symbol symbol-35px me-4">
																<span class="symbol-label bg-light-primary">
																	<i class="ki-duotone ki-abstract-28 fs-2 text-primary">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="mb-0 me-2">
																<a href="<?php echo base_url('data_inbox/viewdata/'.$rows->slug); ?>" class="fs-6 text-gray-800 text-hover-primary fw-bold"><?php echo $rows->subject; ?></a>
																<div class="text-gray-400 fs-7"><?php echo $rows->from_fullname; ?></div>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Section-->
														<!--begin::Label-->
														<span class="badge badge-light fs-8"><?php echo $rows->created;?> </span>
														<!--end::Label-->
													</div>
													<!--end::Item-->
													
															
														<?php } 
													}else{ ?>
														<div class="d-flex flex-stack py-4">
															<div class="message-center" style="height: auto;text-align: center;padding: 5px;">
																<!-- Message -->
																Tidak ada pesan
															   
															</div>
														</div>
														
													<?php }?>
									
												</div>
												<!--end::Items-->
												<!--begin::View more-->
												<div class="py-3 text-center border-top">
													<a href="<?php echo base_url('data_inbox'); ?>" class="btn btn-color-gray-600 btn-active-color-primary">View All
													<i class="ki-duotone ki-arrow-right fs-5">
														<span class="path1"></span>
														<span class="path2"></span>
													</i></a>
												</div>
												<!--end::View more-->
											</div>
											<!--end::Tab panel-->
											<!--begin::Tab panel-->
											<div class="tab-pane fade" id="kt_topbar_notifications_2" role="tabpanel">
												<!--begin::Items-->
												<div class="scroll-y mh-325px my-5 px-8">
													<!--begin::Item-->
													
																										
													<?php
													$this->db->where('active',1);
													$this->db->order_by('created','DESC');
													$this->db->limit(5);
													$querynotif = $this->db->get('vw_ticket');
													$querynotif = $querynotif->result_object();
													
													if($querynotif){
														foreach($querynotif as $rows){ 
															
													?>
													
													
													<div class="d-flex flex-stack py-4">

														<!--begin::Section-->
														<div class="d-flex align-items-center me-2">
															<!--begin::Code-->
															
															<!--end::Code-->
															<!--begin::Title-->
															<a href="<?php echo base_url('data_ticket/replydata/'.$rows->slug); ?>" class=""><span class="w-70px badge badge-light-success me-4"><?php echo $rows->ticket_no; ?></span></a>
															<!--end::Title-->
														</div>
														<!--end::Section-->
														<!--begin::Label-->
														<span class="badge badge-light fs-8"><?php echo $rows->created; ?></span>
														<!--end::Label-->
													</div>
													<!--end::Item-->
													
														<?php } 
													}else{ ?>
														<div class="d-flex flex-stack py-4">
															<div class="message-center" style="height: auto;text-align: center;padding: 5px;">
																<!-- Message -->
																Tidak ada pesan
															   
															</div>
														</div>
														
													<?php }?>
													
												</div>
												<!--end::Items-->
												<!--begin::View more-->
												<div class="py-3 text-center border-top">
													<a href="#" class="btn btn-color-gray-600 btn-active-color-primary">View All
													<i class="ki-duotone ki-arrow-right fs-5">
														<span class="path1"></span>
														<span class="path2"></span>
													</i></a>
												</div>
												<!--end::View more-->
											</div>
											<!--end::Tab panel-->
											<!--begin::Tab panel-->
											<div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
												<!--begin::Items-->
												<div class="scroll-y mh-325px my-5 px-8">
													<!--begin::Item-->
													<div class="d-flex flex-stack py-4">
														<!--begin::Section-->
														<div class="d-flex align-items-center me-2">
															<!--begin::Code-->
															<span class="w-70px badge badge-light-success me-4">200 OK</span>
															<!--end::Code-->
															<!--begin::Title-->
															<a href="#" class="text-gray-800 text-hover-primary fw-semibold">New order</a>
															<!--end::Title-->
														</div>
														<!--end::Section-->
														<!--begin::Label-->
														<span class="badge badge-light fs-8">Just now</span>
														<!--end::Label-->
													</div>
													<!--end::Item-->
													
												</div>
												<!--end::Items-->
												<!--begin::View more-->
												<div class="py-3 text-center border-top">
													<a href="#" class="btn btn-color-gray-600 btn-active-color-primary">View All
													<i class="ki-duotone ki-arrow-right fs-5">
														<span class="path1"></span>
														<span class="path2"></span>
													</i></a>
												</div>
												<!--end::View more-->
											</div>
											<!--end::Tab panel-->
										</div>
										<!--end::Tab content-->
									</div>
									<!--end::Menu-->
									<!--end::Menu wrapper-->
								</div>
								
									<!--begin::Theme mode-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Menu toggle-->
										<a href="#" class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<i class="ki-duotone ki-night-day theme-light-show fs-1">
												<span class="path1"></span>
												<span class="path2"></span>
												<span class="path3"></span>
												<span class="path4"></span>
												<span class="path5"></span>
												<span class="path6"></span>
												<span class="path7"></span>
												<span class="path8"></span>
												<span class="path9"></span>
												<span class="path10"></span>
											</i>
											<i class="ki-duotone ki-moon theme-dark-show fs-1">
												<span class="path1"></span>
												<span class="path2"></span>
											</i>
										</a>
										<!--begin::Menu toggle-->
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
											<!--begin::Menu item-->
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-night-day fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
															<span class="path6"></span>
															<span class="path7"></span>
															<span class="path8"></span>
															<span class="path9"></span>
															<span class="path10"></span>
														</i>
													</span>
													<span class="menu-title">Light</span>
												</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-moon fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
													<span class="menu-title">Dark</span>
												</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-screen fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
														</i>
													</span>
													<span class="menu-title">System</span>
												</a>
											</div>
											<!--end::Menu item-->
										</div>
										<!--end::Menu-->
									</div>
									<!--end::Theme mode-->
									<!--begin::User-->
									<div class="d-flex align-items-center me-lg-n2 ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
										<!--begin::Menu wrapper-->
										<div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
										
										<?php
											$this->db->select('data_gallery.path');
											$this->db->where('email',$this->session->userdata('email'));
											$this->db->join('data_gallery','data_gallery.id = users_data.cover');
											$queryimage = $this->db->get('users_data');
											$queryimage = $queryimage->result_object();
											if($queryimage){
												if($queryimage[0]->path != ''){
													$imagecover = base_url().$queryimage[0]->path;
												}else{
													$imagecover = base_url().'favicon.png';
												}
												//echo ' ('.$query[0]->name.')';
											}else{
												$imagecover = base_url().'favicon.png';
												//echo ' (no set role)';
											}			
										?>
					
											<img class="h-30px w-30px rounded" src="<?php echo $imagecover; ?>" alt="" />
										</div>
										<!--begin::User account menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<div class="menu-content d-flex align-items-center px-3">
													<!--begin::Avatar-->
													<div class="symbol symbol-50px me-5">
														<img alt="Logo" src="<?php echo base_url(); ?>favicon.png" />
													</div>
													<!--end::Avatar-->
													<!--begin::Username-->
													<div class="d-flex flex-column">
													
													<?php if($this->session->userdata("position_name") != null && $this->session->userdata("position_name") != ''){
								
														$position_name = $this->session->userdata("position_name");
														
													}else{
														
														$position_name =  $this->ortyd->select2_getname($this->session->userdata("group_id"),"users_groups","id","name"); 
													}
													
													?>
									
														<div class="fw-bold d-flex align-items-center fs-5"><?php echo $this->session->userdata('fullname'); ?>
														<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"><?php echo $this->ortyd->select2_getname($this->session->userdata("group_id"),"users_groups","id","name"); ?></span></div>
														<a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?php echo $position_name; ?></a>
														<a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?php echo $this->session->userdata('email'); ?><br><?php echo $this->session->userdata('tipe_data'); ?></a>
													</div>
													<!--end::Username-->
												</div>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu separator-->
											<div class="separator my-2"></div>
											<!--end::Menu separator-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="<?php echo base_url('users_data/view'); ?>" class="menu-link px-5">Profil Saya</a>
											</div>
											<!--end::Menu item-->


											
											<!--begin::Menu separator-->
											<div class="separator my-2"></div>
											<!--end::Menu separator-->

											<!--begin::Menu item-->
											<div class="menu-item px-5 my-1">
												<a href="<?php echo base_url().'users_password'; ?>" class="menu-link px-5">Ganti Password</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="<?php echo base_url().'login/logout'; ?>" class="menu-link px-5">Keluar</a>
											</div>
											<!--end::Menu item-->
										</div>
										<!--end::User account menu-->
										<!--end::Menu wrapper-->
									</div>
									<!--end::User -->
									<!--begin::Aside mobile toggle-->
									<!--end::Aside mobile toggle-->
								</div>
								<!--end::Toolbar wrapper-->


  