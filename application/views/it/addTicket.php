<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
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
                    <h3 class="card-title text-danger"> Send IT Ticket </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">                              
                                <div class="panel-body">
                                    <div class="form">
                                        <form class="cmxform form-horizontal " action="<?php echo base_url() ?>it/saveTicket" method="post" enctype="multipart/form-data">
                                            
                                            <div class="form-group row">                                                 
                                                <label class="col-lg-3 control-label" for="comment">cc Email </label>
                                                <div class="col-lg-6 cc_div">
                                                    <div id="cc_input">
                                                        <input type="email" name="cc_email[]" class="form-control mt-2 cc_email" placeholder="CC Email" style="display: inline-block;max-width: 90%;" />                                                        
                                                    </div>
                                                </div>
                                                <button type="button" id="add_cc" class="btn btn-sm btn-primary mt-2" style="max-height: 35px"><i class="fa fa-plus-circle"></i>Add CC</button>
                                                                                           
                                            </div>
                                             <div class="form-group row">
                                                <label class="col-lg-3 control-label" for="comment">Subject</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="subject" class="form-control" required/>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group row">
                                                <label class="col-lg-3 control-label" for="comment">Body</label>
                                                <div class="col-lg-6">
                                                    <textarea name="body" class="form-control" rows="6"></textarea>
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
    <div id="cancel_div" style="display: none;">
        <button type="button" class="remove_cc btn btn-sm btn-light-dark" style="max-width: 32px;"><i class="fa fa-times"></i></button>
    </div>
</div>
<script> 
     
    $(document).on('click', '#add_cc', function () {
        
        var val = $("#cc_input").html();       
        var cancel = $("#cancel_div").html();
        $(".cc_div").append(val);      
        $(".cc_div").append(cancel);      
        
    });
    $(document).on('click', '.remove_cc', function () {
        
        $(this).prev( ".cc_email" ).remove();       
        $(this).remove();       
      
    });
   
   // tinymce.init({ selector:'textarea' });
    
 </script>
