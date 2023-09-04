<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Missing Attendance Request
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doEditMissingAttendance" method="post" enctype="multipart/form-data">
						<input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                  <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>customer" hidden>
                    <?php } ?>
            	<div class="form-group">
                       <label class="col-lg-3 control-label" for="role date">Date</label>

                        <div class="col-lg-6">
                             <input size="16" class="form_datetime form-control"name="date"type="text" id="date"autocomplete="off" value="<?= $row->SRVDT?>" required="">
                        </div>
                </div> 
                  <div class="form-group">
                     <label class="col-lg-3 control-label" for="role name">Signing Type</label>

                        <div class="col-lg-6">
                            <select name="TNAKEY" class="form-control m-b" id="TNAKEY" required />
                                     <option disabled="disabled">-- Select Type --</option>
                                     <?php if($row->TNAKEY == 1){ ?>
                                         <option value="1" selected="selected">Sign In</option>
                                         <option value="2">Sign Out</option>
                                     <?php }elseif ($row->TNAKEY == 2) { ?> 
                                          <option value="1">Sign In</option>
                                         <option value="2" selected="selected">Sign Out</option>
                                      <?php }else{ ?> 
                                        <option value="1">Sign In</option>
                                          <option value="2">Sign Out</option>
                                      <?php } ?>
                            </select>
                        </div>
                </div>
                          

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>hr/missingAttendance" class="btn btn-default" type="button">Cancel</a>
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