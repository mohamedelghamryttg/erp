<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
    .loan_view_select.readonly > .select2-container--default .select2-selection--single{
        background-color: #F3F6F9!important;
    }
    .loan_view_select.readonly > *{
        pointer-events:none;
        
    }    
    </style>
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
                                            <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Edit Record # <?=$row->id?></span>

                                    </div>
                                    <!--end::Search Form-->

                            </div>
                            <!--end::Details-->

                    </div>
            </div>
    <!--end::Subheader-->
        <div class="card card-custom example example-compact">          
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>payroll/updatePayroll/<?=$row->id?>" method="post"  enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Select Employee Name:</label>
                        <div class="col-lg-6">
                            <select name="emp_id" class="form-control"  required="" >
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->selectEmployee($row->emp_id); ?> 
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Action:</label>
                        <div class="col-lg-6">
                            <select name="action" class="form-control"  required="" id="action" onchange="CheckLoan();">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->selectPayrollActions($row->action); ?> 
                            </select>
                        </div>
                    </div> 
                   <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Reflect on Payroll :</label>
                        <div class="col-lg-6"> 
                                <select name="start_month" id="start_month"  class="form-control col-lg-6"  required="" onchange="CalLoan();" >                               
                                    <?= $this->accounting_model->selectMonth(date("m",strtotime($row->start_date))); ?> 
                                </select>                              
                                <select name="start_year" id="start_year" class="form-control col-lg-4"  required="" onchange="CalLoan();">                               
                                    <?= $this->accounting_model->selectYear(date('Y',strtotime($row->start_date))); ?> 
                                </select>
                        </div>
                    </div>  
                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Amount :</label>
                        <div class="col-lg-6">
                            <input type="number" name="amount" id="amount" class="form-control" required="" min="0" step="0.1" value="<?=$row->amount?>" onchange="CalLoan();">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Unit :</label>
                        <div class="col-lg-6">
                            <select name="unit" class="form-control"  required="" id="unit">
                                <option value="" disabled='' selected=''>-- Select --</option>
                                <?= $this->hr_model->selectPayrollUnits($row->unit); ?> 
                            </select>
                        </div>
                    </div> 
                      <div class="separator separator-dashed my-10"></div>
                     <div class="form-group row loan_group" style="display: none">
                        <label class="col-lg-3 col-form-label text-right">Num. Of Months<span class="text-danger">*</span> :</label>
                        <div class="col-lg-6">
                            <input type="number" name="num_month" id="num_month" class="form-control" min="1" step="1" value="<?=$row->num_month?>" onchange="CalLoan();">
                        </div>
                    </div> 
                     <div class="form-group row loan_group" style="display: none">
                        <label class="col-lg-3 col-form-label text-right">Monthly Installment :</label>
                        <div class="col-lg-6">
                            <input type="number" name="monthly_installment"id="monthly_installment" class="form-control form-control-solid loan_view"value="<?=$row->monthly_installment?>"  min="0" step="0.1" readonly="">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Recurrence  :</label>
                        <div class="col-lg-6 loan_view_select">
                            <select name="recurrence" class="form-control loan_view"  required="" id='recurrence' onchange="RecurrenceTill();">                                
                               <option value="0" <?=$row->recurrence==0?"selected":""?>>NO</option>
                               <option value="1" <?=$row->recurrence==1?"selected":""?>>YES</option>                               
                            </select>
                        </div>
                    </div>                   
                    <div class="form-group row end_date" style="<?=$row->recurrence==0?'display: none':''?>">
                        <label class="col-lg-3 col-form-label text-right">Till :</label>
                        <div class="col-lg-6 loan_view_select"> 
                                <select name="end_month" id="end_month" class="form-control col-lg-6 loan_view"   >                               
                                    <?= $this->accounting_model->selectMonth(date('m',strtotime($row->end_date))); ?> 
                                </select>                              
                                <select name="end_year" id="end_year" class="form-control col-lg-4 loan_view"  >                               
                                    <?= $this->accounting_model->selectYear(date('Y',strtotime($row->end_date))); ?> 
                                </select>
                            
                        </div>
                    </div> 
                     <div class="form-group row ">
                        <label class="col-lg-3 col-form-label text-right">Comment :</label>
                        <div class="col-lg-6"> 
                            <textarea class="form-control" name="comment" id="comment"><?=$row->comment?></textarea>                            
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
    CheckLoan();
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
    // loan
    function CheckLoan() {
       var loan =  $("#action").find(":selected").val(); 
        if(loan == 2 ){          
            $(".loan_group").show(); 
            $("#num_month").prop('required',true);
            $(".loan_view_select").addClass("readonly");           
            $(".loan_view").addClass('form-control-solid'); 
            $(".loan_view").prop("readonly", true);
            CalLoan();
        }else{
            $(".loan_group").hide(); 
            $("#num_month").prop('required',false); 
            $(".loan_view_select").removeClass("readonly");
            $(".loan_view").removeClass('form-control-solid');
            $(".loan_view").prop("readonly", false);            
        }
    }
    
    function CalLoan() {
        var loan =  $("#action").find(":selected").val();  
        var num_month =  parseInt($("#num_month").val()); 
        var amount =  $("#amount").val();        
        if(loan == 2 && num_month >=1){  
            var monthly_installment = amount/num_month;
            $("#monthly_installment").val(monthly_installment);
            if(num_month > 1){
                $("#recurrence").val(1).trigger('change');
                var startMonth =  parseInt($("#start_month").find(":selected").val()); 
                var startYear =  parseInt($("#start_year").find(":selected").val()); 
                var sumMonths = startMonth + num_month -1;
                var result1 = sumMonths%12;
                var result2 = parseInt(sumMonths/12);
                var endMonth = (result1 < 9 ? "0" : "") + result1;
                var endYear = startYear + result2;
                $("#end_month").val(endMonth).trigger('change');
                $("#end_year").val(endYear).trigger('change');          
//                  const startDate = new Date(startYear, startMonth, 1);                
//                  const result = addMonths(startDate, num_month);                
              
            }else{
                $("#recurrence").val(0).trigger('change');
            }
           $("#comment").text("total loan "+amount+" , will deduct on "+ num_month+" months.");  
        }
    }
    
    function addMonths(date, months) {
       date.setMonth(date.getMonth() + months);
        return date;
      }
    
</script>
 