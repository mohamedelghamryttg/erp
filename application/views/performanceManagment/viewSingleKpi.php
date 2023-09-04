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
                        <h3 class="card-label"><a class="text-dark" href="<?php echo base_url() ?>performanceManagment/kpi/"> Employees KPIs </a><span class="font-size-h5-sm"><i class="fa fa-arrow-alt-circle-right"></i> <?= $this->hr_model->getTitle($kpi->employee_title) ?>  <span class="text-dark-50"><?=$kpi->active == 1 ? "( Actived )":"" ?></span></span> 
                            <?php if($kpi->active != 0){?>
                                <a  href="<?= base_url() .'performanceManagment/setKpiActive/'. $kpi->id ?>" class="btn btn-sm btn-dark mr-2" onclick="return confirm('Are You Sure?')"> <i class='la la-star'></i> Active This Kpi </a>
                            <?php }?>
                        </h3>
                        <h5 class="text-dark-50"><i class='fa fa-arrow-alt-circle-right'></i>  <?= !empty($kpi->title)?"$kpi->title":"Kpi Title : --" ?> 
                            <a href='#EditKpiTitle' data-toggle="modal" class='btn btn-sm btn-clean btn-icon'title="Edit Kpi Title">
                                <i class='la la-edit'></i>
                            </a>
                        </h5>
                    </div>
                   
                </div>
                <div class="card-body">
                    <a href='#addcore'data-toggle="modal"  title="Add Core">
                        <button class="btn btn-success mr-2"> <i class='la la-plus'></i> Add Core</button>
                    </a> 
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

                                            <a href='#core<?= $value->id ?>'data-toggle="modal" class='btn btn-sm btn-clean btn-icon'title="Edit">
                                                <i class='la la-edit'></i>
                                            </a>
                                            <a href='#addsub<?= $value->id ?>'data-toggle="modal" class='btn btn-sm btn-clean btn-icon' title="Add sub core">
                                                <i class='la la-plus'></i>
                                            </a> 
                                             <a  href="<?php echo base_url() ?>performanceManagment/deleteCore/<?= $value->id ?>" onclick="return confirm('Deleting Core and all Core Sub .... are you sure?')" class='btn btn-sm btn-clean btn-icon'title="Delete">
                                                <i class='la la-trash'></i>
                                            </a>
                                        </h4>
                                    </td>
                                    <?php foreach ($sub as $key => $val) { ?> 
                                    <tr>
                                        <td width='70%'><h5><?= $val->sub_name ?></h5></td>
                                        <td width='10%'><h5><?= $val->weight ?> % </h5></td>
                                        <td width='10%'><h5><?= $val->target .' '.$val->target_type ?></h5></td>
                                        <td width='20%'>
                                            <a href='#sub<?= $val->id ?>'data-toggle="modal" class='btn btn-sm btn-clean btn-icon'title="Edit">
                                                <i class='la la-edit'></i>
                                            </a> 
                                            <a data-id="<?= $val->id ?>" href="<?php echo base_url() ?>performanceManagment/deletesub/<?= $val->id ?>" onclick="return confirm('are you sure?')" class='btn btn-sm btn-clean btn-icon'title="Delete">
                                                <i class='la la-trash'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- start pop up form edit sub -->
                                <div aria-hidden="true" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1" id="sub<?php echo $val->id; ?>" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">                                               
                                                <h4 class="modal-title">Edit Sub</h4>
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal " action="<?php echo base_url() ?>performanceManagment/editSubCore" method="post" name="rejectApprovedRequest" enctype="multipart/form-data">
                                                        <input class="form-control" type="text" name="id" id="id" value="<?= $val->id ?>" hidden>
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label"> New Core Sub Name:</label>   
                                                            <div class="col-lg-6">
                                                                <input class="form-control" type="text" name="sub_name" id="sub_name" value="<?= $val->sub_name ?>" required="">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label "> New Weight:</label>   
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <input class="form-control" type="number" min="1" max="100" name="weight" id="weight" value="<?= $val->weight ?>" required="">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text" id="basic-addon2">%</span>
                                                                    </div>
                                                                </div>                                                               
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label "> New Target:</label>   
                                                            <div class="col-lg-6">
                                                                <div class="input-group">
                                                                    <input class="form-control" type='number' min='1' name="target" id="target" value="<?= $val->target ?>"required="">
                                                                   <div class="input-group-append">
                                                                       <div class="input-group-text" style="padding: 0px ">
                                                                           <select name="target_type" class="custom-select" >                                                                                
                                                                               <option value="%" <?= $val->target_type=='%'?'selected':'' ?>>%</option>
                                                                               <option value="#"<?= $val->target_type=='#'?'selected':'' ?> >Number #</option>
                                                                               <option value="$" <?= $val->target_type=='$'?'selected':'' ?>>Currency $</option>
                                                                           </select>
                                                                       </div>
                                                                   </div>
                                                               </div>                                                               
                                                            </div>
                                                        </div> 


                                                        <div class="form-group">
                                                            <div class="col-lg-offset-3 col-lg-6">
                                                                <button class="btn btn-success"name="save" type="submit">Submit</button> 
                                                                <button type="button" data-dismiss="modal" class="btn btn-default pull-right">Cancel</button>
                                                          
                                                            </div>
                                                        </div>
                                                </div>

                                                </form>  
                                            </div>
                                        </div>
                                    </div>
                                </div>                      
                                <!-- end  pop up form edit sub -->

                            <?php } ?>
                            </tr> 
                            <div aria-hidden="true" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1" id="addsub<?php echo $value->id; ?>" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">                                            
                                            <h4 class="modal-title">Add Sub</h4>
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form">
                                                <form class="cmxform form-horizontal " action="<?php echo base_url() ?>performanceManagment/addSubCore" method="post" name="rejectApprovedRequest" enctype="multipart/form-data">
                                                    <input class="form-control" type="text" name="kpi_core_id" id="id" value="<?= $value->id ?>" hidden>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label ">Core Sub Name:</label>   
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="text" name="sub_name" id="sub_name" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label ">Weight:</label>   
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <input class="form-control" type="number" min="1" max="100" name="weight" id="weight" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                                </div>
                                                            </div>                                                          
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label ">Target:</label>   
                                                        <div class="col-lg-6">
                                                              <div class="input-group">
                                                                    <input class='form-control' type='number' min='1' name='target'id="target" required=""> 
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text" style="padding: 0px ">
                                                                            <select name="target_type" class="custom-select"required >                                                                                
                                                                                <option value="%" selected="">%</option>
                                                                                <option value="#" >Number #</option>
                                                                                <option value="$" >Currency $</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-3 col-lg-6">
                                                            <button class="btn btn-success"name="save" type="submit">Submit</button> 
                                                             <button type="button" data-dismiss="modal" class="btn btn-default pull-right">Cancel</button>
                                                          
                                                        </div>
                                                    </div>
                                            </div>

                                            </form>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- start pop up form edit core -->
                            <div aria-hidden="true" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1" id="core<?php echo $value->id; ?>" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">                                            
                                            <h4 class="modal-title">Edit Core Name</h4>
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form">
                                                <form class="cmxform form-horizontal " action="<?php echo base_url() ?>performanceManagment/editCore" method="post" name="rejectApprovedRequest" enctype="multipart/form-data">

                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label"> Core Name:</label>   
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="text" name="id" id="id" value="<?= $value->id ?>" hidden>
                                                            <input class="form-control" type="text" name="core_name" id="core_name" value="<?= $value->core_name ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-3 col-lg-6">
                                                            <button class="btn btn-success"name="save" type="submit">Submit</button> 
                                                            <button type="button" data-dismiss="modal" class="btn btn-default pull-right">Cancel</button>
                                                          
                                                        </div>
                                                    </div>
                                            </div>

                                            </form>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div aria-hidden="true" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1" id="addcore" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">                                           
                                            <h4 class="modal-title">Add Core </h4>
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form">
                                                <form class="cmxform form-horizontal " action="<?php echo base_url() ?>performanceManagment/addCore" method="post" name="rejectApprovedRequest" enctype="multipart/form-data">

                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label "> Core Name:</label>   
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="text" name="kpi_id"  value="<?= $kpi->id ?>" hidden>
                                                            <input class="form-control" type="text" name="core_name" id="core_name" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-3 col-lg-6">
                                                            <button class="btn btn-success"name="save" type="submit">Submit</button> 
                                                             <button type="button" data-dismiss="modal" class="btn btn-default pull-right">Cancel</button>
                                                          
                                                        </div>
                                                    </div>
                                            </div>

                                            </form>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- end  pop up form edit core -->

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
                <!--end: Datatable-->
                <form class="form" id="kpiexport" action="<?php echo base_url() ?>performanceManagment/exportViewSingleKpi" method="get" enctype="multipart/form-data">
                    <input type="text" name="kpi_id" hidden="" value="<?= $kpi->id ?>">
                    <button class="btn btn-success mr-2" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                </form>


            </div>
        </div>
        <!--end::Card-->

    </div> 
</div>  
    <div aria-hidden="true" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1" id="EditKpiTitle" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">                                           
                    <h4 class="modal-title">Edit Kpi Title</h4>
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <form class="cmxform form-horizontal " action="<?= base_url() ?>performanceManagment/editKpiTitle" method="post" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label ">Kpi Title:</label>   
                                <div class="col-lg-6">
                                    <input class="form-control" type="text" name="kpi_id"  value="<?= $kpi->id ?>" hidden>
                                    <input class="form-control" type="text" name="title" id="title" value="<?=$kpi->title?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-success"name="save" type="submit">Submit</button> 
                                     <button type="button" data-dismiss="modal" class="btn btn-default pull-right">Cancel</button>

                                </div>
                            </div> 
                        </form> 
                    </div>                    
                </div>
            </div>
        </div>
    </div>


