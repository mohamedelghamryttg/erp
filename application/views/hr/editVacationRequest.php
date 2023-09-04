<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
               Edit Vacation Request
            </header>
            
            <div class="panel-body">
                <div class="form">
            <form class="cmxform form-horizontal " id="form"action="<?php echo base_url()?>hr/doEditVacationRequest" method="post"onsubmit="onAddVacationRequest()" name="editVacatin" enctype="multipart/form-data">
                  <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                           <div class='form-group'>
                                <label class='col-lg-3 control-label'>Type Of Vacation</label>
                                <div class='col-lg-6'>
                                    <select name='type_of_vacation'class='form-control m-b'id="type_of_vacation" onchange="calculateAvailableVacationDays(1);"value="" required="">
                                    <?= $this->hr_model->selectAllVacationTypies($row->type_of_vacation) ?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group'id="relative_degree_div" style="display: none;">
                                <label class='col-lg-3 control-label' for='inputPassword'>Relative Degree</label>
                                <div class='col-lg-6'>
                                    <select name='relative_degree'class='form-control m-b'id="relative_degree" onchange="calculateAvailableVacationDays();"value="">
                                    <?php if($row->relative_degree == 1){ ?>
                                             <option value="" >-- Select --</option>
                                             <option value="1" selected="" >First</option>
                                             <option value="2" >Second</option>
                                   <?php }elseif ($row->relative_degree == 2) { ?>
                                             <option value="" >-- Select --</option>
                                             <option value="1" >First</option>
                                             <option value="2"selected="" >Second</option>
                                   <?php }else{ ?>
                                        <option value="" selected=''>-- Select --</option>
                                        <option value="1" >First</option>
                                         <option value="2" >Second</option>
                                   <?php } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group" id="available_days_div">
                                <label class="col-lg-3 control-label" >Available Days</label>
                                 <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="available_days" value = "" id="available_days" data-maxlength="300" placeholder="Available days" readonly>
                                    <input type="text" class="form-control" value =" " name="availableDays" id="availableDays" data-maxlength="300" placeholder="Available days" hidden="">
                                </div>
                            </div>
                            <div class="form-group" id="requested_days_div" style="display: block;">
                                <label class="col-lg-3 control-label" >Requested Days</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control"  value ="<?= $row->requested_days?> " name="requested_days" id="requested_days" data-maxlength="300"  placeholder="Requested days" readonly>
                                </div>
                            </div>
                            <div class='form-group'id="day_type_div" style="display: none;">
                                <label class='col-lg-3 control-label' >Vacation Day Type</label>
                                <div class='col-lg-6'>
                                    <select name='day_type'class='form-control m-b'id="day_type" onchange="checkVacationCredite();">                                       
                                        <option value="0" <?= $row->requested_days !='.5'?'selected':''?>>Full Day</option>
                                         <option value="1" <?= $row->requested_days =='.5'?'selected':''?>>½ Day</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Start</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control datepicker" value="<?= $row->start_date?>" name="start_date"autocomplete="off" onblur="onBlur();showEndDate()" id="start_date" data-maxlength="300"  placeholder="Number Of Days" required="">
                                </div>
                            </div>
                            <div class="form-group" id="end_date_div"style="display: block;">
                                <label class="col-lg-3 control-label" >End</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control datepicker" value="<?= $row->end_date?>" name="end_date"autocomplete="off" onblur="onBlur()" id="end_date" data-maxlength="300"  placeholder="End Date" required="">

                                    <input style="display: none;" type="text"value="<?= $row->end_date?>" class=" form-control"  value =" " name="show_end_date" id="show_end_date" data-maxlength="300" readonly>
                                   
                                </div>
                            </div>
                            <div class="form-group" id="sick_leave_file" style="display: none;">
                                <label class="col-lg-3 control-label" >Sick Leave Document</label>

                                <div class="col-lg-6">
                                    
                                     <input type="file" id="file"name="file" value="<?=$row->sick_leave_file ?>" > 
                                </div>
                            </div>  
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary"name="save" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>hr/vacation" class="btn btn-danger" type="button">Cancel</a>
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
<script type="text/javascript"> 
    //hagar 6/3/2020
 window.onload = function() {
   var type_of_vacation = $("#type_of_vacation").val();
     if(type_of_vacation == 4 || type_of_vacation == 5 || type_of_vacation == 6 || type_of_vacation == 7){
             //$("#end_date_div").hide();
             $("#requested_days_div").hide();
             $("#end_date").removeAttr("required");
             
              if(type_of_vacation == 4){ 
                 $("#available_days").val("5");
               }
               if(type_of_vacation == 5){ 
                 $("#available_days").val("90");
               }
             if(type_of_vacation == 6){ 
                     if( $("#relative_degree").val() == 1){
                       $("#available_days").val("3");
                     }else if( $("#relative_degree").val() == 2){
                       $("#available_days").val("1");
                     }
                $("#relative_degree_div").show();
             }else{
                 $("#relative_degree_div").hide();
             } 
             if(type_of_vacation == 7){ 
                 $("#available_days").val("30");
               }
    }else{  
           calculateAvailableVacationDays(1);
             $("#end_date_div").show();
             $("#requested_days_div").show();
             $("#relative_degree_div").hide();
    }
  };
</script>