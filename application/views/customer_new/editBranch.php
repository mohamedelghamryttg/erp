<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Branch</h3>
                
            </div>
            <!--begin::Form-->
            <form class="cmxform form-horizontal " action="<?php echo base_url()?>customer/doEditBranch/<?=$branch->id?>" method="post" enctype="multipart/form-data">
                <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                   <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                   <?php }else{ ?>
                   <input type="text" name="referer" value="<?=base_url()?>projects" hidden>
                   <?php } ?>
                <div class="card-body">

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Customer</label>
                            <div class="col-lg-6">
                                <select name="customer" class="form-control m-b" id="customer" required />
                                             <option value="" disabled="disabled" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerExisting($branch->customer,$brand)?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Region</label>
                            <div class="col-lg-6">
                                <select name="region" class="form-control m-b" id="region" onchange="getCountries()" required />
                                             <option value="" disabled="disabled" selected="selected">-- Select Region --</option>
                                             <?=$this->admin_model->selectRegion($branch->region)?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Country</label>
                            <div class="col-lg-6">
                                  <select name="country" class="form-control m-b" id="country" required />
                                             <option value="" disabled="disabled" selected="selected">-- Select Country --</option>
                                             <?=$this->admin_model->selectCountries($branch->country,$branch->region)?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Type</label>
                            <div class="col-lg-6">
                                  <select name="type" class="form-control m-b" id="type" required />
                                             <option value="" disabled="disabled" selected="selected">-- Select Type --</option>
                                             <?=$this->customer_model->selectType($branch->type)?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Source</label>
                            <div class="col-lg-6">
                                <select name="source" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected">-- Select Source --</option>
                                             <?=$this->customer_model->selectSource($branch->source)?>
                                    </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Comment</label>
                            <div class="col-lg-6">
                                <textarea name="comment" class="form-control" rows="6"><?=$branch->comment?></textarea>
                            </div>
                        </div>
                        
                    </div>
                    
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url()?>customer/customerBranch" class="btn btn-default" type="button">Cancel</a>
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
        function getCountries(){
            var region = $("#region").val();
            // alert(region);
            $.post("<?=base_url()?>customer/getCountries", {region:region} , function(data){
            // alert(data);
            $("#country").html(data);
            });
        }
    </script>