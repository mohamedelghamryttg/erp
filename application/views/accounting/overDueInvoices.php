<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
    .adv-table table tr td{
        vertical-align: middle;
    }
</style>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Invoices List Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="invoiceForm" action="<?php echo base_url()?>accounting/overDueInvoices" method="get" enctype="multipart/form-data">
         <?php 
           if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            }else{
                $id = "";
            }
            if(isset($_REQUEST['customer'])){
              $customer = $_REQUEST['customer'];
          }else{
              $customer = "";
          }
            if(isset($_REQUEST['date_from'])){
              $date_from = $_REQUEST['date_from'];
          }else{
              $date_from = "";
          }         
         ?>
				<div class="form-group">
 
            <label class="col-lg-2 control-label" for="role date">Due Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off"value="<?=$date_from?>">
            </div>

            <label class="col-lg-2 control-label" for="role date">Due Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_to" value="<?=isset($_REQUEST['date_to'])?$_REQUEST['date_to']:''?>"autocomplete="off">
            </div>

        </div>
				<div class="form-group">
            <label class="col-lg-2 control-label" for="role name">Client</label>

             <div class="col-lg-3">
                <select name="customer" class="form-control m-b" id="customer" />
                         <option disabled="disabled" selected="selected">-- Select Client --</option>
                         <?=$this->customer_model->selectCustomerBranches($customer,$brand)?>
                </select>
          </div>
                  <label class="col-lg-2 control-label" for="role id">Innvoice Number</label>

            <div class="col-lg-3">
                 <input class="form-control" type="text" value="<?= $id?>" name="id" autocomplete="off">
            
            </div>
       



        </div>
        <div class="form-group">
          <div class="col-lg-offset-3 col-lg-6">
              <button class="btn btn-primary" name="search" type="submit">Search</button> 
              <button class="btn btn-success" onclick="var e2 = document.getElementById('invoiceForm'); e2.action='<?=base_url()?>accounting/exportOverDueInvoices'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
              <a href="<?=base_url()?>accounting/overDueInvoices" class="btn btn-warning">(x) Clear Filter</a> 
          </div>
        </div>   
      </form>
			</div>
		</section>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Overdue Invoices List
			</header>
          <?php if($this->session->flashdata('true')){ ?>
			<div class="alert alert-success" role="alert">
              <span class="fa fa-check-circle"></span>
              <span><strong><?=$this->session->flashdata('true')?></strong></span>
            </div>
			<?php  } ?>
			<?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert">
              <span class="fa fa-warning"></span>
              <span><strong><?=$this->session->flashdata('error')?></strong></span>
            </div>
			<?php  } ?>
			<div class="panel-body" style="overflow:scroll;">
				<div class="adv-table editable-table ">
				
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
                                                    <tr>
                                                    <th>Client Name</th>
                                                    <th>Invoice Number</th>                                                   
                                                    <th colspan="2">Selected POs</th>
                                                    <th>Total Revenue</th>
                                                    <th>Currency</th>
                                                    <th>Total Revenue $</th>                                                   
                                                    <th>Due Date</th>                                                    
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    <th>Export To Excel</th>                                                  
                                                    <th>Export To PDF</th>                                                  
                                                    </tr>
						</thead>
						<tbody>
							<?php foreach ($invoice->result() as $row) { 
								$invoiceTotal = $this->accounting_model->getInvoiceTotal($row->po_ids);
								$invoiceCurrency = $this->accounting_model->getInvoiceCurrency($row->po_ids);
                                                                $job = $this->db->query(" SELECT * FROM job WHERE po IN (".$row->po_ids.") ")->result(); 
                                                                $poCount = count($job);
                                                                foreach ($job as $k=>$job) {
                                                                    $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                                                                    $jobTotal = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);
                                                       if($k==0){ ?>
                            
                                                    <tr>
                                                      <td rowspan="<?=$poCount?>"><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                                                      <td rowspan="<?=$poCount?>"># <?=$row->id?></td>
                                                      <td><?= $this->accounting_model->getPONumber($job->po) ?></td>
                                                      <td><?php echo $jobTotal; ?></td>  
                                                      <td rowspan="<?=$poCount?>"><?php echo $invoiceTotal ;?></td>
                                                      <td rowspan="<?=$poCount?>"><?=$this->admin_model->getCurrency($invoiceCurrency)?></td>
                                                      <td rowspan="<?=$poCount?>"><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($invoiceCurrency,2,$row->issue_date,$invoiceTotal),2);?></td>

                                                      <td rowspan="<?=$poCount?>"><?=date( "Y-m-d", strtotime( $row->created_at." +".$row->payment." days" ) )?></td>

                                                      <td rowspan="<?=$poCount?>"><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                                                      <td rowspan="<?=$poCount?>"><?php echo $row->created_at ;?></td>
                                                      <td rowspan="<?=$poCount?>">
                                                          <a href="<?=base_url()?>accounting/exportInvoice?t=<?=base64_encode($row->id)?>" target="_blank" class="">
                                                            <i class="fa fa-download"></i> Export To Excel
                                                          </a>                                                         
                                                      </td> 
                                                      <td rowspan="<?=$poCount?>">
                                                          <a href="<?=base_url()?>accounting/exportInvoice?t=<?=base64_encode($row->id)?>" target="_blank" class="">
                                                            <i class="fa fa-download"></i> Export To Excel
                                                          </a>
                                                          <a href="<?= base_url() ?>accounting/exportInvoicePdf?t=<?= base64_encode($row->id) ?>" target="_blank" class="">
                                                            <i class="fa fa-download"></i> Export To PDF
                                                        </a>
                                                      </td> 
                                                    </tr>
                                                        <?php }else{?>
                                                    <tr>
                                                      <td><?= $this->accounting_model->getPONumber($job->po) ?></td>
                                                      <td><?php echo $jobTotal; ?></td>  
                                                    </tr>
                                                        <?php }}} ?>
						</tbody>
					</table>
					<nav class="text-center">
                         <?=$this->pagination->create_links()?>
                    </nav>
				</div>
			</div>
		</section>
	</div>
</div>