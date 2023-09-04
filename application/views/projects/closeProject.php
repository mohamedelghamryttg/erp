<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Project Jobs
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
							<span class=" btn-primary" style="">
								Project Data 
							</span>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
						<thead>
							<tr>
                                 <th>Project Code</th>
                              	 <th>Project Name</th>
                             	 <th>Client</th>
                             	 <th>Product Line</th>
                             	 <th>Created By</th>
                                 <th>Created At</th>
							</tr>
						</thead>
						
						<tbody>
							<tr class="">
                              <td><?php echo $project->code?></td>
                              <td><?php echo $project->name?></td>
                              <td><?php echo $this->customer_model->getCustomer($project->customer);?></td>
                              <td><?php echo $this->customer_model->getProductLine($project->product_line);?></td>
                              <td><?php echo $this->admin_model->getAdmin($project->created_by);?></td>
                              <td><?php echo $project->created_at ;?></td>
							</tr>
						</tbody>
					</table>
				</div>
          </div>
		</section>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Close Project
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects" method="post" enctype="multipart/form-data">
				
			 	<div class="form-group">
                    <label class="col-lg-3 control-label">PO Number</label>

                    <div class="col-lg-6">
                        <input type="text" class=" form-control" name="po_number" id="po_number" required>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-lg-3 control-label" for="role File Attachment">PO Attachment</label>

                    <div class="col-lg-6">
                        <input type="file" class=" form-control" name="file" id="file" required="" accept="'application/zip'">
                    </div>
                </div>
                
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button> 
                  </div>
              </div>   
              </form>
			</div>
		</section>
	</div>
</div>

<script>
 window.realAlert = window.alert;
window.alert = function() {};
</script>