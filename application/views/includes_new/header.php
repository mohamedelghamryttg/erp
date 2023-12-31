<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 11 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
	<base href="">
	<meta charset="utf-8" />
	<title>Nexus | Site Manager</title>
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<meta name="description" content="Updates and statistics" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="canonical" href="https://keenthemes.com/metronic" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Vendors Styles(used by this page)-->
	<link href="<?php echo base_url(); ?>assets_new/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="<?php echo base_url(); ?>assets_new/css/pages/wizard/wizard-2.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets_new/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets_new/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

	<?php if ($this->brand == 1) { ?>
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo_ar.png" />
	<?php } elseif ($this->brand == 2) { ?>
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/localizera_logo.png" />
	<?php } elseif ($this->brand == 3) { ?>
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/europe.png" />
	<?php } elseif ($this->brand == 11) { ?>
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/columbus_logo.jpg" />
	<?php } ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<link href="<?php echo base_url(); ?>assets_new/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets_new/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!-- <link href="<?php echo base_url(); ?>assets_new/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
</head>
<!--end::Head-->
<!--begin::Body-->
<style>
	.table-separate {
		white-space: nowrap;
	}

	.table-separate>thead {
		white-space: normal;
	}
</style>

<style>
	#loading {
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		position: fixed;
		display: block;
		opacity: 0.7;
		background-color: #fff;
		z-index: 99;
		text-align: center;
	}

	#loading-image {
		position: absolute;
		top: 100px;
		left: 240px;
		z-index: 100;
	}

	.swal2-content .select2 {
		display: none;
	}
</style>

<body id="kt_body" class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed aside-enabled aside-static page-loading">
	<!--begin::Main-->
	<input id="base" type="hidden" value="<?= base_url() ?>">
	<div id="loading" style="display: none;">
		<img id="loading-image" src='<?= base_url() ?>assets/images/loader.gif' style='margin-left: 31%;width:300px;height:300px;' />
	</div>
	<!--begin::Header Mobile-->
	<div id="kt_header_mobile" class="header-mobile header-mobile-fixed">
		<!--begin::Logo-->
		<a href="<?= base_url() ?>admin">

			<?php if ($this->brand == 1) { ?>
				<img alt="Logo" src="<?php echo base_url(); ?>assets/images/logo_ar.png" class="logo-default max-h-40px" />
			<?php } elseif ($this->brand == 2) { ?>
				<img alt="Logo" src="<?php echo base_url(); ?>assets/images/localizera_logo.png" class="logo-default max-h-20px" />
			<?php } elseif ($this->brand == 3) { ?>
				<img alt="Logo" src="<?php echo base_url(); ?>assets/images/europe.png" class="logo-default max-h-50px" />
			<?php } elseif ($this->brand == 11) { ?>
				<img alt="Logo" src="<?= base_url(); ?>assets/images/columbus_logo.jpg" class="logo-default max-h-70px" />
			<?php } ?>
		</a>
		<!--end::Logo-->
		<!--begin::Toolbar-->
		<div class="d-flex align-items-center">
			<button class="btn p-0 burger-icon rounded-0 burger-icon-left" id="kt_aside_tablet_and_mobile_toggle">
				<span></span>
			</button>
			<button class="btn btn-hover-text-primary p-0 ml-3" id="kt_header_mobile_topbar_toggle">
				<span class="svg-icon svg-icon-xl">
					<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<polygon points="0 0 24 0 24 24 0 24" />
							<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
							<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
						</g>
					</svg>
					<!--end::Svg Icon-->
				</span>
			</button>
		</div>
		<!--end::Toolbar-->
	</div>
	<!--end::Header Mobile-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="d-flex flex-row flex-column-fluid page">
			<!--begin::Aside-->
			<div class="aside aside-left d-flex flex-column flex-row-auto" id="kt_aside">
				<!--begin::Aside Menu-->
				<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
					<!--begin::Menu Container-->
					<div id="kt_aside_menu" class="aside-menu min-h-lg-800px" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
						<!--begin::Menu Nav-->
						<ul class="menu-nav">
							<li class="menu-item menu-item-active" aria-haspopup="true">
								<a href="<?= base_url() ?>admin" class="menu-link">
									<span class="svg-icon menu-icon">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24" />
												<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
												<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
									<span class="menu-text">Dashboard</span>
								</a>
							</li>
							<li class="menu-section">
								<h4 class="menu-text">Nexus | Site Manager</h4>
								<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
							</li>
							<?php foreach ($group as $group1) {

								$permission = $this->admin_model->getScreenByGroupAndRole($group1->groups, $this->session->userdata('role'));
							?>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<?= $this->admin_model->getGroup($group1->groups)->icon ?? '' ?>
										</span>
										<span class="menu-text">
											<?= ucfirst($this->admin_model->getGroup($group1->groups)->name) ?>
										</span>
										<?php
										if ($this->admin_model->checkIfUserIsManager($this->user) && date("d") >= 5 && date("d") <= 10) {
											if ($group1->groups == 19) {
												if ($this->hr_model->numOfMissingKpiToManager() > 0) {
										?>
													<span class="menu-label">
														<span class="label pulse pulse-danger bg-transparent">
															<span class="position-relative"><i class="flaticon2-information text-danger"></i></span>
															<span class="pulse-ring"></span>
														</span>
													</span>
												<?php }
											}
										}
										if ($this->admin_model->checkIfUserIsManager($this->user) && $group1->groups == 15) {
											if ($this->hr_model->numOfVacationToManager() > 0 || $this->hr_model->numOfmissingToManager() > 0) { ?>
												<span class="menu-label">
													<span class="label pulse pulse-danger bg-transparent">
														<span class="position-relative"><i class="flaticon2-information text-danger"></i></span>
														<span class="pulse-ring"></span>
													</span>
												</span>
										<?php }
										} ?>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											<li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
													<span class="menu-text">
														<?= ucfirst($this->admin_model->getGroup($group1->groups)->name) ?>
													</span>
												</span>
											</li>
											<?php foreach ($permission as $permission) {
												$screen = $this->admin_model->getScreen($permission->screen);
											?>
												<li class="menu-item" aria-haspopup="true">
													<a href="<?php echo base_url() . $screen->url; ?>" class="menu-link">
														<i class="menu-bullet menu-bullet-dot">
															<span></span>
														</i>
														<span class="menu-text">
															<?= $screen->name; ?>
														</span>
														<?php if ($this->admin_model->checkIfUserIsManager($this->user) && date("d") >= 5 && date("d") <= 10) {
															if ($screen->id == 193) {
																$numKpi = $this->hr_model->numOfMissingKpiToManager();
																if ($numKpi > 0) {   ?>
																	<span class="menu-label">
																		<span class="label label-rounded label-danger"><?= $numKpi ?></span>
																	</span>
														<?php }
															}
														} ?>
														<?php if ($this->admin_model->checkIfUserIsManager($this->user) && $screen->id == 143) {
															$numVac = $this->hr_model->numOfVacationToManager();
															if ($numVac > 0) {   ?>
																<span class="menu-label">
																	<span class="label label-rounded label-danger"><?= $numVac ?></span>
																</span>
														<?php }
														} ?>
														<?php if ($this->admin_model->checkIfUserIsManager($this->user) && $screen->id == 145) {
															$numMiss = $this->hr_model->numOfmissingToManager();
															if ($numMiss > 0) {   ?>
																<span class="menu-label">
																	<span class="label label-rounded label-danger"><?= $numMiss ?></span>
																</span>
														<?php }
														} ?>
													</a>
												</li>
											<?php } ?>
										</ul>
									</div>
								</li>
							<?php } ?>
						</ul>
						<!--end::Menu Nav-->
					</div>
					<!--end::Menu Container-->
				</div>
				<!--end::Aside Menu-->
			</div>
			<!--end::Aside-->
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
				<!--begin::Header-->
				<div id="kt_header" class="header header-fixed">
					<!--begin::Container-->
					<div class="container d-flex align-items-stretch justify-content-between">
						<!--begin::Left-->
						<div class="d-none d-lg-flex align-items-center mr-3">
							<!--begin::Aside Toggle-->
							<button class="btn btn-icon aside-toggle ml-n3 mr-10" id="kt_aside_desktop_toggle">
								<span class="svg-icon svg-icon-xxl svg-icon-dark-75">
									<!--begin::Svg Icon | path:assets/media/svg/icons/Text/Align-left.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2" rx="1" />
											<rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2" rx="1" />
											<path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z" fill="#000000" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>
							</button>
							<!--end::Aside Toggle-->
							<!--begin::Logo-->
							<a href="#">
								<?php if ($this->brand == 1) { ?>
									<img alt="Logo" src="<?php echo base_url(); ?>assets/images/logo_ar.png" class="logo-default max-h-50px" />
								<?php } elseif ($this->brand == 2) { ?>
									<img alt="Logo" src="<?php echo base_url(); ?>assets/images/localizera_logo.png" class="logo-default max-h-20px" />
								<?php } elseif ($this->brand == 3) { ?>
									<img alt="Logo" src="<?php echo base_url(); ?>assets/images/europe.png" class="logo-default max-h-70px" />
								<?php } elseif ($this->brand == 11) { ?>
									<img alt="Logo" src="<?= base_url(); ?>assets/images/columbus_logo.jpg" class="logo-default max-h-70px" />
								<?php } ?>
							</a>
							<!--end::Logo-->
						</div>
						<!--end::Left-->
						<!--begin::Topbar-->
						<div class="topbar">
							<!--begin::Tablet & Mobile Search-->
							<div class="dropdown d-flex d-lg-none">
								<!--begin::Toggle-->
								<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
									<div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
										<span class="svg-icon svg-icon-xl">
											<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
													<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
									</div>
								</div>
								<!--end::Toggle-->
								<!--begin::Dropdown-->
								<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
									<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
										<!--begin:Form-->
										<form method="get" class="quick-search-form">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<span class="svg-icon svg-icon-lg">
															<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																	<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
																</g>
															</svg>
															<!--end::Svg Icon-->
														</span>
													</span>
												</div>
												<input type="text" class="form-control" placeholder="Search..." />
												<div class="input-group-append">
													<span class="input-group-text">
														<i class="quick-search-close ki ki-close icon-sm text-muted"></i>
													</span>
												</div>
											</div>
										</form>
										<!--end::Form-->
										<!--begin::Scroll-->
										<div class="quick-search-wrapper scroll" data-scroll="true" data-height="325" data-mobile-height="200"></div>
										<!--end::Scroll-->
									</div>
								</div>
								<!--end::Dropdown-->
							</div>
							<!--end::Tablet & Mobile Search-->

							<!--begin::Quick Actions-->
							<div class="topbar-item mr-4">
								<div class="btn btn-icon btn-sm btn-clean btn-text-dark-75" id="kt_quick_actions_toggle">
									<span class="svg-icon svg-icon-lg">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
												<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</div>
							</div>
							<!--end::Quick panel-->
							<!--begin::User-->
							<div class="topbar-item mr-4">
								<div class="btn btn-icon btn-sm btn-clean btn-text-dark-75" id="kt_quick_user_toggle">
									<span class="svg-icon svg-icon-lg">
										<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24" />
												<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
												<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</div>
							</div>
							<!--end::User-->
						</div>
						<!--end::Topbar-->
					</div>
					<!--end::Container-->
				</div>

				<!--end::Header-->