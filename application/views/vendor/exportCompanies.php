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
        <th>Company Name</th>
        <th>Email</th>
        <th>Country</th>
        <th>Region</th>
        <th>Comment</th>
        <th>Edit</th>
        <th>Delete</th>

      </tr>
    </thead>
    <tbody>
      <?php
      if ($companies->num_rows() > 0) {
        foreach ($companies->result() as $row) {
          ?>
          <tr class="">
            <td>
              <?php echo $row->id; ?>
            </td>
            <td>
              <?php echo $row->name; ?>
            </td>
            <td>
              <?php echo $row->email; ?>
            </td>
            <td>
              <?php echo $this->admin_model->getCountry($row->country); ?>
            </td>
            <td>
              <?php echo $this->admin_model->getRegion($row->region); ?>
            </td>
            <td>
              <?php echo $row->comment; ?>
            </td>
          </tr>
          <?php
        }
      } else {
        ?>
      <tr>
        <td colspan="7">There is no Companies to list</td>
      </tr>
      <?php
      }
      ?>
    </tbody>

  </table>
</body>

</html>