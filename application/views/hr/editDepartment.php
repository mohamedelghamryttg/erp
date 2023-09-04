<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Department
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doEditDepartment" method="post" enctype="multipart/form-data">
                            <input type="text" name="id" value="<?=base64_encode($department->id)?>" hidden="">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Department">Department</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$department->name?>" name="name" required>
                                </div>
                            </div>


                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Department">Division</label>

                                <div class="col-lg-6">
                                    <select name="division" class="form-control m-b" id="role" required="">
                                        <option></option>
                                        <?=$this->hr_model->selectDivision($department->division)?>
                                    </select>
                                </div>
                            </div>




                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>hr/department" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>