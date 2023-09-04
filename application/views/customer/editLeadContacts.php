<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Customer Contacts 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " id="commentForm" action="<?php echo base_url()?>customer/doEditLeadContacts?t=<?=base64_encode($id)?>" method="post" enctype="multipart/form-data">
                      		<input type="text" name="lead" value="<?=$contact->lead?>" hidden>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="name">Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="name" data-maxlength="300" id="name" value="<?=$contact->name?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="email">Email</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="email" data-maxlength="300" id="email" value="<?=$contact->email?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="email"> Phone </label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="phone" data-maxlength="300" id="phone" value="<?=$contact->phone?>" required>
                                </div>
                            </div>

                           <div class="form-group">
                                <label class="col-lg-3 control-label" for="skype">Skype Account</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="skype_account" data-maxlength="300" id="skype" value="<?=$contact->skype_account?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="title">Job Title</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="job_title" data-maxlength="300" id="title" value="<?=$contact->job_title?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="location">Location</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="location" data-maxlength="300" id="title" value="<?=$contact->location?>" required>
                                </div>
                            </div>
                           <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" rows="6"><?=$contact->comment?></textarea>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>customer/leadContacts?t=<?=base64_encode($contact->lead)?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>