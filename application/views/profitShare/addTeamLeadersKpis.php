<div class="d-flex flex-column-fluid mt-2">
    <!--begin::Container-->
    <div class="container">
        <?php if ($this->session->flashdata('true')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong>
                        <?= $this->session->flashdata('true') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="fa fa-warning"></span>
                <span><strong>
                        <?= $this->session->flashdata('error') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title"><i class='flaticon2-pen mr-2 text-danger'></i> Team Leaders Kpis</h3>
            </div>
            <!--begin::Form-->          
            <form class="form" action="<?= base_url().'profitShare/updateTeamLeadersKpis'?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <input type='hidden' name="target_id" value="<?= $id ?>" />
                    <table class="table table-head-custom table-bordered " width="100%" id="kt_datatable2">
                        <thead>
                            <tr>
                                <th colspan="4"><i class="flaticon-calendar-2 mr-2 text-danger"></i>Year : <?=$row->year?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($employees as $k => $emp){
                                ?>
                            <tr class="<?=$k%2==0?' bg-light-o-70':''?>">                              
                                <td rowspan='3' >
                                    <p class="font-weight-bolder">                                        
                                        <?= ++$k?>
                                    </p>
                                </td>
                                <td rowspan='3'>
                                    <p class="font-weight-bolder text-uppercase">
                                        <input type="hidden" name="emp_id[]" value="<?= $emp->id ?>" />
                                        <?= $this->automation_model->getEmpName($emp->id); ?>
                                    </p>
                                </td>                              
                               
                            </tr>
                            <?php for($i=1;$i<=2;$i++){
                                $score = $this->profitShare_model->getTeamLeaderperformance($emp->id,$i,$row->year)['score_val'];?>
                            <tr class="<?=($k+1)%2==0?' bg-light-o-70':''?>">                                
                                <td >H<?=$i?></td>
                                <td >
                                    <div class="radio-inline">
                                        <?php foreach($performanceMatrixArray as $x =>$y){?>
                                       <label class="radio radio-square mr-7">
                                            <input type="radio" name="score<?=$i?>_<?=$emp->id?>" value="<?=$x?>" <?=(isset($score)&&$score==$x)?'checked':''?>/>
                                            <span></span>
                                           <?= $y?>
                                        </label>
                                        <?php }?>
                                    </div>
                                </td>
                            </tr>
                            <?php }
                            }?>
                          
                         
                            

                        </tbody>
                    </table>
                    
                    <hr />
                    <hr />
                 
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-success btn-sm mr-2">Submit</button>
                            <a class="btn btn-secondary btn-sm" href="<?php echo base_url() ?>profitShare/Settings" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<script>
 
</script>