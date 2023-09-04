<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
        	<!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Details-->
                    <div class="d-flex align-items-center flex-wrap mr-2">
                            <!--begin::Title-->
                            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Payroll</h5>
                            <!--end::Title-->
                            <!--begin::Separator-->
                            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Search Form-->
                            <div class="d-flex align-items-center" id="kt_subheader_search">
                                    <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Add New Record</span>
                                 
                            </div>
                            <!--end::Search Form-->
                           
                    </div>
                    <!--end::Details-->
                  
            </div>
    </div>
    <!--end::Subheader-->
       
        <div class="card card-custom example example-compact">           
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>payroll/savePayroll" method="post"  enctype="multipart/form-data">
                <div class="card-body pt-15">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Select Employee Name:</label>
                        <div class="col-lg-6">
                            <select name="emp_id" class="form-control"  required="" >
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->selectEmployee(); ?> 
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Action:</label>
                        <div class="col-lg-6">
                            <select name="action" class="form-control"  required="" >
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->selectPayrollActions(); ?> 
                            </select>
                        </div>
                    </div> 
                   <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Reflect on Payroll :</label>
                        <div class="col-lg-6"> 
                                <select name="start_month" class="form-control col-lg-6"  required="" >                               
                                    <?= $this->accounting_model->selectMonth(date('m')); ?> 
                                </select>                              
                                <select name="start_year" class="form-control col-lg-4"  required="" >                               
                                    <?= $this->accounting_model->selectYear(date('Y')); ?> 
                                </select>
                        </div>
                    </div>  
                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Amount :</label>
                        <div class="col-lg-6">
                            <input type="number" name="amount" class="form-control" required="" min="0" step="0.1">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Unit :</label>
                        <div class="col-lg-6">
                            <select name="unit" class="form-control"  required="" >
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->selectPayrollUnits(); ?> 
                            </select>
                        </div>
                    </div>    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Recurrence  :</label>
                        <div class="col-lg-6">
                            <select name="recurrence" class="form-control"  required="" id='recurrence' onchange="RecurrenceTill();">                                
                               <option value="0">NO</option>
                               <option value="1">YES</option>                               
                            </select>
                        </div>
                    </div>   
                    <div class="form-group row end_date" style="display: none">
                        <label class="col-lg-3 col-form-label text-right">Till :</label>
                        <div class="col-lg-6"> 
                                <select name="end_month" class="form-control col-lg-6"   >                               
                                    <?= $this->accounting_model->selectMonth(date('m')+1); ?> 
                                </select>                              
                                <select name="end_year" class="form-control col-lg-4"  >                               
                                    <?= $this->accounting_model->selectYear(date('Y')); ?> 
                                </select>
                            
                        </div>
                    </div> 
                    <div class="form-group row ">
                        <label class="col-lg-3 col-form-label text-right">Comment :</label>
                        <div class="col-lg-6"> 
                            <textarea class="form-control" name="comment"></textarea>                            
                        </div>
                    </div> 
                </div>  
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary"  href="<?php echo base_url()?>payroll"  type="button">Cancel</a>
                            
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
    function RecurrenceTill() {
       var recurrence =  $("#recurrence").find(":selected").val();       
        if(recurrence == 1){
            $(".end_date").show(); 
            $(".end_date select").prop('required',true); 
        }else{
            $(".end_date").hide(); 
            $(".end_date select").prop('required',false); 
        }
    }
    
</script>
 