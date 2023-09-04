<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Holiday
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doAddHolidaysPlan" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Name">Holiday Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="holiday_name" data-maxlength="300" id="holiday_name" required>
                                </div>
                            </div> 

                            <div class="form-group">
		                       <label class="col-lg-3 control-label" for="role date">Holiday Date</label>

		                         <div class="col-lg-6">
                                     <input size="16" class="datepicker form-control"name="holiday_date_1" id="holiday_date_1" type="text" autocomplete="off" onblur="validateHolidayDate(1); alert($('#holiday_date_1').val());"  required>
                                 </div>
                            </div>  
                            <hr>
                            <div id="pairs">
                                
                            </div> 
                            <div class="form-group">
                              <div class="col-lg-offset-1 col-lg-6">
                                  <a onclick="addNewPair()" class="text-light btn btn-primary">Add Another Holiday</a>
                                  <a onclick="deletePair()" class="btn btn-danger">Delete Last One </a>
                                  <input type="text" name="new_pair" id="new_pair" value="2" hidden>
                              </div>
                             </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>hr/holidaysPlan" class="btn btn-default" type="button">Cancel</a>
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
        function addNewPair(){
            var x = $("#new_pair").val();
            $("#pairs").append(`
                <div id='pair_`+x+`'>
                            <div class="form-group">
                               <label class="col-lg-3 control-label" for="role date">Holiday Date</label>

                                 <div class="col-lg-6">
                                     <input size="16" class="datepicker form-control"name="holiday_date_`+x+`" type="text" autocomplete="off" onblur="validateHolidayDate(`+x+`);" id="holiday_date_`+x+`" required>
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