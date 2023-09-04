<script>tinymce.init({selector: 'textarea'});</script>  
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
                        <h3 class="card-label"><a class="text-dark" href="<?php echo base_url() ?>performanceManagment/kpi/"> Employees KPIs </a><span class="font-size-h5-sm"><i class="fa fa-arrow-alt-circle-right"></i> <?= $this->hr_model->getTitle($kpi->employee_title); ?> <i class="fa fa-arrow-alt-circle-right"></i> Kpi Design</span></h3>
                    </div>

                </div>
                <div class="card-body">
                 <!--form-->                  
                 <form action="<?php echo base_url() ?>performanceManagment/doAddKpi"class="form" method="post"  enctype="multipart/form-data">
                     <input type="hidden" value="<?=$kpi->id?>" name="kpi_id"/>
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
                            <?= $this->hr_model->selectAllEmployeesByTitle('none',$kpi->employee_title); ?>  
                            <?php }else{?>
                            <?= $this->hr_model->selectAllEmployeesByTitleSelf($emp_id,$kpi->employee_title); ?>
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
                      <input type="submit" class="btn btn-primary" value="Save"/>  
                 </form>
                    <!--begin: Datatable-->
                    <table class="table table-head-custom table-checkable table-hover table-responsive" width='100%' id="kt_datatable2">
                        <thead>
                        <th></th>
                        <th>weight</th>
                        <th>target</th>
                        <th></th>
                        </thead>
                        <tbody> 
                            <?php
                            foreach ($core_headers as $key => $value) {
                                $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();
                                ?>
                                <tr>
                                    <td colspan="4"><h4 class="text-danger"><?= $value->core_name ?>
                                        </h4>
                                    </td>
                                    <?php foreach ($sub as $key => $val) { ?> 
                                    <tr>
                                        <td width='70%'><h5><?= $val->sub_name ?></h5></td>
                                        <td><h5><?= $val->weight ?> % </h5></td>
                                        <td><h5><?= $val->target .' '.$val->target_type ?></h5></td>                                        
                                    </tr>                                

                            <?php } ?>
                            </tr>     
                <?php } ?>
                <tr  class="bg-danger-o-10">
                    <?php
                    $total_weight = $this->db->query("SELECT sum(`weight`)as total From kpi_sub WHERE kpi_core_id IN (SELECT id From kpi_core WHERE kpi_id = '$kpi->id')")->row();
                    ?> 
                    <td><h4 class="text-danger">Total Weight</h4></td>
                    <td class="total_weight"><h4><?= $total_weight->total ?>%</h4></td>
                    <td colspan="2"></td>

                </tr> 
                </tbody>

                </table>
              

            </div>
        </div>
        <!--end::Card-->

    </div>  
</div>  





