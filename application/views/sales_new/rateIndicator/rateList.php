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
      <div class="card card-custom gutter-b example example-compact mt-10">
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
        if (!empty($_REQUEST['date_from'])) {
          $date_from = $_REQUEST['date_from'];

        } else {
          $date_from = "";
        }
        if (!empty($_REQUEST['date_to'])) {
          $date_to = $_REQUEST['date_to'];

        } else {
          $date_to = "";
        }

        ?>
        <form class="form" id="rateIndicatorForm" action="<?= base_url() ?>sales/rateIndicator" method="get">
          <div class="card-body">

            <div class="form-group row"> 
              <label class="col-lg-2 control-label text-lg-right" for="role name">Product Line</label>
              <div class="col-lg-3">
                  <select name="product_line" class="form-control m-b" id="product_line"  required="">
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
                  <select name="source" class="form-control m-b" id="source" required="" >
                <option disabled="disabled" value="" selected="selected">-- Select Target Language --</option>               
                <?= $this->admin_model->selectLanguage($source) ?>
                </select>
              </div>
              <label class="col-lg-2 control-label text-lg-right" for="role name">Target Language</label>
              <div class="col-lg-3">
                  <select name="target" class="form-control m-b" id="target" required="">
                <option disabled="disabled" value="" selected="selected">-- Select Target Language --</option>               
                <?= $this->admin_model->selectLanguage($target) ?>
                </select>
              </div>
            </div>
            <div class="form-group row date_row">
                   <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date From</label>
                   <div class="col-lg-3">
                       <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" value="<?=$date_from?>">
                   </div>

                   <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date To</label>
                   <div class="col-lg-3">
                       <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off"  value="<?=$date_to?>">
                   </div>
            </div>
            </div>
            <div class="card-footer">
              <div class="row">
               
                <div class="col-lg-12 text-center">
                  <button class="btn btn-success mr-2" name="search" type="submit">Search</button>
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
        <table class="table table-head-custom table-bordered  table-striped w-50" >
            <thead>
                <tr class="text-center">                                    
                    <th colspan="4">Vendor Rate indicator</th>
                </tr>
                <tr>  
                    <th>The high Rate </th>
                    <th>The low Rate </th>           
                    <th>The Avg Rate</th>
                    <th>Unit</th> 
                </tr>
            </thead>
          <tbody>
            <?php
                if(isset($vendor_rate) && !empty($vendor_rate->max_rate)){ ?>
                <tr class="">              
                  <td>
                    <?php echo $vendor_rate->max_rate; ?>
                    <?php echo $this->admin_model->getCurrency($vendor_rate->currency); ?>
                  </td>
                  <td>
                    <?php echo $vendor_rate->min_rate; ?>
                    <?php echo $this->admin_model->getCurrency($vendor_rate->currency); ?>
                  </td>
                  <td>
                    <?php echo $vendor_rate->avg_rate ; ?>
                    <?php echo $this->admin_model->getCurrency($vendor_rate->currency); ?>
                  </td>
                  <td>
                    <?php echo $this->admin_model->getUnit($vendor_rate->unit); ?>
                  </td>
                </tr>
              <?php }  else{ ?>
              <tr>
                  <td colspan="4" class="text-center">No data available in table</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
          <hr class="mt-10"/><hr class="mb-10"/>
        <!--begin: Datatable-->
        <table class="table table-head-custom table-bordered" id="ratetable">
            <thead>
                <tr class="text-center"> 
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
            if(isset($priceList)){
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
            <?php } } ?>
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
		var table = $('#ratetable').DataTable({
			responsive: true,
			// Pagination settings
			dom: `<'row'<'col-sm-6 text-left'l><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'p>>`,

			buttons: [
				'print',
				'excelHtml5',
				'pdfHtml5',
				'colvis',
			],
                        colReorder: true,
                        paging: true,
                        searching: false,
		});

	};
    
    $(document).ready(function(){
        initTable1();
       
    });
    </script>