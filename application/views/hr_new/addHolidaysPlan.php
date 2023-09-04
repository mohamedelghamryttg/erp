<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
		<div class="card card-custom example example-compact">
			<div class="card-header">
				<h3 class="card-title">Add New Holiday</h3>
				
			</div>
			<!--begin::Form-->
			<form class="form" action="<?php echo base_url()?>hr/doAddHolidaysPlan" method="post" enctype="multipart/form-data">
				<div class="card-body">
					
						<div class="form-group row">
							<label class="col-lg-3 col-form-label text-right">Holiday Name:</label>
							<div class="col-lg-6">
								<input type="text" class="form-control"name="holiday_name" id="holiday_name" required>
							</div>
						</div>
						 <div class="form-group row">
							<label  class="col-lg-3 col-form-label text-right" for="role date">Holiday Date</label>
		                         <div class="col-lg-6">
                                  <input class="form-control date_sheet"name="holiday_date_1" id="holiday_date_1"type="text" autocomplete="off" onblur="validateHolidayDate(1); alert($('#holiday_date_1').val());" required>
                                 </div>
						</div>

						
                            </div>  
                            <hr>
                            <div id="pairs"></div>

					 <div class="form-group row">
							<div class="col-lg-offset-1 col-lg-6">
                                  <a onclick="addNewPair()" class="text-light btn btn-success">Add Another Holiday</a>
                                  <a onclick="deletePair()" class="btn btn-danger">Delete Last One </a>
                                  <input type="text" name="new_pair" id="new_pair" value="2" hidden>
                              </div>
						</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="submit" class="btn btn-success mr-2">Submit</button>
							<a class="btn btn-secondary" href="<?php echo base_url()?>hr/holidaysPlan" class="btn btn-default" type="button">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Card-->
	</div>
</div> 

 <script type="text/javascript">
        $(function () {
                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                });
           });
        function addNewPair(){
            var x = $("#new_pair").val();
            $("#pairs").append(`
                <div id='pair_`+x+`'>
                            <div class="form-group row">
                                 <label  class="col-lg-3 col-form-label text-right" for="role date">Holiday Date</label>
		                         <div class="col-lg-6">
                                     <input size="16" class="form-control date_sheet"name="holiday_date_`+x+`" id="holiday_date_`+x+`" type="text" autocomplete="off" onblur="validateHolidayDate(`+x+`);" required>
                                 </div>
                            </div>  
                            <hr></div>`);
            var newInput = parseInt(x) + 1;
            $("#new_pair").val(newInput);
        }

        function deletePair() {
              var res = $("#new_pair").val();
              var newInput = parseInt(res) - 1;
              if(newInput >= 2){
                $("#pair_"+newInput).remove();
                $("#new_pair").val(newInput);   
              }else{
                alert("There's No Holiday To Delete ..");
              }
          }
          
    </script>
    <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
        });
    </script>