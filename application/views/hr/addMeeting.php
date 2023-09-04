<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Meeting 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doAddMeeting" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Title / Mail Subject</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="title" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Website">Attendees</label>

                                <div class="col-lg-6">
                                    <select name="attendees[]" id="example" class="form-control m-b"  multiple="multiple" style="display: none;">
                                      <?=$this->admin_model->selectUsersEmail()?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="insrtuctions">Description</label>

                                <div class="col-lg-6">
                                      <textarea name="description" class="form-control" rows="6"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3">Start Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" onchange="checkDate('start_date')" autocomplete="off" class="form_datetime form-control" name="start_date" id="start_date" required="">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="control-label col-md-3">End Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" onchange="checkDate('end_date')" autocomplete="off" class="form_datetime form-control" name="end_date" id="end_date" required="">
                              </div>
                          </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>hr/meetingRoomList" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>