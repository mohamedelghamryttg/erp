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
        <th>Source Language Direction</th>
        <th>Target Language Direction</th>
        <th>Total Revenue in $</th>
        <th>count</th>
        <th>Total Cost in $</th>
        <th>unit</th>
        <th>Created By</th>


      </tr>
    </thead>
    <tbody>
      <?php
      if (isset($project)) {
        foreach ($project->result() as $row) {
          $priceList = $this->projects_model->getJobPriceListData($row->price_list);
          $jobTotal = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
          $jobTotal = number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $row->created_at, $jobTotal), 2);
          $dateArray = explode("-", $row->created_at);
          $year = $dateArray[0];

          $dtp_tasks = $this->db->get_where('dtp_request', array('job_id' => $row->id))->result();
          $totalRate = 0;
          $totval = 0;
          $unit = '';
          foreach ($dtp_tasks as $dtp) {
            $rateProduction = $this->db->get_where('production_team_cost', array('unit' => $dtp->unit, 'year' => $year, 'brand' => $this->brand, 'team' => 3))->row()->rate;
            $rateTrnasfared = $this->accounting_model->transfareTotalToCurrencyRate(1, 2, $row->created_at, $rateProduction) * $dtp->volume;
            $totval = $totval + $dtp->volume;
            $unit =  $dtp->unit;
            $totalRate = $totalRate + $rateTrnasfared;
          }
      ?>
          <tr>


            <!-- jobs -->
            <td><?= $row->name ?></td>
            <td><?= $row->code ?></td>
            <td><?= $this->admin_model->getLanguage($priceList->source) ?></td>
            <td><?= $this->admin_model->getLanguage($priceList->target) ?></td>
            <td><?php echo $jobTotal; ?></td>
            <td><?php echo $totval; ?></td>

            <td><?php echo number_format($totalRate, 2); ?></td>
            <td><?= $this->admin_model->getUnit($unit) ?></td>
            <td><?= $this->admin_model->getAdmin($row->created_by) ?></td>


          </tr>
          <!-- End DTP Tasks -->

          </tr>
      <?php }
      } ?>
    </tbody>
  </table>
</body>

</html>