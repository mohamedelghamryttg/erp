<script>tinymce.init({selector: 'textarea'});</script>  
<style>    
    .bg-yellow{
        background-color:yellow;      
    }
    .bg-primary{
        background-color:#003eff!important;      
    }
</style>
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
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">


        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">

            <!--begin::Card-->
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">ScoreCard <i class="fa fa-arrow-alt-circle-right"></i> <?= $this->hr_model->getEmployee($employee_id).'<span class="font-size-h5" style="color:#B5B5C3">('. $this->accounting_model->getMonth($score->month).','. $this->hr_model->getYear($score->year).')</span>' ?></h3>
                    </div>
                    <?php if($score->status < 1 && $score->manager_approval == 0 && $this->hr_model->getEmpId($score->created_by) == $this->emp_id){?>
                    <a href="<?php echo base_url() ?>performanceManagment/editEmployeeKpiScore/<?=$score->id?>" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i>Edit</a>
                    <?php }elseif ($score->status == 3) {?>
                    <button class="btn btn-success mr-2" disabled=""><?= $this->hr_model->getScoreStatus($score->id); ?></button>
                 <?php   }elseif ($score->status == 1 && $score->emp_id == $this->emp_id) {?>
                    <form class="form mt-10" style="display:inline-block" id="action" action="<?php echo base_url() ?>performanceManagment/changeScoreStatus" method="post">
                        <input type="text" name="score" hidden="" value="<?= $score->id ?>">
                        <button class="btn btn-danger mr-2" name="reject" type="submit"><i class="fa fa-exchange-alt" aria-hidden="true"></i> Ask For HR Meeting</button>
                        <button class="btn btn-success mr-2" name="accept" type="submit"><i class="fa fa-check-double" aria-hidden="true"></i> Accept</button>
                    </form>
                 <?php }elseif($score->status == 4 && $score->manager_approval == 0 && $this->hr_model->getManagerId($this->hr_model->getUserEmp($score->created_by)) == $this->emp_id){?>
                     <form class="form mt-10" style="display:inline-block" id="action" action="<?php echo base_url() ?>performanceManagment/changeScoreStatus" method="post" >
                        <input type="text" name="score" hidden="" value="<?= $score->id ?>">
                        <button class="btn btn-success mr-2" name="approve" type="submit"><i class="fa fa-check-double" aria-hidden="true"></i> Approve </button>
                    </form>
                 <?php   }?>
                </div>
                <div class="card-body pt-0">
                     <table class="table table-dark table-head-custom table-hover mb-10 ">                        
                        <tbody>
                            <tr>
                                <td class="text-danger font-weight-bolder">User </td>
                                <td ><?= $this->hr_model->getEmpName($score->emp_id); ?></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bolder">Created By</td>
                                <td ><?= $this->admin_model->getEmpNameFromUser($score->created_by); ?> <i class="fa fa-arrow-circle-right fa-sm"></i> <?= $score->created_at ?></td>
                            </tr>                            
                            <tr>
                                <td class="text-danger font-weight-bolder">Approved By  </td>
                                <td ><?php if($score->approved_by)echo $this->admin_model->getEmpNameFromUser($score->approved_by)." <i class='fa fa-arrow-circle-right fa-sm'></i>". $score->approved_at;else echo"--"?></td>
                            </tr> 
                            <tr>
                                <td class="text-danger font-weight-bolder">Status</td>
                                <td><?= $this->hr_model->getScoreStatus($score->id) ?> </td>
                            </tr>


                        </tbody>
                    </table>
                    
                    <!--begin: Datatable-->
                    <table class="table table-head-custom table-checkable table-hover table-responsive" width="100%" id="kt_datatable2">
                        <thead>
                        <th></th>
                        <th>Weight%</th>
                        <th>Target</th>
                        <th>Achieved</th>
                        <th>Score</th>
                        <th>Comment</th>
                        </thead>
                        <tbody> 
                            <?php foreach ($core_headers as $key => $value) { ?>
                                <tr>
                                    <td colspan="5"><h4 class="text-success"><?= $value->core_name ?></h4></td>
                                </tr>
                                <?php
                                $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();
                                foreach ($sub as $key => $val) {

                                    $score_data = $this->db->query("SELECT * From kpi_score_data WHERE kpi_sub_id = '$val->id' and kpi_score_id = '$score->id'")->row();
                                    ?> 
                                    <tr>
                                        <td width='50%'><h6><?= $val->sub_name ?></h6></td>
                                        <td width='10%' class="weight"><?= $score_data->weight ?> % </td>
                                        <td width='15%'><?= $score_data->target .' '?><?=$val->target_type!='#'?$val->target_type:'' ?></td>
                                        <td width='15%'><?= $score_data->achieved .' '?><?=$val->target_type!='#'?$val->target_type:'' ?></td>
                                        <td width='10%' class="score"><?= number_format((float)$score_data->score, 2, '.', ''); ?> %</td>
                                        <td width='10%'><?= $score_data->comment?> </td>

                                    </tr>

                                <?php }
                            } ?>
                            <?php
                                $total_score = $this->db->query("SELECT sum(`score`)as total From kpi_score_data WHERE kpi_score_id = '$score->id'")->row();
                                ?>  
                                <tr  class="bg-<?=$this->hr_model->performanceMatrix((float)$total_score->total,$score->year)['color']?>" style="color:#FFF">                                                           
                                <td colspan="4"><h4 class='ml-5'>Total Score</h4></td>  
                                <td colspan="2" class="total_score"><h4 class="text-left"><?= number_format((float)$total_score->total, 2, '.', ''); ?>%</h4></td>
                            </tr>  
                        </tbody>

                    </table>
                    <!--end: Datatable-->               
                    <hr style='border-top-width: thick;margin: 30px 0;'>                    
                        <a href="<?= base_url() ?>performanceManagment/viewEmployeeincidentLog/<?=$employee_id."/".$month?>" class="btn btn-dark btn-sm text-white float-right mb-5" target="_blank">View Incidents Log</a>
                    <?php if($gab > 0){?>
                    <h3 class="text-danger">Gap Performance Analysis </h3>
                   <!--gab table-->
                    <table class="table table-head-custom table-checkable table-hover table-responsive" width='100%' id="kt_datatable2">
                        <thead>
                        <th>GAP Performance</th>
                        <th>Action</th>
                        <th>Due Date</th>
                        <th>Owners</th>
                        <th>Remarks</th>
                        </thead>
                        <tbody> 
                    <?php 
                    if(!empty($actions)){                         
                       foreach($actions as $k=>$action){ ?> 
                            <tr>
                                <td width='55%'><?=$this->hr_model->getSubCoreName($action->kpi_sub_id)?></td>
                                <td width='15%'><?=$action->action?></td>
                                <td width='10%'><?=$action->deadline?></td>
                                <td width='15%'><?=$action->owner?></td>
                                <td width='10%'><?=$action->comment?></td>
                            </tr>
                    <?php  }}else{
                        if($permission->edit == 1 && $this->hr_model->getEmpId($score->created_by) == $this->emp_id && $score->manager_approval == 1 && $score->status < 1){      ?>   
                            <form class="form" action="<?php echo base_url() ?>performanceManagment/saveKpiAction" method="post" enctype="multipart/form-data">
                           <input type="hidden" name="kpi_score_id"value="<?=$score->id?>">
                      <?php     $score_data = $this->db->query("SELECT * From kpi_score_data WHERE kpi_score_id = '$score->id'")->result();
                                foreach($score_data as $data){
                                //Average Performance 
                                if($this->hr_model->getScoreAveragePerformance($data->score,$data->weight,$score->year)){
                               ?>
                            <tr>
                                <td width="30%"><input type="hidden" name="kpi_sub_id[]"value="<?=$data->kpi_sub_id?>"><?=$this->hr_model->getSubCoreName($data->kpi_sub_id) .' <span class="text-success">Score('.number_format(((float)$data->score / (float)$data->weight )*100).'%)' ?></td>
                                <td><input type="text" name="action[]" class="form-control" required=""></td>
                                <td><input type="date" name="deadline[]" class="form-control" required=""></td>
                                <td><input type="text" name="owner[]" class="form-control"></td>
                                <td><textarea name="comment[]" class="form-control"></textarea></td>
                            </tr>
                            
                       <?php  } } ?>
                            <tr><td colspan="4">
                             <button class="btn btn-success mr-2" type="submit"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                <td></tr>                     
                            </form>
                   
                    <?php } }?>
                     </tbody>
                    </table>
                   <?php } else{ if($score->status == 0 && $score->manager_approval == 1 && $this->hr_model->getEmpId($score->created_by) == $this->emp_id){?>                     
                        <form class="form mb-10" id="action" action="<?php echo base_url() ?>performanceManagment/changeScoreStatus" method="get" enctype="multipart/form-data">
                        <input type="text" name="score" hidden="" value="<?= $score->id ?>">
                        <button class="btn btn-success mr-2"  type="submit"><i class="fa fa-save" aria-hidden="true"></i> Finish & Send To Employee</button>
                    </form> 
                    <?php }} ?>
                     <form class="form" id="kpiexport" action="<?php echo base_url() ?>performanceManagment/exportViewSingleKpiScore" method="get" enctype="multipart/form-data">
                         <input type="text" name="score_id" hidden="" value="<?= base64_encode($score->id)?>">
                        <button class="btn btn-success mr-2" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                    </form>
                </div>
            </div>
            <!--end::Card-->

        </div> 
    </div>  


