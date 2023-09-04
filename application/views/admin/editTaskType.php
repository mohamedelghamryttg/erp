<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Task Type
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>admin/doEditTaskType/<?=$task_type->id?>" method="post" enctype="multipart/form-data">

                            <input type="text" name="id" value="<?=base64_encode($task_type->id)?>" hidden="">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="name">Task Type</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$task_type->name?>" name="name" data-maxlength="300" id="first_name" required>
                                </div>
                            </div>

                           
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="type">Services</label>

                                <div class="col-lg-6">
                                    <select name="parent" class="form-control m-b" id="role">
                                        <option></option>
                                        <?=$this->admin_model->selectServices($task_type->parent)?>
                                    </select>
                                </div>
                            </div>

                          

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>admin/task_type" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>