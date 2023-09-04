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
            <form class="form"action="<?php echo base_url()?>projects/doEditProject" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="text" name="id" value="<?=base64_encode($id)?>" hidden>
                             <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                             <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                             <?php }else{ ?>
                             <input type="text" name="referer" value="<?=base_url()?>projects" hidden>
                             <?php } ?>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Project Name/Email subject</label>
                            <div class="col-lg-6">
                              <input type="text" class=" form-control" name="name" id="name" value="<?=$row->name?>" required>
                                </div>
                            </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-6" id="LeadData">
                                 <?=$this->customer_model->leadDataPm($row->lead,$row->customer,$pm)?>
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right">Product Lines</label>
                            <div class="col-lg-6" id="email">
                                <select name="product_line" class="form-control m-b" id="product_line" onchange="getPriceList()" required />
                                             <option  disabled="disabled" selected="selected">-- Select Product Line --</option>
                                             <?=$this->customer_model->selectProductLineByCustomer($row->lead,$row->product_line)?>
                                    </select>
                        </div>

                    </div>

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