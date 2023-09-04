<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New User 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>admin/doAddUser" onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="fname">First Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="first_name" data-maxlength="300" id="first_name" required>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="lname">Last Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="last_name" data-maxlength="300" id="last_name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="user_name">Username</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" data-maxlength="300" name="user_name" id="user_name" required>
                                </div>
                            </div>
                      
                      		<div class="form-group">
                                <label class="col-lg-3 control-label" for="user_name">Abbreviations</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" data-maxlength="3" name="abbreviations" id="abbreviations">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="email">Email</label>

                                <div class="col-lg-6">
                                    <input type="email"  placeholder="E-mail" class=" form-control" name="email" id="email" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="inputPassword">Password</label>

                                <div class="col-lg-6">
                                    <input type="password" id="inputPassword" placeholder="Password" class=" form-control" 
                                    name="password"  required="">
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="type">Role</label>

                                <div class="col-lg-6">
                                    <select name="role" class="form-control m-b" id="role">
                                        <option></option>
                                        <?=$this->admin_model->selectRole()?>
                                    </select>
                                </div>
                            </div>

                        <div class="form-group">
                                <label class="col-lg-3 control-label" for="type">Employee Name</label>

                                <div class="col-lg-6">
                                    <select name="employees" class="form-control m-b" id="employees" required="">
                                        <option></option>
                                        <?=$this->admin_model->selectEmployees()?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="phone">phone</label>

                                <div class="col-lg-6">
                                    <input type="number" id="mobile" class=" form-control" name="phone" required="" data-maxlength="15" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="type">Brand</label>

                                <div class="col-lg-6">
                                    <select name="brand" class="form-control m-b" id="brand">
                                        <option></option>
                                        <?=$this->admin_model->selectBrand()?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="form-group last">
                                <label class="control-label col-md-3">Image Upload</label>
                                <div class="col-md-9">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" 
                                        style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                        <div>
                                           <span class="btn btn-white btn-file">
                                           <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                           <input type="file" class="default" id="image" name="image"/>
                                           </span>
                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                        </div>
                                    </div>
                                    <span class="label label-danger">NOTE!</span>
                                    <span>
                                        Attached image thumbnail is
                                        supported in Latest Firefox, Chrome, Opera,
                                        Safari and Internet Explorer 10 only
                                    </span>
                                </div>
                            </div>
                          

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary disableAdd" type="submit">Save</button> <a href="<?php echo base_url()?>admin/users" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>