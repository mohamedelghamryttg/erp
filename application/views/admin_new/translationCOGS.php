<?php if ($this->session->flashdata('true')) { ?>
  <div class="alert alert-success" role="alert">
    <span class="fa fa-check-circle"></span>
    <span><strong><?= $this->session->flashdata('true') ?></strong></span>
  </div>
<?php  } ?>
<?php if ($this->session->flashdata('error')) { ?>
  <div class="alert alert-danger" role="alert">
    <span class="fa fa-warning"></span>
    <span><strong><?= $this->session->flashdata('error') ?></strong></span>
  </div>
<?php  } ?>
<!--begin::Content-->

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">


  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">


      <!-- start search form card -->
      <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
          <h3 class="card-title">Search</h3>
        </div>

        <form class="form" id="translationCOGS" method="get" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group row">
              <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date From</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
              </div>

              <label class="col-lg-2 col-form-label text-lg-right" for="role date">Date To</label>
              <div class="col-lg-3">
                <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
              </div>
            </div>


            <div class="card-footer">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                  <button class="btn btn-success mr-2" name="search" onclick="var e2 = document.getElementById('translationCOGS'); e2.action='<?= base_url() ?>report/translationCOGS'; e2.submit();" type="submit">Search</button>
                  <button class="btn btn-secondary" onclick="var e2 = document.getElementById('translationCOGS'); e2.action='<?= base_url() ?>report/exportTranslationCOGS'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
                  <a href="<?= base_url() ?>report/translationCOGS" class="btn btn-warning"><i class="la la-trash"></i>Clear Filter</a>

                </div>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- end search form -->

    <!--begin::Card-->
    <div class="card">
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
          <h3 class="card-label">Translation COGS Report</h3>
        </div>

      </div>
      <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
          <thead>
            <tr>
              <th>Job Name</th>
              <th>Job Code</th>
              <th>Volume</th>
              <th>Count</th>
              <th>Total Revenue in $</th>
              <th>Total Cost in $</th>
              <th>Task Type</th>
              <th>Unit</th>
              <th>Source Language Direction</th>
              <th>Target Language Direction</th>
              <th>Start Date</th>
              <th>Delivery Date</th>
              <th>issue_date</th>
              <th>Created By</th>

            </tr>
          </thead>
          <tbody>

            <?php
            if (isset($project)) {
              foreach ($project->result() as $row) {
                $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                $total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
                $year =  explode("-", $row->created_at)[0];
                //Translation
                $translation_tasks = $this->db->select('task_type, unit, created_at, count')->from('translation_request')->where(array('job_id' => $row->id, 'status' => 3))->get()->result();
                $totalRateTrans = 0;
                foreach ($translation_tasks as $trans) {
                  $rateProductionTrans = $this->db->get_where('production_team_cost', array('task_type' => $trans->task_type, 'unit' => $trans->unit, 'year' => $year, 'team' => 1))->row()->rate;
                  $rateTrnasfaredTrans = number_format($this->accounting_model->transfareTotalToCurrencyRate(1, 2, $trans->created_at, $rateProductionTrans), 2) * ($trans->count - $trans->tm);
                  $totalRateTrans = $totalRateTrans + $rateTrnasfaredTrans;

            ?>
                  <tr>


                    <!-- jobs -->

                    <td><?= $row->name ?></td>
                    <td><?= $row->code ?></td>
                    <td>
                      <?php if ($row->type == 1) { ?>
                        <?php echo $row->volume; ?>
                      <?php } elseif ($row->type == 2) { ?>
                        <?php echo $total_revenue / $priceList->rate; ?>
                      <?php } ?>
                    </td>
                    <td><?php echo ($trans->count - $trans->tm); ?> </td>

                    <td><?php echo $total_revenue; ?></td>
                    <td><?php echo number_format($totalRateTrans, 2); ?></td>


                    <!--DTP Task -->


                    <td><?php echo $this->admin_model->getTaskType($trans->task_type); ?></td>
                    <td><?= $this->admin_model->getUnit($trans->unit) ?></td>
                    <td><?= $this->admin_model->getLanguage($priceList->source) ?></td>
                    <td><?= $this->admin_model->getLanguage($priceList->target) ?></td>

                    <td><?= $row->start_date ?></td>
                    <td><?= $row->delivery_date ?></td>
                    <td><?= $row->issue_date ?></td>
                    <td><?= $this->admin_model->getAdmin($trans->created_by) ?></td>

                  </tr>
                  <!-- End DTP Tasks -->

                  </tr>
            <?php }
              }
            } ?>
          </tbody>
        </table>
        <!--end: Datatable-->
        <!--begin::Pagination-->
        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <?= $this->pagination->create_links() ?>
        </div>
        <!--end:: Pagination-->
      </div>
    </div>
    <!--end::Card-->
  </div>
  <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->