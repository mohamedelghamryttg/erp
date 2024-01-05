<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">

            <header class="panel-heading">
                Invoices List Filter
            </header>

            <div class="panel-body">
                <form class="cmxform form-horizontal " id="invoiceForm" action="<?php echo base_url() ?>accounting/invoices" method="get" enctype="multipart/form-data">
                    <?php
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                    } else {
                        $id = "";
                    }
                    if (isset($_REQUEST['customer'])) {
                        $customer = $_REQUEST['customer'];
                    } else {
                        $customer = "";
                    }
                    ?>
                    <div class="form-group">

                        <label class="col-lg-2 control-label" for="role date">Date From</label>

                        <div class="col-lg-3">

                            <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
                        </div>

                        <label class="col-lg-2 control-label" for="role date">Date To</label>

                        <div class="col-lg-3">
                            <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label" for="role name">Client</label>

                        <div class="col-lg-3">
                            <select name="customer" class="form-control m-b" id="customer" >
                            <option disabled="disabled" selected="selected">-- Select Client --</option>
                            <?= $this->customer_model->selectCustomerBranches($customer, $brand) ?>
                            </select>
                        </div>
                        <label class="col-lg-2 control-label" for="role id">Innvoice Number</label>

                        <div class="col-lg-3">
                            <input class="form-control" type="text" value="<?= $id ?>" name="id" autocomplete="off">

                        </div>




                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-6">
                            <button class="btn btn-primary" name="search" type="submit">Search</button> 
                            <button class="btn btn-success" onclick="var e2 = document.getElementById('invoiceForm'); e2.action = '<?= base_url() ?>accounting/exportInvoices'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                            <a href="<?= base_url() ?>accounting/invoices" class="btn btn-warning">(x) Clear Filter</a> 
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
                Invoices List
            </header>
            <?php if ($this->session->flashdata('true')) { ?>
                <div class="alert alert-success" role="alert">
                    <span class="fa fa-check-circle"></span>
                    <span><strong><?= $this->session->flashdata('true') ?></strong></span>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-warning"></span>
                    <span><strong><?= $this->session->flashdata('error') ?></strong></span>
                </div>
            <?php } ?>
            <div class="panel-body" style="overflow:scroll;">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="btn-group">
                            <?php if ($permission->add == 1) { ?>
                                <a href="<?= base_url() ?>accounting/addInvoice" class="btn btn-primary " style="margin-right: 5rem;"><i class="fa fa-plus" aria-hidden="true"></i> Add New Invoice</a>
                                </br></br></br>
                            <?php } ?>

                        </div>

                    </div>
                    <div class="space15"></div>

                    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                        <thead>
                            <tr>
                                <?php if($this->brand == 1){?>
                                    <th>Brand Name</th>
                                <?php }?>
                                <th>Invoice Number</th>
                                <th>External serial</th>
                                <th>Issue Date</th>
                                <th>Issue Month</th>
                                <th>Issue Year</th>                                                            
                                <th>Customer Name</th>
                                <th>Client Status</th>
                                <th>Country</th>
                                <th>Region</th>
                                <th>Currency</th>
                                <th>Total Revenue</th>
                                <th>Total Revenue $</th>
                                <th>PO Number</th>
                                <th>Status</th> 
                                <th>Payment Date</th>   
                                 <th>Payment Month</th>   
                                 <th>Payment year</th> 
                                <th>Payment Method</th>   
                                <th>Service</th>
                                <th>Source</th>
                                <th>Target</th>
                                <th>Volume</th>
                                <th>Unit</th>
                                <th>Rate</th>   
                                <th>PM Name</th>         
                                <th>Sales Name</th> 
                                <th>Payment terms</th>
                                <th>Due Date</th>
                                <th>Due Month</th>
                                <th>Due Year</th> 
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Export To Excel</th>
                                <th>Export To PDF</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($invoice->result() as $row) {
                                $invoiceTotal = $this->accounting_model->getInvoiceTotal($row->po_ids);
                                $invoiceCurrency = $this->accounting_model->getInvoiceCurrency($row->po_ids);
                                $job = $this->db->query(" SELECT * FROM job WHERE po IN (".$row->po_ids.") ")->result(); 
                                $poCount = count($job);
                                foreach ($job as $k=>$job) {
                                    $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                                    $jobTotal = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);
                                    $payment = $this->db->query(" SELECT * FROM payment WHERE customer = $row->customer AND( po_ids like '%,$job->po,%' OR  po_ids like '$job->po,%' OR  po_ids like '%,$job->po' OR  po_ids like '$job->po')")->row();
                                ?>
                                <tr>
                                    <?php if($this->brand == 1){?>
                                        <td><?php echo $this->projects_model->getTTGBranchForJob($job->id);?></td>
                                    <?php }?>
                                    <td># <?= $row->id ?></td>
                                    <td><?= $row->external_serial ?></td>
                                    <td><?= $row->issue_date ?></td>
                                    <td><?= date('F', strtotime($row->issue_date)) ?></td>
                                    <td><?= date('Y', strtotime($row->issue_date)) ?></td> 
                                    <td><?php echo $this->customer_model->getCustomer($row->customer); ?></td>
                                    <td><?= $this->accounting_model->getCustomerStatus($row->customer); ?></td>                                    
                                    <td><?= $this->admin_model->getCountry($this->customer_model->getLeadDataByCustomer($row->lead)->country) ?></td>
                                    <td><?= $this->admin_model->getRegion($this->customer_model->getLeadDataByCustomer($row->lead)->region) ?></td>
                                    <td><?= $this->admin_model->getCurrency($invoiceCurrency) ?></td>
                                    <td><?php echo $jobTotal; ?></td>  
                                    <td><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($invoiceCurrency, 2, $row->issue_date, $jobTotal), 2); ?></td>
                                   <!--po details-->
                                    <td><?= $this->accounting_model->getPONumber($job->po) ?></td>        
                                    <td><?= $this->accounting_model->getPoInvoiceStatus($job->po, $row->created_at, $row->payment) ?></td>
                                    <td><?=$payment?$payment->payment_date:''?></td>
                                    <td><?=$payment?date('F', strtotime($payment->payment_date)):''?></td>                                                   
                                    <td><?= $payment?date("Y", strtotime($payment->payment_date)):'' ?></td>
                                    <td><?= $payment?$this->accounting_model->getPaymentMethod($payment->payment_method):'' ?></td> 
                                    <td><?php echo $this->admin_model->getServices($priceList->service); ?></td>
                                    <td><?php echo $this->admin_model->getLanguage($priceList->source); ?></td>
                                    <td><?php echo $this->admin_model->getLanguage($priceList->target); ?></td>
                                    <?php if ($job->type == 1) { ?>
                                        <td><?php echo $job->volume; ?></td>
                                    <?php } elseif ($job->type == 2) { ?>
                                    <td><?php echo $jobTotal / $priceList->rate; ?></td>
                                        <?php } ?>                                                    
                                    <td><?php echo $this->admin_model->getUnit($priceList->unit) ?></td>
                                    <td><?php echo $priceList->rate; ?></td>
                                    <td><?= $this->admin_model->getAdmin($job->created_by);?></td>
                                    <td><?= $this->admin_model->getAdmin($job->assigned_sam);?></td>
                                    <td><?= $row->payment ?></td>
                          
                                    <td><?= date("Y-m-d", strtotime($row->created_at . " +" . $row->payment . " days")) ?></td>
                                    <td><?= date("F", strtotime($row->created_at . " +" . $row->payment . " days")) ?></td>
                                    <td><?= date("Y", strtotime($row->created_at . " +" . $row->payment . " days")) ?></td>                               
                                    
                                    <td><?php echo $this->admin_model->getAdmin($row->created_by); ?></td>
                                    <td><?php echo $row->created_at; ?></td>
                                <?php if($k==0){?>
                                    <td rowspan="<?=$poCount?>" style="vertical-align: middle">
                                        <a href="<?= base_url() ?>accounting/exportInvoice?t=<?= base64_encode($row->id) ?>" target="_blank" class="">
                                            <i class="fa fa-download"></i> Export To Excel
                                        </a>                                       
                                    </td>
                                    <td rowspan="<?=$poCount?>" style="vertical-align: middle">                                       
                                        <a href="<?= base_url() ?>accounting/exportInvoicePdf?t=<?= base64_encode($row->id) ?>" target="_blank" class="">
                                            <i class="fa fa-download"></i> Export To PDF
                                        </a>
                                    </td>
                                    <td rowspan="<?=$poCount?>" style="vertical-align: middle">
                                        <?php if ($permission->edit == 1 && $row->status == 0) { ?>
                                                    <a href="#" class="">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </a>
                                        <?php } ?>
                                            </td>
                                            <td rowspan="<?=$poCount?>" style="vertical-align: middle">
                                        <?php if ($permission->delete == 1 && $row->status == 0) { ?>
                                                    <a href="#" title="delete" 
                                                       class="" onclick="return confirm('Are you sure you want to delete this Invoice ?');">
                                                        <i class="fa fa-times text-danger text"></i> Delete
                                                    </a>
                                        <?php } ?>
                                            </td>
                                        </tr>
                                    
                                            </td>
                                        </tr>
                            <?php } }}?>
                        </tbody>
                    </table>
                    <nav class="text-center">
                        <?= $this->pagination->create_links() ?>
                    </nav>
                </div>
            </div>
        </section>
    </div>
</div>