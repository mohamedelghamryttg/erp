<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Permission 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>admin/doEditPermission/<?=$permission->id?>" method="post" enctype="multipart/form-data">
                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Screen">Screen</label>
                                <div class="col-lg-6">
                                    <select name="screen" class="form-control m-b" required  id="screen">
                                             <option disabled="disabled" value="">-- Select Screen --</option>
                                             <?=$this->admin_model->selectScreen($permission->screen)?>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="role">Role</label>
                                <div class="col-lg-6">
                                    <select name="role" class="form-control m-b" required  id="role">
                                             <option disabled="disabled">-- Select Role --</option>
                                             <?=$this->admin_model->selectRole($permission->role)?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="follow">Follow-Up</label>
                                <div class="col-lg-6">
                                    <select name="follow" class="form-control m-b" id="follow">
                                             <option value="0">-- Select Follow-Up --</option>
                                             <?=$this->admin_model->selectFollowUp($permission->follow)?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="view">View</label>
                                <div class="col-lg-6">
                                    <?php if($permission->view == "2"){$s1 = "";$s2="selected=selected";}
                                            elseif($permission->view == "1"){$s1 = "selected=selected";$s2="";}
                                            else{$s1="";$s2="";} ?>
                                    <select name="view" class="form-control m-b" required  id="view">
                                             <option disabled="disabled">-- Select Permission --</option>
                                             <option value="2" <?=$s2?>>View only assigned</option>
                                             <option value="1"<?=$s1?>>View ALL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Add">Can Add</label>
                                <div class="col-lg-6">
                                <?php if($permission->add == "1"){$s1 = "";$s2="selected=selected";}
                                            elseif($permission->add == "0"){$s1 = "selected=selected";$s2="";} ?>
                                    <select name="add" class="form-control m-b" required  id="add">
                                             <option disabled="disabled">-- Select Permission --</option>
                                             <option value="1" <?=$s2?>>Yes</option>
                                             <option value="0" <?=$s1?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Edit">Can Edit</label>
                                <div class="col-lg-6">
                                    <?php if($permission->edit == "1"){$s1 = "";$s2="selected=selected";}
                                            elseif($permission->edit == "0"){$s1 = "selected=selected";$s2="";} ?>
                                    <select name="edit" class="form-control m-b" required  id="edit">
                                             <option disabled="disabled">-- Select Permission --</option>
                                             <option value="1" <?=$s2?>>Yes</option>
                                             <option value="0" <?=$s1?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Delete">Can Delete</label>
                                <div class="col-lg-6">
                                <?php if($permission->delete == "1"){$s1 = "";$s2="selected=selected";}
                                            elseif($permission->delete == "0"){$s1 = "selected=selected";$s2="";} ?>
                                    <select name="delete" class="form-control m-b" required  id="delete">
                                             <option disabled="disabled">-- Select Permission --</option>
                                             <option value="1" <?=$s2?>>Yes</option>
                                             <option value="0" <?=$s1?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>admin/permission" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>