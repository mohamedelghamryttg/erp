<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="container container-form">
    <?php if ($this->session->flashdata('true')) { ?>
        <div class="alert alert-success" role="alert">
            <span class="fa fa-check-circle"></span>
            <span><strong><?= $this->session->flashdata('true') ?></strong></span>
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger" role="alert">
            <span class="fa fa-warning"></span>
            <span><strong><?= $this->session->flashdata('error') ?></strong></span>
        </div>
    <?php } ?>

    <!--begin::Card-->
    <div class="card">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label"><a class="text-dark" href="<?php echo base_url() ?>performanceManagment/kpi/"> Employees KPIs </a><i class="fa fa-arrow-alt-circle-right"></i> Add Kpi</h3>
            </div>

        </div>
        <div class="card-body">            
            <form action="<?php echo base_url() ?>performanceManagment/doAddKpi"class="form" method="post" onsubmit="return calculateTotalWeight();" enctype="multipart/form-data">
                          
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right" for="Division">Kpi Design Title:</label>
                    <div class="col-lg-6">
                         <input class="form-control" type="text" name="title" id="title" >
                    </div> 
                </div>  
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right" for="Division">Select Employee Title:</label>
                    <div class="col-lg-6">
                        <select name="employee_title" class="form-control" id="employee_title" required="">
                            <option value="" disabled='' selected=''>-- Select --</option>
                            <?php if($permission->view == 1){?>
                            <?= $this->hr_model->selectAllEmployeesByTitle(); ?>  
                            <?php }else{?>
                            <?= $this->hr_model->selectAllEmployeesByTitleSelf($emp_id); ?>  
                            <?php }?>
                        </select>
                    </div> 
                </div>  
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right" for="Division">Use This Kpi Design Card: <i class='fa fa-info-circle text-danger' title='Choose Yes to use this kpi in "add kpi score page"'></i></label>
                    <div class="col-lg-6">
                        <select name="active" class="form-control" id="active" required="">
                            <option value="1" >-- YES --</option>
                            <option value="0" >-- NO --</option>                           
                        </select>
                    </div>
                </div> 
              
                <hr/>
                <div class="repeater">
                    <div data-repeater-list="core_pair">
                        <div class="core" data-repeater-item>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-right">Core:</label>   
                                <div class="col-lg-8">
                                    <input class="form-control co" type="text" name="core" id="core" value="" required="">
                                </div>
                            </div>  
                            <!-- add subs -->
                            <div class="inner-repeater">
                                <div data-repeater-list="sub_pair">
                                    <div class="core" data-repeater-item>
                                        <table class="table table-hover" id="kt_datatable2">
                                            <tr>
                                                <td width="40%"> <label class="col-lg-4 col-form-label">Sub:</label> <input class="form-control" type="text" name="sub" id="sub" value="" required=""> </td>
                                                <td width='25%'><label class="col-lg-4 col-form-label">Weight:</label> 
                                                    <div class="input-group">
                                                        <input class='form-control su' type='number' min="1" max="100" name='weight' id="weight" required="">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                    </div>    
                                                </td>
                                                <td width='25%'> <label class="col-lg-4 col-form-label">Target:</label>
                                                    <div class="input-group">
                                                        <input class='form-control' type='number' min='1' name='target'id="target" required=""> 
                                                        <div class="input-group-append">
                                                            <div class="input-group-text" style="padding: 0px ">
                                                                <select name="target_type" class="custom-select" required>                                                                                
                                                                    <option value="%" selected="">%</option>
                                                                    <option value="#" >Number #</option>
                                                                    <option value="$" >Currency $</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                  </td>                                               
                                                <td> <input data-repeater-delete type='button' class='btn btn-danger' value="Delete Sub"> </td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                                <input data-repeater-create type="button" class="btn btn-success" value="Add Sub +"/>
                            </div>

                            <!-- -->
                            <div class="form-group row">
                                <div class="col-sm-3 offset-5">
                                    <input data-repeater-delete type='button' class='btn btn-danger' value="Delete Core">
                                </div>
                            </div>
                            <hr>

                        </div>

                    </div>           
                    <input data-repeater-create type="button" class="btn btn-success" value="Add Core +"/>
                    <input type="submit" class="btn btn-primary" value="Save"/>          
                </div>
            </form>  
        </div>



        <div class="m-10 bg-danger-o-15">
            <label class="col-form-label">Total Weight:</label> 
            <input type="text" readonly="" class='form-control' name="total_weight">
        </div>     
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
        let base_url = "<?= base_url()?>";
         
        $(document).on('change', '.su', function () {
            var total = 0;
            $('.su').each(function () {
                var val = $(this).val() ? parseInt($(this).val()) : 0;
                total += val;
            });
            $("input[name=total_weight]").val(total);
        });

        function calculateTotalWeight() {
            var total_weight = 0;
            var $data_return = '';
            var core = document.getElementsByClassName("co");
            var sub = document.getElementsByClassName("su");
            var arrFromList = Array.prototype.slice.call(sub);
            for (var i = 0; i < core.length; i++) {
                //get subs
                for (var y = 0; y < sub.length; y++) {
                    var weightValue = $('input[name="core_pair[' + i + '][sub_pair][' + y + '][weight]"]').val();
                    //alert(weightValue);
                    if (weightValue == undefined) {
                        continue;
                    } else {
                        total_weight = parseInt(total_weight) + parseInt(weightValue);
                        // alert("Total "+total_weight);
                        $("input[name=total_weight]").val(total_weight);
                    }
                }
            }
            // alert("Final Total: " + total_weight);

            if (total_weight == 100) {               
                data_return =  true;
            } else {
                alert("Kpi Total Weight Must Equal 100");
                data_return = false;
            }

            return data_return;

        }
        
        
    </script>