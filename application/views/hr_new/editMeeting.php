<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title"> Edit Meeting  </h3>
				
			</div>
			<!--begin::Form-->
			<form class="form"action="<?php echo base_url()?>hr/doEditMeeting/<?=$meeting_room_schedule->id?>" method="post" enctype="multipart/form-data">
				 <div class="card-body">
                    <input type="text" name="id" value="<?=base64_encode($meeting_room_schedule->id)?>" hidden="">
						
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" for="role name">Title / Mail Subject :</label>

                        <div class="col-lg-6">
                            <input type="text" class=" form-control" value="<?=$meeting_room_schedule->title?>" name="title" required>
                        </div>
                    </div>
                      <div class="form-group row ">
                            <label class="col-lg-3 col-form-label text-right" for="Division">Attendees:</label>

                            <div class="col-lg-6">
                                <select name="attendees[]" id="example" class="form-control" multiple="multiple" style="display: none;">
                                    <?=$this->admin_model->selectUsersEmail($meeting_room_schedule->attendees)?>
                                </select>
                            </div>
                        </div> 

                        <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right" for="insrtuctions">Description</label>

                                <div class="col-lg-6">
                                      <textarea name="description" class="form-control" rows="6"><?=$meeting_room_schedule->description?></textarea>
                                </div>
                          </div>

                         <div class="form-group row">
                              <label class="col-lg-3 col-form-label text-right">Start Date</label>
                              <div class="col-md-6">
                                  <input type="text" onchange="checkDate('start_date')" autocomplete="off" class=" form-control date_sheet" name="start_date" id="start_date" value="<?=$meeting_room_schedule->start?>" required="">
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-lg-3 col-form-label text-right">End Date</label>
                              <div class="col-md-6">
                                  <input type="text" onchange="checkDate('end_date')" autocomplete="off" class=" form-control date_sheet" name="end_date" id="end_date" value="<?=$meeting_room_schedule->end?>" required="">
                              </div>
                          </div>
					
					
					</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/meetingRoomList_test" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div>