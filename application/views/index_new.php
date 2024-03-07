<!--begin::Content-->
<style>
	@media (max-width: 768px) {
		.mobile_fontsize_12 {
			font-size: 12px !important;
			margin-left: -10px;
		}

		.mobile_fontsize_11 {
			font-size: 11px !important;
			margin-left: -10px;
		}
	}
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Dashboard-->
			<!--begin::Row-->
			<div class="row">
				<div class="col-xl-7">
					<div class="row">
						<div class="col-xl-12" style="height: 200px;">
							<!--begin::Engage Widget 8-->
							<div class="card card-custom gutter-b card-stretch card-shadowless">
								<div class="card-body p-0 d-flex">
									<div class="d-flex align-items-start justify-content-start flex-grow-1 bg-light-warning p-8 card-rounded flex-grow-1 position-relative">
										<div class="d-flex flex-column align-items-start flex-grow-1 h-100">
											<div class="p-1 flex-grow-1">
												<h4 class="font-weight-bolder mobile_fontsize_12" style="color:#c41106;">Welcome To Nexus</h4>
												<p class="text-dark font-weight-bold mt-3  mobile_fontsize_11" style="font-size: 14px ;">
													<?= $this->session->userdata('username') ?>
												</p>
											</div>
										</div>
										<div class="position-absolute right-0 bottom-0 overflow-hidden">
											<img src="<?= base_url() ?>assets_new/media/svg/humans/4963913.png" class="max-h-175px max-h-xl-325px mb-n5 mb-xl-n20" alt="" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end::Engage Widget 8-->
					<div class="row">
						<div class="col-xl-12">
							<?php if ($this->role == 21 || $this->role == 1) { ?>
								<a href="<?php echo base_url() ?>server/singleOperationalReportBYBrand" class="btn btn-primary font-weight-bolder" onclick="return confirm('Sending Reports .... Are You Sure?')">
									<i class="fa fa-envelope"></i> Send Single Operational Reports
								</a>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-xl-5">
					<div class="row">
						<div class="col-xl-12">
							<!--begin::Nav Panel Widget 1-->
							<div class="card card-custom gutter-b card-stretch card-shadowless">
								<!--begin::Body-->
								<div class="card-body p-0">
									<!--begin::Nav Tabs-->
									<ul class="dashboard-tabs nav nav-pills nav-danger row row-paddingless m-0 p-0 flex-column flex-sm-row" role="tablist">
										<!--begin::Item-->
										<li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
											<!-- <a href="<?= base_url() ?>hr/remoteAccess" class="btn nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center"> -->
											<a href="<?= base_url() ?>hr/remoteAccess" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5 d-flex flex-grow-1 rounded flex-column align-items-center">
												<span class="nav-icon py-2 w-auto">
													<span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Navigation\Sign-in.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24" />
																<rect fill="#000000" opacity="0.3" transform="translate(9.000000, 12.000000) rotate(-270.000000) translate(-9.000000, -12.000000) " x="8" y="6" width="2" height="12" rx="1" />
																<path d="M20,7.00607258 C19.4477153,7.00607258 19,6.55855153 19,6.00650634 C19,5.45446114 19.4477153,5.00694009 20,5.00694009 L21,5.00694009 C23.209139,5.00694009 25,6.7970243 25,9.00520507 L25,15.001735 C25,17.2099158 23.209139,19 21,19 L9,19 C6.790861,19 5,17.2099158 5,15.001735 L5,8.99826498 C5,6.7900842 6.790861,5 9,5 L10.0000048,5 C10.5522896,5 11.0000048,5.44752105 11.0000048,5.99956624 C11.0000048,6.55161144 10.5522896,6.99913249 10.0000048,6.99913249 L9,6.99913249 C7.8954305,6.99913249 7,7.89417459 7,8.99826498 L7,15.001735 C7,16.1058254 7.8954305,17.0008675 9,17.0008675 L21,17.0008675 C22.1045695,17.0008675 23,16.1058254 23,15.001735 L23,9.00520507 C23,7.90111468 22.1045695,7.00607258 21,7.00607258 L20,7.00607258 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.000000, 12.000000) rotate(-90.000000) translate(-15.000000, -12.000000) " />
																<path d="M16.7928932,9.79289322 C17.1834175,9.40236893 17.8165825,9.40236893 18.2071068,9.79289322 C18.5976311,10.1834175 18.5976311,10.8165825 18.2071068,11.2071068 L15.2071068,14.2071068 C14.8165825,14.5976311 14.1834175,14.5976311 13.7928932,14.2071068 L10.7928932,11.2071068 C10.4023689,10.8165825 10.4023689,10.1834175 10.7928932,9.79289322 C11.1834175,9.40236893 11.8165825,9.40236893 12.2071068,9.79289322 L14.5,12.0857864 L16.7928932,9.79289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.500000, 12.000000) rotate(-90.000000) translate(-14.500000, -12.000000) " />
															</g>
														</svg><!--end::Svg Icon-->
													</span>
												</span>
												<span class="nav-text font-size-lg py-2 font-weight-bolder text-center">Remote Access</span>
											</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
											<!-- <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" href="<?= base_url() ?>automation/tickets"> -->
											<a href="<?= base_url() ?>automation/addTicket" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5  d-flex flex-grow-1 rounded flex-column align-items-center">
												<span class="nav-icon py-2 w-auto">
													<span class="svg-icon svg-icon-primary svg-icon-3x">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24" />
																<path d="M17.2718029,8.68536757 C16.8932864,8.28319382 16.9124644,7.65031935 17.3146382,7.27180288 C17.7168119,6.89328641 18.3496864,6.91246442 18.7282029,7.31463817 L22.7282029,11.5646382 C23.0906029,11.9496882 23.0906029,12.5503176 22.7282029,12.9353676 L18.7282029,17.1853676 C18.3496864,17.5875413 17.7168119,17.6067193 17.3146382,17.2282029 C16.9124644,16.8496864 16.8932864,16.2168119 17.2718029,15.8146382 L20.6267538,12.2500029 L17.2718029,8.68536757 Z M6.72819712,8.6853647 L3.37324625,12.25 L6.72819712,15.8146353 C7.10671359,16.2168091 7.08753558,16.8496835 6.68536183,17.2282 C6.28318808,17.6067165 5.65031361,17.5875384 5.27179713,17.1853647 L1.27179713,12.9353647 C0.909397125,12.5503147 0.909397125,11.9496853 1.27179713,11.5646353 L5.27179713,7.3146353 C5.65031361,6.91246155 6.28318808,6.89328354 6.68536183,7.27180001 C7.08753558,7.65031648 7.10671359,8.28319095 6.72819712,8.6853647 Z" fill="#000000" fill-rule="nonzero" />
																<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-345.000000) translate(-12.000000, -12.000000) " x="11" y="4" width="2" height="16" rx="1" />
															</g>
														</svg><!--end::Svg Icon-->
													</span>
												</span>
												<span class="nav-text font-size-lg py-2 font-weight-bolder text-center">Automation Tickets</span>
											</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
											<!-- <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#tab_forms_widget_4"> -->
											<a href="<?= base_url() ?>it/addTicket" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5  d-flex flex-grow-1 rounded flex-column align-items-center">

												<span class="nav-icon py-2 w-auto">
													<span class="svg-icon svg-icon-primary svg-icon-3x">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24" />
																<path d="M12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.98630124,11 4.48466491,11.0516454 4,11.1500272 L4,7 C4,5.8954305 4.8954305,5 6,5 L20,5 C21.1045695,5 22,5.8954305 22,7 L22,16 C22,17.1045695 21.1045695,18 20,18 L12.9835977,18 Z M19.1444251,6.83964668 L13,10.1481833 L6.85557487,6.83964668 C6.4908718,6.6432681 6.03602525,6.77972206 5.83964668,7.14442513 C5.6432681,7.5091282 5.77972206,7.96397475 6.14442513,8.16035332 L12.6444251,11.6603533 C12.8664074,11.7798822 13.1335926,11.7798822 13.3555749,11.6603533 L19.8555749,8.16035332 C20.2202779,7.96397475 20.3567319,7.5091282 20.1603533,7.14442513 C19.9639747,6.77972206 19.5091282,6.6432681 19.1444251,6.83964668 Z" fill="#000000" />
																<path d="M8,17 C8.55228475,17 9,17.4477153 9,18 L9,21 C9,21.5522847 8.55228475,22 8,22 L3,22 C2.44771525,22 2,21.5522847 2,21 L2,18 C2,17.4477153 2.44771525,17 3,17 L3,16.5 C3,15.1192881 4.11928813,14 5.5,14 C6.88071187,14 8,15.1192881 8,16.5 L8,17 Z M5.5,15 C4.67157288,15 4,15.6715729 4,16.5 L4,17 L7,17 L7,16.5 C7,15.6715729 6.32842712,15 5.5,15 Z" fill="#000000" opacity="0.3" />
															</g>
														</svg>
													</span>
												</span>
												<span class="nav-text font-size-lg py-2 font-weight-bolder text-center">IT
													<br>Tickets</span>
											</a>
										</li>
										<!--end::Item-->

									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-12">
							<!--begin::Nav Panel Widget 1-->
							<div class="card card-custom gutter-b card-stretch card-shadowless">
								<!--begin::Body-->
								<div class="card-body p-0">
									<ul class="dashboard-tabs nav nav-pills nav-danger row row-paddingless m-0 p-0 flex-column flex-sm-row" role="tablist">
										<!--begin::Item-->
										<li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
											<a href="<?= base_url() ?>admin/whos" class="btn btn-block btn-light btn-hover-primary text-dark-50 text-center py-10 px-5  d-flex flex-grow-1 rounded flex-column align-items-center">
												<span class="nav-icon py-2 w-auto">
													<span class="svg-icon svg-icon-primary svg-icon-3x">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-account-search" width="26" height="26" viewBox="0 0 24 24">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24" />
																<path d="M15.5,12C18,12 20,14 20,16.5C20,17.38 19.75,18.21 19.31,18.9L22.39,22L21,23.39L17.88,20.32C17.19,20.75 16.37,21 15.5,21C13,21 11,19 11,16.5C11,14 13,12 15.5,12M15.5,14A2.5,2.5 0 0,0 13,16.5A2.5,2.5 0 0,0 15.5,19A2.5,2.5 0 0,0 18,16.5A2.5,2.5 0 0,0 15.5,14M10,4A4,4 0 0,1 14,8C14,8.91 13.69,9.75 13.18,10.43C12.32,10.75 11.55,11.26 10.91,11.9L10,12A4,4 0 0,1 6,8A4,4 0 0,1 10,4M2,20V18C2,15.88 5.31,14.14 9.5,14C9.18,14.78 9,15.62 9,16.5C9,17.79 9.38,19 10,20H2Z" fill="#fb6f92" fill-rule="nonzero"></path>
																<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-345.000000) translate(-12.000000, -12.000000) " x="11" y="4" width="2" height="16" rx="1" />
															</g>
														</svg>
													</span>
												</span>
												<span class="nav-text font-size-lg py-2 font-weight-bolder text-center">Company Directory</span>
											</a>
										</li>
										<!--end::Item-->
									</ul>
									<!--end::Nav Tabs-->
								</div>
								<!--end::Body-->
							</div>
							<!--begin::Nav Panel Widget 1-->
						</div>
					</div>
				</div>
			</div>

			<!--end::Row-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->
<script>
	var dt = new Date();
	var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
	console.log(time);
</script>