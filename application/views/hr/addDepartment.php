<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Department
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doAddDepartment" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Department">Department</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="name" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Division">Division</label>

                                <div class="col-lg-6">
                                    <select name="division" class="form-control m-b" id="division" required="">
                                        <option></option>
                                        <?=$this->hr_model->selectDivision()?>
                                    </select>
                                </div>
                            </div>
                          

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary disableAdd" type="submit" name="submit" value="Save"> <a href="<?php echo base_url()?>department" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>