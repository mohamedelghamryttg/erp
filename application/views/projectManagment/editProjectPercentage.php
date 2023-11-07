<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Project</h3>
                
            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url()?>projectManagment/doEditProjectPercentage" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="text" name="project_id" value="<?=base64_encode($id)?>" hidden>                           

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Project Name/Email subject</label>
                            <div class="col-lg-6">
                              <input type="text" class=" form-control"  value="<?=$row->name?>"  disabled>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Client</label>
                            <div class="col-lg-6">
                              <input type="text" class=" form-control"  value="<?= $this->customer_model->getCustomer($row->customer); ?>"  disabled>
                                </div>
                            </div>                      

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Product Lines</label>
                            <div class="col-lg-6">
                                <select  class="form-control m-b"  disabled />
                                             <option  disabled="disabled" selected="selected">-- Select Product Line --</option>
                                             <?=$this->customer_model->selectProductLineByCustomer($row->lead,$row->product_line)?>
                                    </select>  
                        </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Min. Profit Percentage</label>
                            <div class="col-lg-6">
                              <input type="number" class=" form-control" name="min_profit_percentage" value="<?=$row->min_profit_percentage?>" step=".01"  min="0" required>
                                </div>
                            </div>    
                    <br/>
                    <br/>
                 </div>
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>projects" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>