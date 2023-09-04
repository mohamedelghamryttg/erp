<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Date Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " id="vmActivity" action="<?php echo base_url()?>vendor/vmActivity" method="post" enctype="multipart/form-data">
        <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
            </div>

        </div>
        <?php if($permission->view == 1){ ?>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="role Task Type">VM Name</label>
          <div class="col-lg-3">
                <select name="created_by" class="form-control m-b" id="created_by"/>
                         <option value="">-- Select Vm --</option>
                         <?=$this->admin_model->selectAllVm($this->brand)?>
                </select>
            </div>
        </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button class="btn btn-primary" name="search" type="submit">Search</button> 
              	<button class="btn btn-success" onclick="var e2 = document.getElementById('vmActivity'); e2.action='<?=base_url()?>vendor/exportVmActivity'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
            </div>
        </div>   
        </form>
      </div>
    </section>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        VM Activity Sheet
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Ticket Number</th>
                <th>Opened BY</th>
                <th>Closed By</th>
                <th>Requester Name</th>
                <th>Number Of Rescource</th>
                <th>Request Type</th>
                <th>Service</th>
                <th>Task Type</th>
                <th>Rate</th>
                <th>Count</th>
                <th>Unit</th>
                <th>Currency</th>
                <th>Source Language</th>
                <th>Target Language</th>
                <th>Start Date</th>
                <th>Delivery Date</th>
<!--                <th>Due Date</th>-->
                <th>Subject Matter</th>
                <th>Software</th>
                <th>Request Time</th>
                <th>Time Of Opening</th>
                <th>Time OF CLosing</th>
                <th>Taken Time</th>
                <th>New Vendors</th>
                <th>Existing Vendors</th>
                <th>Existing Vendors with New Pairs</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if($ticket != ""){
              foreach ($ticket->result() as $row) {
                $time_closing = $this->db->get_where('vm_ticket_time',array('ticket'=>$row->ticket,'status'=>'4'))->row();
                $vmClosed = $this->db->get_where('vm_ticket_time',array('ticket'=>$row->ticket,'status'=>'5'))->row();
                $existing = $this->db->query("SELECT COUNT(*) AS existing FROM `vm_ticket_resource` WHERE ticket = '$row->ticket' and type = '2'")->row()->existing;
                $new = $this->db->query("SELECT COUNT(*) AS new FROM `vm_ticket_resource` WHERE ticket = '$row->ticket' and type = '1'")->row()->new;
                $existing_pair = $this->db->query("SELECT COUNT(*) AS existing_pair FROM `vm_ticket_resource` WHERE ticket = '$row->ticket' and type = '3'")->row()->existing_pair;
              ?>
              <tr>
                <td><?php echo $row->ticket ;?></td>
                <td><?=$this->admin_model->getAdmin($row->vm)?></td>
                <td><?=$this->admin_model->getAdmin($vmClosed->created_by)?></td>
                <td><?=$this->admin_model->getAdmin($row->requester)?></td>
                <td><?php echo $row->number_of_resource ;?></td>
                <td><?php echo $this->vendor_model->getTicketType($row->request_type);?></td>
                <td><?php echo $this->admin_model->getServices($row->service);?></td>
                <td><?php echo $this->admin_model->getTaskType($row->task_type);?></td>
                <td><?php echo $row->rate ;?></td>
                <td><?php echo $row->count ;?></td>
                <td><?php echo $this->admin_model->getUnit($row->unit) ;?></td>
                <td><?php echo $this->admin_model->getCurrency($row->currency) ;?></td>
                <td><?php echo $this->admin_model->getLanguage($row->source_lang) ;?></td>
                <td><?php echo $this->admin_model->getLanguage($row->target_lang) ;?></td>
                <td><?php echo $row->start_date ;?></td>
                <td><?php echo $row->delivery_date ;?></td>
<!--                <td><?php echo $row->due_date ;?></td>-->
                <td><?php echo $this->admin_model->getFields($row->subject);?></td>
                <td><?php echo $this->sales_model->getToolName($row->software);?></td>
                <td><?php echo $row->request_time ;?></td>
                <td><?php echo $row->open_time ;?></td>
                <td><?php if(isset($time_closing->created_at)){echo $time_closing->created_at;}?></td>
                <td><?php echo $this->vendor_model->ticketTime($row->ticket).' H:M';?></td>
                <td><?=$new?></td>
                <td><?=$existing?></td>
                <td><?=$existing_pair?></td>
                <td><?php echo $this->vendor_model->getTicketStatus($row->ticket_status);?></td>
                </tr>
              <?php }} ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>