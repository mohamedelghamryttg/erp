<script type="text/javascript">
	function hideDiv() {
		$("#filter").hide();
      	$("#filter2").hide();
	}
    window.onload = hideDiv;
</script>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter2" onclick="showAndHide('filter2','button_filter2');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button>
				 Your Projects From SAM - <span class="numberCircle"><span><?=$opportunity->num_rows()?></span></span>
			</header>
			
			<div id="filter2" class="panel-body" style="overflow:scroll;">
			 <table class="table table-striped table-hover table-bordered" id="">
						<thead>
							<tr>
                                 <th>Project Name</th>
                             	 <th>Client</th>
                             	 <th>Assigned Date</th>
                              	 <th>SAM</th>
                                 <th>Save</th>
							</tr>
						</thead>
						
						<tbody>
							<?php
							if($opportunity->num_rows() > 0)
							{
								foreach($opportunity->result() as $row)
								{
									?>
									<tr class="">

                                      <td><?php echo $row->project_name?></td>
                                      <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                                      <td><?php echo $row->assigned_at;?></td>
                                      <td><?php echo $this->admin_model->getAdmin($row->created_by);?></td>
                                      <td><a href="<?php echo base_url()?>projects/saveProject?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> View Project
											</a></td>
									</tr>
									<?php
								}
							}
							else
							{
								?><tr><td colspan="7">There is no new projects to you </td></tr><?php
							}
							?>								
						</tbody>
					</table>
			</div>
		</section>
	</div>
</div>

 <div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter" onclick="showAndHide('filter','button_filter');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button> Projects Filter
			</header>

			<?php 
			if(!empty($_REQUEST['code'])){
                    $code = $_REQUEST['code'];
                }else{
                    $code = "";
                }
                if(!empty($_REQUEST['name'])){
                    $name = $_REQUEST['name'];
                }else{
                    $name = "";
                }
                if(!empty($_REQUEST['customer'])){
                    $customer = $_REQUEST['customer'];
                }else{
                    $customer = "";
                }
                if(!empty($_REQUEST['product_line'])){
                    $product_line = $_REQUEST['product_line'];
                }else{
                    $product_line = "";
                }
                if(!empty($_REQUEST['status'])){
                    $status = $_REQUEST['status'];
                }else{
                    $status = "";
                }
                if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                }else{
                    $date_to = "";
                    $date_from = "";
                }
			?>
			
			<div id="filter" class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects" method="get" enctype="multipart/form-data">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Project Code</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" name="code" value="<?=$code?>">
                    </div>

                     <label class="col-lg-2 control-label" for="role Task Type">Project Name</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" name="name" value="<?=$name?>">
                    </div>

                </div>
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Client</label>

                     <div class="col-lg-3">
                        <select name="customer" class="form-control m-b" id="customer" />
                                 <option value=""  disabled="disabled" selected="selected">-- Select Client --</option>
                                 <?=$this->customer_model->selectCustomerByPm($customer,$this->user,$permission,$this->brand)?>
                        </select>
                    </div>

                     <label class="col-lg-2 control-label" for="role Task Type">Product Line</label>

                    <div class="col-lg-3">
                        <select name="product_line" class="form-control m-b" id="product_line" />
                                <option value=""  disabled="disabled" selected="">-- Select Product Line --</option>
                                 <?=$this->customer_model->selectProductLine($product_line,$this->brand)?>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Status">Status</label>

                    <div class="col-lg-3">
                        <select name="status" class="form-control m-b" id="status" />
                                <option value="">-- Select Status --</option>
                            <?php 
							    if($_REQUEST['status'] == 2 ){?>
							    <option selected="" value = "<?=$_REQUEST['status']?>">Running</option>
								<option value = "1">Closed</option>		
                    		<?php }elseif($_REQUEST['status'] == 1){ ?>
							    <option selected="" value = "<?=$_REQUEST['status']?>">Closed</option>
							    <option value = "2">Running</option>
							<?php }else{?>
                                 <option value="2">Running</option>
                                 <option value="1">Closed</option>
                             <?php }?>
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
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                       <a href="<?=base_url()?>projects" class="btn btn-warning">(x) Clear Filter</a>
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
				Projects Management <span class="numberCircle"><span><?=$total_rows?></span></span>
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
								<a href="<?=base_url()?>projects/addProject" class="btn btn-primary ">Add New Project</a>
							</br></br></br>
						<?php } ?>
						Show / Hide:
						<a href="" class="toggle-vis" data-column="0">Code</a> - 
						<a href="" class="toggle-vis" data-column="1">Code</a> - 
						<a href="" class="toggle-vis" data-column="2">Name</a> -
						<a href="" class="toggle-vis" data-column="3">Client</a> -
						<a href="" class="toggle-vis" data-column="4">Product Line</a> -
						<a href="" class="toggle-vis" data-column="5">Status</a> - 
						<a href="" class="toggle-vis" data-column="6">View Tickets</a> -
            			<a href="" class="toggle-vis" data-column="7">Opportunity No</a> -
						<a href="" class="toggle-vis" data-column="8">Created By</a> -
						<a href="" class="toggle-vis" data-column="9">Created At</a> -
						<a href="" class="toggle-vis" data-column="10">Edit</a> -
						<a href="" class="toggle-vis" data-column="11">Delete</a>
						</br></br></br>
						</div>
						
					</div>
					<div class="space15"></div>
					
					<table id="tablesData" class="display" style="width:100%">
						<thead>
							<tr>
								<th>ID</th>
                              	<th>Project Code</th>
                              	<th>Project Name</th>
                             	<th>Client</th>
                             	<th>Product Line</th>
                              	<th>Status</th>
                              	<th>View Tickets</th>
                              	<th>Opportunity No</th>
                                <th>Created By</th>
                                <th>Created At</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($project->result() as $row) { 
						?>
							<tr>
								<td><?php echo $row->id ;?></td>
								<td><a href="<?=base_url()?>projects/projectJobs?t=<?=base64_encode($row->id)?>"><?=$row->code?></a></td>
								<td><?php echo $row->name ;?></td>
								<td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
								<td><?php echo $this->customer_model->getProductLine($row->product_line);?></td>
                              	<td>
									<?=$this->projects_model->getNewProjectStatus($row->status,$row->id)?>
								</td>
                              	<td>
                              	<?php if($row->status == 0){ ?>
									<a class="btn btn-primary" href="<?php echo base_url()?>vendor/vmPmTicket?t=<?php echo base64_encode($row->id); ?>" title="View Tickets" style="color:#fff">View Tickets</a>
								<?php } ?>
								</td>
                            	<td><?php echo $row->opportunity ;?></td>
								<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
								<td><?php echo $row->created_at ;?></td>
								<td>
									<?php if($permission->edit == 1 && $row->status == 0){ ?>
									<a href="<?php echo base_url()?>projects/editProject?t=<?php echo 
									base64_encode($row->id) ;?>" class="">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<?php } ?>
								</td>
								<td>
									<?php if($permission->delete == 1 && $row->status == 0){ ?>
									<a href="<?php echo base_url()?>projects/deleteProject?t=<?php echo 
									base64_encode($row->id) ;?>" title="delete" 
									class="" onclick="return confirm('Are you sure you want to delete this Project ?');">
										<i class="fa fa-times text-danger text"></i> Delete
									</a>
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


<script>
 window.realAlert = window.alert;
window.alert = function() {};
</script>