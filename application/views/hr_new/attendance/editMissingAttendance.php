<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Edit Missing Attendance Request</h3>

                </div>
                <!--begin::Form-->
                <form class="form" action="<?php echo base_url() ?>hr/doEditMissingAttendance" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="text" name="id" hidden="" value="<?= base64_encode($id) ?>">
                        <?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
                        <?php } else { ?>
                            <input type="text" name="referer" value="<?= base_url() ?>customer" hidden>
                        <?php } ?>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Date Time:</label>
                            <div class="col-lg-6">
                                <input name="date"type="text" id="date"autocomplete="off" required=""class="form-control form-control-solid datetimepicker-input date_sheet_day"placeholder="Select date &amp; time" data-toggle="datetimepicker" data-target="#kt_datetimepicker_5" value="<?= $row->SRVDT ?>"   />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Signing Type:</label>

                            <div class="col-lg-6">
                                <select name="TNAKEY" id="TNAKEY" required class="form-control">
                                    <option disabled="disabled">-- Select Type --</option>                                   
                                        <option value="1" <?=$row->TNAKEY == 1?'selected':''?>>Sign In</option>
                                        <option value="2" <?=$row->TNAKEY == 2?'selected':''?>>Sign Out</option>
                                   
                                </select>
                            </div>
                        </div>
                              <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right" for="role name">Location</label>

                        <div class="col-lg-6">
                            <select name="location" class="form-control m-b" id="location" required >
                                <option value="" disabled="disabled" selected="selected">-- Select Type --</option>
                                <option value="0"<?=$row->location == 0?'selected':''?>>Office</option>
                                <option value="1"<?=$row->location == 1?'selected':''?>>Home</option>

                            </select>
                        </div>
                    </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <a class="btn btn-secondary" href="<?php echo base_url() ?>hr/missingAttendance" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
<script type="text/javascript">
   $(function() {
       $('.date_sheet_day').datetimepicker( {format: 'YYYY-MM-DD HH:mm:ss'}); 

    });
</script>