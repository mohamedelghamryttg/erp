<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Filter
			</header>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="vendorForm" action="<?php echo base_url()?>vendor/cvDialict" method="post" enctype="multipart/form-data">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role Task Type">Source</label>

                    <div class="col-lg-3">
                    	<select name="source_lang" class="form-control m-b" id="source" />
                                 <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                 <?=$this->admin_model->selectLanguage()?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label" for="role Task Type">Target</label>

                    <div class="col-lg-3">
                        <select name="target_lang" class="form-control m-b" id="target" />
                                 <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                 <?=$this->admin_model->selectLanguage()?>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="role Field">Field</label>

                    <div class="col-lg-3">
                        <select name="field[]" multiple class="form-control m-b" id="subject" />
                                 <option disabled="disabled" selected="selected">-- Select Field --</option>
                                 <?=$this->admin_model->selectFields()?>
                        </select>
                    </div>
                    <label class="col-lg-2 control-label" for="role Task Type">Created By</label>

                    <div class="col-lg-3">
                    	<select name="created_by" class="form-control m-b" id="created_by"/>
                         <option value="">-- Select Vm --</option>
                         <?=$this->admin_model->selectAllVm($this->brand)?>
                </select>
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
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				CV List
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
							<a href="<?=base_url()?>vendor/addCVDialict?t=<?=base64_encode($idVendorDialect)?>" class="btn btn-primary ">Add New Dialect</a>
							</br></br></br>
						<?php } ?>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
                             <th>ID</th>
							<th>Dialect</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Edit</th>
                            <th>Delete</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($cv->result() as $row)
								{
						?>
									<tr class="">
                                      <td><?=$row->id?></td>
										<td><a href="<?=base_url()?>vendor/cvField?t=<?=base64_encode($row->id)?>"><?=$row->dialect?></a></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
										<td><?php echo $row->created_at ;?></td>
										<td>
											<?php if($permission->edit == 1){ ?>
											<a href="<?php echo base_url()?>vendor/editCVDialict?t=<?=base64_encode($row->id)?>&x=<?=base64_encode($idVendorCv)?>" class="">
												<i class="fa fa-pencil"></i> Edit
											</a>
											<?php } ?>
										</td>
										<td>
											<?php if($permission->delete == 1){ ?>
											<a href="<?php echo base_url()?>vendor/deleteCVDialict?t=<?=base64_encode($row->id)?>&x=<?=base64_encode($idVendorCv)?>" title="delete" 
											class="" onclick="return confirm('Are you sure you want to delete this Record ?');">
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
					</table>
				</div>
			</div>
		</section>
	</div>
</div>