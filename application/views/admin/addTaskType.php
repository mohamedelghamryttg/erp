<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New Task Type
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>admin/doAddTaskType" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="name">Task Type</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="name" data-maxlength="300" id="name" required>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="parent">Service</label>

                                <div class="col-lg-6">
                                    <select name="parent" class="form-control m-b" id="parent" required="">
                                        <option></option>
                                        <?=$this->admin_model->selectServices()?>
                                    </select>
                                </div>
                            </div>
                          

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary disableAdd" type="submit">Save</button> <a href="<?php echo base_url()?>admin/task_type" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>