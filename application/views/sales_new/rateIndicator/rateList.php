<style>
  .badge span {
    vertical-align: text-top;
  }
</style>
<?php if ($this->session->flashdata('true')) { ?>
  <div class="alert alert-success" role="alert">
    <span class="fa fa-check-circle"></span>
    <span><strong>
        <?= $this->session->flashdata('true') ?>
      </strong></span>
  </div>
<?php } ?>
<?php if ($this->session->flashdata('error')) { ?>
  <div class="alert alert-danger" role="alert">
    <span class="fa fa-warning"></span>
    <span><strong>
        <?= $this->session->flashdata('error') ?>
      </strong></span>
  </div>
<?php } ?>
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid" id="kt_content">

  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search </h3>
        </div>
        <?php
        if (!empty($_REQUEST['product_line'])) {
          $product_line = $_REQUEST['product_line'];

        } else {
          $product_line = "";
        }       
        if (!empty($_REQUEST['source'])) {
          $source = $_REQUEST['source'];

        } else {
          $source = "";
        }
        if (!empty($_REQUEST['target'])) {
          $target = $_REQUEST['target'];

        } else {
          $target = "";
        }        
        if (!empty($_REQUEST['unit'])) {
          $unit = $_REQUEST['unit'];

        } else {
          $unit = "";
        }

        ?>
        <form class="form" id="rateIndicatorForm" action="<?php echo base_url() ?>sales/rateIndicator" method="get"
          enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group row"> 
              <label class="col-lg-2 control-label text-lg-right" for="role name">Product Line</label>
              <div class="col-lg-3">
                <select name="product_line" class="form-control m-b" id="product_line" />
                <option disabled="disabled" selected="selected" value="">-- Select Product Line --</option>
                <?= $this->customer_model->selectProductLine($product_line, $this->brand) ?>
                </select>
              </div>
              <label class="col-lg-2 col-form-label text-lg-right">Unit</label>
              <div class="col-lg-3">
                <select name="unit" class="form-control m-b" id="unit" />
                <option value="">-- Select --</option>
                <?= $this->admin_model->selectUnit($unit) ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-2 col-form-label text-lg-right">Source Language</label>
              <div class="col-lg-3">
                <select name="source" class="form-control m-b" id="source" />
                <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                <option value="0">Empty</option>
                <?= $this->admin_model->selectLanguage($source) ?>
                </select>
              </div>
              <label class="col-lg-2 control-label text-lg-right" for="role name">Target Language</label>
              <div class="col-lg-3">
                <select name="target" class="form-control m-b" id="target" />
                <option disabled="disabled" value="-1" selected="selected">-- Select Target Language --</option>
                <option value="0">Empty</option>
                <?= $this->admin_model->selectLanguage($target) ?>
                </select>
              </div>
            </div>
            <div class="form-group row">

            

            </div>
        </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search"
                    onclick="var e2 = document.getElementById('rateIndicatorForm'); e2.action='<?= base_url() ?>sales/rateIndicator'; e2.submit();"
                    type="submit">Search</button>
                  <a href="<?= base_url() ?>sales/rateIndicator" class="btn btn-warning"><i class="la la-trash"></i>Clear
                    Filter</a>

               

                </div>
              </div>
            </div>
        </form>
      
    </div>

    <!-- end search form -->

    <!--begin::Card-->
    <div class="card">
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
          <h3 class="card-label">Rate Indicator List</h3>
        </div>
      
      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-head-custom table-bordered" id="datatable1">
          <thead>
            <tr>              
             
                <th rowspan="2">Product Line</th>
                <th rowspan="2">Source</th>
                <th rowspan="2">Target</th>
                <th colspan="3">Customer Rate indicator</th>
             
            </tr>
            <tr>              
              <th>Customer Name</th>             
              <th>Rate</th>
              <th>Unit</th> 
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($priceList->result() as $row) {
                           ?>
              <tr class="">
                <td>
                  <?php echo $this->customer_model->getProductLine($row->product_line); ?>
                </td>
                   <td>
                  <?php echo $this->admin_model->getLanguage($row->source); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getLanguage($row->target); ?>
                </td>
                <td>
                  <?php echo $this->customer_model->getCustomer($row->customer); ?>
                </td>
                <td>
                  <?php echo $row->rate; ?>
                  <?php echo $this->admin_model->getCurrency($row->currency); ?>
                </td>
                <td>
                  <?php echo $this->admin_model->getUnit($row->unit); ?>
                </td>
             
              
                
         
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
        <!--end: Datatable-->
      
      </div>
    </div>
    <!--end::Card-->
  </div>
  <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->
<!--begin::Page Scripts(used by this page)-->
<script src="<?= base_url()?>assets_new/js/pages/crud/datatables/extensions/buttons.js"></script>
<!--end::Page Scripts-->
<script>
    var initTable1 = function() {
		// begin first table
		var table = $('#datatable1').DataTable({
			responsive: true,
			// Pagination settings
			dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

			buttons: [
				'print',
				'copyHtml5',
				'excelHtml5',
				'pdfHtml5',
				'colvis',
			],
                        colReorder: true,
                        paging: false,
			
		});

	};
    
    $(document).ready(function(){
        initTable1();
       
    });
    </script>