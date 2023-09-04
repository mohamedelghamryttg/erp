<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				POs List Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>accounting/payments" method="get" id="payment" enctype="multipart/form-data">
				        <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Client</label>

                     <div class="col-lg-8">
                        <select name="customer" class="form-control m-b" id="customer" />
                           <option disabled="disabled" selected="selected">-- Select Client --</option>
                           <?=$this->customer_model->selectCustomerBranches(0,$brand)?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role date">Payment Date From</label>

                    <div class="col-lg-3">
                         <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
                    </div>

                    <label class="col-lg-2 control-label" for="role date">Payment Date To</label>

                    <div class="col-lg-3">
                         <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                  	  <button class="btn btn-success" onclick="var e2 = document.getElementById('payment'); e2.action='<?=base_url()?>accounting/exportPayment'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i>Export To Excel</button>
                      <a href="<?php echo base_url()?>accounting/payments" class="btn btn-warning">(x) Clear Filter</a>
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
				Payments List
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
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1){ ?>
								<a href="<?=base_url()?>accounting/addPayment" class="btn btn-primary ">Add New Payment</a>
							</br></br></br>
						<?php } ?>
						
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                            <th>ID</th>
                 	<th>Payment Date</th>
                  <th>Client Name</th>
                  <th>Selected POs</th>
                  <th>Invoice Numbers</th>
                  <th>Deductions</th>
                  <th>Deductions Reason</th>
                  <th>Advanced Payment</th>
                  <th>Credit Note IDs</th>
                  <th>Credit Note Total</th>
                  <th>Total</th>
                  <th>Currency</th>
                  <th>Payment Method</th>
                  <th>Created By</th>
                  <th>Created At</th>
                  <th>Edit</th>
                  <th>Delete</th>
							</tr>
						</thead>
						<tbody>
            <?php foreach ($payment->result() as $row) { 
                        
            ?>
              <tr>
              	<td><?=$row->id?></td>
                <td><?=$row->payment_date?></td>
                <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                <td><?php echo $this->accounting_model->getSelectedPOs($row->po_ids) ;?></td>
                <td>
                <?php
                  $pos = explode(",", $row->po_ids);
                  for ($i=0; $i <count($pos) ; $i++) { 
                    if($i != 0){
                      echo ", ";
                    }
                    echo $this->accounting_model->getInvoiceNumberByPoAndCustomer($pos[$i],$row->customer);
                  }
                ?>  
                </td>
                <td><?=$row->deductions?></td>
                <td><?=$this->accounting_model->getPaymentDeductions($row->deduction_reason)?></td>
                <td><?=$row->advanced_payment?></td>
                <td><?=$row->credit_note?></td>
                <td><?=$row->total_credit_note?></td>
                <td><?=$row->net_amount?></td>
                <td><?=$this->admin_model->getCurrency($row->currency)?></td>
                <td><?=$this->accounting_model->getPaymentMethod($row->payment_method)?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
                <td>
                  <?php if($permission->edit == 1){ ?>
                  <!-- <a href="#" class="">
                    <i class="fa fa-pencil"></i> Edit
                  </a> -->
                  <?php } ?>
                </td>
                <td>
                  <?php if($permission->delete == 1){ ?>
                  <!-- <a href="#" title="delete" 
                  class="" onclick="return confirm('Are you sure you want to delete this Payment ?');">
                    <i class="fa fa-times text-danger text"></i> Delete
                  </a> -->
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
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