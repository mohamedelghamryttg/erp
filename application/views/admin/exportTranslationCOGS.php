<!DOCTYPE>
<html dir=ltr>

<head>
  <style>
    @media print {
      table {
        font-size: smaller;
      }

      thead {
        display: table-header-group;
      }

      table {
        page-break-inside: auto;
        width: 75%;
      }

      tr {
        page-break-inside: avoid;
        page-break-after: auto;
      }
    }

    table {
      border: 1px solid black;
      font-size: 18px;
    }

    table td {
      border: 1px solid black;
    }

    table th {
      border: 1px solid black;
    }

    .clr {
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
  <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
    <thead>
      <tr>
        <th>Job Name</th>
        <th>Job Code</th>
        <!-- <th>Volume</th> -->
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
          $translation_tasks = $this->db->select('task_type, unit, created_at, count,tm')->from('translation_request')->where(array('job_id' => $row->id, 'status' => 3))->get()->result();
          $totalRateTrans = 0;

          foreach ($translation_tasks as $trans) {
            $rateProductionTrans = $this->db->get_where('production_team_cost', array('task_type' => $trans->task_type, 'unit' => $trans->unit, 'year' => $year, 'team' => 1))->row()->rate;
            $rateTrnasfaredTrans = $this->accounting_model->transfareTotalToCurrencyRate(1, 2, $trans->created_at, $rateProductionTrans) * ($trans->count - $trans->tm);
            $totalRateTrans = $rateTrnasfaredTrans;
            //$totalRateTrans + $rateTrnasfaredTrans;

      ?>
            <tr>


              <!-- jobs -->

              <td><?= $row->name ?></td>
              <td><?= $row->code ?></td>
              <!-- <td>
                <?php if ($row->type == 1) { ?>
                  <?php echo $row->volume; ?>
                <?php } elseif ($row->type == 2) { ?>
                  <?php echo $total_revenue / $priceList->rate; ?>
                <?php } ?>
              </td> -->
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
      <?php
          }
        }
      } ?>
    </tbody>
  </table>
  </td>
  <!-- End LE Tasks -->
  </tr>
  </tbody>
  </table>
</body>

</html>