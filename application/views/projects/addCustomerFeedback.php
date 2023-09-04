<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:"#content" });</script>
<script>tinymce.init({ selector:"#feedback" });</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add Feedback
			</header>
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>projects/doAddCustomerFeedback" method="post" enctype="multipart/form-data">
                 <div class="form-group">
                   <label class="col-lg-3 control-label" for="Feedback"  required="">Customer Email</label>
                      <div class="col-lg-6" >
                            <textarea name="emails"style="width: 700px"></textarea>
                      </div>
                </div>
                 <div class="form-group">
                     <label class="col-lg-3 control-label" for="Feedback"  required="">Feedback</label>
                      <div class="col-lg-6">
                            <textarea name="feedback" id="content"></textarea>
                      </div>
               
                </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>projects/customerFeedback.php" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    