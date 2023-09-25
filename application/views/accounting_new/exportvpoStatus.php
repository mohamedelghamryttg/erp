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
  <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
    <thead>
      <tr>
        <th>PM Name</th>
        <th>P.O Number</th>
        <th>VPO Status</th>
        <th>CPO Verified</th>
        <th>CPO Verified Date</th>
        <th>VPO Date</th>
        <th>Vendor Name</th>
        <th>Source Language</th>
        <th>Target Language</th>
        <th>Task Type</th>
        <th>Count</th>
        <th>Unit</th>
        <th>Rate</th>
        <th>Currency</th>
        <th>P.O Amount</th>
        <th>Invoice Status</th>
        <th>Invoice Date</th>
        <th>Due Date (45 Days)</th>
        <th>Max Due Date (60 Days)</th>
        <th>Payment Status</th>
        <th>Payment Date</th>
        <th>Payment Method</th>
        <th>System</th>
        <th>VPO File</th>
      </tr>
    </thead>
    <tbody>
      <?php
      //$vpo_status=["Running","Delivered","Canceled"];
      $vpo_status = ["Running", "Delivered", "Cancelled", "Rejected", "Waiting Vendor Acceptance", "Waiting PM Confirmation", "Not Started Yet", "Heads Up", "Heads Up ( Marked as Available )", "Heads Up ( Marked as Not Available )"];

      if (isset($task)) {
        foreach ($task as $row) {
      ?>
          <tr>
            <td><?php echo $row->user_name; ?></td>
            <td><?= $row->code ?></td>
            <td><?php echo $vpo_status[$row->status]; ?></td>
            <td><?php if ($row->po_verified == 1) {
                  echo "Verified";
                } else {
                  echo "";
                } ?></td>
            <td><?php if ($row->po_verified == 1) {
                  echo $row->po_verified_at;
                } else {
                  echo "";
                } ?></td>
            <td><?php echo $row->closed_date; ?></td>
            <td><?php echo $row->vendor_name; ?></td>
            <td><?php echo $row->source_lang; ?></td>
            <td><?php echo $row->target_lang; ?></td>
            <td><?php echo $row->task_type_name; ?></td>
            <td><?php echo $row->count; ?></td>
            <td><?php echo $row->unit_name; ?></td>
            <td><?php echo $row->rate; ?></td>
            <td><?php echo $row->currency_name; ?></td>
            <td><?php echo $row->rate * $row->count; ?></td>
            <td><?= $this->accounting_model->getPOStatus($row->verified) ?></td>
            <td><?php echo $row->invoice_date; ?></td>
            <td><?php if ($row->verified == 1) {
                  echo date("Y-m-d", strtotime($row->invoice_date . " +45 days"));
                } ?></td>
            <td><?php if ($row->verified == 1) {
                  echo date("Y-m-d", strtotime($row->invoice_date . " +60 days"));
                } ?></td>
            <td><?php if (!empty($row->payment_status) && $row->payment_status == 1) {
                  echo "Paid";
                } else {
                  echo "Not Paid";
                } ?></td>
            <td><?php if (!empty($row->payment_date)) {
                  echo $row->payment_date;
                } ?></td>
            <td><?php if (!empty($row->payment_method_name)) {
                  echo $row->payment_method_name;
                } ?></td>
            <td> <?php if ($row->job_portal == 1) { ?>
                Nexus System
              <?php } ?>
            </td>
            <td><?php if (strlen($row->vpo_file) > 1) { ?>
                Yes
              <?php } else { ?>
                No
              <?php } ?>
            </td>
          </tr>
      <?php }
      } ?>

    </tbody>
  </table>
</body>

</html>