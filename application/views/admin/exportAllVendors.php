<!DOCTYPE ><html dir=rtl>
    <head>
<style>
@media print {
table {font-size: smaller; }
thead {display: table-header-group; }
table { page-break-inside:auto; width:75%; }
tr { page-break-inside:avoid; page-break-after:auto; }
}
table {
  border: 1px solid black;
  font-size:18px;
}
table td {
  border: 1px solid black;
}
table th {
  border: 1px solid black;
}
.clr{
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
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Source Language</th>
            <th>Target Language</th>
            <th>Dialect</th>
            <th>Service</th>
            <th>Task Type</th>
            <th>Unit</th>
            <th>Rate</th>
            <th>Currency</th>
            <th>Tools</th>
			<th>Num. Of Tasks</th>
            <th>Subject Matter</th>
            <th>FeedBack (General)</th>
            <th>FeedBack (Quality)</th>
            <th>FeedBack (Communication)</th>
            <th>FeedBack (Commitment)</th>
            <th>Profile</th>
            <th>Brand</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if($row){
            foreach ($row as $row) {
        ?>
        <tr class="gradeX">
            <td><?=$this->vendor_model->getVendorName($row->vendor)?></td>
            <td><?=$row->email?></td>
            <td><?=$row->contact?></td>
            <td><?=$this->admin_model->getLanguage($row->source_lang)?></td>
            <td><?=$this->admin_model->getLanguage($row->target_lang)?></td>
            <td><?=$row->dialect?></td>
            <td><?=$this->admin_model->getServices($row->service)?></td>
            <td><?=$this->admin_model->getTaskType($row->task_type)?></td>
            <td><?=$this->admin_model->getUnit($row->unit)?></td>
            <td><?=$row->rate?></td>
            <td><?=$this->admin_model->getCurrency($row->currency)?></td>
            <td><?=$row->tools?></td>
          <td><?= $this->vendor_model->getVendorTaskCount($row->vendor); ?>	</td>
            <td><?=$row->subject?></td>
            <td><?=$row->general?></td>
            <td><?=$row->quality?></td>
            <td><?=$row->communication?></td>
            <td><?=$row->commitment?></td>
            <td><?=$row->profile?></td>
            <td><?php echo $this->admin_model->getBrand($row->brand) ;?></td>
            <!-- <td><?=$row->id?></td>
            <td><?=$row->vendor?></td>
            <td><?=$this->vendor_model->getVendorName($row->vendor)?></td>
            <td><?=$row->source_lang?></td>
            <td><?=$row->target_lang?></td>
            <td><?=$row->dialect?></td>
            <td><?=$row->service?></td>
            <td><?=$row->task_type?></td>
            <td><?=$row->unit?></td>
            <td><?=$row->rate?></td>
            <td><?=$row->currency?></td>
            <td><?php echo $this->admin_model->getBrand($row->brand) ;?></td> -->
        </tr>
        <?php }} ?>
    </tbody>
</table>
</body>
</html>