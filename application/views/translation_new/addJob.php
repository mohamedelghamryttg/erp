<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Add New Job </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"  action="<?php echo base_url()?>translation/doAddJob" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
				 <div class="card-body">
                      <input type="text" name="request_id" value="<?=base64_encode($task->id)?>" hidden="">
						<!--begin::Card-->
                <div class="card">
                 
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                         <thead>
                                            <tr>
                                                 <th>Task Code</th>
                                                <th>Task Subject</th>
                                                <th>Task Type</th>
                                                 <th>Count</th>
                                                 <th>Unit</th>
                                                 <th>Start Date</th>
                                                 <th>Delivery Date</th>
                                                 <th>Task File</th>
                                                 <th>Status</th>
                                                 <th>Request Date</th>
                                                 <th>Requested By</th>
                                                 <th>Closed Date</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr class="">
                                               <td><a href="<?php echo base_url()?>translation/TranslationJobs?t=<?php echo base64_encode($task->id) ;?>" class="">Translation-<?=$task->id?></a></td>
                                            <td><?php echo $task->subject ;?></td>
                                            <td><?php echo $this->admin_model->getTaskType($task->task_type);?></td>
                                            <td><?php echo $task->count ;?></td>
                                            <td><?php echo $this->admin_model->getUnit($task->unit) ;?></td>
                                            <td><?php echo $task->start_date ;?></td>
                                            <td><?php echo $task->delivery_date ;?></td>
                                            <td><?php if(strlen($task->file) > 1){ ?><a href="<?=base_url()?>assets/uploads/translationRequest/<?=$task->file?>" target="_blank">Click Here</a><?php } ?></td>
                                            <td><?php echo $this->projects_model->getTranslationTaskStatus($task->status) ;?></td>
                                            <td><?php echo $task->created_at ;?></td>
                                            <td><?php echo $this->admin_model->getAdmin($task->created_by) ;?></td>
                                            <td><?php echo $task->closed_date ;?></td>
                                            <td><?php echo $this->admin_model->getAdmin($task->status_by) ;?></td>
                                            <td><?php echo $task->status_at ;?></td>
                                            </tr>
                                        </tbody>
                    </table>
                    <!--end: Datatable-->
                  </div>
                </div>
                <!--end::Card-->
                      <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Translator :</label>

                            <div class="col-lg-6">
                                <select name="translator" class="form-control" id="translator" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                        <?=$this->admin_model->selectAllTranslator($this->brand)?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Task Type :</label>

                            <div class="col-lg-6">
                                <select name="task_type" class="form-control" id="task_type" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                    <?=$this->admin_model->selectTaskType(0,1)?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Count :</label>
							<div class="col-lg-6">
								<input class="form-control" onkeypress="return numbersOnly(event)" name="count" id="count" required />
								
							</div>
						</div> 
						<div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Unit :</label>

                            <div class="col-lg-6">
                                <select name="unit" class="form-control" id="unit" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                    <?=$this->admin_model->selectUnit($task->unit)?>
                                </select>
                            </div>
                        </div> 
                            
    						<div class="form-group row">
    							<label class="col-lg-3 col-form-label text-right">Start Date :</label>
    							<div class="col-lg-6">
    								<input onchange="checkDate('start_date')" value="<?=date("Y-m-d H:i:s")?>"  autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required=""/>
    								
    							</div>
    						</div>
    						<div class="form-group row">
    							<label class="col-lg-3 col-form-label text-right">Delivery Date :</label>
    							<div class="col-lg-6">
    								<input  onchange="checkDate('delivery_date')" autocomplete="off" class="form_datetime form-control" name="delivery_date" id="delivery_date" required="" />
    								
    							</div>
    						</div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label text-right">File Attachment :</label>
                  <div class="col-lg-6">
                    <input type="file" class="form-control" name="file" id="file" accept="'application/zip'" />
                    
                  </div>
                </div> 
    						<div class="form-group row">
    							<label class="col-lg-3 col-form-label text-right">Instructions :</label>
    							<div class="col-lg-6">
                                 <textarea name="insrtuctions" class="form-control" rows="6"></textarea>								
    							</div>
    						</div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<input class="btn btn-success mr-2" type="submit" name="submit" value="Save">
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>