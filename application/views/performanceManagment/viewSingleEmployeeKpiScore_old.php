<script>tinymce.init({selector: 'textarea'});</script>  
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
                        <h3 class="card-label">Employees KPIs <i class="fa fa-arrow-alt-circle-right"></i> <?= $this->accounting_model->getMonth($month); ?> <i class="fa fa-arrow-alt-circle-right"></i> View Kpi Score</h3>
                    </div>

                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover table-responsive" id="kt_datatable2">
                        <thead>
                        <th></th>
                        <th>Weight</th>
                        <th>Target</th>
                        <th>Achieved</th>
                        <th>Score</th>
                        </thead>
                        <tbody> 
                            <?php foreach ($core_headers as $key => $value) { ?>
                                <tr>
                                    <td colspan="5"><h4 class="text-danger"><?= $value->core_name ?></h4></td>
                                </tr>
                                <?php
                                $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();
                                foreach ($sub as $key => $val) {

                                    $score_data = $this->db->query("SELECT * From kpi_score_data WHERE kpi_sub_id = '$val->id' and kpi_score_id = '$score->id'")->row();
                                    ?> 
                                    <tr>
                                        <td><h6><?= $val->sub_name ?></h6></td>
                                        <td class="weight"><?= $val->weight ?> % </td>
                                        <td><?= $val->target ?></td>
                                        <td><?= $score_data->achieved ? $score_data->achieved : '-' ?></td>
                                        <td class="score"><?= $score_data->score ?: '-' ?></td>

                                    </tr>

                                <?php }
                            }
                            ?>
                            <tr  class="bg-danger-o-10">
                                <?php
                                $total_weight = $this->db->query("SELECT sum(`weight`)as total From kpi_score_data WHERE kpi_score_id = '$score->id'")->row();
                                $total_score = $this->db->query("SELECT sum(`score`)as total From kpi_score_data WHERE kpi_score_id = '$score->id'")->row();
                                ?> 
                                <td><h4>Total Weight</h4></td>
                                <td class="total_weight"><h4><?= $total_weight->total ?></h4></td>
                                <td><h4>Total Score</h4></td>                                
                                <td class="total_score"><h4><?= number_format((float) $total_score->total, 2, '.', ''); ?></h4></td>
                            </tr>  
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                    <?php if(empty($action)|| $action->status == 3 ){?>
                    <form class="form mt-10" style="display:inline-block" id="action" action="<?php echo base_url() ?>performanceManagment/changeScoreStatus" method="get" enctype="multipart/form-data">
                        <input type="text" name="score" hidden="" value="<?= $score->id ?>">
                        <button class="btn btn-success mr-2" name="accept" type="submit"><i class="fa fa-check-double" aria-hidden="true"></i> Accept</button>
                    </form>
                    <button class="btn btn-danger mr-2" name="rejected" data-toggle="modal" href='#reject'><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
                        <!-- start pop up form -->
                        <div aria-hidden="true" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1" id="reject" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Reject Reason</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form">
                                             <form class="form-inline"  action="<?php echo base_url() ?>performanceManagment/changeScoreStatus" method="get" enctype="multipart/form-data">
                                                <input type="text" name="score" hidden="" value="<?= $score->id ?>">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label text-right"> Comment:</label>   
                                                <div class="col-lg-6">
                                                    <textarea class="form-control" name="comment" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-lg-6">
                                                    <button class="btn btn-success"name="save" type="submit">Submit</button> 
                                                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                             </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                                <!-- end  pop up form  -->
                    
                    <?php }else{
                         $status = $this->db->get_where('kpi_actions', array('kpi_score_id' => $score->id))->row();?>
                                <table class="table table-separate table-head-custom table-checkable table-hover" >
                                    <tbody> 
                                        <tr><td>Status :</td><td><?=$this->hr_model->getScoreStatus($score->id); ?></td></tr>
                                        <tr><td>Comment :</td><td><?= $status->comment ?></td></tr>
                                    </tbody> 
                                </table>
                    <?php }?>
                                
                         <form class="form mt-10" id="kpiexport" action="<?php echo base_url() ?>performanceManagment/exportViewSingleKpiScore" method="get" enctype="multipart/form-data">
                        <input type="text" name="score_id" hidden="" value="<?=$score->id?>">
                        <button class="btn btn-success mr-2" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                    </form>
                </div>
            </div>
            <!--end::Card-->

        </div> 
    </div>  



