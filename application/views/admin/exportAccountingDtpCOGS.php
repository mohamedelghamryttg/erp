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
        <th>unit</th>
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
          //dtp
          $dtp_tasks = $this->db->select('volume,unit,created_at')->from('dtp_request')->where(array('job_id' => $row->id))->get()->result();
          $totalRateDtp = 0;
          foreach ($dtp_tasks as $dtp) {
            $rateProductionDtp_r = $this->db->get_where('production_team_cost', array('unit' => $dtp->unit, 'brand' => $this->brand, 'year' => $year, 'team' => 3))->row();
            if ($rateProductionDtp_r) {
              $rateProductionDtp = $rateProductionDtp_r->rate;
            } else {
              $rateProductionDtp = 0;
            }
            $rateTrnasfaredDtp = $this->accounting_model->transfareTotalToCurrencyRate(1, 2, $dtp->created_at, $rateProductionDtp) * $dtp->volume;
            $totalRateDtp = $rateTrnasfaredDtp;
            //$totalRateDtp + $rateTrnasfaredDtp;

      ?>
            <tr>


              <!-- jobs -->
              <td><?= $row->name ?></td>
              <td><?= $row->code ?></td>

              <td><?php echo $total_revenue; ?></td>
              <td><?php echo $dtp->volume; ?></td>
              <td><?php echo number_format($rateTrnasfaredDtp, 2); ?></td>


              <td><?= $this->admin_model->getUnit($dtp->unit) ?></td>
              <td><?= $this->admin_model->getLanguage($priceList->source) ?></td>
              <td><?= $this->admin_model->getLanguage($priceList->target) ?></td>
              <td><?= $row->start_date ?></td>
              <td><?= $row->delivery_date ?></td>
              <td><?= $row->issue_date ?></td>
              <td><?= $this->admin_model->getAdmin($row->created_by) ?></td>

            </tr>
            <!-- End DTP Tasks -->

            </tr>
      <?php }
        }
      } ?>
    </tbody>
  </table>
</body>

</html>