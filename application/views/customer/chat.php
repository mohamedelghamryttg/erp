<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Chat
			</header>
			
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						
					</div>
					
					<div class="space15"></div>

					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th>Username</th>
								<th>email</th>
								<th>Message</th>
								<th>Date</th>
							</tr>
						</thead>
						<input type="text" name="room" id="room" value="<?=$roomData->id?>" hidden="">
						<tbody id="msgs">
						<?php
							foreach($message->result() as $row)
								{
									if($row->user_type == 2){
						?>
									<tr class="">
										<td><?=$roomData->name?></td>
										<td><?=$roomData->email?></td>
										<td><?=$row->message?></td>
										<td><?=$row->created_at?></td>
									</tr>
								<?php }elseif ($row->user_type == 1) { ?>
									<tr class="">
								<th>Username</th>
										<td><?=$this->admin_model->getAdmin($row->username)?></td>
										<td></td>
										<td><?=$row->message?></td>
										<td><?=$row->created_at?></td>
									</tr>
								<?php } ?>
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

<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Send New Message
			</header>
			
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						
					</div>
					
					<div class="space15"></div>
					<form class="cmxform form-horizontal ">
					<div class="form-group">
                        <label class="col-lg-3 control-label" for="comment">Comment</label>

                        <div class="col-lg-6">
                              <textarea name="message" id="message" class="form-control" value="" rows="6"></textarea>
                        </div>
                    </div>
                     
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-6">
                            <a class="btn btn-primary" href="#" onclick="sendNewMessage()">Send Message</a>
                        </div>
                    </div>
                    </form>
					
				</div>
			</div>
		</section>
	</div>
</div>
<script type="text/javascript">
	setInterval(function() {
    // alert("here");
	    var room = $("#room").val();
	    // console.log(room);
	     $.post("<?=base_url()?>customer/getAllRoomMassages", {room:room} , function(data){
	        // alert(data);
	        $("#msgs").html(data);
	    });
	 }, 1000);
</script>
<script type="text/javascript">
	function sendNewMessage(){
	    var room = $("#room").val();
	    var message = $("#message").val();
	    // alert(region);
	    $.post("<?=base_url()?>customer/sendNewMessage", {room:room,message:message} , function(data){
		    $('#message').val("");
	    });
	}
</script>