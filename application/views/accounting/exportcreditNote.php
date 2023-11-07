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
        <th>ID</th>
        <th>Credit Note Type</th>
        <th>Customer</th>
        <th>Issue_date</th>
        <th>PM Name</th>
        <th>PO Number</th>
        <th>Invoice Number</th>
        <th>POs</th>
        <th>Amount</th>
        <th>Currency</th>

        <th>Status</th>
        <th>Approved/Reject By</th>
        <th>Approved/Reject At</th>
        <th>Status By</th>
        <th>Status At</th>
        <th>Created By</th>
        <th>Created At</th>

      </tr>
    </thead>
    <tbody>
      <?php if (isset($creditNote)) {
        foreach ($creditNote->result() as $row) {
      ?>
          <tr>
            <td><?= $row->id ?></td>
            <td><?= $this->accounting_model->getCreditNoteType($row->type) ?></td>
            <td><?php echo $this->customer_model->getCustomer($row->customer); ?></td>
            <td><?= $row->issue_date ?></td>
            <td><?= $this->admin_model->getAdmin($row->pm) ?></td>
            <td><?= $row->number ?></td>
            <td><?= $this->accounting_model->getCreditNoteInvoice($row->number) ?></td>
            <td><?php if ($row->type == 2 || $row->type == 3) {
                  echo $this->accounting_model->getSelectedPOs($row->pos);
                } ?></td>
            <td><?= $row->amount ?></td>
            <td><?= $this->admin_model->getCurrency($row->currency) ?></td>
            <td><?= $this->accounting_model->getCreditNoteStatus($row->status) ?></td>
            <td><?= $this->admin_model->getAdmin($row->approved_by); ?></td>
            <td><?= $row->approved_at ?></td>
            <td><?= $this->admin_model->getAdmin($row->status_by); ?></td>
            <td><?= $row->status_at ?></td>
            <td><?= $this->admin_model->getAdmin($row->created_by); ?></td>
            <td><?= $row->created_at ?></td>


          </tr>
      <?php }
      } ?>
    </tbody>
  </table>
</body>

</html>