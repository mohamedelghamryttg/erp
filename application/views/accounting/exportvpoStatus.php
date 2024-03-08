<!DOCTYPE>
<html dir=ltr>

<head>
  <style>
    @media print {
      table {
        font-size: smaller;
      }

      /* thead {
        display: table-header-group;
      }

      table {
        page-break-inside: auto;
        width: 75%;
      }

      tr {
        page-break-inside: avoid;
        page-break-after: auto;
      } */
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
  <table class="table">
    <thead>
      <tr>
        <th>PM Name</th>
        <th>P.O Number</th>
        <th>VPO Status</th>
        <th>VPO Date</th>

        <th>CPO Verified</th>
        <th>CPO Verified Date</th>

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
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $vpo_status = ["Running", "Delivered", "Cancelled", "Rejected", "Waiting Vendor Acceptance", "Waiting PM Confirmation", "Not Started Yet", "Heads Up", "Heads Up ( Marked as Available )", "Heads Up ( Marked as Not Available )"];
      foreach ($task->result() as $row) { ?>
        <tr>
          <td><?= $row->user_name; ?></td>
          <td><?= $row->code ?></td>
          <td><?= (($row->status != null) ? $vpo_status[$row->status] : ''); ?></td>
          <td><?= $row->closed_date; ?></td>
          <td><?= $row->po_verified; ?></td>
          <td><?= $row->po_verified_at; ?></td>
          <td><?= $row->vendor_name; ?></td>
          <td><?= $row->source_lang; ?></td>
          <td><?= $row->target_lang; ?></td>
          <td><?= $row->task_type_name; ?></td>
          <td><?= $row->count; ?></td>
          <td><?= $row->unit_name; ?></td>
          <td><?= $row->rate; ?></td>
          <td><?= $row->currency_name; ?></td>
          <td><?= $row->totalamount; ?></td>
          <td><?= $row->verifiedStat ?></td>
          <td><?= $row->invoice_dated; ?></td>
          <td><?= $row->date45; ?></td>
          <td><?= $row->date60; ?></td>
          <td><?= $row->PaidStat ?></td>
          <td><?= $row->payment_date; ?></td>

          <td><?= $row->payment_method_name; ?></td>
          <td><?= $row->portalStat; ?></td>

        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>

</html>