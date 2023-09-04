<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Upload New CV 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>vendor/doEditCV" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?=base64_encode($row->id)?>" hidden="">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Source">Source Language</label>

                                <div class="col-lg-6">
                                    <select name="source_lang" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected">-- Select Source Language --</option>
                                             <?=$this->admin_model->selectLanguage($row->source_lang)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Target">Target Language</label>

                                <div class="col-lg-6">
                                    <select name="target_lang" class="form-control m-b" id="target" onchange="selectDialect()" required />
                                             <option disabled="disabled" selected="selected">-- Select Target Language --</option>
                                             <?=$this->admin_model->selectLanguage($row->target_lang)?>
                                    </select>
                                </div>
                            </div>
            
            				<div class="form-group">
                                <label class="col-lg-3 control-label" for="role Dialect">Dialect</label>

                                <div class="col-lg-6">
                                    <select name="dialect" class="form-control m-b" id="dialect"/>
                                            <option disabled="disabled" selected="selected">-- Select Dialect --</option>
                                            <?=$this->admin_model->selectDialect($row->dialect,$row->target_lang)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role Field">Field</label>

                                <div class="col-lg-6">
                                    <?=$this->admin_model->selectFieldsCheckBoxs($row->field)?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">CV Attachment</label>

                                <div class="col-lg-6">
                                    <input type="file" class=" form-control" name="file">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" value="" rows="6"><?=$row->comment?></textarea>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>vendor/uploadCV" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
