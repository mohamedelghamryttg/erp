<!-- search -->
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
           Product Line Filter
      </header>
	  
      <div class="panel-body">
       <form class="cmxform form-horizontal "id="productlinefilter" action="<?php echo base_url()?>customer/productLines" method="get" enctype="multipart/form-data">
	   <?php 
	      
			if(isset($_REQUEST['Product_Line_name'])){
				$ProductLineName = $_REQUEST['Product_Line_name'];
			}else{
				$ProductLineName = "";
			}
	  ?>
			    <div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Product Line Name</label>

                    <div class="col-lg-3">
                      <input class="form-control" type="text" value="<?=$ProductLineName?>" name="Product_Line_name" autocomplete="off">
                    </div>
                </div> 
				
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('productlinefilter'); e2.action='<?=base_url()?>customer/exportProductLine'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
					  <a href="<?=base_url()?>customer/productLines" class="btn btn-warning">(x) Clear Filter</a> 
				  </div>
              </div>     
              </form>
      </div>
    </section>
  </div>
</div>

<!-- -->
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Product Lines
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
							<a href="<?=base_url()?>customer/addProductLine" class="btn btn-primary ">Add New Product Line</a>
							</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id=" " style="overflow:scroll;">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Edit</th>
                                <th>Delete</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($productLines->result() as $row)
								{
						?>
									<tr class="">
										<td><?=$row->id?></td>
										<td><?php echo $row->name ;?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
											<?php if(($permission->edit == 1 && $permission->follow == 2) || ($permission->edit == 1 && $row->created_by == $user)){ ?>
											<a href="<?php echo base_url()?>customer/editProductLine?t=<?php echo 
											base64_encode($row->id) ;?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
											<?php } ?>
										</td>
										<td>
											<?php if(($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)){ ?>
											<a href="<?php echo base_url()?>customer/deleteProductLine?t=<?php echo 
											base64_encode($row->id) ;?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this Product Line ?');">
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