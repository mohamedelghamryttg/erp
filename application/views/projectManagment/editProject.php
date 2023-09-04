<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Save Project 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projectManagment/doEditProject" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?=base64_encode($id)?>" hidden>
                             <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                             <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                             <?php }else{ ?>
                             <input type="text" name="referer" value="<?=base_url()?>projectManagment" hidden>
                             <?php } ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="project name">Project Name/Email subject</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="name" id="name" value="<?=$row->name?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer"  onchange="getCustomerData()" required />
                                             <option value="" selected="selected" disabled="">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerByPm($row->customer,$pm,$permission,$this->brand)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name"></label>
                                <div class="col-lg-6" id="LeadData">
                                <?=$this->customer_model->leadDataPm($row->lead,$row->customer,$pm)?>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Product Lines">Product Lines</label>

                                <div class="col-lg-6">
                                    <select name="product_line" class="form-control m-b" id="product_line" onchange="getPriceList()" required />
                                             <option  disabled="disabled" selected="selected">-- Select Product Line --</option>
                                             <?=$this->customer_model->selectProductLineByCustomer($row->lead,$row->product_line)?>
                                    </select>
                                </div>
                            </div>
                             <?php if($this->brand == 1){?>
                              <div class="form-group">
                                  <label class="col-lg-3 control-label">TTG Branch Name</label>

                                  <div class="col-lg-6">
                                      <select name="branch_name" class="form-control m-b"  />
                                              <option disabled="disabled" selected="selected">-- Select Branch Name --</option>
                                               <?=$this->projects_model->selectTTGBranchName($row->branch_name)?>
                                      </select>
                                  </div>
                              </div>
                            <?php }?>
                        </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>projectManagment" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>