<style>
	.datepicker {
		z-index: 10000;
	}

	.row.display-flex {
		display: flex;
		flex-wrap: wrap;
	}

	.row.display-flex>[class*='col-'] {
		display: flex;
		flex-direction: column;
	}

	.text-white {
		color: var(--bs-text-white) !important;
	}

	/* .fs-2hx {
            font-size: 2.5rem !important;
          } */

	.ls-n2 {
		letter-spacing: -.115rem !important;
	}

	.text-white {
		--bs-text-opacity: 1;
		color: rgba(var(--bs-white-rgb), var(--bs-text-opacity)) !important;
	}

	.lh-1 {
		line-height: 1 !important;
	}

	.fw-bold {
		font-weight: 600 !important;
	}

	.fs-0hx {
		font-size: calc(0.2rem + 1.0vw) !important;
	}

	.fs-1hx {
		font-size: calc(0.375rem + 1.0vw) !important;
	}

	.fs-2hx {
		font-size: calc(1.375rem + 1.5vw) !important;
	}

	.fs-3hx {
		font-size: calc(1rem + 1.5vw) !important;
	}

	.fs-4hx {
		font-size: calc(.4rem + 1.5vw) !important;
	}

	.me-2 {
		margin-right: 1.5rem !important;
	}

	.fs-6 {
		font-size: 1.075rem !important;
	}

	.fw-semibold {
		font-weight: 500 !important;
	}

	.pt-1 {
		padding-top: 0.25rem !important;
	}

	.dataTables_wrapper .dataTable {

		border-radius: 0;
	}

	.table-bordered th,
	.table-bordered td {
		border-bottom: 1px solid #828AA0 !important;
	}
</style>

</style>
<?php if ($this->session->flashdata('true')) { ?>
	<div class="alert alert-success" role="alert">
		<span class="fa fa-check-circle"></span>
		<span><strong><?= $this->session->flashdata('true') ?></strong></span>
	</div>
<?php  } ?>
<?php if ($this->session->flashdata('error')) { ?>
	<div class="alert alert-danger" role="alert">
		<span class="fa fa-warning"></span>
		<span><strong><?= $this->session->flashdata('error') ?></strong></span>
	</div>
<?php  } ?>
<div class="container content-row">
	<div class="row">
		<!--begin::Col-->
		<div class="col-12" style="display: flex;">
			<div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
				<div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: #385898;">
					<!-- linear-gradient(180deg, rgb(71, 71, 204) 90%, rgb(0, 212, 255) 100%);"> -->
					<div class="card-body  p-0" style="float:left;">
						<span class="fs-3hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="AllCount"><?= $rec_all ?></span>
						<span class="card-text fs-0hx text-right">All Client PO </span>

					</div>
				</div>
			</div>

			<div class="col-sm-6 col-lg-2 d-flex align-items-stretch">
				<div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: #2abba7;">
					<!-- linear-gradient(180deg,  rgba(28,173,17,.8) 90%, rgba(0,212,255,.5) 100%);"> -->
					<div class="card-body p-0" style="float:left;">

						<span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="VerifiedCount"><?= $rec_v ?></span>
						<span class="card-text fs-0hx text-right"><br>Verified </span>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-lg-2 d-flex align-items-stretch">
				<div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: #f0284a;">
					<!-- linear-gradient(180deg,  rgba(248,40,90,.8) 90%, rgba(0,212,255,.5) 100%); "> -->
					<div class="card-body p-0" style="float:left;">
						<span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="ErrorCount"><?= $rec_e ?></span>
						<span class="card-text fs-0hx text-right"><br>Has Error </span>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-lg-2 d-flex align-items-stretch">
				<div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: #1877F2;">
					<!-- linear-gradient(180deg,  rgba(63,66,84,.8) 90%, rgba(0,212,255,.5) 100%);"> -->
					<div class="card-body p-0" style="float:left;">
						<span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="InvoicedCount"><?= $rec_i ?></span>
						<span class="card-text fs-0hx text-right"><br>Invoiced </span>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-2 d-flex align-items-stretch">
				<div class="card-body flex-fill btn-primary shadow-lg rounded p-3 w-100 h-100" style="background: #7E8299;">
					<!-- linear-gradient(180deg,  rgba(63,66,84,.8) 90%, rgba(0,212,255,.5) 100%);"> -->
					<div class="card-body p-0" style="float:left;">
						<span class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="PaidCount"><?= $rec_p ?></span>
						<span class="card-text fs-0hx text-right"><br>Paid </span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="filter11Modal" tabindex="-1" role="dialog" aria-labelledby="filter11ModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header text-center" style="margin-left: auto;margin-right: auto;">
				<h5 class="modal-title text-uppercase" id="filter11ModalLabel">Search Conditions</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div>
				<?php
				if (!empty($_REQUEST['customer'])) {
					$customer = $_REQUEST['customer'];
				} else {
					$customer = "";
				}
				if (!empty($_REQUEST['po'])) {
					$po = $_REQUEST['po'];
				} else {
					$po = "";
				}
				if (!empty($_REQUEST['verified'])) {
					$verified = $_REQUEST['verified'];
				} else {
					$verified = "";
				}
				if (!empty($_REQUEST['invoiced'])) {
					$invoiced = $_REQUEST['invoiced'];
				} else {
					$invoiced = "";
				}
				if (!empty($_REQUEST['paid'])) {
					$paid = $_REQUEST['paid'];
				} else {
					$paid = "";
				}

				if (!empty($_REQUEST['created_by'])) {
					$created_by = $_REQUEST['created_by'];
				} else {
					$created_by = "";
				}
				if (!empty($_REQUEST['from_date'])) {
					$from_date = $_REQUEST['from_date'];
				} else {
					$from_date = "";
				}
				if (!empty($_REQUEST['to_date'])) {
					$to_date = $_REQUEST['to_date'];
				} else {
					$to_date = "";
				}
				?>
			</div>

			<div class="modal-body  px-0">
				<div class="col-12">

					<form class="cmxform form-horizontal" id="searchform" enctype="multipart/form-data">
						<div class="card-body  py-3 my-0">


							<div class="form-group row">
								<label class="col-lg-2  control-label text-right" style="margin: auto;">Client</label>
								<div class="col-lg-4">
									<select name="customer" class="form-control m-b" id="customer" style="width: 100%;">
										<option disabled="disabled" selected="selected">-- Select Client --</option>
										<?= $this->customer_model->selectCustomerBranches($customer, $brand) ?>
									</select>
								</div>

								<label class="col-lg-2  control-label text-right" style="margin: auto;">PO Number</label>

								<div class="col-lg-4">
									<input type="text" class="form-control" value="<?= $po ?>" name="po">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-2  control-label text-right" style="margin: auto;">Po Status</label>

								<div class="col-lg-4">
									<select name="verified" class="form-control m-b" id="verified" style="width: 100%;">
										<option value="" disabled="disabled" selected="selected">-- Select Status --</option>

										<option value="1" <?= $verified == 1 ? " selected" : "" ?>>Verified</option>
										<option value="3" <?= $verified == 3 ? " selected" : "" ?>>Not Verified</option>
										<option value="2" <?= $verified == 2 ? " selected" : "" ?>>Has Error</option>

									</select>
								</div>
								<label class="col-lg-2  control-label text-right" style="margin: auto;">Invoice Status</label>

								<div class="col-lg-4">
									<select name="invoiced" class="form-control m-b" id="invoiced" style="width: 100%;">
										<option disabled="disabled" selected="selected">-- Select --</option>
										<?php
										if ($_REQUEST['invoiced'] == 1) { ?>
											<option selected="" value="<?= $_REQUEST['invoiced'] ?>">Invoiced</option>
											<option value="2">Not Invoiced</option>
										<?php } elseif ($_REQUEST['invoiced'] == 2) { ?>
											<option selected="" value="<?= $_REQUEST['invoiced'] ?>">Not Invoiced</option>
											<option value="1">Invoiced</option>
										<?php } else { ?>
											<option value="1">Invoiced</option>
											<option value="2">Not Invoiced</option>

										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group row">

								<label class="col-lg-2  control-label text-right" style="margin: auto;">Created by</label>
								<div class="col-lg-4">
									<select name="created_by" class="form-control m-b" id="created_by" style="width: 100% Iimportant;">
										<option value="">-- Select PM --</option>
										<?= $this->admin_model->selectAllPm($created_by, $this->brand) ?>
									</select>
								</div>

								<label class="col-lg-2  control-label text-right" style="margin: auto;">Payment Status</label>
								<div class="col-lg-4">
									<select name="paid" class="form-control m-b" id="paid" style="width: 100%;">
										<option value="" disabled="disabled" selected="selected">-- Select Status --</option>
										<option value="1" <?= $verified == 1 ? " selected" : "" ?>>Paid</option>
										<option value="0" <?= $verified == 0 ? " selected" : "" ?>>Not Paid</option>
									</select>
								</div>
							</div>

							<div class="form-group row">

								<label class="col-lg-2  control-label text-right" style="margin: auto;">

									<div class="dropdown dropdown-inline" data-bs-theme="light">
										<button class="btn btn-secondary  btn-icon btn-sm " type="button" id="dropdownMenuButtonLight" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent;border: none;height: 100%;">
											<i class="fa fa-ellipsis-v text-primary" aria-hidden="true"></i>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonLight">
											<li><a class="dropdown-item " onclick="changeValue('today')" href="javascript:void(0);">Today</a></li>
											<li><a class="dropdown-item " onclick="changeValue('7today')" href="javascript:void(0);">Last 7 Days</a></li>
											<li><a class="dropdown-item " onclick="changeValue('30today')" href="javascript:void(0);">Last 30 Days</a></li>

											<li>
												<hr class="dropdown-divider">
											</li>
											<li><a class="dropdown-item" onclick="changeValue('month')" href="javascript:void(0);">This Month</a></li>
											<li><a class="dropdown-item" onclick="changeValue('lmonth')" href="javascript:void(0);">Last Month</a></li>
											<li><a class="dropdown-item" onclick="changeValue('year')" href="javascript:void(0);">This Year</a></li>
											<li>
												<hr class="dropdown-divider">
											</li>
											<li><a class="dropdown-item" onclick="changeValue('fyear1')" href="javascript:void(0);">First Quarter</a></li>
											<li><a class="dropdown-item" onclick="changeValue('fyear2')" href="javascript:void(0);">Secand Quarter</a></li>
											<li><a class="dropdown-item" onclick="changeValue('fyear3')" href="javascript:void(0);">Theard Quarter</a></li>
											<li><a class="dropdown-item" onclick="changeValue('fyear4')" href="javascript:void(0);">Forth Quarter</a></li>
										</ul>
										<!-- </div> -->

									</div> From Date
								</label>
								<div class="col-lg-4" style="width: 100%;">
									<input type="text" class="input-group date_sheet form-control" name="from_date" id="from_date" required value="<?= $from_date ?>">
								</div>

								<label class="col-lg-2  control-label text-right" style="margin: auto;">To Date</label>
								<div class="col-lg-4" style="width: 100%;">
									<input type="text" class="date_sheet form-control" name="to_date" id="to_date" required value="<?= $to_date ?>">
								</div>

							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button class="btn btn-primary" name="search" data-toggle="filter11Modal" id="search" type="button" value="search">Search</button>
				<a href="<?= base_url() ?>accounting/cpoStatus" class="btn btn-warning">(x) Clear Filter</a>
			</div>
		</div>
	</div>
</div>
<div class="content d-flex flex-column flex-column-fluid  pt-2" id="kt_content">

	<div class="container-fluid">
		<!--begin::Card-->
		<div class="card  pt-2 mb-2 pb-0">
			<div class="card-header flex-wrap border-0 py-0">
				<div class="card-title">
					<h3 class="card-label">Customer Purchase Order List (CPO)</h3>
				</div>
			</div>
		</div>
		<div class="card-body-fluid">
			<!--begin: Datatable-->

			<!-- <table class="table table-striped table-separate table-head-custom row-bordered " id="examp" cellspacing="0" width="100%"> -->

			<table class="table table-striped table-separate table-head-custom table-bordered  " id="kt_datatable2" cellspacing="0" width="100%">

				<thead>
					<tr>
						<th>#</th>
						<th>Id</th>
						<th>Client Name</th>
						<th>PO Number</th>
						<th>CPO File</th>
						<!-- <th>Jobs Count</th> -->
						<th>Closed Date</th>
						<th>PM Name</th>
						<th>Verified</th>
						<th>Verified At</th>
						<th>Has Error</th>
						<th>Invoiced</th>
						<th>Paid</th>
						<th>Currency</th>
						<th>Total Revenue</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
<input type='hidden' id="brand_id" value="<?= $this->brand ?>">
<input type='hidden' id="brand_name" value="<?= $this->admin_model->getBrand($brand) ?>">

<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets_new/js/images.js"></script> -->

<script>
	var table
	let cpoData;
	let permissions;
	// var brand_id = $('#brand_id').val()
	// logo_def(brand_id)

	var childEditors = {};
	$(document).ready(function() {
		$.fn.dataTableExt.sErrMode = "console";

		table = $('#kt_datatable2').DataTable({
			// data: cpoData,
			processing: true,
			serverSide: true,
			order: [],
			destroy: true,
			paging: true,
			select: false,
			searching: false,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			pageLength: 10,
			pagingType: "full_numbers",
			scrollX: true,
			scrollY: "60vh",
			scrollCollapse: true,
			pageResize: true,
			responsive: false,

			rowReorder: false,
			orderMulti: true,
			fixedHeader: true,

			autoWidth: false,
			orderCellsTop: true,
			deferRender: true,
			stateSave: false,

			dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
				"<'row'<'col-sm-12'frt>>" +
				"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			language: {
				lengthMenu: "_MENU_ Rows per page",
				info: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
				paginate: {
					next: '<i class="fas fa-angle-right"></i>',
					previous: '<i class="fas fa-angle-left"></i>',
					first: '<i class="fas fa-angle-double-left"></i>',
					last: '<i class="fas fa-angle-double-right"></i>'
				},
			},
			'ajax': {

				url: base_url + 'accounting/cpoStatus_data',
				type: 'POST',
				data: {
					filter_data: function() {
						return $('#searchform').serialize();
					}
				},
				beforeSend: function() {
					Swal.fire({
						title: 'Please Wait !',
						text: 'Data Loading ....',
						allowEscapeKey: false,
						allowOutsideClick: false,
						onOpen: function() {
							Swal.showLoading()
						}
					});
				},

				dataSrc: function(json) {
					// console.log(json)
					swal.close();
					return (json.data);
					// }
				}
			},
			columnDefs: [{
					targets: 4,
					orderable: false,
					className: 'noExport'
				},
				{
					targets: 0,
					width: 1,
					className: 'details-control noExport noVis',
					orderable: false,
					data: null,
					defaultContent: ''

				},

			],
			initComplete: function(data) {

				// var allCount = (cpoData) ? cpoData.length : 0;
				// var rowToCount = data;

				// document.getElementById("AllCount").innerHTML = table.page.info().recordsTotal;
				// document.getElementById("VerifiedCount").innerHTML = data['json']['v_records'];

				// document.getElementById("ErrorCount").innerHTML = data['json']['e_records'];

				// document.getElementById("InvoicedCount").innerHTML = data['json']['i_records'];
				// document.getElementById("PaidCount").innerHTML = data['json']['p_records'];
			},
		}).on('buttons-processing', function(e, indicator) {
			if (indicator) {
				Swal.fire({
					title: 'Please Wait !',
					html: 'Descargar excel', // add html attribute if you want or remove
					allowEscapeKey: false,
					allowOutsideClick: false,
					onBeforeOpen: () => {
						Swal.showLoading()
					}
				});
			} else {
				swal.close();
			}
		});


		$('#kt_datatable2 tbody').on('click', 'td.details-control', function() {

			let tr = $(this).closest('tr');
			let row = $('#kt_datatable2').DataTable().row(tr);
			let rowData = row.data();
			// let rowData = rowData1['jobs_' + rowData1[0]]
			let tbId = `#tb-${'jobs_' + rowData[0]}`;
			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');

				$(tbId).DataTable().destroy();
			} else {
				// Open this row
				row.child(format1(rowData)).show();
				let jod_id = 'jobs_' + rowData[0]
				// console.log(rowData)
				let jod_data = rowData[jod_id]

				$(tbId).DataTable({
					data: jod_data,
					searching: false,
					bPaginate: false,
					info: false,
					scrollX: true,
					scrollY: "60vh",
					scrollCollapse: true,
					pageResize: true,
					responsive: false,

					columns: [

						{
							data: 'code'
						},
						{
							data: 'service'
						},
						{
							data: 'source'
						},
						{
							data: 'target'
						},
						{
							data: null,
							render: function(row) {
								if (row.type == 1) {
									return row.volume;
								} else if (row.type == 2) {
									return row.jobTotal / row.rate;
								}
							}
						},
						{
							data: 'rate'
						},
						{
							data: 'currency'
						},
						{
							data: 'jobTotal'
						},
						{
							data: null,
							render: function(row) {
								if (row.status == 0) {
									return "Running";
								} else if (row.status == 1) {
									return "Delivered";
								} else if (row.status == 2) {
									return "Cancelled";
								} else if (row.status == 4) {
									return "Waiting Vendor Acceptance";
								} else if (row.status == 3) {
									return "Rejected";
								} else if (row.status == 5) {
									return "Waiting PM Confirmation";
								} else if (row.status == 6) {
									return "Not Started Yet";
								} else if (row.status == 7) {
									return "Heads Up ";
								} else if (row.status == 8) {
									return "Heads Up ( Marked as Available )";
								} else if (row.status == 9) {
									return "Heads Up ( Marked as Not Available )";
								}
							}
						},
						{
							data: 'closed_date'
						},
						{
							data: 'user_name'
						}

					],
					rowCallback: function(row, data, dataIndex) {
						$(row).css("background-color", "#fff");
						$(row).css("border-bottom", "1px solid #000");
						$(row).css("white-space", "normal");
						// $(row).addClass('red');white-space: normal!important;
					},
				});

				tr.addClass('shown');
			}

		});

	});

	function format1(d) {
		// `d` is the original data object for the row

		let jod_id = 'jobs_' + d[0]
		let jod_data = d[jod_id]
		// console.log(jod_data);
		let tabla = `<div class="border mx-5" style="border-color: #c7c7c7 !important;"><table class="table table-bordered compact  table-responsive" id="tb-${jod_id}" cellpadding="5" cellspacing="0" style="border-collapse: separate; border-spacing: 1px 1px;" >
                    <thead>
                        <tr>
							
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Job Code</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Service</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Source</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Target</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Volume</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Rate</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Currency</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Total Revenue</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Status</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Closed Date</th>
							<th class="border border-secondary bg-white" style="color: #3f4254  !important;border-color: #b7b7b7 !important;">Created By</th>
						</tr> 
					</thead> 
					<tbody>`
		for (i = 0; i < jod_data.length; i++) {
			tabla += `<tr>`
			tabla += `<td class="">` + jod_data[i]['code'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `<td class="border border-secondary" style="border-color: #b7b7b7 !important;white-space: normal!important;">` + jod_data[i]['name'] + `</td>`
			tabla += `</tr>`
		};

		tabla += `</tbody>
                </table></div>`;

		// console.log(tabla)
		return $(tabla).toArray();
	}
</script>