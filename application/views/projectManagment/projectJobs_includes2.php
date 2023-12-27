  <?php foreach ($tasks->result() as $row) {
        $task_ev_exists = $this->projects_model->checkTaskEvaluationExists($row->id);
        $project_id = $this->projects_model->getJobData($row->job_id)->project_id;
        $job_data = $this->projects_model->getJobData($row->job_id);
        $job_status = $job_data->status;
        if ($row->status == 1 &&  $task_ev_exists == false && $job_status == 0) {
    ?>
          <!-- Modal-->
          <div class="modal fade" id="evAddModal_<?= $row->id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Evaluation</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i aria-hidden="true" class="ki ki-close"></i>
                          </button>
                      </div>
                      <form class="cmxform form-horizontal " action="<?= base_url() ?>projectManagment/doAddVendorEvaluation" method="post" enctype="multipart/form-data">

                          <div class="modal-body">
                              <div class="form-group row">
                                  <label class="col-lg-3 col-form-label text-right">Rate </label>
                                  <div class="col-lg-9">
                                      <div class="slidecontainer">
                                          <input type="range" name="pm_ev_select" min="0" max="10" value="5" class="slider" id="myRange" oninput="this.nextElementSibling.value = this.value" style="display: inline-block;width: auto;"><output style="display: inline-block;position: relative;top: -25px;left: -11%;">5</output>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label class="col-lg-3 col-form-label text-right">Note </label>
                                  <div class="col-lg-9">
                                      <textarea name="pm_note" class="form-control" rows="5" cols="10"></textarea>
                                  </div>
                              </div>

                              <input type="hidden" name="job_id" value="<?= $row->job_id ?>">
                              <input type="hidden" name="project_id" value="<?= $project_id ?>">
                              <input type="hidden" name="task_id" value="<?= $row->id ?>">
                              <input type="hidden" name="vendor_id" value="<?= $row->vendor ?>">
                              <div class="bad_review"></div>

                          </div>
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-dark font-weight-bold">Save</button>
                              <button type="button" class="close_btn btn btn-default font-weight-bold" data-dismiss="modal">Close</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
          <!--end Modal-->
      <?php } elseif ($row->status == 1 && $task_ev_exists == true && $job_status == 0) {
            $task_ev = $this->db->get_where('task_evaluation', array('task_id' => $row->id))->row();
        ?>
          <!-- Modal-->
          <div class="modal fade" id="evEditModal_<?= $row->id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Update Evaluation</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i aria-hidden="true" class="ki ki-close"></i>
                          </button>
                      </div>
                      <form class="cmxform form-horizontal " action="<?= base_url() ?>projectManagment/doAddVendorEvaluation" method="post" enctype="multipart/form-data">

                          <div class="modal-body" id="body">
                              <div class="modal-body">
                                  <div class="form-group row">
                                      <label class="col-lg-3 col-form-label text-right">Rate </label>
                                      <div class="col-lg-9">
                                          <div class="slidecontainer">
                                              <input type="range" name="pm_ev_select" min="0" max="10" value="<?= $task_ev->pm_ev_select ?>" class="slider" id="myRange" oninput="this.nextElementSibling.value = this.value" style="display: inline-block;width: auto;"><output style="display: inline-block;position: relative;top: -25px;left: -11%;"><?= $task_ev->pm_ev_select ?></output>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <label class="col-lg-3 col-form-label text-right">Note </label>
                                      <div class="col-lg-9">
                                          <textarea class="form-control" name="pm_note" rows="5" cols="10"><?= $task_ev->pm_note ?></textarea>
                                      </div>
                                  </div>
                                  <input type="hidden" name="job_id" value="<?= $row->job_id ?>">
                                  <input type="hidden" name="project_id" value="<?= $project_id ?>">
                                  <input type="hidden" name="task_id" value="<?= $row->id ?>">
                                  <input type="hidden" name="vendor_id" value="<?= $row->vendor ?>">
                                  <div class="bad_review">
                                      <table style="width: 100%">
                                          <thead>
                                              <tr>
                                                  <th width='5%'></th>
                                                  <th>Items to be checked</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php for ($x = 1; $x <= 6; $x++) {
                                                    $pm_ev_text = "pm_ev_text" . $x;
                                                    $pm_ev_per = "pm_ev_per" . $x;
                                                    $pm_ev_val = "pm_ev_val" . $x;
                                                    if ($task_ev->$pm_ev_text != null) {
                                                ?>
                                                      <tr>
                                                          <td>
                                                              <input type="hidden" name="<?= "pm_ev_text" . $x ?>" value="<?= $task_ev->$pm_ev_text ?>">
                                                              <input type="hidden" name="<?= "pm_ev_per" . $x ?>" value="<?= $task_ev->$pm_ev_per  ?>">
                                                              <input type="checkbox" name="<?= "pm_ev_val" . $x ?>" value="1" <?= $task_ev->$pm_ev_val == 1 ? 'checked' : '' ?>>
                                                          </td>
                                                          <td width='50'><?= $task_ev->$pm_ev_text ?></td>
                                                      </tr>
                                              <?php }
                                                } ?>
                                          </tbody>
                                      </table>
                                  </div>

                              </div>

                          </div>
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-dark font-weight-bold">Save</button>
                              <button type="button" class="close_btn btn btn-default font-weight-bold" data-dismiss="modal">Close</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
          <!--end Modal-->
      <?php } elseif ($task_ev_exists == true && $job_status == 1) {
            $task_ev = $this->db->get_where('task_evaluation', array('task_id' => $row->id))->row();
        ?>
          <!-- Modal-->
          <div class="modal fade" id="evModal_<?= $row->id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Vendor Evaluation</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i aria-hidden="true" class="ki ki-close"></i>
                          </button>
                      </div>

                      <div class="modal-body" id="body">
                          <div class="modal-body">
                              <div class="form-group row">
                                  <label class="col-lg-3 col-form-label text-right">Rate </label>
                                  <div class="col-lg-9">
                                      <input type="text" class="form-control" readonly="" value="<?= $task_ev->pm_ev_select ?>" />

                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label class="col-lg-3 col-form-label text-right">Note </label>
                                  <div class="col-lg-9">
                                      <textarea class="form-control" name="pm_note" rows="5" cols="10" readonly=""><?= $task_ev->pm_note ?></textarea>
                                  </div>
                              </div>

                              <div class="bad_review">
                                  <table style="width: 100%">
                                      <tbody>
                                          <?php for ($x = 1; $x <= 6; $x++) {
                                                $pm_ev_text = "pm_ev_text" . $x;
                                                $pm_ev_per = "pm_ev_per" . $x;
                                                $pm_ev_val = "pm_ev_val" . $x;
                                                if ($task_ev->$pm_ev_text != null) {
                                            ?>
                                                  <tr>
                                                      <td>
                                                          <input type="checkbox" name="<?= "pm_ev_val" . $x ?>" value="1" <?= $task_ev->$pm_ev_val == 1 ? 'checked' : '' ?> readonly="">
                                                      </td>
                                                      <td width='50'><?= $task_ev->$pm_ev_text ?></td>
                                                  </tr>
                                          <?php }
                                            } ?>
                                      </tbody>
                                  </table>
                              </div>

                          </div>

                      </div>
                      <div class="modal-footer">
                          <button type="button" class="close_btn btn btn-default font-weight-bold" data-dismiss="modal">Close</button>
                      </div>

                  </div>
              </div>
          </div>
          <!--end Modal-->
  <?php }
    } ?>


  <?php if ($pm_setup != false) { ?>
      <div id="pm_setup" style="display:none">
          <table style="width: 100%">
              <thead>
                  <tr>
                      <th width='5%'></th>
                      <th>Items to be checked</th>
                  </tr>
              </thead>
              <tbody>
                  <?php for ($x = 1; $x <= 6; $x++) {
                        $pm_ev_name = "pm_ev_name" . $x;
                        $pm_ev_per = "pm_ev_per" . $x;
                        $pm_ev_val = "pm_ev_val" . $x;
                        if ($pm_setup->$pm_ev_name != null) {
                    ?>
                          <tr>
                              <td>
                                  <input type="hidden" name="<?= "pm_ev_text" . $x ?>" value="<?= $pm_setup->$pm_ev_name ?>">
                                  <input type="hidden" name="<?= "pm_ev_per" . $x ?>" value="<?= $pm_setup->$pm_ev_per  ?>">
                                  <input type="checkbox" name="<?= "pm_ev_val" . $x ?>" value="1">
                              </td>
                              <td width='50'><?= $pm_setup->$pm_ev_name ?></td>
                          </tr>
                  <?php }
                    } ?>
              </tbody>
          </table>
      </div>
  <?php } ?>