<!DOCTYPE ><html dir=ltr>
    <head>
<style>
@media print {
table {font-size: smaller; }
thead {display: table-header-group; }
table { page-break-inside:auto; width:75%; }
tr { page-break-inside:avoid; page-break-after:auto; }
}
table {
  border: 1px solid black;
  font-size:18px;
}
table td {
  border: 1px solid black;
}
table th {
  border: 1px solid black;
}
.clr{
  background-color: #EEEEEE;
  text-align: center;
}
.clr1 {
background-color: #FFFFCC;
  text-align: center;
}
</style>
</head>
<body>
<table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
            <thead>
                <tr style="background-color: #900C3F;color: white;">
                <th>Opportunity Number</th>
                <th>Project Name</th>
                <th>Project Status</th>
                <th>Customer</th>
                <th>Brand</th>
                <th>Region</th>
                <th>Country</th>
                <th>PM</th>
                <th>Status</th>
                <th>Assign</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>
            <table>
             <thead>
               <tr style="background-color: #900C3F;color: white;">
    	 		     <th>Product Line</th>
             	 <th>Service</th>
             	 <th>Source</th>
             	 <th>Target</th>
             	 <th>Volume</th>
             	 <th>Rate</th>
             	 <th>Total Revenue</th>
             	 <th>Total Revenue $ USD</th>
             	 <th>Currency</th>
                <th>Created By</th>
                <th>Created At</th>
             </tr>
            </thead>
          </table>
          </th>
              </tr>
            </thead>
            
            <tbody>
            <?php
              foreach($opportunity->result() as $row)
                {
                  $leadData = $this->customer_model->getLeadDataByCustomer($row->lead);
				  $customerData = $this->db->get_where('customer',array('id' => $row->customer))->row();
            ?>
                  <tr class="">
                    <td><?php echo $row->id ;?></td> 
                    <td><?=$row->project_name?></td>
                    <td><?php echo $this->sales_model->getProjectStatus($row->project_status) ;?></td>
                    <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                    <td><?php echo $this->admin_model->getBrand($customerData->brand);?></td>
                    <td><?php echo $this->admin_model->getRegion($leadData->region);?></td>
                    <td><?php echo $this->admin_model->getCountry($leadData->country);?></td>
                    <td><?php echo $this->admin_model->getAdmin($row->pm) ;?></td>
                                        <td>
                                          <?php 
                                          if($row->saved == 0 && $row->assigned == 1){
                                            echo 'Still Not Saved';
                                          }else if($row->saved == 1){
                                            echo 'Saved As A project';
                                          }elseif ($row->saved == 2) {
                                            echo 'Opportunity Rejected';
                                          }
                                          ?>
                                        </td>
                    <td>
                                          <?php if($row->project_status == 1){ ?>
                                          <?php if($row->assigned == 0 || $row->saved == 2){ ?>
                                                Assign
                                            <?php }else{ ?>
                                              Opportunity Assigned 
                                            <?php } ?>
                                            <?php } ?>
                                        </td>
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td><?php echo $row->created_at ;?></td>

            <td>
                <table>
                  <tbody>
                <?php 
                  $job = $this->db->get_where('job',array('opportunity'=>$row->id));
                foreach ($job->result() as $row) { 
                  $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                	$jobTotal = $this->sales_model->calculateRevenueJob($row->id,$row->type,$row->volume,$priceList->id);
                	?>
                <tr>
								<td><?php echo $this->customer_model->getProductLine($priceList->product_line);?></td>
								<td><?php echo $this->admin_model->getServices($priceList->service);?></td>
								<td><?php echo $this->admin_model->getLanguage($priceList->source);?></td>
								<td><?php echo $this->admin_model->getLanguage($priceList->target);?></td>
								<td><?php echo $row->volume ;?></td>
								<td><?php echo $priceList->rate ;?></td>
								<td><?=$jobTotal?></td>
                <td><?php echo number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency,2,$row->created_at,$jobTotal),2);?></td>
								<td><?php echo $this->admin_model->getCurrency($priceList->currency) ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>
							</tr>
              <?php } ?>
              </tbody>
              </table>
              </td>

                  </tr>
            <?php
                }
            ?>    
            </tbody>
          </table>
</body>
</html>