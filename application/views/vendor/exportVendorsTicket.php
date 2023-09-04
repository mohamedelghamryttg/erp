<!DOCTYPE ><html dir=ltr>
    <head>
<style>
@media print {
table {font-size: smaller; }
thead {display: table-header-group; }
table { page-break-inside:auto; width:75%; }
tr { page-break-inside:avoid; page-break-after:auto; }
}
table {
  border: 1px solid black;
  font-size:18px;
}
table td {
  border: 1px solid black;
}
table th {
  border: 1px solid black;
}
.clr{
  background-color: #EEEEEE;
  text-align: center;
}
.clr1 {
background-color: #FFFFCC;
  text-align: center;
}
</style>
</head>
<body>

<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                              <thead>
                                <tr>
                                  <th>Resource Type</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Contact</th>
                                  <th>Country of Residence</th>
                                  <th>Mother Tongue</th>
                                  <th>Profile</th>
                                  <th>CV</th>
                                  <th>Source Language</th>
                                  <th>Target Language</th>
                                  <th>Dialect</th>
                                  <th>Service</th>
                                  <th>Task Type</th>
                                  <th>Unit</th>
                                  <th>Rate</th>
                                  <th>Currency</th>
                                  <th>Subject Matter</th>
                                  <th>Tools</th>
                                  <th>Created By</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php 
                              foreach ($ticket_resources->result() as $ticket_resources) { 
                                $resource = $this->db->get_where('vendor',array('id'=>$ticket_resources->vendor))->row();
                                $sheet = $this->db->get_where('vendor_sheet',array('ticket_id'=>$id,'vendor'=>$resource->id,'i'=>$ticket_resources->id))->row();
                              ?>
                              <tr>
                                <td>
                                <?php if($ticket_resources->type == 1){echo "New Resource";}
                                      if($ticket_resources->type == 2){echo "Select Existing Resource";}
                                      if($ticket_resources->type == 3){echo "Select Existing Resource & Adding New Pair";}
                                ?>
                                </td>
                                <td><?=$resource->name?></td>
                                <td><?=$resource->email?></td>
                                <td><?=$resource->contact?></td>
                                <td><?=$this->admin_model->getCountry($resource->country)?></td>
                                <td><?=$resource->mother_tongue?></td>
                                <td><?=$resource->profile?></td>
                                <td>
                                  <?php if(strlen(trim($resource->cv)) > 0){ ?>
                                  <a href="<?=base_url()?>assets/uploads/vendors/<?=$resource->cv?>">Click Here ..</a>
                                  <?php } ?>
                                </td>
                                <?php if($ticket_resources->type != 2){ ?>
                                <td><?=$this->admin_model->getLanguage($sheet->source_lang)?></td>
                                <td><?=$this->admin_model->getLanguage($sheet->target_lang)?></td>
                                <td><?=$sheet->dialect?></td>
                                <td><?=$this->admin_model->getServices($sheet->service)?></td>
                                <td><?=$this->admin_model->getTaskType($sheet->task_type)?></td>
                                <td><?=$this->admin_model->getUnit($sheet->unit)?></td>
                                <td><?=$sheet->rate?></td>
                                <td><?=$this->admin_model->getCurrency($sheet->currency)?></td>
                                <td>
                                <?php
                                $subjects = explode(",", $resource->subject);
                                for ($i=0; $i < count($subjects); $i++) { 
                                  if($i > 0){echo " - ";}
                                  echo $this->admin_model->getFields($subjects[$i]);
                                 } 
                                ?>
                                </td>
                                <td>
                                <?php
                                $tools = explode(",", $resource->tools);
                                for ($i=0; $i < count($tools); $i++) { 
                                  if($i > 0){echo " - ";}
                                  echo $this->sales_model->getToolName($tools[$i]);
                                 } 
                                ?>
                                </td>
                                <?php }else{ ?>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <?php } ?>
                                <td><?php echo $this->admin_model->getAdmin($ticket_resources->created_by) ;?></td>
                              </tr>
                              <?php } ?>
                              </tbody>
                            </table>

				</body>
</html>