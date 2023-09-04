<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Structure
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doEditStructure/<?=$structure->id?>" method="post" enctype="multipart/form-data">

                            <input type="text" name="id" value="<?=base64_encode($structure->id)?>" hidden="">
                            <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                             <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                             <?php }else{ ?>
                             <input type="text" name="referer" value="<?=base_url()?>hr/employees" hidden>
                             <?php } ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Title">Title</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$structure->title?>" name="title" data-maxlength="300" id="title" required>
                                </div>
                            </div>

    
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Division">Division</label>

                                <div class="col-lg-6">
                                    <select name="division" onchange="getDepartment()" class="form-control m-b" id="division" required />
                                            <option disabled="disabled" selected="" value=""></option>
                                            <?=$this->hr_model->selectDivision($structure->division)?>
                                    </select>
                                </div>
                            </div>
                           
                         <div class="form-group">
                                <label class="col-lg-3 control-label" for="Department">Department</label>

                                <div class="col-lg-6">
                                    <select name="department" class="form-control m-b" id="department" required />
                                            
                                            <?=$this->hr_model->selectDepartment($structure->department,$structure->division)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Track">Track</label>

                                <div class="col-lg-6">
                                    <select name="track" class="form-control m-b" id="track" required>
                                        <option disabled="" selected="" value="">-- Select Track --</option>
                                        <?=$this->hr_model->selectTrack($structure->track)?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Parent">Parent</label>

                                <div class="col-lg-6">
                                    <select name="parent" class="form-control m-b" id="parent">
                                        <option selected="" value="">N/A</option>
                                        <?=$this->hr_model->selectTitle($structure->parent)?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Grand Parent">Grand Parent</label>

                                <div class="col-lg-6">
                                    <select name="grand_parent" class="form-control m-b" id="grand_parent">
                                        <option selected="" value="">N/A</option>
                                        <?=$this->hr_model->selectTitle($structure->grand_parent)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>hr/structure" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>