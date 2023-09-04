<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Handover
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doEditHandoverResource"  method="post" enctype="multipart/form-data">
                        <input type="text" name="id" value="<?=base64_encode($id)?>" hidden>
                             <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                             <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                             <?php }else{ ?>
                             <input type="text" name="referer" value="<?=base_url()?>projects/handover" hidden>
                             <?php } ?>
                           
                             <div class='form-group'>
                                                <label class='col-lg-3 control-label'>Type</label>
                                                <div class='col-lg-6'>
                                                    <select name='type' id='type'class='form-control m-b' value="" required="">
                                                        <option value="" disabled='' selected=''>-- Select --</option>
                                                    <?php if($row->type == 1 ){ ?>
                                                        <option  value='1' selected="">Translator</option>
                                                        <option  value='2'>Reviewer</option>
                                                        <option  value='3'>Proofreader</option>
                                                     <?php } if($row->type == 2 ){ ?>
                                                        <option  value='2' selected="">Reviewer</option>
                                                        <option  value='1' >Translator</option>
                                                        <option  value='3'>Proofreader</option>

                                                     <?php } if($row->type == 3 ){?>
                                                        <option  value='3' selected="">Proofreader</option>
                                                        <option  value='1'>Translator</option>
                                                        <option  value='2'>Reviewer</option>
                                                     <?php } ?>

                                                    </select>
                                                </div>
                                            </div> 
                
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="name" value="<?= $row->name?>" required>

                                </div>
                            </div> 
                           <div class="form-group">
                              <label class="control-label col-md-3">Delivery Date</label>
                              <div class="col-md-6">
                                  <input size="16" type="text" value="<?= $row->delevery_date?>" autocomplete="off" class="form_datetime form-control" name="delevery_date" id="delevery_date" required="">
                              </div>
                           </div> 
                            

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>projects/handOver" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div> 
