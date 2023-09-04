<?php if($row->type == 2 || $row->type== 3){ ?>
<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Credit Note Request
			</header>
			<div class="panel-body">
          		<div class="adv-table editable-table " style="overflow:scroll;">
					<div class="clearfix">
						<div class="btn-group">
							<span class=" btn-primary" style="">
								Request Data 
							</span>
						</div>
						
					</div>
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" id="">
						<thead>
							<tr>
                                 <th>ID</th>
                                 <th>Credit Note Type</th>
                                 <th>Customer</th>
                                 <th>Issue_date</th>
                                 <th>POs Number</th>
                                 <th>Amount</th>
                                 <th>Currency</th>
                                 <th>Attachment File</th>
                                 <th>Status</th>
                                 <th>Status By</th>
                                 <th>Status At</th>
                                 <th>Created By</th>
                                 <th>Created At</th>
							</tr>
						</thead>
						<tbody>
							<tr class="">
                                <td><?=$row->id?></td>
            					<td><?=$this->accounting_model->getCreditNoteType($row->type)?></td>
                				<td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                				<td><?=$row->issue_date?></td>
                				<td><?=$this->accounting_model->getSelectedPOs($row->pos)?></td>
                				<td><?=$row->amount?></td>
                				<td><?=$this->admin_model->getCurrency($row->currency)?></td>
                				<td><a href="<?=base_url()?>assets/uploads/creditNote/<?=$row->file?>" target="_blank">Click Here</a></td>
                				<td><?=$this->accounting_model->getCreditNoteStatus($row->status)?></td>
                				<td><?php echo $this->admin_model->getAdmin($row->status_by) ;?></td>
                            	<td><?=$row->status_at?></td>
                				<td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                				<td><?=$row->created_at?></td>
							</tr>
						</tbody>
					</table>
				</div>
        	</div>
    	</section>
    </div>
</div>

<?php if($row->status == 0){ ?>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Approve Request 
            </header>
            
            <div class="panel-body">
                 <form class="cmxform form-horizontal " action="<?php echo base_url()?>accounting/doApproveCreditNote" method="post" enctype="multipart/form-data">

                        <input name="id" type="hidden" value="<?=base64_encode($row->id)?>" readonly="">
                        <!-- Enter your comment -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Reject Reason</label>
                                <div class="col-sm-6">
                                    <textarea name="reject_reason" id="reject_reason" class="form-control" value="" rows="6"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <input class="btn btn-success" type="submit" onclick="return checkCommentSave();" name="submit" value="Approve Request">
                                  	<input class="btn btn-danger" type="submit" name="reject" onclick="return checkCommentReject();" value="Reject Request">
                                    <a href="<?php echo base_url()?>projects/creditNote" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>   
                  </form>
            </div>
        </section>
        </div>
    </div>
<?php } ?>

<?php } ?>