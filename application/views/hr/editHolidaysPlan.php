<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Holiday
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>hr/doEditHolidaysPlan" method="post" enctype="multipart/form-data">
                          <input type="text" name="id" hidden="" value="<?=base64_encode($id)?>">
                         <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                            <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                            <?php }else{ ?>
                            <input type="text" name="referer" value="<?=base_url()?>holidaysPlan" hidden>
                    <?php } ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Name">Holiday Name</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" name="holiday_name" data-maxlength="300" id="name" value="<?= $row->holiday_name?>" required>
                                </div>
                            </div>  

                            <div class="form-group">
		                       <label class="col-lg-3 control-label" for="role date">Holiday Date</label>

		                         <div class="col-lg-6">
                                     <input size="16" class="datepicker form-control"name="holiday_date" type="text" onblur="validateHolidayDate(0);" id="holiday_date" autocomplete="off"value="<?= $row->holiday_date?>" required>
                                 </div>
                            </div> 
                          

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>hr/holidaysPlan" class="btn btn-default" type="button">Cancel</a>
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