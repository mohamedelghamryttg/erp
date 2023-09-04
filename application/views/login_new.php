<!DOCTYPE html>
<!--
Template Name: Nexus System
-->
<html lang="en">
<!--begin::Head-->

<head>
	<!-- <base href="../../../../"> -->
	<meta charset="utf-8" />
	<title>Sign In | Nexus Site Manager</title>
	<meta name="description" content="Singin page example" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="canonical" href="https://keenthemes.com/metronic" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Custom Styles(used by this page)-->
	<link href="<?php echo base_url(); ?>assets_new/css/pages/login/login-4.css" rel="stylesheet" type="text/css" />
	<!--end::Page Custom Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="<?php echo base_url(); ?>assets_new/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets_new/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets_new/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<!--end::Layout Themes-->
	<!-- 		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets_new/media/logos/favicon.ico" /> -->
    <style>
    @media (min-width: 992px){
.display2-lg {
    font-size: 4.8rem !important;
}}
</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid">
			<!--begin::Content-->
			<div class="login-container order-2 order-lg-1 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 #ebebeb">
				<!--begin::Wrapper-->
				<div class="login-content d-flex flex-column pt-lg-0 pt-12">
					<!--begin::Logo-->
					<!-- 						<a href="#" class="login-logo pb-xl-20 pb-15">
							<img src="<?php echo base_url(); ?>assets_new/media/logos/logo-4.png" class="max-h-70px" alt="" />
						</a> -->
					<!--end::Logo-->
					<!--begin::Signin-->
					<div class="login-form">
						<!--begin::Form-->
						<form class="form" id="kt_login_singin_form" action="<?php echo base_url() ?>Login/doLogin" method="post">
							<!--begin::Title-->


							<div class="pb-5 pb-lg-15">
                            <img src="<?php echo base_url(); ?>assets/images/nexusLogo.png" class="max-h-70px" style="max-height: 165px !important;" alt="">
									<!-- <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In Nexus</h3>
																<div class="text-muted font-weight-bold font-size-h4">New Here?
									<a href="custom/pages/login/login-4/signup.html" class="text-primary font-weight-bolder">Create Account</a></div> -->
							</div>

							<?php if ($this->session->flashdata('true')) { ?>
								<div class="pb-5 pb-lg-15">
									<div class="alert alert-block alert-danger">
										<strong>Error! </strong>
										<?= $this->session->flashdata('true') ?>
									</div>
								</div>
							<?php } ?>
							<!--begin::Title-->
							<!--begin::Form group-->
							<div class="form-group">
								<label class="font-size-h6 font-weight-bolder text-dark">Your Email</label>
								<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="email" name="email" autocomplete="off" required="" />
							</div>
							<!--end::Form group-->
							<!--begin::Form group-->
							<div class="form-group">
								<div class="d-flex justify-content-between mt-n5">
									<label class="font-size-h6 font-weight-bolder text-dark pt-5">Your Password</label>
									<!-- 										<a href="custom/pages/login/login-4/forgot.html" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot Password ?</a> -->
								</div>
								<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" name="password" autocomplete="off" required="" />
							</div>
							<!--end::Form group-->
							<!--begin::Action-->
							<div class="pb-lg-0 pb-5">
								<button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3" style="background: linear-gradient(147.04deg, #14587a 0.74%, #000 99.61%);border-color: transparent;">Sign
									In</button>
							</div>
							<!--end::Action-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Signin-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--begin::Content-->
			<!--begin::Aside-->
			<div class="login-aside order-1 order-lg-2 bgi-no-repeat bgi-position-x-right" style="width: 50%;background: linear-gradient(147.04deg, #14587a 0.74%, #000 99.61%) !important;">
				<div class="login-conteiner bgi-no-repeat bgi-position-x-right bgi-position-y-bottom" style="background-image: url(<?php echo base_url(); ?>assets_new/media/svg/illustrations/login-visual-4.svg);">
					<!--begin::Aside title-->
					<h4 class="pt-lg-40 pl-lg-20 pb-lg-0 pl-10 py-20 m-0 d-flex justify-content-lg-start font-weight-boldest display5 display2-lg text-white" >
						Your
						<br />Success Story
						<br />Starts Here!
					</h4>
					<!--end::Aside title-->
				</div>
			</div>
			<!--end::Aside-->
		</div>
		<!--end::Login-->
	</div>
	<!--end::Main-->
	<!--begin::Global Config(global config for global JS scripts)-->
	<script>
		var KTAppSettings = {
			"breakpoints": {
				"sm": 576,
				"md": 768,
				"lg": 992,
				"xl": 1200,
				"xxl": 1200
			},
			"colors": {
				"theme": {
					"base": {
						"white": "#ffffff",
						"primary": "#6993FF",
						"secondary": "#E5EAEE",
						"success": "#1BC5BD",
						"info": "#8950FC",
						"warning": "#FFA800",
						"danger": "#F64E60",
						"light": "#F3F6F9",
						"dark": "#212121"
					},
					"light": {
						"white": "#ffffff",
						"primary": "#E1E9FF",
						"secondary": "#ECF0F3",
						"success": "#C9F7F5",
						"info": "#EEE5FF",
						"warning": "#FFF4DE",
						"danger": "#FFE2E5",
						"light": "#F3F6F9",
						"dark": "#D6D6E0"
					},
					"inverse": {
						"white": "#ffffff",
						"primary": "#ffffff",
						"secondary": "#212121",
						"success": "#ffffff",
						"info": "#ffffff",
						"warning": "#ffffff",
						"danger": "#ffffff",
						"light": "#464E5F",
						"dark": "#ffffff"
					}
				},
				"gray": {
					"gray-100": "#F3F6F9",
					"gray-200": "#ECF0F3",
					"gray-300": "#E5EAEE",
					"gray-400": "#D6D6E0",
					"gray-500": "#B5B5C3",
					"gray-600": "#80808F",
					"gray-700": "#464E5F",
					"gray-800": "#1B283F",
					"gray-900": "#212121"
				}
			},
			"font-family": "Poppins"
		};
	</script>
	<!--end::Global Config-->
	<!--begin::Global Theme Bundle(used by all pages)-->
	<!-- 		<script src="<?php echo base_url(); ?>assets_new/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets_new/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets_new/js/scripts.bundle.js"></script> -->
	<!--end::Global Theme Bundle-->
	<!--begin::Page Scripts(used by this page)-->
	<!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>