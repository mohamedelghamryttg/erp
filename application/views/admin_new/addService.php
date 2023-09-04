<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add Service</h3>

			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url() ?>admin/doAddService" onsubmit="return disableAddButton();"
				method="post" enctype="multipart/form-data">
				<div class="card-body">

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Service</label>
						<div class="col-lg-6">
							<input name="name" id="name" class="form-control" required />

						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Abbreviation</label>
						<div class="col-lg-6">
							<input name="abbreviations" id="abbreviations" data-maxlength="3" class="form-control"
								required />

						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label text-right">Q.C Log Selection</label>
						<div class="col-lg-6">
							<select name='qclog' class='form-control m-b' id="qclog" onchange="showDiv('div',this)">
								<option value="" selected="selected">-- Select Q.C Log --</option>
								<option value="1">Upload File</option>
								<option value="2">Check List</option>
								<option value="3">Both</option>
							</select>
						</div>
					</div>
					<div id="chklistitem" style="display:none">
						<div class="card-body border">
							<h6>Check List Item</h6>
							<div class="table-responsive">
								<table class="table table-hover text-center">
									<tbody>

										<?php for ($i = 1; $i < 31; $i++): ?>
											<tr>
												<td style="vertical-align: middle;font-weight: bold;">
													<?= $i; ?> -
												</td>
												<td><input type="text" class="form-control font-weight-bold"
														name="<?= 'logcheck' . $i; ?>" id="<?= 'logcheck' . $i; ?>"
														maxlength="100">
												</td>
											</tr>
										<?php endfor; ?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-lg-3"></div>
							<div class="col-lg-6">
								<button type="submit" class="btn btn-success mr-2">Submit</button>
								<a class="btn btn-secondary" href="<?php echo base_url() ?>admin/services"
									class="btn btn-default" type="button">Cancel</a>
							</div>
						</div>
					</div>

				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>
<script>
	function showDiv() {
		getSelectValue = document.getElementById("qclog").value;
		if (getSelectValue == "2" || getSelectValue == "3") {
			document.getElementById("chklistitem").style.display = "block";
		} else {
			document.getElementById("chklistitem").style.display = "none";
			for (let index = 1; index < 31; index++) {
				document.getElementById("logcheck" + index).value = '';

			}
		}
	}
</script>