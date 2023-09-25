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
  <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
    <thead>
      <tr>
        <th>Job Name</th>
        <th>Job Code</th>
        <th>Total Revenue in $</th>
        <th>count</th>

        <th>Total Cost in $</th>
        <th>Task Type</th>
        <th>unit</th>
        <th>Source Language Direction</th>
        <th>Target Language Direction</th>
        <th>Start Date</th>
        <th>Delivery Date</th>
        <th>Issue Date</th>
        <th>Created By</th>

      </tr>
    </thead>
    <tbody>
      <?php
      if (isset($project)) {
        foreach ($project->result() as $row) {
          //         $priceList = $this->projects_model->getJobPriceListData($row->price_list);
          //         $jobTotal = $this->sales_model->calculateRevenueJob($row->id, $row->job_type, $row->job_volume, $priceList->id);
          //         $jobTotal = number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $row->created_at, $jobTotal), 2);
          //         $dateArray = explode("-", $row->created_at);
          //         $year = $dateArray[0];
          //         $rateProduction = $this->db->get_where('production_team_cost', array('unit' => $row->unit, 'year' => $year, 'team' => 2))->row()->rate;
          //         $rateTrnasfared = number_format($this->accounting_model->transfareTotalToCurrencyRate(1, 2, $row->created_at, $rateProduction), 6);

          $priceList = $this->projects_model->getJobPriceListData($row->price_list);
          $total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
          $year =  explode("-", $row->created_at)[0];

          $le_Tasks = $this->db->select('id')->from("le_request")->where(array('job_id' => $row->id, 'status' => 3))->get()->result();
          $totalRateLe = 0;
          foreach ($le_Tasks as $le_Task) {
            $le_Tasks_job = $this->db->select('volume,unit,created_at')->from("le_request_job")->where(array('request_id' => $le_Task->id))->get()->result();
            foreach ($le_Tasks_job as $le) {
              $rateProductionLe_r = $this->db->get_where('production_team_cost', array('unit' => $le->unit, 'year' => $year, 'team' => 2))->row();
              if ($rateProductionLe_r) {
                $rateProductionLe = $rateProductionLe_r->rate;
              } else {
                $rateProductionLe = 0;
              }
              if ($le->unit == '5' && $le->volume < 15) {
                $le->volume = 15;
              }
              $rateTrnasfaredLe = $this->accounting_model->transfareTotalToCurrencyRate(1, 2, $le->created_at, $rateProductionLe) * $le->volume;
              $totalRateLe = $totalRateLe + $rateTrnasfaredLe;

      ?>


              <tr>


                <!-- jobs -->

                <td style="white-space: normal;"><?= $row->name ?></td>
                <td><?= $row->code ?></td>

                <td><?php echo $total_revenue; ?></td>
                <td><?php echo $le->volume; ?></td>
                <td><?php echo number_format($rateTrnasfaredLe, 2); ?></td>

                <td><?php echo $this->admin_model->getTaskType($trans->task_type); ?></td>
                <td><?= $this->admin_model->getUnit($le->unit) ?></td>
                <td><?= $this->admin_model->getLanguage($priceList->source) ?></td>
                <td><?= $this->admin_model->getLanguage($priceList->target) ?></td>
                <td><?= $row->start_date ?></td>
                <td><?= $row->delivery_date ?></td>
                <td><?= $row->issue_date ?></td>
                <td><?= $this->admin_model->getAdmin($row->created_by) ?></td>


              </tr>


              </tr>
      <?php }
          }
        }
      } ?>
    </tbody>
  </table>
</body>

</html>