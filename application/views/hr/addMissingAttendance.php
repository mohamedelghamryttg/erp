<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add Missing Attendance Request
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doAddMissingAttendance" method="post" onsubmit="return disableAddButton();" enctype="multipart/form-data">
            	<div class="form-group">
                       <label class="col-lg-3 control-label" for="role date">Date</label>

                        <div class="col-lg-6">
                             <input size="16" class="form_datetime form-control"name="date"type="text" id="date"autocomplete="off" required="">
                        </div>
                </div> 
                 
                  <div class="form-group">
                     <label class="col-lg-3 control-label" for="role name">Signing Type</label>

                        <div class="col-lg-6">
                            <select name="TNAKEY" class="form-control m-b" id="TNAKEY" required />
                                     <option disabled="disabled" selected="selected">-- Select Type --</option>
                                     <option value="1">Sign In</option>
                                     <option value="2">Sign Out</option>
                            </select>
                        </div>
                </div>

                          
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary disableAdd" type="submit">Save</button> <a href="<?php echo base_url()?>hr/missingAttendance" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
     <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
        });
    </script>