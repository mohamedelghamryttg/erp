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
                <h3 class="card-title"><?=$card_title?></h3>
            </div>
            <!--begin::Form-->
            <?php if($edit == 0){
                $form_link = base_url()."profitShare/saveProfitShareSettings";
            }elseif($edit == 1){
                 $form_link = base_url()."profitShare/updateProfitShareSettings";
            }?>
            <form class="form" action="<?= $form_link ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <?php if($edit == 1){?>
                         <input type='hidden' name="id" value="<?= $id ?>" />
                   <?php }?>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right">Year <span class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <select name="year" class="form-control" id="year" required>
                                <option disabled="disabled" selected="selected" value="">-- Select Year --
                                </option>
                                <?= $this->accounting_model->selectYear($edit==1?$row->year:'') ?>
                            </select>
                        </div>

                    </div>
                    <hr />
                    <hr />
                    <table class="table text-center">
                        <thead>
                            <tr><th scope="col"> </th>   
                                <?php foreach($regions as $region){?>                                                             
                                <th scope="col"><?= $region->name ?></th>
                                <?php }?>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($brands as $val) {     
                                ?>
                            <tr class="targets">
                                    <th scope="row"><?= $val->name ?></th>
                                    <?php  foreach($regions as $region){ 
                                          if($edit == 1){
                                                $value = $this->profitShare_model->getBrandRegionTarget($row->year,$val->id,$region->id);
                                              }
                                              
                                            ?>
                                    <td><input type="number" name="target_<?= $val->id ?>_<?= $region->id ?>" class="form-control form-control-sm target" placeholder="<?= $val->abbreviations.' '.$region->abbreviations ?> Target" min="0"  required value="<?=$edit==1?$value :''?>" onChange="getTotal();"/></td>
                                    <?php }
                                    ?> 
                                    <td><input  class="form-control form-control-sm total" disabled /></td>
                                
                                </tr>
                            <?php } ?>
                           
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-success btn-sm mr-2">Submit</button>
                            <a class="btn btn-secondary btn-sm" href="<?php echo base_url() ?>profitShare/settings" class="btn btn-default" type="button">Cancel</a>
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
    $(document).ready(function(){
        getTotal();
    });
    function getTotal(){
        $('tr.targets').each(function () {
            var total = 0 ;
            $(this).find('input.target').each(function () {
                if($(this).val())                
                    total += parseFloat($(this).val());
            });
             $(this).find('.total').val(total.toLocaleString());
        });       
    }
</script>