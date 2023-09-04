<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Branches Filter
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
                if(!empty($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    
                }else{
                    $date_to = "";
                    $date_from = "";
                }
               if(!empty($_REQUEST['created_by'])){
                    $created_by = $_REQUEST['created_by'];
                   
                }else{
                    $created_by = "";
                }

          ?>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " action="<?php echo base_url()?>customer/customerBranch" method="get" id="branches" enctype="multipart/form-data">
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
                    <label class="col-lg-2 control-label" for="role name">Created By</label>

                    <div class="col-lg-3">
                        <select name="created_by" class="form-control m-b" id="created_by"/>
                                 <option value="">-- Select User --</option>
                                 <?=$this->customer_model->selectAllSamMarketing($created_by,$this->brand)?>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('branches'); e2.action='<?=base_url()?>customer/customerBranch'; e2.submit();" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('branches'); e2.action='<?=base_url()?>customer/exportbranches'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                      <a href="<?=base_url()?>customer/customerBranch" class="btn btn-warning">(x) Clear Filter</a>
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
				Customers Branches
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
				<div class="adv-table editable-table ">
					<div class="clearfix">
						<div class="btn-group">
						<?php if($permission->add == 1){ ?>
							<a href="<?=base_url()?>customer/addBranch" class="btn btn-primary ">Add New</a>
							</br></br></br>
						<?php } ?>
            Show / Hide:
            <a href="" class="toggle-vis" data-column="0">ID</a> - 
            <a href="" class="toggle-vis" data-column="1">Name</a> - 
            <a href="" class="toggle-vis" data-column="2">Source</a> - 
            <a href="" class="toggle-vis" data-column="3">Region</a> - 
            <a href="" class="toggle-vis" data-column="4">Country</a> -  
            <a href="" class="toggle-vis" data-column="5">Type</a> - 
            <a href="" class="toggle-vis" data-column="6">Assigned SAM</a> - 
            <a href="" class="toggle-vis" data-column="7">Assigned PM</a> - 
            <a href="" class="toggle-vis" data-column="8">Status</a>  - 
            <a href="" class="toggle-vis" data-column="9">Approved</a>  - 
            <a href="" class="toggle-vis" data-column="10">Created By</a> -
            <a href="" class="toggle-vis" data-column="11">Created At</a>  - 
            <a href="" class="toggle-vis" data-column="12">Edit</a>  -
            <a href="" class="toggle-vis" data-column="13">Delete</a>
            </br></br></br>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table id="tablesData" class="display" style="width:100%">
						<thead>
							<tr>
                			          <th>ID</th>
                				        <th>Name</th>
                				        <th>Source</th>
                                <th>Region</th>
                                <th>Country</th>
                                <th>Type</th>
                                <th>Assigned SAM</th>
                                <th>Assigned PM</th>
                                <th>Status</th>
                                <th>Approved</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Edit</th>
                                <th>Delete</th>
							</tr>
						</thead>
						
						<tbody>
                        <?php
                            foreach($branch->result() as $row)
                                {
                                $SamCustomer = $this->customer_model->customersSam($row->id);
                                $PmCustomer = $this->customer_model->customersPmRow($row->id);
                        ?>
                                    <tr class="">
                                        <td><?=$row->id?></td>
                                        <td><a href="<?=base_url()?>customer/leadContacts?t=<?=base64_encode($row->id)?>"><?php echo $this->customer_model->getCustomer($row->customer);?></a></td>
                                        <?php if(is_numeric($row->source)){ ?>
                                          <td><?php echo $this->customer_model->getSource($row->source);?></td>
                                        <?php }else{ ?>  
                                        <td><?=$row->source?></td>
                                        <?php } ?> 
                                        <td><?php echo $this->admin_model->getRegion($row->region) ;?></td>
                                        <td><?php echo $this->admin_model->getCountry($row->country) ;?></td>
                                        <td><?php echo $this->customer_model->getType($row->type) ;?></td>
                                        <td id="SamTable_<?=$row->id?>">
                                        <?php if($row->approved == 1){ ?>
                                            <?php if($SamCustomer->num_rows() == 0){?>
                                            <?php if($permission->follow == 2){ ?>
                                            <a href="#myModal<?php echo $row->id ;?>" data-toggle="modal" class="btn btn-success" >Assign SAM</a>
                                            <?php } ?>
                                            <?php }else{ ?>
                                            <table style="border-collapse:collapse;">
                                            <tr><td style="border: 1px solid #ddd;">SAM Name</td>
                                            <?php if($permission->follow == 2){ ?>
                                              <td style="border: 1px solid #ddd;"></td>
                                              <td style="border: 1px solid #ddd;"></td>
                                            <?php } ?>
                                            </tr>
                                            <?php 
                                            $i=0;
                                            $count=$SamCustomer->num_rows();
                                          foreach($SamCustomer->result() as $sam)
                                          {
                                              //echo $i;
                                              ?>
                                                <tr>
                                                    <td style="border: 1px solid #ddd;"><?php echo $this->admin_model->getAdmin($sam->sam);?></td>
                                                   <?php if($permission->follow == 2){ ?>
                                                  <!-- <td style="border: 1px solid #ddd;"><a href="<?php echo base_url()?>customer/deleteSamCustomer?t=<?php echo base64_encode($sam->id); ?>">  -->
                                                  <td style="border: 1px solid #ddd;"><a onclick="deleteSamCustomer(<?=$sam->id?>,<?=$row->id?>)"> 
                                                    <i class="fa fa-times text-danger text"></i> </a></td><?php } ?>
                                              <?php if( $i < 1)
                                                {
                                              ?>
                                              <?php if($permission->follow == 2){ ?>
                                              <td rowspan="<?php echo $count; ?>" style="border: 1px solid #ddd;"><a href="#myModal<?php echo $row->id ?>" data-toggle="modal" class="btn btn-success" >Assign SAM</a></td><?php } ?>
                                            <?php }
                                              ?>
                                          </tr>
                                             <?php 
                                        $i=$i+1;
                                        } ?>       
                                        </table>
                                            <?php } ?>
                                        <?php } ?>
                                        <!-- form of adding sam and brand to customer-->                                   
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal<?php echo $row->id;?>" class="modal fade">
                                             <div class="modal-dialog">
                                                 <div class="modal-content">
                                                     <div class="modal-header">
                                                         <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                         <h4 class="modal-title">Assign SAM To this Customer</h4>
                                                     </div>
                                                     <div class="modal-body">

                                                      <input name="lead" id="lead_<?=$row->id?>" type="hidden" value="<?php echo $row->id;?>" >
                                                      <input name="customer" id="customer_<?=$row->id?>" type="hidden" value="<?php echo $row->customer;?>" >
                                                     <div class="form-group">
                                                       <label for="sam">Select SAM</label>
                                                         <select name="sam" id="sam_<?=$row->id?>" class="form-control m-b" id="sam" required >
                                                           <option disabled="disabled" selected="selected">Select SAM</option>
                                                           <?=$this->customer_model->selectSamCustomer($row->id,$brand)?>
                                                         </select>
                                                     </div>

                                                     <button class="btn btn-default" type="submit" aria-hidden="true" data-dismiss="modal" class="close" onclick="assignSamCustomer(<?=$row->id?>)">Submit</button>
                                               </div>
                                             </div>
                                           </div>
                                        </div>
                                        </td>
                                        <td>
                                          <?php if($PmCustomer->num_rows() == 0){?>

                                             <?php }else{ ?>
                                             <table style="border-collapse:collapse;">
                                             <tr><td style="border: 1px solid #ddd;">PM Name</td>
                                             <?php if($permission->follow == 2){ ?>
                         
                                          <?php } ?>
                                      </tr>
                                          <?php 
                                          $i=0;
                                          $count=$PmCustomer->num_rows();
                                          foreach($PmCustomer->result() as $pm)
                                          {
                                              
                                          ?>
                                      <tr>
                                      <td style="border: 1px solid #ddd;"><?php echo $this->admin_model->getAdmin($pm->pm);?></td>
                                      </tr>
                                             <?php 
                                        $i=$i+1;
                                        } ?>       
                                        </table>
                                           <?php } ?>
                                        </td>
                                        <td><?php echo $this->customer_model->getStatus($row->status) ;?></td>
                                        <td><?php if($row->approved == 1){echo "Yes";}elseif($row->approved == 2){echo "No";}?></td>
                                        <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                                        <td><?=$row->created_at?></td>
                                        <td>
                                            <?php if($permission->edit == 1){ ?>
                                            <a href="<?php echo base_url()?>customer/editBranch?t=<?php echo 
                                            base64_encode($row->id) ;?>" class="">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if(($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)){ ?>
                                            <a href="<?php echo base_url()?>customer/deleteLead?t=<?php echo 
                                            base64_encode($row->id) ;?>" title="delete" 
                                            class="" onclick="return confirm('Are you sure you want to delete this Customer ?');">
                                                <i class="fa fa-times text-danger text"></i> Delete
                                            </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
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