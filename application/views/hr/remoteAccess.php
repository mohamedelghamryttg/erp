<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Add New
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doAddRemoteAccess" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Date Time</label>

                                <div class="col-lg-6">
                                    <input type="text" class="form-control" value="<?=date("Y-m-d H:i:s")?>" name="sign" disabled="">
                                </div>
                            </div>
                    
                    		<div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Signing Type</label>

                                <div class="col-lg-6">
                                    <select name="TNAKEY" class="form-control m-b" id="TNAKEY" required />
                                             <option disabled="disabled" selected="selected">-- Select Type --</option>
                                             <option value="1">Sign In</option>
                                             <option value="2">Sign Out</option>
                                    </select>
                                </div>
                            </div>
                          

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>hr/attendance" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>