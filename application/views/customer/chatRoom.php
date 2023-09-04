<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Chat Rooms
			</header>
			<?php if($this->session->flashdata('true')){ ?>
			<div class="alert alert-success" role="alert">
              <span class="fa fa-check-circle"></span>
              <span><strong><?=$this->session->flashdata('true')?></strong></span>
            </div>
			<?php  } ?>
			<?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert">
              <span class="fa fa-warning"></span>
              <span><strong><?=$this->session->flashdata('error')?></strong></span>
            </div>
			<?php  } ?>
			
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id="editable-sample">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Room Status</th>
								<th>Close Chat Room</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($customer->result() as $row)
								{
						?>
									<tr class="">
										<td><a href="<?=base_url()?>customer/chat?t=<?=base64_encode($row->id)?>"><?=$row->name?></a></td>
										<td><?=$row->email?></td>
										<td><?=$this->customer_model->chatRoomStatus($row->closed)?></td>
										<td><a href="<?=base_url()?>customer/closeRoom?t=<?=base64_encode($row->id)?>">Close this Room</a></td>
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