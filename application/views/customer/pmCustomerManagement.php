<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Leads Filter
      </header>

      	<?php 

         if(!empty($_REQUEST['customer'])){
            $customer = $_REQUEST['customer'];
            
        }else{
            $customer = "";
        }
        if(!empty($_REQUEST['region'])){
            $region = $_REQUEST['region'];
            
        }else{
            $region = "";
        }

      	?>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " action="<?php echo base_url()?>customer/pmCustomer" method="get" id="pmCustomer" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Customer</label>

                    <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer" />
                                 <option value="">-- Select Customer --</option>
                                 <?=$this->customer_model->selectCustomerExisting($customer,$this->brand)?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role name">Region</label>

                    <div class="col-lg-3">
                        <select name="region" class="form-control m-b" id="region"/>
                                 <option value="">-- Select Region --</option>
                                 <?=$this->admin_model->selectRegion($region)?>
                        </select>
                    </div>

                </div>


                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('pmCustomer'); e2.action='<?=base_url()?>customer/pmCustomer'; e2.submit();" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('pmCustomer'); e2.action='<?=base_url()?>customer/exportPmCustomer'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                      <a href="<?=base_url()?>customer/pmCustomer" class="btn btn-warning">(x) Clear Filter</a>
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
				Customers PM Management
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
			
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1){ ?>
							<a href="<?=base_url()?>customer/addBranch" class="btn btn-primary ">Add New</a>
							</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
	                            <th>Customer Portal</th>
								<th>Source</th>
                                <th>Region</th>
                                <th>Country</th>
                                <th>Type</th>
                                <th>Assigned PM</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($branch->result() as $row)
								{
								$PmCustomer = $this->customer_model->customersPmRow($row->id);
						?>
									<tr class="">
										<td><?=$row->id?></td>
										<td><a href="<?=base_url()?>customer/leadContacts?t=<?=base64_encode($row->id)?>"><?php echo $this->customer_model->getCustomer($row->customer);?></a></td>

										<td><a href="<?=base_url()?>customer/customerPortal?t=<?=base64_encode($row->id)?>">Go To Customer Portal</a></td>

										<td><?php echo $row->source ;?></td> 
										<td><?php echo $this->admin_model->getRegion($row->region) ;?></td>
										<td><?php echo $this->admin_model->getCountry($row->country) ;?></td>
										<td><?php echo $this->customer_model->getType($row->type) ;?></td>
										<td>
											<?php if($PmCustomer->num_rows() == 0){?>
											<?php if($permission->follow == 2){ ?>
											<a href="#myModal<?php echo $row->id ;?>" data-toggle="modal" class="btn btn-success" >Assign PM</a>
											<?php } ?>
											<?php }else{ ?>
											<table style="border-collapse:collapse;">
                                            <tr><td style="border: 1px solid #ddd;">PM Name</td>
                                            <?php if($permission->follow == 2){ ?>
                                              <td style="border: 1px solid #ddd;"></td>
                                              <td style="border: 1px solid #ddd;"></td>
                                            <?php } ?>
                                            </tr>
                                            <?php 
                                         	$i=0;
                                      		$count=$PmCustomer->num_rows();
                                          foreach($PmCustomer->result() as $pm)
                                          {
                                              //echo $i;
                                              ?>
                                                <tr>
                                                    <td style="border: 1px solid #ddd;"><?php echo $this->admin_model->getAdmin($pm->pm);?></td>
                                                   <?php if($permission->follow == 2){ ?>
                                                  <td style="border: 1px solid #ddd;"><a href="<?php echo base_url()?>customer/deletePmCustomer?t=<?php echo base64_encode($pm->id); ?>"> 
                                                    <i class="fa fa-times text-danger text"></i> </a></td><?php } ?>
                                              <?php if( $i < 1)
                                          		{
                                              ?>
                                              <?php if($permission->follow == 2){ ?>
                                              <td rowspan="<?php echo $count; ?>" style="border: 1px solid #ddd;"><a href="#myModal<?php echo $row->id ?>" data-toggle="modal" class="btn btn-success" >Assign PM</a></td><?php } ?>
                                            <?php }
                                              ?>
                                          </tr>
                                             <?php 
                                        $i=$i+1;
                                        } ?>       
                                		</table>
											<?php } ?>
										</td>
									</tr>

									<!-- form of adding PM and brand to customer-->                                   
									<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal<?php echo $row->id;?>" class="modal fade">
									     <div class="modal-dialog">
									     	 <div class="modal-content">
									      		 <div class="modal-header">
									      		    <h4 class="modal-title">Assign Pm To this Customer</h4>
									        		 <button aria-hidden="true" data-dismiss="modal" class="close text-danger" type="button" style="color:red !important;">×</button>
									      		 </div>
									      		 <div class="modal-body">

									           <form role="form" id="commentForm" action="<?php echo base_url()?>customer/assignPmCustomer" method="post" enctype="multipart/form-data">
									              <input name="lead" type="hidden" value="<?php echo $row->id;?>" >
									              <input name="customer" type="hidden" value="<?php echo $row->customer;?>" >
									             <div class="form-group">
									               <!--<label for="pm">Select Pm </label>-->
									                 <select name="pm" class="form-control m-b" id="pm" required >
									                   <option disabled="disabled" selected="selected">Select Pm</option>
									                   <?=$this->customer_model->selectPmCustomer($row->id,$brand)?>
									                 </select>
									             </div>

									             <button type="submit" class="btn btn-primary">Submit</button>
									           </form>
									       </div>
									     </div>
									   </div>
									</div>
						<?php
								}
						?>		
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