<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Holidays Plan Filter
      </header>
      <?php 
        if(!empty($_REQUEST['holiday_name'])){
            $holiday_name = $_REQUEST['holiday_name'];
            
        }else{
            $holiday_name = "";
        }
        ?>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/holidaysPlan" method="get" id="holidaysPlan" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="Division">Holiday Name</label>

                    <div class="col-lg-3">
                      <input type="text" class="form-control" name="holiday_name" value="<?=$holiday_name?>">
                    </div>
                 </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('holidaysPlan'); e2.action='<?=base_url()?>hr/holidaysPlan'; e2.submit();" type="submit">Search</button>
                      <a href="<?=base_url()?>hr/holidaysPlan" class="btn btn-warning">(x) Clear Filter</a>

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
				Holidays Plan
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
							<a href="<?=base_url()?>hr/addHolidaysPlan" class="btn btn-primary ">Add New Holiday</a>
							</br></br></br>
						<?php } ?>
						</div>

						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th>ID</th>
								<th>Holiday Name</th>
								<th>Holiday Date</th>
								<th>Created By</th>
                                <th>Created At</th>
								<th>Edit</th>
								<th>Delete</th>
								
							</tr>
						</thead>
						
						<tbody>
							<?php
								foreach($holiday->result() as $row)
								{
									?>
									<tr class="">
										<td><?php echo $row->id ;?></td>
										<td><?php echo $row->holiday_name;?></td>
										<td><?php echo $row->holiday_date;?></td>
										<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                                        <td><?php echo $row->created_at ;?></td>
										<td>
					                      <?php if($permission->edit == 1){ ?>
					                         <a href="<?php echo base_url()?>hr/editHolidaysPlan?i=<?php echo base64_encode($row->id);?>" class="">
					                        <i class="fa fa-pencil"></i> Edit
					                      </a>
					                      <?php } ?>
					                    </td>
					                    
					                    <td>
					                      <?php if($permission->delete == 1){ ?>
					                      <a href="<?php echo base_url()?>hr/deleteHolidaysPlan?i=<?php echo base64_encode($row->id);?>" title="delete" 
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
				</div>
			</div>
		</section>
	</div>
</div>