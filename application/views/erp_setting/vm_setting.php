<script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<!--begin::Container-->
<div class="container-fluid pt-10">
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
    <div class="card card-custom example example-compact" style="align-items: center;">
        <div class="card-header center">
            <h3 class="card-title">Vendor Management Settings</h3>
        </div>
    </div>
    <form class="cmxform form-horizontal" method="post" enctype="multipart/form-data" id="config_form" action="<?php echo base_url() ?>settings/saveVmConfig" onsubmit="return disableAddButton();">
        <div class="card-body">
            <input type="hidden" class="form-control" name="id" id="id" value="<?= $vmConfig->id;
                                                                                ?>">
            <div class="row">

                <!-- Tab navs -->
                <div class="col-md-2 mb-2">
                    <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="vosettings-tab" data-toggle="tab" href="#vosettings" role="tab" aria-controls="vosettings" aria-selected="true">Vendor Offer Settings</a>
                        </li>
                       
                    </ul>
                </div>
                <!-- Tab navs -->

                <div class="col-md-10 mb-10">
                    <!-- Tab content -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active " id="vosettings" role="tabpanel" aria-labelledby="vosettings-tab">
                            <div class="card">
                                <div class="card-header" style="padding-bottom: 0px !important;">
                                    <h3 class="card-title text-center">Vendor Offer Settings </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label  col-sm-12">Email for Unaccepted Offers Notification </label>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" class="form-control" name="unaccepted_offers_email" id="unaccepted_offers_email" value="<?= $vmConfig->unaccepted_offers_email;
                                                                                                                        ?>">
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="col-md-4 col-form-label  col-sm-12">Time to check vendor acceptance offers / hour </label>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="number" class="form-control" name="acceptance_offers_hours" id="acceptance_offers_hours" value="<?= $vmConfig->acceptance_offers_hours;?>" step=".5"  min="0">
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <div class="text-center">
                        <button type="text" class="btn btn-success mr-2" id="submit">Submit</button>
                        <a class="btn btn-secondary" href="<?php echo base_url() ?>admin" type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
