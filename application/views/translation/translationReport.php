<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				 Filter
			</header>

      <?php

      if(!empty($_REQUEST['code'])){
          $code = $_REQUEST['code'];
         
      }else{
          $code = "";
      }
     if(!empty($_REQUEST['translator'])){
          $translator = $_REQUEST['translator'];
         
      }else{
          $translator = "";
      }


      ?>
			
			<div class="panel-body">
			 <form class="cmxform form-horizontal " id="translationReport" method="get" enctype="multipart/form-data">
				<div class="form-group">
                    <label class="col-lg-2 control-label" for="role name">Job Code</label>

                    <div class="col-lg-3">
                    	<input type="text" class="form-control" name="code" value="<?=$code?>">
                    </div>

                    <label class="col-lg-2 control-label" for="role Assigned Translator">Assigned Translator</label>

                    <div class="col-lg-3">
                        <select name="translator" class="form-control m-b" id="translator" />
                                <option disabled="disabled" selected=""></option>
                                <?=$this->admin_model->selectAllTranslator($this->brand,$translator)?>
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
                      <button class="btn btn-primary" name="search" onclick="var e2 = document.getElementById('translationReport'); e2.action='<?=base_url()?>translation/translationReport'; e2.submit();" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('translationReport'); e2.action='<?=base_url()?>translation/exportTranslationJobs'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                      <a href="<?=base_url()?>translation/translationReport" class="btn btn-warning">(x) Clear Filter</a> 
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
				Translation Report
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
				<div class="adv-table editable-table " style="overflow-y: scroll;">
					<div class="clearfix">
						
					</div>
					<div class="space15"></div>


<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Subject</th>
                <th>PM</th>
                <th>Sent Date</th>
                <th>Task Code</th>
                  <th>Assigned Translator</th>
                  <th>Task Type</th>
                 <th>Count</th>
                 <th>Updated Count</th>
                 <th>Unit</th>
                 <th>Start Date</th>
                 <th>Delivery Date</th>
                 <th>Status</th>
                  <th>Created By</th>
                  <th>Created At</th>
                 <th>Closed Date</th>
                 <th>Taken Time (Hrs)</th>
                 <th>Taken Time (Mins)</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($job->result() as $row) { 
                  $request = $this->db->get_where('translation_request',array('id' => $row->request_id))->row();
                  $jobData = $this->projects_model->getJobData($request->job_id);
                  $priceListData = $this->projects_model->getJobPriceListData($jobData->price_list);
                  if($row->status == 2 || $row->status == 4){
                    $takenTime = $this->projects_model->getTranslationJobTime($row->id);
                  }
              ?>
              <tr class="">
                <td><?=$request->subject?></td>
                <td><?=$this->admin_model->getAdmin($request->created_by)?></td>
                <td><?=$request->created_at?></td>
                <td>Translation-<?=$request->id?>-<?=$row->id?></td>
                <td><?php echo $this->admin_model->getAdmin($row->translator) ;?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php if($row->status == 4){ echo $row->updated_count ;} ?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
                <td><?php echo $this->projects_model->getTranslationJobStatus($row->status) ;?></td>
                <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                <td><?php echo $row->created_at ;?></td>
                <td><?php echo $row->closed_date ;?></td>
                <td><?php echo $takenTime['hrs'] ;?></td>
                <td><?php echo $takenTime['mins'] ;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

             <nav class="text-center">
         <?=$this->pagination->create_links()?>
          			</nav>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>