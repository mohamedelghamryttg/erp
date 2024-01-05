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
				?>
			</div>

			<div class="modal-body  px-0">
				<div class="col-12">

					<form class="cmxform form-horizontal" id="searchform" enctype="multipart/form-data">
						<div class="card-body  py-3 my-0">


							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right">Client</label>
								<div class="col-lg-4">
									<select name="customer" class="form-control m-b" id="customer">
										<option disabled="disabled" selected="selected">-- Select Client --</option>
										<?= $this->customer_model->selectCustomerBranches($customer, $brand) ?>
									</select>
								</div>

								<label class="col-lg-2 control-label" for="role name">PO Number</label>

								<div class="col-lg-4">
									<input type="text" class="form-control" value="<?= $po ?>" name="po">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 control-label" for="role date">Po Status</label>

								<div class="col-lg-4">
									<select name="verified" class="form-control m-b" id="verified">
										<option value="" disabled="disabled" selected="selected">-- Select Status --</option>

										<option value="1" <?= $verified == 1 ? " selected" : "" ?>>Verified</option>
										<option value="3" <?= $verified == 3 ? " selected" : "" ?>>Not Verified</option>
										<option value="2" <?= $verified == 2 ? " selected" : "" ?>>Has Error</option>

									</select>
								</div>
								<label class="col-lg-2 control-label" for="role date">Invoice Status</label>

								<div class="col-lg-4">
									<select name="invoiced" class="form-control m-b" id="invoiced">
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

								<div class="form-group row">
									<label class="col-lg-2 col-form-label col-sm-12" for="role cdate">Date
										Ranges</label>
									<div class="col-lg-4">
										<div class='input-group' id='kt_daterangepicker_6'>
											<input type='text' class="form-control" readonly placeholder="Select date range" id="cdate" />

										</div>
									</div>


									<label class="col-lg-2 col-form-label text-right">Payment Status</label>
									<div class="col-lg-4">
										<select name="paid" class="form-control m-b" id="paid">
											<option value="" disabled="disabled" selected="selected">-- Select Status --</option>

											<option value="1" <?= $verified == 1 ? " selected" : "" ?>>Paid</option>
											<option value="0" <?= $verified == 0 ? " selected" : "" ?>>Not Paid</option>

										</select>

									</div>
								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button class="btn btn-primary" name="search" data-toggle="filter11Modal" id="search" type="button" value="search">Search</button>
				<a href="<?= base_url() ?>admin/screens" class="btn btn-warning">(x) Clear Filter</a>
			</div>
		</div>
	</div>
</div>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="container-fluid">
		<!--begin::Card-->
		<div class="card">
			<div class="card-header flex-wrap border-0 pt-6 pb-0">
				<div class="card-title">
					<h3 class="card-label">Screens</h3>
				</div>
			</div>
		</div>
		<div class="card-body">
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
						<th>Jobs Count</th>
						<th>Closed Date</th>
						<th>PM Name</th>
						<th>Verified</th>
						<th>Verified At</th>
						<th>Has Error</th>
						<th>Invoiced</th>
						<th>Paid</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	td.details-control {
		background: url('https://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
		cursor: pointer;
	}

	tr.shown td.details-control {
		background: url('https://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
	}

	#detalis_div {
		padding-left: 20px;
		padding-right: 10px;
		border-bottom: 1px solid #3d3d3d !important;
		border-style: double solid !important;
		border-color: #e5e5e5;
	}

	#detalis_dev .dataTables_scroll {
		border: 1px solid #a19d9d;
	}

	table {
		border-collapse: collapse;
	}

	tr {
		border-bottom: 1pt solid black;
	}

	#detalis_dev table thead th {
		background-color: #fff;
	}

	.dataTables_wrapper th,
	td {
		white-space: normal;

	}
</style>

<script>
	var table
	let screensData;
	let permissions;

	var childEditors = {};
	$(document).ready(function() {
		$.fn.dataTableExt.sErrMode = "console";
		$.fn.DataTable.ext.pager.numbers_length = 15;
		loadAjaxData();

		function loadAjaxData() {
			$.ajax({
				url: base_url + 'Accounting/cpoStatus_data',
				type: "POST",
				async: true,
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
						didOpen: function() {
							Swal.showLoading()
						}
					});

				},

				success: function(data) {
					var data = JSON.parse(atob(data));
					screensData = data['cpo'];
					permissions = data['permission'];
					swal.close();
					createTables(screensData, permissions);
					return
				},
				error: function(jqXHR, exception) {
					swal.close();
				}
			});
		}

		function createTables(screensData, permissions) {
			// Main table
			table = $('#kt_datatable2').DataTable({
				data: screensData,

				processing: true,
				serverSide: false,
				bDestroy: true,
				paging: true,
				select: false,
				searching: false,
				dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
				lengthMenu: [5, 10, 25, 50],
				pageLength: 10,
				pagingType: "full_numbers",
				scrollX: true,
				// scrollY: "50vh",
				scrollCollapse: true,

				responsive: false,
				// bProcessing: true,
				language: {
					lengthMenu: "_MENU_ Rows per page",
					info: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
					// sSearch: "_INPUT_",
					// sSearchPlaceholder: "Search table",
					paginate: {
						next: '<i class="fas fa-angle-right"></i>',
						previous: '<i class="fas fa-angle-left"></i>',
						first: '<i class="fas fa-angle-double-left"></i>',
						last: '<i class="fas fa-angle-double-right"></i>'
					},
					aria: {
						sortAscending: ": activate to sort column ascending",
						sortDescending: ": activate to sort column descending"
					},
				},
				columnDefs: [{
					className: 'details-control main-table noExport',
					orderable: false,
					data: null,
					defaultContent: '',
					targets: 0
				}, ],
				order: [
					[6, 'asc']
				],
				pageResize: true,
				autoWidth: true,
				orderCellsTop: true,
				deferRender: false,
				columns: [{
						data: null,
					},
					{
						data: "id"
					},
					{
						data: "customer_name"
					},
					{
						data: "number",
						className: 'text-wrap'
					},
					{
						data: null,
						className: 'noExport',
						render: function(row) {
							return '<a href="<?= base_url() ?>assets/uploads/cpo/' + row.cpo_file +
								' target="_blank">Click Here</a></td>'
						}
					},
					{
						data: 'job_count',
						className: 'noExport'
					},
					{
						data: "created_at"
					},
					{
						data: "pm"
					},
					{
						data: null,
						render: function(row) {
							if (row.verified == 1) {
								return "Verified";
							} else if (row.verified == 2) {
								return "Has Error";
							} else {
								return "Not Verified";
							}
						}
					},
					{
						data: "verified_at"
					},
					{
						data: "error_name",
						className: 'text-wrap'
					},
					{
						data: null,
						render: function(row) {
							if (row.invoiced == 1) {
								return "Invoiced";
							} else {
								return "Not Invoiced";
							}
						}
					},
					{
						data: null,
						render: function(row) {
							if (row.paid == 1) {
								return "Paid";
							} else {
								return "Not Paid";
							}
						}
					}
				],
				buttons: [


					{
						text: 'Search Conditions',
						className: 'btn btn-success btn-sm text-center font-monospace fw-bold text-uppercase',
						action: function(e, dt, node, config) {
							$('#filter11Modal').modal('show')
						}
					},
					{
						extend: 'collection',
						className: 'btn btn-primary btn-sm text-center font-monospace fw-bold text-uppercase',

						text: 'Export',
						buttons: [{
								extend: 'excelHtml5',
								text: '<i class="far fa-file-excel"></i>',
								className: 'btn btn-primary btn-sm text-center font-monospace fw-bold text-uppercase',

								titleAttr: 'Excel',
								autoFilter: true,
								title: 'CPO Status List',
								filename: 'CPO Status List',
								sheetName: 'CPO Status List',
								exportOptions: {
									columns: "thead th:not(.noExport)",
									extension: 'xlsx',
									modifier: {
										// page: 'current'
									}

								},
								excelStyles: {
									template: "blue_medium"
								},
								init: function(api, node, config) {
									$(node).removeClass('btn-secondary')
								},
								// customize: function(xlsx) {
								// 	var table = $('#kt_datatable2').DataTable();
								// 	// Get number of columns to remove last hidden index column.
								// 	var numColumns = table.columns().header().count();

								// 	// Get sheet.
								// 	var sheet = xlsx.xl.worksheets['sheet1.xml'];

								// 	var col = $('col', sheet);
								// 	// Set the column width.
								// 	$(col[1]).attr('width', 20);

								// 	// Get a clone of the sheet data.        
								// 	var sheetData = $('sheetData', sheet).clone();

								// 	// Clear the current sheet data for appending rows.
								// 	$('sheetData', sheet).empty();

								// 	// Row count in Excel sheet.
								// 	var rowCount = 1;

								// 	// Itereate each row in the sheet data.
								// 	$(sheetData).children().each(function(index) {

								// 		// Used for DT row() API to get child data.
								// 		var rowIndex = index - 1;

								// 		// Don't process row if its the header row.
								// 		if (index > 0) {

								// 			// Get row
								// 			var row = $(this.outerHTML);

								// 			// Set the Excel row attr to the current Excel row count.
								// 			row.attr('r', rowCount);

								// 			var colCount = 1;

								// 			// Iterate each cell in the row to change the rwo number.
								// 			row.children().each(function(index) {
								// 				var cell = $(this);

								// 				// Set each cell's row value.
								// 				var rc = cell.attr('r');
								// 				rc = rc.replace(/\d+$/, "") + rowCount;
								// 				cell.attr('r', rc);

								// 				if (colCount === numColumns) {
								// 					cell.html('');
								// 				}

								// 				colCount++;
								// 			});

								// 			// Get the row HTML and append to sheetData.
								// 			row = row[0].outerHTML;
								// 			$('sheetData', sheet).append(row);
								// 			rowCount++;

								// 			// Get the child data - could be any data attached to the row.
								// 			var table1 = table.row(':eq(' + rowIndex + ')').data()).DataTable();
								// 			var childData = table1.row(':eq(' + rowIndex + ')').data().job_count;

								// 			if (childData.length > 0) {
								// 				// Prepare Excel formated row
								// 				headerRow = '<row r="' + rowCount +
								// 					'" s="2"><c t="inlineStr" r="A' + rowCount +
								// 					'"><is><t>' +
								// 					'</t></is></c><c t="inlineStr" r="B' + rowCount +
								// 					'" s="2"><is><t>Result' +
								// 					'</t></is></c><c t="inlineStr" r="C' + rowCount +
								// 					'" s="2"><is><t>Notes' +
								// 					'</t></is></c></row>';

								// 				// Append header row to sheetData.
								// 				$('sheetData', sheet).append(headerRow);
								// 				rowCount++; // Inc excelt row counter.

								// 			}

								// 			// The child data is an array of rows
								// 			for (c = 0; c < childData.length; c++) {

								// 				// Get row data.
								// 				child = childData[c];

								// 				// Prepare Excel formated row
								// 				childRow = '<row r="' + rowCount +
								// 					'"><c t="inlineStr" r="A' + rowCount +
								// 					'"><is><t>' +
								// 					'</t></is></c><c t="inlineStr" r="B' + rowCount +
								// 					'"><is><t>' + child.code +
								// 					'</t></is></c><c t="inlineStr" r="C' + rowCount +
								// 					'"><is><t>' + child.note +
								// 					'</t></is></c></row>';

								// 				// Append row to sheetData.
								// 				$('sheetData', sheet).append(childRow);
								// 				rowCount++; // Inc excelt row counter.

								// 			}
								// 			// Just append the header row and increment the excel row counter.
								// 		} else {
								// 			var row = $(this.outerHTML);

								// 			var colCount = 1;

								// 			// Remove the last header cell.
								// 			row.children().each(function(index) {
								// 				var cell = $(this);

								// 				if (colCount === numColumns) {
								// 					cell.html('');
								// 				}

								// 				colCount++;
								// 			});
								// 			row = row[0].outerHTML;
								// 			$('sheetData', sheet).append(row);
								// 			rowCount++;
								// 		}
								// 	});
								// }
							},
							{
								extend: 'pdfHtml5',
								className: 'btn btn-primary btn-sm text-center font-monospace fw-bold text-uppercase',

								text: '<i class="far fa-file-pdf"></i>',
								titleAttr: 'PDF',
								exportOptions: {
									columns: ':visible',
									orientation: 'landscape',
									columns: "thead th:not(.noExport)",
									modifier: {
										page: 'current'
									}
								},
								// customize: function(doc) {

								// 	// Get the row data in in table order and search applied
								// 	var table = $('#kt_datatable2').DataTable();
								// 	var rowData = table.rows({
								// 		order: 'applied',
								// 		search: 'applied'
								// 	}).data();
								// 	var headerLines = 0; // Offset for accessing rowData array

								// 	var newBody = []; // this will become our new body (an array of arrays(lines))
								// 	//Loop over all lines in the table
								// 	doc.content[1].table.body.forEach(function(line, i) {

								// 		// Remove detail-control column
								// 		newBody.push(
								// 			[line[1], line[2], line[3], line[4]]
								// 		);


								// 		if (line[0].style !== 'tableHeader' && line[0].style !== 'tableFooter') {
								// 			var table1 = document.getElementById(table.row(':eq(' + rowIndex + ')').data().id).DataTable();
								// 			var childData = table1.row(':eq(' + rowIndex + ')').data().job_count;

								// 			// var childTable = $('#' + line[0].text).DataTable();
								// 			// var childdata = childTable.rows({
								// 			// 	order: 'applied',
								// 			// 	search: 'applied'
								// 			// }).data();
								// 			console.log(childdata)
								// 			//rowData[i - headerLines];

								// 			// Append child data, matching number of columns in table
								// 			newBody.push(
								// 				[{
								// 						text: '** Child data:',
								// 						style: 'defaultStyle'
								// 					},
								// 					{
								// 						text: childdata.code,
								// 						style: 'defaultStyle'
								// 					},
								// 					{
								// 						text: childdata.id,
								// 						style: 'defaultStyle'
								// 					},
								// 					{
								// 						text: '',
								// 						style: 'defaultStyle'
								// 					},
								// 				]
								// 			);

								// 		} else {
								// 			headerLines++;
								// 		}
								// 	});

								// 	//Overwrite the old table body with the new one.
								// 	doc.content[1].table.headerRows = 1;
								// 	//doc.content[1].table.widths = [50, 50, 50, 50, 50, 50];
								// 	doc.content[1].table.body = newBody;
								// 	doc.content[1].layout = 'lightHorizontalLines';

								// 	doc.styles = {
								// 		subheader: {
								// 			fontSize: 10,
								// 			bold: true,
								// 			color: 'black'
								// 		},
								// 		tableHeader: {
								// 			bold: true,
								// 			fontSize: 10.5,
								// 			color: 'black'
								// 		},
								// 		lastLine: {
								// 			bold: true,
								// 			fontSize: 11,
								// 			color: 'blue'
								// 		},
								// 		defaultStyle: {
								// 			fontSize: 10,
								// 			color: 'black',
								// 			text: 'center'
								// 		}
								// 	};
								// }
							},
							{
								extend: 'print',
								className: 'btn btn-primary btn-sm text-center font-monospace fw-bold text-uppercase',

								text: '<i class="fas fa-print"></i>',
								titleAttr: 'Print',

								exportOptions: {
									columns: ':visible',
									orientation: 'landscape',
									columns: "thead th:not(.noExport)",
								},
								customize: function(win) {
									$(win.document.body).addClass('white-bg');
									$(win.document.body).css('font-size', '10px');
									$(win.document.body).find('table')
										.addClass('compact')
										.css('font-size', 'inherit');
								}
							}
						]
					},
					{
						extend: 'colvis',
						className: 'btn btn-primary btn-sm text-center font-monospace fw-bold text-uppercase',

						postfixButtons: ['colvisRestore'],
						text: '<i class="fa fa-bars"></i>',
						collectionLayout: 'fixed two-column',
						collectionTitle: 'Column visibility control',
						columns: ':not(.noVis)',
						columnText: function(dt, idx, title) {
							return (idx + 1) + ': ' + title;
						},
					}
				],
			}).on('buttons-processing', function(e, indicator) {
				if (indicator) {
					Swal.fire({
						title: 'Please Wait !',
						html: 'Descargar excel', // add html attribute if you want or remove
						allowEscapeKey: false,
						allowOutsideClick: false,
						didOpen: () => {
							Swal.showLoading()
						}
					});
				} else {
					swal.close();
				}
			});
		}

		function getTableId(level, uniqueData) {
			return level + '-' + uniqueData.replace(' ', '-');
		}

		// function format(rowData, tableId) {

		function format(rowData, tableId) {
			return '<div id="detalis_div"><table id="' + tableId + '" class="table table-striped table-bordered" style="border: 1px solid #bdbdbd;border-radius: 0;background-color: #fff;" cellpadding="5" cellspacing="0">' +
				'<thead style="white-space: normal;">' +
				'<th style="color: #787676 ;">#</th>' +
				'<th style="color: #787676 ;">Job Code</th>' +
				'<th style="color: #787676 ;">Service</th>' +
				'<th style="color: #787676 ;">Source</th>' +
				'<th style="color: #787676 ;">Target</th>' +
				'<th style="color: #787676 ;">Volume</th>' +
				'<th style="color: #787676 ;">Rate</th>' +
				'<th style="color: #787676 ;">Currency</th>' +
				'<th style="color: #787676 ;">Total Revenue</th>' +
				'<th style="color: #787676 ;">Status</th>' +
				'<th style="color: #787676 ;">Closed Date</th>' +
				'<th style="color: #787676 ;">Created By</th>' +
				'</thead>' +

				'</table>' +
				'<div><span id="jobTotal"></span></div>' +
				'</div>';
		}


		// Add event listener for for main talbe to open and close first level child details
		$('#kt_datatable2 tbody').on('click', 'td.details-control', function() {
			var tr = $(this).closest('tr');

			var row = table.row(tr);
			var rowData = row.data();
			// if (row.child.isShown()) {
			// 	row.child.hide();
			// 	tr.removeClass('shown');
			// } else {
			// 	row.child(format(row.data())).show();
			// 	tr.addClass('shown');
			// }
			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');

				// Destroy the Child Datatable
				$('#' + rowData.id.replace(' ', '-')).DataTable().destroy();
			} else {

				var id = getTableId("1", rowData.id);

				// Open this row
				row.child(format(rowData, id)).show();

				table1 = $('#' + id).DataTable({
					dom: "t",
					pageResize: true,
					autoWidth: true,
					scrollY: '50vh',
					scrollX: true,
					scroller: true,
					scrollCollapse: true,
					ajax: {
						url: base_url + 'Accounting/get_data_cpo_job',
						type: "POST",
						datatype: "json",
						data: {
							'id': rowData.id
						},
						dataSrc: 'jobs'
					},
					// data: data,
					columns: [{
							data: null,
							render: function(data, type, row, meta) {
								return meta.row + meta.settings._iDisplayStart + 1;
							},
							className: "text-right"
						},
						{
							// title: "Job Code",
							data: 'code'
						},
						{
							// title: "Service",
							data: 'service'
						},
						{
							// title: "Source",
							title: 'source'
						},
						{
							// title: "Target",
							data: 'target'
						},
						{
							// title: "Volume",
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
							// title: "Rate",
							data: 'rate'
						},
						{
							// title: "Currency",
							data: 'currency'
						},
						{
							// title: "Total Revenue",
							data: 'jobTotal'
						},
						{
							// title: "Status",
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
							// title: "Closed Date",
							data: 'closed_date'
						},
						{
							// title: "Created By",
							data: 'user_name'
						},
					],
					// scrollX: true,
					// scrollY: "10vh",
					// select: true,
					footerCallback: function(row, data, start, end, display) {
						let api = this.api();

						// Remove the formatting to get integer data for summation
						let intVal = function(i) {
							return typeof i === 'string' ?
								i.replace(/[\$,]/g, '') * 1 :
								typeof i === 'number' ?
								i :
								0;
						};
						// Total over all pages
						total = api
							.column(8)
							.data()
							.reduce((a, b) => intVal(a) + intVal(b), 0);
						$('#jobTotal').html('<b>Project Total Revenue:   </b><u>' + total + '</u>');
					}
				});




				var iFrameID = document.getElementById(id);
				$('#' + id).on("load", function() {
					if (iFrameID) {
						iFrameID.height = "";
						iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
					}
				});
				tr.addClass('shown');
			}
		});


	});
</script>
<!-- 
<script>
	var bTable;
	let screensData;
	let permissions;
	$(document).ready(function() {
		$.fn.dataTableExt.sErrMode = "console";
		$.fn.DataTable.ext.pager.numbers_length = 15;

		loadAjaxData();

		function loadAjaxData() {
			$.ajax({
				url: base_url + 'Accounting/cpoStatus_data',
				type: "POST",
				async: true,
				// dataType: 'json',
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
						didOpen: function() {
							Swal.showLoading()
						}
					});

				},

				success: function(data) {
					var data = JSON.parse(atob(data));
					screensData = data['cpo'];
					permissions = data['permission'];
					swal.close();
					createTables(screensData, permissions);
					return
				},
				error: function(jqXHR, exception) {
					swal.close();
				}
			});
		}

		function createTables(screensData, permissions) {

			bTable = $("#kt_datatable2").DataTable({
				data: screensData,

				processing: true,
				serverSide: false,
				bDestroy: true,
				paging: true,
				select: false,
				searching: false,
				dom: "<'row'<'col-12 col-md-5'l><'col-sm-12 col-md-7 text-right'CB>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
				lengthMenu: [5, 10, 25, 50],
				pageLength: 10,
				pagingType: "full_numbers",
				scrollX: true,
				scrollY: "50vh",
				scrollCollapse: true,
				pageResize: true,
				responsive: true,
				// bProcessing: true,
				language: {
					lengthMenu: "_MENU_ Rows per page",
					info: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
					// sSearch: "_INPUT_",
					// sSearchPlaceholder: "Search table",
					paginate: {
						next: '<i class="fas fa-angle-right"></i>',
						previous: '<i class="fas fa-angle-left"></i>',
						first: '<i class="fas fa-angle-double-left"></i>',
						last: '<i class="fas fa-angle-double-right"></i>'
					},
					aria: {
						sortAscending: ": activate to sort column ascending",
						sortDescending: ": activate to sort column descending"
					},

					// processing: '<i class="fas fa-asterisk fa-spin fa-6x fa-fw"></i> < br > PROCESSING < br > Please wait...',

				},
				responsive: {
					details: {
						type: 'column',
						target: 0
					}
				},
				order: [1, 'desc'],
				autoWidth: true,
				orderCellsTop: true,
				deferRender: false,
				columns: [{
						data: 'id'
					},
					{
						data: 'group'
					},
					{
						data: 'name'
					},
					{
						data: 'url'
					},
					{
						data: 'menu'
					},

					{
						data: 'null',
						className: 'noExport noVis',
						orderable: false,
						render: function(data, type, row) {
							var action_btn = '<div>';
							if (permissions && permissions.edit == '1') {
								// action_btn += '<a class="btn btn-dark mr-2" href="<?php echo base_url() ?>admin/editPermission?t=' + btoa(row.id) + '"><i class="fa fa-pen "></i> Edit</a>';
								action_btn += '<a href="<?php echo base_url() ?>admin/editScreen/' + btoa(row.id) + '" class=""><i class="fa fa-pencil"></i> Edit</a>'
							}
							action_btn += '</div>';
							return action_btn
						}
					},
					{
						data: 'null',
						className: 'noExport noVis',
						orderable: false,
						render: function(data, type, row) {
							var action_btn = '<div>';
							if (permissions && permissions.delete == '1') {
								var conf_text = 'Are you sure you want to delete this Screen ? ';
								action_btn += '<a href="<?php echo base_url() ?>admin/deleteScreen/' + btoa(row.id) + ' title="delete" class="" onclick="return confirm("' + conf_text + '");"> <i class = "fa fa-times text-danger text"> </i> Delete </a>';
							}

							action_btn += '</div>';
							return action_btn
						}
					}
				],
				order: [],
				buttons: [

					{
						text: 'Add New Screen',
						className: 'btn btn-danger btn-sm text-center font-monospace  fw-bold text-uppercase',
						action: function(e, dt, node, config) {
							if (permissions && permissions.add == '1') {
								window.location.href = "<?= base_url() ?>admin/addScreen";
							}
						}
					},
					{
						text: 'Search Conditions',
						className: 'btn btn-success btn-sm text-center font-monospace fw-bold text-uppercase',
						action: function(e, dt, node, config) {
							$('#filter11Modal').modal('show')
						}
					},
					{
						extend: 'collection',
						// className: 'btn btn-success btn-sm text-center font-monospace fw-bold text-uppercase',

						text: 'Export',
						buttons: [{
								extend: 'excelHtml5',
								text: '<i class="far fa-file-excel"></i>',
								titleAttr: 'Excel',
								autoFilter: true,
								title: 'Permission List',
								filename: 'Permission List',
								sheetName: 'Permission List',
								exportOptions: {
									columns: "thead th:not(.noExport)",
									extension: 'xlsx',
									modifier: {
										// page: 'current'
									}

								},
								excelStyles: {
									template: "blue_medium"
								},
								init: function(api, node, config) {
									$(node).removeClass('btn-secondary')
								}
							},
							{
								extend: 'pdfHtml5',
								text: '<i class="far fa-file-pdf"></i>',
								titleAttr: 'PDF',
								exportOptions: {
									columns: ':visible',
									orientation: 'landscape',
									columns: "thead th:not(.noExport)",
								},

							},
							{
								extend: 'print',
								text: '<i class="fas fa-print"></i>',
								titleAttr: 'Print',

								exportOptions: {
									columns: ':visible',
									orientation: 'landscape',
									columns: "thead th:not(.noExport)",
								},
								customize: function(win) {
									$(win.document.body).addClass('white-bg');
									$(win.document.body).css('font-size', '10px');
									$(win.document.body).find('table')
										.addClass('compact')
										.css('font-size', 'inherit');
								}
							}
						]
					},
					{
						extend: 'colvis',
						postfixButtons: ['colvisRestore'],
						text: '<i class="fa fa-bars"></i>',
						collectionLayout: 'fixed two-column',
						collectionTitle: 'Column visibility control',
						columns: ':not(.noVis)',
						columnText: function(dt, idx, title) {
							return (idx + 1) + ': ' + title;
						},
					}
				],

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
		}
		//////////////////////////////
		$('#search').on('click', function(e) {
			e.preventDefault();
			loadAjaxData();
			$('#filter11Modal').modal('toggle');
		});
		//////////////////////////////
	});
</script> -->