  <?php foreach ($job->result() as $row) {
        $priceList = $this->projects_model->getJobPriceListData($row->price_list);
        $qc_type = $this->projects_model->getQCTypeByService($priceList->service);
        $job_qc_exists = $this->projects_model->checkJobQC($row->id);
        if ($row->status == 0 && $qc_type != null && $job_qc_exists == false) { ?>

          <!-- Modal-->
          <div class="modal fade" id="qcModal_<?= $row->id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Q.C. Log</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i aria-hidden="true" class="ki ki-close"></i>
                          </button>
                      </div>
                      <form class="cmxform form-horizontal " action="<?= base_url() ?>projectManagment/doAddJobQC" method="post" enctype="multipart/form-data">

                          <div class="modal-body">
                              <input type="hidden" name="job_id" value="<?= $row->id ?>">
                              <input type="hidden" name="project_id" value="<?= $project_data->id ?>">
                              <input type="hidden" name="service_id" value="<?= $priceList->service ?>">
                              <input type="hidden" name="qc_type" value="<?= $qc_type ?>">
                              <!--if type = 1 file-->
                              <?php if ($qc_type == 1 || $qc_type == 3) { ?>
                                  <div class="form-group row">
                                      <label class="col-lg-3 col-form-label text-right">File</label>
                                      <div class="col-lg-9">
                                          <input type="file" class=" form-control mt-10" name="file" required accept='application/zip'>

                                      </div>
                                  </div>
                                  <?php }
                                if ($qc_type == 2 || $qc_type == 3) {
                                    $checkList = $this->db->get_where('services', array('id' => $priceList->service))->row();
                                    if (!empty($checkList)) { ?>
                                      <table style="width: 100%" class="table table-striped table-hover table-bordered">
                                          <thead>
                                              <tr>
                                                  <th>Category</th>
                                                  <th width='50'>Items to be checked</th>
                                                  <th>Y/N</th>
                                              </tr>
                                          </thead>
                                          <tbody>

                                              <?php for ($i = 1; $i <= 30; $i++) {
                                                    $inputCat = '';
                                                    $logCheck = "logcheck" . $i;
                                                    $logCheckCat = "logcheckg" . $i;
                                                    $logCheckCat = "logcheckg" . $i;
                                                    if (!empty($checkList->$logCheck)) {
                                                        $inputLabel = $checkList->$logCheck;
                                                        if (!empty($checkList->$logCheckCat))
                                                            $inputCat = $checkList->$logCheckCat; ?>
                                                      <tr>
                                                          <td><?= $this->projects_model->getQCCatName($inputCat) ?></td>
                                                          <td><?= $inputLabel ?></td>
                                                          <td>
                                                              <input type="hidden" name="<?= 'label_' . $logCheck ?>" value="<?= $inputLabel ?>" id="name" required>

                                                              <input type="radio" name="<?= $logCheck ?>" value='1' required> Y
                                                              <input type="radio" name="<?= $logCheck ?>" value='2' required> N
                                                          </td>
                                                      </tr>

                                                  <?php
                                                    }
                                                }
                                                for ($i = 1; $i <= 5; $i++) {
                                                    $inputCat = '';
                                                    $logCheckn = "logcheckn" . $i;
                                                    $logCheckng = "logcheckng" . $i;
                                                    if (!empty($checkList->$logCheckn)) {
                                                        $inputLabel = $checkList->$logCheckn;
                                                        if (!empty($checkList->$logCheckng)) {
                                                            $inputCat = $checkList->$logCheckng;
                                                        }
                                                    ?>
                                                      <tr>
                                                          <td><?= $this->projects_model->getQCCatName($inputCat) ?></td>
                                                          <td><?= $inputLabel ?></td>
                                                          <td>
                                                              <input type="hidden" name="<?= 'label_' . $logCheckn ?>" value="<?= $inputLabel ?>" id="name" required>
                                                              <input type="text" class=" form-control" name="<?= $logCheckn ?>" id="name" required>

                                                          </td>
                                                      </tr>

                                              <?php
                                                    }
                                                } ?>
                                          </tbody>
                                      </table>
                              <?php }
                                } ?>
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
      <?php } elseif ($row->status == 0 && $qc_type != null && $job_qc_exists == true) {
            $qcData = $this->db->get_where('job_qc', array('job_id' => $row->id))->row();
        ?>
          <!-- Modal-->
          <div class="modal fade" id="qcEditModal_<?= $row->id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Update Q.C. Log</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i aria-hidden="true" class="ki ki-close"></i>
                          </button>
                      </div>
                      <form class="cmxform form-horizontal " action="<?= base_url() ?>projectManagment/doAddJobQC" method="post" enctype="multipart/form-data">

                          <div class="modal-body" id="body">
                              <input type="hidden" name="job_id" value="<?= $row->id ?>">
                              <!--if type = 1 file-->
                              <?php if ($qcData->qc_type == 1 || $qcData->qc_type == 3) { ?>
                                  <div class="form-group row">
                                      <label class="col-lg-1 col-form-label text-right">File</label>
                                      <div class="col-lg-9">
                                          <input type="file" class=" form-control mt-10" name="file" accept='application/zip'>

                                      </div>
                                      <?php if (strlen($qcData->file) > 1) { ?>
                                          <div class="col-lg-1">
                                              <a class='btn btn-dark' href="<?= base_url() ?>assets/uploads/jobQc/<?= $qcData->file ?>" target="_blank">View File</a>
                                          </div>
                                      <?php } ?>
                                  </div>
                              <?php }
                                if ($qcData->qc_type == 2 || $qcData->qc_type == 3) {
                                    $checkList = $this->db->get_where('services', array('id' => $priceList->service))->row();
                                ?>
                                  <table style="width: 100%" class="table table-striped table-hover table-bordered">
                                      <thead>
                                          <tr>
                                              <th width='50'>Items to be checked</th>
                                              <th>Y/N</th>
                                          </tr>
                                      </thead>
                                      <tbody>

                                          <?php for ($i = 1; $i <= 30; $i++) {
                                                $logCheck = "logcheck" . $i;
                                                $logcheck_value = "logcheck_value" . $i;
                                                if (!empty($qcData->$logCheck)) {
                                                    $inputLabel = $qcData->$logCheck;
                                                    $inputvalue = $qcData->$logcheck_value;
                                            ?>
                                                  <tr>
                                                      <td><?= $inputLabel ?></td>
                                                      <td>
                                                          <input type="hidden" name="<?= 'label_' . $logCheck ?>" value="<?= $inputLabel ?>" id="name" required>
                                                          <input type="radio" name="<?= $logCheck ?>" value='1' <?= $inputvalue == 1 ? 'checked' : '' ?> required> Y
                                                          <input type="radio" name="<?= $logCheck ?>" value='2' <?= $inputvalue == 2 ? 'checked' : '' ?> required> N
                                                      </td>
                                                  </tr>

                                              <?php
                                                }
                                            }
                                            for ($i = 1; $i <= 5; $i++) {
                                                $x = $i + 30;
                                                $logCheckn = "logcheckn" . $i;
                                                $logCheck = "logcheck" . $x;
                                                $logcheck_value = "logcheck_value" . $x;
                                                if (!empty($qcData->$logCheck)) {
                                                    $inputLabel = $qcData->$logCheck;
                                                    $inputvalue = $qcData->$logcheck_value;
                                                ?>
                                                  <tr>
                                                      <td><?= $inputLabel ?></td>
                                                      <td>
                                                          <input type="hidden" name="<?= 'label_' . $logCheckn ?>" value="<?= $inputLabel ?>" id="name" required>
                                                          <input type="text" class=" form-control" name="<?= $logCheckn ?>" id="name" value='<?= $inputvalue ?>' required>

                                                      </td>
                                                  </tr>

                                          <?php
                                                }
                                            } ?>
                                      </tbody>
                                  </table>
                              <?php } ?>
                          </div>
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-dark font-weight-bold">Save</button>
                              <button type="button" class="close_btn btn btn-default font-weight-bold" data-dismiss="modal">Close</button>
                              <button type="button" id='btn_<?= $row->id ?>' class="qc_default btn btn-danger font-weight-bold">Retrieve Default</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
          <!--end Modal-->
      <?php } elseif ($row->status == 1 && $qc_type != null && $job_qc_exists == true) {
            $qcData = $this->db->get_where('job_qc', array('job_id' => $row->id))->row();
        ?>
          <!-- Modal-->
          <div class="modal fade" id="qcListModal_<?= $row->id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Q.C. Log</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i aria-hidden="true" class="ki ki-close"></i>
                          </button>
                      </div>
                      <div class="modal-body" id="body">
                          <!--if type = 1 file-->
                          <?php if ($qcData->qc_type == 1 || $qcData->qc_type == 3) { ?>
                              <div class="form-group row">
                                  <?php if (strlen($qcData->file) > 1) { ?>
                                      <a href="<?= base_url() ?>assets/uploads/jobQc/<?= $qcData->file ?>" target="_blank" class='text-dark text-bold'>View File</a>

                                  <?php } ?>
                              </div>
                          <?php }
                            if ($qcData->qc_type == 2 || $qcData->qc_type == 3) {
                            ?>
                              <table style="width: 100%" class="table table-striped table-hover table-bordered">
                                  <thead>
                                      <tr>
                                          <th width='50'>Items to be checked</th>
                                          <th>Y/N</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                      <?php for ($i = 1; $i <= 30; $i++) {
                                            $logCheck = "logcheck" . $i;
                                            $logcheck_value = "logcheck_value" . $i;
                                            if (!empty($qcData->$logCheck)) {
                                                $inputLabel = $qcData->$logCheck;
                                                $inputvalue = $qcData->$logcheck_value;
                                        ?>
                                              <tr>
                                                  <td><?= $inputLabel ?></td>
                                                  <td>
                                                      <input type="radio" name="<?= $logCheck ?>" value='1' <?= $inputvalue == 1 ? 'checked' : '' ?> disabled=""> Y
                                                      <input type="radio" name="<?= $logCheck ?>" value='2' <?= $inputvalue == 2 ? 'checked' : '' ?> disabled> N
                                                  </td>
                                              </tr>

                                          <?php
                                            }
                                        }
                                        for ($i = 1; $i <= 5; $i++) {
                                            $x = $i + 30;
                                            $logCheckn = "logcheckn" . $i;
                                            $logCheck = "logcheck" . $x;
                                            $logcheck_value = "logcheck_value" . $x;
                                            if (!empty($qcData->$logCheck)) {
                                                $inputLabel = $qcData->$logCheck;
                                                $inputvalue = $qcData->$logcheck_value;
                                            ?>
                                              <tr>
                                                  <td><?= $inputLabel ?></td>
                                                  <td>
                                                      <input type="text" class=" form-control" name="<?= $logCheckn ?>" id="name" value='<?= $inputvalue ?>' readonly>

                                                  </td>
                                              </tr>
                                      <?php
                                            }
                                        } ?>
                                  </tbody>
                              </table>
                          <?php } ?>
                      </div>
                      <div class="modal-footer">

                          <button type="button" class="close_btn btn btn-default font-weight-bold" data-dismiss="modal">Close</button>
                      </div>
                  </div>
              </div>
          </div>
          <!--end Modal-->
      <?php } ?>
      <div id="default_<?= $row->id ?>" style='display:none'>
          <input type="hidden" name="job_id" value="<?= $row->id ?>">
          <input type="hidden" name="project_id" value="<?= $project_data->id ?>">
          <input type="hidden" name="service_id" value="<?= $priceList->service ?>">
          <input type="hidden" name="qc_type" value="<?= $qc_type ?>">
          <!--if type = 1 file-->
          <?php if ($qc_type == 1 || $qc_type == 3) { ?>
              <div class="form-group row">
                  <label class="col-lg-3 col-form-label text-right">File</label>
                  <div class="col-lg-9">
                      <input type="file" class=" form-control mt-10" name="file" required accept='application/zip'>

                  </div>
              </div>
              <?php }
            if ($qc_type == 2 || $qc_type == 3) {
                $checkList = $this->db->get_where('services', array('id' => $priceList->service))->row();
                if (!empty($checkList)) { ?>
                  <table style="width: 100%" class="table table-striped table-hover table-bordered">
                      <thead>
                          <tr>
                              <th>Category</th>
                              <th width='50'>Items to be checked</th>
                              <th>Y/N</th>
                          </tr>
                      </thead>
                      <tbody>

                          <?php for ($i = 1; $i <= 30; $i++) {
                                $inputCat = '';
                                $logCheck = "logcheck" . $i;
                                $logCheckCat = "logcheckg" . $i;
                                $logCheckCat = "logcheckg" . $i;
                                if (!empty($checkList->$logCheck)) {
                                    $inputLabel = $checkList->$logCheck;
                                    if (!empty($checkList->$logCheckCat))
                                        $inputCat = $checkList->$logCheckCat; ?>
                                  <tr>
                                      <td><?= $this->projects_model->getQCCatName($inputCat) ?></td>
                                      <td><?= $inputLabel ?></td>
                                      <td>
                                          <input type="hidden" name="<?= 'label_' . $logCheck ?>" value="<?= $inputLabel ?>" id="name" required>

                                          <input type="radio" name="<?= $logCheck ?>" value='1' required> Y
                                          <input type="radio" name="<?= $logCheck ?>" value='2' required> N
                                      </td>
                                  </tr>

                              <?php
                                }
                            }
                            for ($i = 1; $i <= 5; $i++) {
                                $inputCat = '';
                                $logCheckn = "logcheckn" . $i;
                                $logCheckng = "logcheckng" . $i;
                                if (!empty($checkList->$logCheckn)) {
                                    $inputLabel = $checkList->$logCheckn;
                                    if (!empty($checkList->$logCheckng)) {
                                        $inputCat = $checkList->$logCheckng;
                                    }
                                ?>
                                  <tr>
                                      <td><?= $this->projects_model->getQCCatName($inputCat) ?></td>
                                      <td><?= $inputLabel ?></td>
                                      <td>
                                          <input type="hidden" name="<?= 'label_' . $logCheckn ?>" value="<?= $inputLabel ?>" id="name" required>
                                          <input type="text" class=" form-control" name="<?= $logCheckn ?>" id="name" required>

                                      </td>
                                  </tr>

                          <?php
                                }
                            } ?>
                      </tbody>
                  </table>
          <?php }
            } ?>
      </div>

  <?php } ?>