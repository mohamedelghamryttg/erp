<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Employee Credit
			</header>
			
			<div class="panel-body">
				<div class="form">
			<form class="cmxform form-horizontal " id="form"action="<?php echo base_url()?>hr/doEditVacationBalance" method="post" name="addVacatin" enctype="multipart/form-data">
                  <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                  <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>vacationBalance" hidden>
                    <?php } ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Name">Name</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$this->db->query("SELECT name FROM employees WHERE id = '$row->emp_id'")->row()->name?>" name="employee" readonly data-maxlength="300" id="name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Balance</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->current_year?>" name="current_year"  data-maxlength="300" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Double Days Balance</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->double_days?>" name="double_days"  data-maxlength="300" required>
                                </div>
                            </div> 
                          
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Sick Leave</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->sick_leave?>" name="sick_leave"  data-maxlength="300" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Marriage</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->marriage?>" name="marriage"  data-maxlength="300" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Maternity Leave</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$row->maternity_leave?>" name="maternity_leave"  data-maxlength="300" required>
                                </div>
                            </div>
                           
                           
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary"name="save" type="submit">Save</button> 
                                    <a href="<?php echo base_url()?>hr/vacationBalance" class="btn btn-danger" type="button">Cancel</a>
                                </div>
                            </div>
                            
                        </form> 
                    </div>
                </div>
            </section>
        </div>
    </div>
    

    <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
        });
    </script>