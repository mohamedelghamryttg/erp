<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Edit Lead 
			</header>
			
			<div class="panel-body">
				<div class="form">
					<form class="cmxform form-horizontal " action="<?php echo base_url()?>customer/doEditLead/<?=$lead->id?>" method="post" enctype="multipart/form-data">

             <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                   <input type="text" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>" hidden>
                   <?php }else{ ?>
                   <input type="text" name="referer" value="<?=base_url()?>projects" hidden>
                   <?php } ?>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="role name">Customer</label>

                                <div class="col-lg-6">
                                    <select name="customer" class="form-control m-b" id="customer" required />
                                             <option value="" disabled="disabled" selected="selected">-- Select Customer --</option>
                                             <?=$this->customer_model->selectCustomerLead($lead->customer,$this->brand)?>
                                    </select>
                                </div>
                            </div>
                  
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Region">Region</label>
                                <div class="col-lg-6">
                                    <select name="region" class="form-control m-b" id="region" onchange="getCountries()" required />
                                             <option value="" disabled="disabled" selected="selected">-- Select Region --</option>
                                             <?=$this->admin_model->selectRegion($lead->region)?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Country">Country</label>
                                <div class="col-lg-6">
                                    <select name="country" class="form-control m-b" id="country" required />
                                             <option value="" disabled="disabled" selected="selected">-- Select Country --</option>
                                             <?=$this->admin_model->selectCountries($lead->country,$lead->region)?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="Type">Type</label>
                                <div class="col-lg-6">
                                    <select name="type" class="form-control m-b" id="type" required />
                                             <option value="" disabled="disabled" selected="selected">-- Select Type --</option>
                                             <?=$this->customer_model->selectType($lead->type)?>
                                    </select>
                                </div>
                            </div>
                            <?php if($permission->follow == 3 || $permission->follow == 2){ ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Status</label>

                                <div class="col-lg-6">
                                      <select name="status" class="form-control m-b" id="status" required />
                                             <option value="" disabled="disabled" selected="selected">-- Select Status --</option>
                                             <?=$this->customer_model->SelectStatus($lead->status)?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Customer Approve</label>

                                <div class="col-lg-6">
                                      <select name="approved" class="form-control m-b" id="approved" required />
                                             <option disabled="disabled" selected="selected">-- Select --</option>
                                             <?php if($lead->approved == 1){ ?>
                                             <option value="1" selected="">Yes</option>
                                             <option value="2">No</option>
                                             <?php }else if($lead->approved == 2){ ?>
                                             <option value="1">Yes</option>
                                             <option value="2" selected="">No</option>
                                             <?php }else{ ?>
                                             <option value="1">Yes</option>
                                             <option value="2">No</option>
                                             <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>

                             <div class="form-group">
                                <label class="col-lg-3 control-label" for="Source">Source</label>
                                <div class="col-lg-6">
                                    <select name="source" class="form-control m-b" id="source" required />
                                             <option disabled="disabled" selected="selected">-- Select Source --</option>
                                             <?=$this->customer_model->selectSource($lead->source)?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea name="comment" class="form-control" rows="6"><?=$lead->comment?></textarea>
                                </div>
                            </div>
                             
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                    <a href="<?php echo base_url()?>customer/leads" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
	
	<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Activities with Comments
      </header>
      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow:scroll;">
          <div class="clearfix">            
          </div>
          
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <tr>
                <th>Number #</th>
                <th>Created By</th>
                <th>Response</th>
              </tr>
              </tr>
            </thead>
            
            <tbody>
            <?php
			  $activityComment = $this->db->get_where('users',array('id'=>000));
              foreach($activityComment->result() as $row)
                {
            ?>
                  <tr class="">
                    <td><?php echo $row->id ;?></td> 
                    <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                    <td>
                      <a href="" onclick="openDiv(<?=$row->id?>);return false;" class="btn btn-success" >Response</a>
                    </td>
                  </tr>

            <?php
                }
            ?>    
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>

	<?php
        foreach($activityComment->result() as $row)
          {
            $comments = $this->db->get_where('customer_activity_comment',array('activity'=>$row->id,'lead'=>$lead->id))->result();
      ?>
    <div class="row divComments" id="comments_<?=$row->id?>" style="display: none;">
        <div class="col-sm-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="form">
                        <form class="cmxform form-horizontal ">
                        <input type="text" id="activity_<?=$row->id?>" value="<?=$row->id?>" hidden="">
                        <input type="text" id="lead" value="<?=$lead->id?>" hidden="">
                        <?php foreach ($comments as $comment) { 
                          if($comment->team == 3){
                          ?>
                            <div class="form-group">
                                <div class="col-lg-3" style="padding-top: 5px;background-color: #79c4f1;"><p style="text-align: left;"><?php echo $this->admin_model->getAdmin($comment->created_by) ;?> - <?=$comment->created_at?></p></div>
                                <div class="col-lg-6" style="padding-top: 5px;background-color: #79c4f1;"><p style="text-align: left;"><?=$comment->comment?></p></div>
                                <div class="col-lg-3"></div>
                            </div>
                          <?php }else{ ?>
                            <div class="form-group">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6" style="padding-top: 5px;background-color: #f6ede8;"><p style="text-align: right;"><?=$comment->comment?></p></div>
                                <div class="col-lg-3" style="padding-top: 5px;background-color: #f6ede8;"><p style="text-align: right;"><?php echo $this->admin_model->getAdmin($comment->created_by) ;?> - <?=$comment->created_at?></p></div>
                            </div>
                        <?php }} ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Comment</label>

                                <div class="col-lg-6">
                                      <textarea id="chat_<?=$row->id?>" class="form-control" value="" rows="6"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment"></label>

                                <div class="col-lg-6">
                                      <a href="" onclick="addComment();return false;" class="btn btn-primary" type="button">Send Comment</a>
                                      <a href="" onclick="hideDiv(<?=$row->id?>);return false;" class="btn btn-danger" type="button">(x) Close</a>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php } ?>

    <script type="text/javascript">
        function getCountries(){
            var region = $("#region").val();
            // alert(region);
            $.post("<?=base_url()?>customer/getCountries", {region:region} , function(data){
            // alert(data);
            $("#country").html(data);
            });
        }
    </script>