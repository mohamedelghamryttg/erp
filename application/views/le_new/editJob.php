<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Edit Job </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>le/doEditJob" method="post" enctype="multipart/form-data">
				 <div class="card-body">
                      <input type="text" name="request_id" value="<?=base64_encode($task->id)?>" hidden="">
                      <input type="text" name="id" value="<?=base64_encode($job->id)?>" hidden="">
						<!--begin::Card-->
                <div class="card">
                 
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                         <thead>
                                          <tr>
                                            <th>Task Code</th>
                                            <th>Task Name</th>
                                            <th>Task Type</th>
                                            <th>Subject Matter</th>
                                            <th>Product Line</th>
                                            <th>Linguist Format</th>
                                            <th>Deliverable Format</th>
                                             <th>Unit</th>
                                            <th>Volume</th> 
                                            
                                            <th>Source Language</th>
                                            <th>Target Language</th>
                                           <th>Start Date</th>
                                           <th>Delivery Date</th>
                                           <th>Task File</th>
                                           <th>Status</th>
                                           <th>Request Date</th>
                                           <th>Requested By</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                            <th>View Request</th>
                                          </tr>
                                        </thead>
                                        
                                        <tbody>
                                          <tr class="">
                                            <td><a href="<?php echo base_url()?>le/leJobs?t=<?php echo base64_encode($task->id) ;?>" class="">LE-<?=$task->id?></a></td>
                                              <td><?php echo $task->subject ;?></td>
                                            <td><?php echo $this->admin_model->getLETaskType($task->task_type);?></td>
                                            <td><?php echo $this->admin_model->getLESubject($task->subject_matter);?></td>
                                            <td><?php echo $this->customer_model->getProductLine($priceListData->product_line);?></td>
                                          <?php if(is_numeric($task->linguist) && is_numeric($task->deliverable)){ ?>
                                          <td><?php echo $this->admin_model->getLeFormat($task->linguist);?></td>
                                          <td><?php echo $this->admin_model->getLeFormat($task->deliverable);?></td>
                                        <?php }else{ ?>
                                          <td><?=$task->linguist ?></td>
                                          <td><?=$task->deliverable ?></td>
                                        <?php } ?>  
                                          <td><?php echo $this->admin_model->getUnit($task->unit);?></td>
                                          <td><?=$task->volume?></td> 
                                         
                                            <td><?php echo $this->admin_model->getLanguage($priceListData->source);?></td>
                                            <td><?php echo $this->admin_model->getLanguage($priceListData->target);?></td>
                                            <td><?php echo $task->start_date ;?></td>
                                            <td><?php echo $task->delivery_date ;?></td>
                                            <td><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/leRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
                                            <td><?php echo $this->projects_model->getTranslationTaskStatus($task->status) ;?></td>
                                            <td><?php echo $task->created_at ;?></td>
                                            <td><?php echo $this->admin_model->getAdmin($task->created_by) ;?></td>
                                            <td><?php echo $this->admin_model->getAdmin($task->status_by) ;?></td>
                                            <td><?php echo $task->status_at ;?></td>
                                            <td>
                                              <a href="<?php echo base_url()?>le/viewRequest?t=<?php echo 
                                                base64_encode($task->id) ;?>" class="">
                                                  <i class="fa fa-eye"></i> View Request
                                              </a>
                                            </td>
                                          </tr>
                                        </tbody>
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Assigned LE :</label>

                            <div class="col-lg-6">
                                <select name="le" class="form-control" id="le" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectAllLE($this->brand,$job->le)?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Task Type :</label>

                            <div class="col-lg-6">
                                <select name="task_type" class="form-control" id="task_type" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                   <?=$this->admin_model->selectLETaskType($job->task_type)?>
                                </select>
                            </div>
                        </div>  
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Subject Matter :</label>

                            <div class="col-lg-6">
                                <select name="subject_matter" class="form-control" id="subject_matter" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                    <?=$this->admin_model->selectLESubject($job->subject_matter)?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Linguist Format :</label>

                            <div class="col-lg-6">
                                <select name="linguist_format" class="form-control" id="linguist_format" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                    <?=$this->admin_model->selectLeFormat($job->linguist)?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Deliverable Format :</label>

                            <div class="col-lg-6">
                                <select name="deliverable_format" class="form-control" id="deliverable_format" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                    <?=$this->admin_model->selectLeFormat($job->deliverable)?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Unit :</label>

                            <div class="col-lg-6">
                                <select name="unit" class="form-control" id="unit" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                     <?=$this->admin_model->selectLeUnit($job->unit)?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
          						   	<label class="col-lg-3 col-form-label text-right">Volume :</label>
          							  <div class="col-lg-6">
          							  	<input class="form-control"  name="volume"  value="<?= $job->volume ?>"  id="volume" />
          								
          							</div>
      						     </div> 
  						         <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Start Date :</label>
                        <div class="col-lg-6">
                          <input onchange="checkDate('start_date')" value="<?=$job->start_date?>" autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required=""/>
                          
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Delivery Date :</label>
                        <div class="col-lg-6">
                          <input onchange="checkDate('delivery_date')" value="<?=$job->delivery_date?>" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required="" />
                          
                        </div>
                      </div> 
                        <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">File Attachment :</label>
                        <div class="col-lg-6">
                          <input type="file" class="form-control" name="file" id="file" accept="'application/zip'" />
                          
                        </div>
                      </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">TTG TM usage :</label>

                            <div class="col-lg-6">
                                <select name="tm_usage" class="form-control" id="tm_usage" required="">
                                   <option disabled="disabled" selected=""></option>
                                            <?php if($job->tm_usage == 1){ ?>
                                            <option value="1" selected="">Yes</option>
                                            <option value="0">No</option>
                                            <?php }else{ ?>
                                            <option value="1">Yes</option>
                                            <option value="0" selected="">No</option>
                                            <?php } ?>
                                </select>
                            </div>
                        </div> 
                        
          						<div class="form-group row">
          							<label class="col-lg-3 col-form-label text-right">Instructions :</label>
          							<div class="col-lg-6">
                               <textarea name="insrtuctions" class="form-control" rows="6"><?=$job->insrtuctions?></textarea>								
          							</div>
          						</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<input class="btn btn-success mr-2"  type="submit" name="submit" value="Save">
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>