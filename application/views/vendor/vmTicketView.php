<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector: "#content" });</script>
<script>tinymce.init({ selector: "#comment" });</script>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        Vm View Ticket
      </header>

      <?php if ($this->session->flashdata('true')) { ?>
        <div class="alert alert-success" role="alert">
          <span class="fa fa-check-circle"></span>
          <span><strong>
              <?= $this->session->flashdata('true') ?>
            </strong></span>
        </div>
      <?php } ?>
      <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger" role="alert">
          <span class="fa fa-warning"></span>
          <span><strong>
              <?= $this->session->flashdata('error') ?>
            </strong></span>
        </div>
      <?php } ?>

      <div class="panel-body" style="overflow: scroll;">
        <table class="table table-striped table-hover table-bordered" style="white-space: normal;">
          <thead>
            <tr>
            <tr>
              <th>Ticket Number</th>
              <th>Request Type</th>
              <th>Number Of Rescource</th>
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
              <!--                    <th>Due Date</th>-->
              <th>Subject Matter</th>
              <th>Software</th>
              <th>File Attachment</th>

              <th>Status</th>
              <th>Created By</th>
              <th>Created At</th>
            </tr>

            </tr>


          </thead>



          <tbody>
            <tr class="">
              <input type="text" id="request_type" value="<?= $row->request_type ?>" hidden="">
              <input type="text" id="number_of_resource" value="<?= $row->number_of_resource ?>" hidden="">
              <td>
                <?= $row->id; ?>
              </td>
              <td>
                <?= $this->vendor_model->getTicketType($row->request_type); ?>
              </td>
              <td>
                <?= $row->number_of_resource; ?>
              </td>
              <td>
                <?= $this->admin_model->getServices($row->service); ?>
              </td>
              <td>
                <?= $this->admin_model->getTaskType($row->task_type); ?>
              </td>
              <td>
                <?= $row->rate; ?>
              </td>
              <td>
                <?= $row->count; ?>
              </td>
              <td>
                <?= $this->admin_model->getUnit($row->unit); ?>
              </td>
              <td>
                <?= $this->admin_model->getCurrency($row->currency); ?>
              </td>
              <td>
                <?= $this->admin_model->getLanguage($row->source_lang); ?>
              </td>
              <td>
                <?= $this->admin_model->getLanguage($row->target_lang); ?>
              </td>
              <td>
                <?= $row->start_date; ?>
              </td>
              <td>
                <?= $row->delivery_date; ?>
              </td>

              <td>
                <?= $this->admin_model->getFields($row->subject); ?>
              </td>
              <td>
                <?= $this->sales_model->getToolName($row->software); ?>
              </td>
              <td>
                <?php if (strlen($row->file ?? '') > 1) { ?><a
                  href="<?= base_url() ?>assets/uploads/tickets/<?= $row->file ?>" target="_blank">Click Here ..</a>
                <?php } ?>
              </td>

              <td>
                <?= $this->vendor_model->getTicketStatus($row->status); ?>
              </td>
              <td>
                <?= $this->admin_model->getAdmin($row->created_by); ?>
              </td>
              <td>
                <?= $row->created_at; ?>
              </td>
            </tr>
            <tr>
              <td>Comment</td>
              <td colspan="20">
                <?= $row->comment ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        Ticket Response
      </header>

      <div class="panel-body" style="overflow: scroll;">
        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
            <tr>
              <th>Username</th>
              <th>Response</th>
              <th>Created At</th>
            </tr>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($response as $response) { ?>
              <tr class="">
                <td>
                  <?= $this->admin_model->getAdmin($response->created_by) ?>
                </td>
                <td>
                  <?= $response->response ?>
                  <?php if (strlen($response->file ?? '') > 0) { ?>
                    </br> Attachment :
                    <a target="_blank" href="<?= base_url() ?>assets/uploads/tickets/<?= $response->file ?>">Click Here</a>
                  </td>
                <?php } ?>
                <td>
                  <?= $response->created_at ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        </br>
        <?php if ($row->status != 4) { ?>
          <div class="col-lg-offset-3 col-lg-6">

          </div>
          <div class="form">
            <form role="form" class="cmxform form-horizontal " id="commentForm"
              action="<?= base_url() ?>vendor/ticketRespone" method="post" enctype="multipart/form-data">
              <input name="id" type="hidden" value="<?= base64_encode($id) ?>" readonly="">
              <div class="form-group">
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label" for="comment" required="">Comment</label>

                <div class="col-lg-6">
                  <textarea name="comment" id="content"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label" for="role name">Attachment File</label>

                <div class="col-lg-6">
                  <input type="file" class=" form-control" name="file">
                </div>

              </div>
              <div class="form-group">
                <div class="col-lg-3"></div>
                <div class="col-lg-3"></div>
                <div class="col-lg-3"><button type="submit" class="btn btn-primary">Submit</button></div>

              </div>
            </form>
          </div>
        <?php } ?>
        </br>
        </br>
      </div>
    </section>
  </div>
</div>

<!-- CV Request -->
<?php if ($row->request_type == 5) { ?>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          Ticket Action
        </header>

        <div class="panel-body">
          <form class="cmxform form-horizontal " action="<?= base_url() ?>vendor/changeTicketStatus" method="post"
            enctype="multipart/form-data">

            <input name="id" type="hidden" value="<?= base64_encode($id) ?>" readonly="">
            <?php if ($row->status <= 3) { ?>
              <div class="form-group">
                <label class="col-lg-3 control-label" for="ticket status">Ticket Status</label>
                <div class="col-lg-6">
                  <select name="status" onchange="checkTicketStatus()" class="form-control m-b" id="status" required>
                    <?php if ($row->status == 2) { ?>
                      <?= $this->vendor_model->selectTicketStatusPartly($row->status) ?>
                    <?php } elseif ($row->status == 3) { ?>
                      <?= $this->vendor_model->selectTicketStatusClosed($row->status) ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            <?php } ?>
            <hr>
            <?php $ticketData = $this->db->get_where('vm_ticket_resource', array('ticket' => $row->id))->row();
            if (isset($ticketData->file)) {
              ?>
              <input type="text" name="resource_row" value="<?= $ticketData->id ?>" hidden="">
              <div class="form-group">
                <label class="col-lg-3 control-label" for="role name">Attachment</label>
                <div class="col-lg-6">
                  <a href="<?= base_url() ?>assets/uploads/tickets/<?= $ticketData->file ?>" target="_blank">Click Here
                    ..</a>
                </div>
              </div>
            <?php } else { ?>
              <div class="form-group">
                <label class="col-lg-3 control-label" for="role name">Attachment</label>
                <div class="col-lg-6">
                  <input type="file" class=" form-control" name="file" id="file" required="">
                </div>
              </div>
            <?php } ?>
            <?php if ($row->status <= 3) { ?>
              <div class="form-group">
                <div class="col-lg-offset-3 col-lg-6">
                  <button class="btn btn-primary" type="submit">Save</button>
                </div>
              </div>
            <?php } ?>
          </form>
        </div>
      </section>
    </div>
  </div>
<?php } ?>

<!-- Resource Availabilty -->
<?php if ($row->request_type == 4) { ?>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          Ticket Action
        </header>
        <div class="panel-body">
          <form class="cmxform form-horizontal " action="<?= base_url() ?>vendor/changeTicketStatus" method="post"
            enctype="multipart/form-data">

            <?php
            $ticketData = $this->db->get_where('vm_ticket_resource', array('ticket' => $row->id))->row();
            if (isset($ticketData->number_of_resource)) {
              $number = $ticketData->number_of_resource;
              ?>
              <input type="text" name="resource_row" value="<?= $ticketData->id ?>" hidden="">
              <?php
            } else {
              $number = "";
            }
            ?>

            <input name="id" type="hidden" value="<?= base64_encode($id) ?>" readonly="">
            <?php if ($row->status <= 3) { ?>
              <div class="form-group">
                <label class="col-lg-3 control-label" for="ticket status">Ticket Status</label>
                <div class="col-lg-6">
                  <select name="status" onchange="checkTicketStatus()" class="form-control m-b" id="status" required>
                    <?php if ($row->status == 2) { ?>
                      <?= $this->vendor_model->selectTicketStatusPartly($row->status) ?>
                    <?php } elseif ($row->status == 3) { ?>
                      <?= $this->vendor_model->selectTicketStatusClosed($row->status) ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            <?php } ?>
            <hr>
            <div class="form-group" id="resouceNumber">
              <label class="col-lg-3 control-label" for="role Product Lines">Number Of Resources</label>

              <div class="col-lg-3">
                <input type="text" class=" form-control" value="<?= $number ?>" name="number_of_resource"
                  id="number_of_resource" onkeypress="return numbersOnly(event)" required>
              </div>
            </div>
            <?php if ($row->status <= 3) { ?>
              <div class="form-group">
                <div class="col-lg-offset-3 col-lg-6">
                  <button class="btn btn-primary" type="submit">Save</button>
                </div>
              </div>
            <?php } ?>
          </form>
        </div>
      </section>
    </div>
  </div>
<?php } ?>

<!-- Price Inquiry -->
<?php if ($row->request_type == 2 || $row->request_type == 3) { ?>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          Ticket Action
        </header>

        <div class="panel-body">
          <form class="cmxform form-horizontal " action="<?= base_url() ?>vendor/changeTicketStatus" method="post"
            enctype="multipart/form-data">

            <?php
            $ticketData = $this->db->get_where('vm_ticket_resource', array('ticket' => $row->id))->row();
            ?>

            <input name="id" type="hidden" value="<?= base64_encode($id) ?>" readonly="">
            <?php if ($row->status <= 3) { ?>
              <div class="form-group">
                <label class="col-lg-3 control-label" for="ticket status">Ticket Status</label>
                <div class="col-lg-6">
                  <select name="status" onchange="checkTicketStatus()" class="form-control m-b" id="status" required>
                    <?php if ($row->status == 2) { ?>
                      <?= $this->vendor_model->selectTicketStatusPartly($row->status) ?>
                    <?php } elseif ($row->status == 3) { ?>
                      <?= $this->vendor_model->selectTicketStatusClosed($row->status) ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            <?php } ?>
            <hr>
            <?php if ($row->status <= 3) { ?>
              <div class="form-group">
                <div class="col-lg-offset-3 col-lg-6">
                  <button class="btn btn-primary" type="submit">Save</button>
                </div>
              </div>
            <?php } ?>
          </form>
        </div>
      </section>
    </div>
  </div>
<?php } ?>

<!-- New Resource -->
<?php if ($row->request_type == 1 || $row->request_type == 3) { ?>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          Ticket Action
        </header>

        <div class="panel-body">
          <div class="form">
            <form class="cmxform form-horizontal " action="<?= base_url() ?>vendor/changeTicketStatus" method="post"
              enctype="multipart/form-data">

              <input name="id" type="hidden" value="<?= base64_encode($id) ?>" readonly="">
              <?php if ($row->status <= 4) { ?>
                <div class="form-group">
                  <label class="col-lg-3 control-label" for="ticket status">Ticket Status</label>
                  <div class="col-lg-6">
                    <select name="status" onchange="checkTicketStatus()" class="form-control m-b" id="status" required>
                      <?php if ($row->status == 2) { ?>
                        <?= $this->vendor_model->selectTicketStatusPartly($row->status) ?>
                      <?php } elseif ($row->status == 3) { ?>
                        <?= $this->vendor_model->selectTicketStatusClosed($row->status) ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              <?php } elseif ($row->status == 5) { ?>
                <div class="form-group">
                  <label class="col-lg-3 control-label" for="ticket status">Ticket Status</label>
                  <div class="col-lg-6">
                    <select name="status" onchange="checkTicketStatus()" class="form-control m-b" id="status" required>
                      <option value="5" selected="selected">Waiting Requester Acceptance</option>
                    </select>
                  </div>
                </div>
              <?php } ?>
              <?php if ($row->status != 4) { ?>
                <a class="btn btn-primary" href="<?= base_url() ?>vendor/addTicketResource?t=<?= base64_encode($id) ?>">Add
                  New
                  Resource</a></br></br>
              <?php } ?>
              <a class="btn btn-success" target="_blank"
                href="<?= base_url() ?>vendor/exportVendorsTicket?t=<?= base64_encode($id) ?>"><i class="fa fa-download"
                  aria-hidden="true"></i> Export Vendors</a></br></br>

              <?php
              $ticket_resources = $this->db->get_where('vm_ticket_resource', array('ticket' => $id));
              ?>
              <div style="overflow: scroll;">
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
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($ticket_resources->result() as $ticket_resources) {
                      $resource = $this->db->get_where('vendor', array('id' => $ticket_resources->vendor))->row();
                      $sheet = $this->db->get_where('vendor_sheet', array('ticket_id' => $id, 'vendor' => $resource->id, 'i' => $ticket_resources->id))->row();
                      ?>
                      <tr>
                        <td>
                          <?php if ($ticket_resources->type == 1) {
                            echo "New Resource";
                          }
                          if ($ticket_resources->type == 2) {
                            echo "Select Existing Resource";
                          }
                          if ($ticket_resources->type == 3) {
                            echo "Select Existing Resource & Adding New Pair";
                          }
                          ?>
                        </td>
                        <td>
                          <?= $resource->name ?>
                        </td>
                        <td>
                          <?= $resource->email ?>
                        </td>
                        <td>
                          <?= $resource->contact ?>
                        </td>
                        <td>
                          <?= $this->admin_model->getCountry($resource->country) ?>
                        </td>
                        <td>
                          <?= $resource->mother_tongue ?>
                        </td>
                        <td>
                          <?= $resource->profile ?>
                        </td>
                        <td>
                          <?php if (strlen(trim($resource->cv ?? '')) > 0) { ?>
                            <a href="<?= base_url() ?>assets/uploads/vendors/<?= $resource->cv ?>">Click Here ..</a>
                          <?php } ?>
                        </td>
                        <?php if ($ticket_resources->type != 2) { ?>
                          <td>
                            <?= $this->admin_model->getLanguage($sheet->source_lang) ?>
                          </td>
                          <td>
                            <?= $this->admin_model->getLanguage($sheet->target_lang) ?>
                          </td>
                          <td>
                            <?= $sheet->dialect ?>
                          </td>
                          <td>
                            <?= $this->admin_model->getServices($sheet->service) ?>
                          </td>
                          <td>
                            <?= $this->admin_model->getTaskType($sheet->task_type) ?>
                          </td>
                          <td>
                            <?= $this->admin_model->getUnit($sheet->unit) ?>
                          </td>
                          <td>
                            <?= $sheet->rate ?>
                          </td>
                          <td>
                            <?= $this->admin_model->getCurrency($sheet->currency) ?>
                          </td>
                          <td>
                            <?php
                            $subjects = explode(",", $resource->subject);
                            for ($i = 0; $i < count($subjects); $i++) {
                              if ($i > 0) {
                                echo " - ";
                              }
                              echo $this->admin_model->getFields($subjects[$i]);
                            }
                            ?>
                          </td>
                          <td>
                            <?php
                            $tools = explode(",", $resource->tools);
                            for ($i = 0; $i < count($tools); $i++) {
                              if ($i > 0) {
                                echo " - ";
                              }
                              echo $this->sales_model->getToolName($tools[$i]);
                            }
                            ?>
                          </td>
                        <?php } else { ?>
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
                        <td>
                          <?= $this->admin_model->getAdmin($ticket_resources->created_by); ?>
                        </td>
                        <td>
                          <?php if ($row->status != 4) { ?>
                            <a href="<?= base_url() ?>vendor/editTicketResource?t=<?= base64_encode($ticket_resources->id) ?>&d=<?= base64_encode($id) ?>"
                              class="">
                              <i class="fa fa-pencil"></i> Edit
                            </a>
                          <?php } ?>
                        </td>
                        <td>
                          <?php if ($row->status != 4) { ?>
                            <a href="<?= base_url() ?>vendor/deleteTicketResource?t=<?= base64_encode($ticket_resources->id) ?>&d=<?= base64_encode($id) ?>"
                              title="delete" class=""
                              onclick="return confirm('Are you sure you want to delete this Resource ?');">
                              <i class="fa fa-times text-danger text"></i> Delete
                            </a>
                          <?php } ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <hr>
              <?php if ($row->status != 4) { ?>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                    <button class="btn btn-primary" type="submit">Save</button>
                  </div>
                </div>
              <?php } ?>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
<?php } ?>

<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        VM Team Ticket Comments
      </header>

      <div class="panel-body" style="overflow: scroll;">
        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
            <tr>
              <th>Username</th>
              <th>Comment</th>
              <th>Created At</th>
            </tr>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($team_response as $response) { ?>
              <tr class="">
                <td>
                  <?= $this->admin_model->getAdmin($response->created_by) ?>
                </td>
                <td>
                  <?= $response->response ?>
                <td>
                  <?= $response->created_at ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        </br>
        <?php if ($row->status != 4) { ?>
          <div class="col-lg-offset-3 col-lg-6">
            <!-- <a href="#myModal" data-toggle="modal" class="btn btn-primary" >Reply</a> -->
          </div>
          <div class="form">
            <form role="form" class="cmxform form-horizontal " id="commentForm"
              action="<?= base_url() ?>vendor/ticketVMTeamRespone" method="post" enctype="multipart/form-data">
              <input name="id" type="hidden" value="<?= base64_encode($id) ?>" readonly="">
              <div class="form-group">
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label" for="comment" required="">Comment</label>

                <div class="col-lg-6">
                  <textarea name="comment" id="comment"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-3"></div>
                <div class="col-lg-3"></div>
                <div class="col-lg-3"><button type="submit" class="btn btn-primary">Submit</button></div>

              </div>
            </form>
          </div>
        <?php } ?>
        </br></br>
      </div>
    </section>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        Ticket Log
      </header>

      <div class="panel-body">
        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
            <tr>
              <th>Username</th>
              <th>Ticket Status</th>
              <th>Created At</th>
            </tr>
            </tr>
          </thead>
          <tbody>
            <tr class="">
              <td>
                <?= $this->admin_model->getAdmin($row->created_by) ?>
              </td>
              <td><span class="badge badge-danger p-2" style="background-color: #fb0404">New</span></td>
              <td>
                <?= $row->created_at ?>
              </td>
            </tr>
            <?php foreach ($log as $log) { ?>
              <tr class="">
                <td>
                  <?= $this->admin_model->getAdmin($log->created_by) ?>
                </td>
                <td>
                  <?= $this->vendor_model->getTicketStatus($log->status) ?>
                </td>
                <td>
                  <?= $log->created_at ?>
                </td>
              </tr>
            <?php } ?>
            <tr>
              <td colspan="2">Time taken</td>
              <td>
                <?= $this->vendor_model->ticketTime($row->id) ?> H:M
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</div>