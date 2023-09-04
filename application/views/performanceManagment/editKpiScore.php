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
                <div class="card-title">
                        <h3 class="card-label">Employees KPIs <i class="fa fa-arrow-alt-circle-right"></i> <?= $this->hr_model->getEmployee($emp_id); ?> <i class="fa fa-arrow-alt-circle-right"></i> Edit Kpi Score</h3>
                    </div>
            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>performanceManagment/updateKpiScore" method="post" onsubmit="return checkScore();" enctype="multipart/form-data">
                <div class="card-body">
                   
                    <input class='form-control' type='text' name='score_id' value="<?= $score->id ?>" hidden>
                    
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
                                            <td width='30%'> <input class='form-control' type='text' name='sub_id' value='<?= $val->id ?>' hidden>
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
                                            <td>
                                                <div class='input-group'>
                                                    <input class='form-control'type='number' min='0' id='achieved_<?= $val->id ?>' name='achieved_<?= $val->id ?>' onchange='calculateScore(<?= $val->id ?>);' value="<?= $score_data->achieved ?>"  required> 
                                                    <div class='input-group-append'>
                                                        <span class='input-group-text' id='basic-addon2'><?=$val->target_type?></span>
                                                    </div>
                                                </div></td> 
                                            <td> <input class='form-control' type='text' id='score_<?= $val->id ?>' name='score_<?= $val->id ?>' value="<?=number_format((float)$score_data->score, 2, '.', '') ?> %" readonly > </td>
                                            <td><textarea class='form-control' name='comment_<?= $val->id ?>'><?=$score_data->comment?></textarea></td>

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
        var data_return = '';
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
                    
       return data_return;
    }
       

</script>