<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New Screen 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>admin/doAddScreen" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Group">Group</label>
                                <div class="col-lg-6">
                                    <select name="groups" class="form-control m-b" id="groups" required />
                                             <option disabled="disabled" selected="selected">-- Select Group --</option>
                                             <?=$this->admin_model->selectGroup()?>
                                    </select>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="lname">Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="name" data-maxlength="300" id="name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="user_name">URL</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" data-maxlength="300" name="url" id="url" required>
                                </div>
                            </div>
                      
                      	    <div class="form-group">
                                <label class="col-lg-3 control-label" for="Add">Menu</label>
                                <div class="col-lg-6">
                                    <select name="menu" class="form-control m-b" required  id="menu">
                                             <option disabled="disabled" selected="selected">-- Select Menu --</option>
                                             <option value="1">1</option>
                                             <option value="0">0</option>
                                    </select>
                                </div>
                            </div>        

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary disableAdd" type="submit">Save</button> <a href="<?php echo base_url()?>screen" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>