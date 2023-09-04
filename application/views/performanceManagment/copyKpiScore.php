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
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add Kpi Score</h3>

            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>performanceManagment/doAddKpiScore" method="post" onsubmit="return checkScore();" enctype="multipart/form-data">
                <div class="card-body">
                   
                    <input class='form-control' type='text' name='kpi_id' value="<?= $kpi->id ?>" hidden>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Select Employee Title:</label>
                        <div class="col-lg-6">
                            <select name="employee_title" class="form-control" id="employee_title" required="" onchange="getEmployeesNameByTitle(), drawKpiScoreTable();">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                  <?php if($this->role == 31 || $this->role == 21){?>
                                    <?= $this->hr_model->selectAllEmployeesByTitle("none", $kpi->employee_title); ?>  
                                <?php }else{?>
                                <?=  $this->hr_model->selectAllEmployeesByTitleSelf($emp_id, $kpi->employee_title);  ?> 
                                <?php }?>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row" id="employee_name_div">
                        <label class="col-lg-3 col-form-label text-right">Select Employee Name:</label>
                        <div class="col-lg-6">
                            <select name="employee_name" class="form-control" id="employee_name" required="">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?php foreach ($employee_names as $name) { ?>
                                    <option value="<?= $name['id'] ?>" <?= $name['id'] == $score->emp_id ? 'selected' : '' ?>><?= $name['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Select Year:</label>
                        <div class="col-lg-6">
                            <select name="year" class="form-control" id="year" required=""onchange="drawKpiScoreTable();">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->selectYear($kpi->year); ?> 
                            </select>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Select Month:</label>
                        <div class="col-lg-6">
                            <select name="month" class="form-control" id="month" required=""onchange="drawKpiScoreTable();">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->accounting_model->selectMonth($score->month); ?>
                            </select>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <!--begin: Datatable-->
                        <table class="table table-hover" id="kt_datatable2">
                            <thead>
                            <th></th>
                            <th>Weight</th>
                            <th>Target</th>
                            <th>Achived</th>
                            <th>Score</th>
                            <th>Comment</th>
                            </thead>
                            <tbody id="kpiTable"> 
                                <?php
                                foreach ($core_headers as $key => $value) {
                                    $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();?>                                    
                                    <tr>
                                        <td colspan="4">
                                            <h4 class="text-success"><?= $value->core_name ?></h4>
                                        </td>
                                    </tr>
                                    <?php
                                    foreach ($sub as $key => $val) {
                                        $score_data = $this->db->query("SELECT * From kpi_score_data WHERE kpi_sub_id = '$val->id' and kpi_score_id = '$score->id'")->row();
                                        ?> 
                                        <tr>
                                            <td width='25%'> <input class='form-control' type='text' name='sub_id' value='<?= $val->id ?>' hidden>
                                                <h5><?= $val->sub_name ?></h5></td>
                                             <td>
                                                <div class='input-group'>
                                                    <input class='form-control weight' type='number' min='1' max='100' id='weight_<?= $val->id ?>' name='weight_<?= $val->id ?>' value="<?= $score_data->weight ?>" onchange='calculateScore(<?= $val->id ?>);' required="">
                                                    <div class='input-group-append'>
                                                        <span class='input-group-text' id='basic-addon2'>%</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class='input-group'>
                                                    <input class='form-control' type='number' min='1' id='target_<?= $val->id ?>' name='target_<?= $val->id ?>' value="<?= $score_data->target ?>" onchange='calculateScore(<?= $val->id ?>);' required>
                                                    <div class='input-group-append'>
                                                        <span class='input-group-text' id='basic-addon2'><?=$val->target_type?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <input class='form-control' type='text' id='achieved_<?= $val->id ?>' name='achieved_<?= $val->id ?>' onchange='calculateScore(<?= $val->id ?>);' value="<?= $score_data->achieved ?>"  required> </td> 
                                            <td> <input class='form-control' type='text' id='score_<?= $val->id ?>' name='score_<?= $val->id ?>' value="<?= $score_data->achieved ?>" readonly > </td>
                                            <td><textarea class='form-control' name='comment_<?= $val->id ?>'></textarea></td>

                                        </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>  
                </div>  
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>performanceManagment/kpiScore" class="btn btn-default" type="button">Cancel</a>
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
    let base_url = "<?= base_url() ?>";

    function getEmployeesNameByTitle() {
        var employee_title = $("#employee_title").val();
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "performanceManagment/getEmployeesNameByTitle", {employee_title: employee_title}, function (response) {
            $('#loading').hide();
            $('#employee_name').empty();
            response = JSON.parse(response);
            var html = '<option value=""> select name</option>';
            console.log(response);
            $.each(response, function (e) {
                console.log();
                html += '<option value="' + response[e].id + '">' + response[e].name + '</option>';
            });
            $('#employee_name').html(html);
            $('#employee_name_div').show();
            $('#employee_name').selectpicker("refresh");
            console.log(html);

        });
    }
    function drawKpiScoreTable() {
        var employee_title = $("#employee_title").val();
        var year = $("#year").val();
         var month = $("#month").val();  
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "performanceManagment/drawKpiScoreTable", {employee_title: employee_title, year: year, month: month}, function (data) {
            $('#loading').hide();
            $('#kpiTable').empty();
            // console.log(data);
            //    var html= data;
            $('#kpiTable').append(data);
            // $('#employee_name').html(html);
            // $('#employee_name').selectpicker("refresh");
            // console.log(html);

        });
    }

    function calculateScore(sub_id) {
        //alert(sub_id);
        var weight = $("#weight_" + sub_id).val();
        var target = $("#target_" + sub_id).val();
        var achieved = $("#achieved_" + sub_id).val();
        
        var score_value = (parseFloat(achieved) / parseFloat(target)) * parseFloat(weight);
        if(score_value > parseFloat(weight)){
            score_value = parseFloat(weight);
        }else{
           score_value = Math.round(score_value * 100) / 100;
        }
        var score = $("#score_" + sub_id).val(score_value);
    }

    function checkScore() {      
        var employee_title = $("#employee_title").val();
        var employee_name = $("#employee_name").val();
        var year = $("#year").val();
        var month = $("#month").val();
        var data_return = '';
        
         $.ajax({
            async: false,
            type: "POST",
            url: base_url + "performanceManagment/checkScoreIfExists",
            data: {emp_id: employee_name, month: month, employee_title: employee_title, year: year},
            dataType: "json",
            success: function (data) {             
                if (data.status == "success") {               
                // check weight 
                    var total = 0;
                    $('.weight').each(function () {
                        var val = $(this).val() ? parseInt($(this).val()) : 0;
                        total += val;
                    });
                    if (total != 100) {
                        alert("Error! Kpi Total Weight Must Equal 100");
                        data_return=false;
                    }else{
                        data_return=true;
                    }
                }
            //end check
            else {
                data_return=false;
                alert(data.msg);
            }
            $('#loading').hide();
            }
        });
          return data_return;
    }
       

</script>