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
            <form class="form" action="<?= base_url().'profitShare/updateProfitAchieved'?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <?php if($edit == 1){?>
                         <input type='hidden' name="id" value="<?= $id ?>" />
                   <?php }?>
                    <p class="font-weight-bolder font-size-lg"> <i class="flaticon-calendar-2 mr-2 text-danger"></i>Year : <?=$row->year?>
                    </p>  
                    <hr />
                    <hr />
                    <?php for($i=1;$i<=2;$i++){?>
                    <table class="table text-center table-bordered mb-10">
                        <thead>
                              <thead>
                            <tr>
                                <th colspan="5" class="font-weight-bolder text-danger bg-gray-200"> H <?=$i?> ( <?=$i==1?"Jan : Jun":" Jul : Dec"?> )</th>   
                            </tr>
                        </thead>
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
                                                $value = $this->profitShare_model->getBrandRegionAchieved($row->year,$val->id,$region->id,$i);
                                              }
                                              
                                            ?>
                                    <td><input type="number" name="acheived_<?= $val->id ?>_<?= $region->id ?>[<?=$i?>]" class="form-control form-control-sm target" placeholder="<?= $val->abbreviations.' '.$region->abbreviations ?> Target" min="0"  required value="<?=$edit==1?$value :''?>" onChange="getTotal();"/></td>
                                    <?php }
                                    ?> 
                                    <td><input  class="form-control form-control-sm total" disabled /></td>
                                
                                </tr>
                            <?php } ?>
                           
                        </tbody>
                    </table>
                     <hr />
                    <hr />
                     <?php } ?>
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