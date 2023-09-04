<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!-- start search form card --> 
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title text-danger"> Send Ticket </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">                              
                                <div class="panel-body">
                                    <div class="form">
                                        <form class="cmxform form-horizontal " action="<?php echo base_url() ?>automation/saveTicket" method="post" enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-lg-3 control-label" for="comment">Ticket Subject</label>
                                                <div class="col-lg-6">
                                                    <input type='text' name="subject" class="form-control" />
                                                </div>
                                            </div>
                                            
                                             <div class="form-group row">
                                                <label class="col-lg-3 control-label" for="comment">Ticket Description</label>
                                                <div class="col-lg-6">
                                                    <textarea name="description" class="form-control" rows="6"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 control-label" for="role File Attachment">File Attachment</label>
                                                <div class="col-lg-6">
                                                    <input type="file" class=" form-control" name="file" id="file" >
                                                </div>
                                            </div>

                                           
                                            <div class="form-group row">
                                                <div class="col-lg-3"></div>
                                                <div class="col-lg-6">
                                                    <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i>Send</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script> 

       tinymce.init({ selector:'textarea' });
 </script>
