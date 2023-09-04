<!DOCTYPE ><html dir=ltr>
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
	<table class="table table-striped table-hover table-bordered">
						<thead>
								<tr>
								<th>ID</th>
								<th>customerID</th>
								<th>Name</th>
                                <th>Source</th>
		                        <th>Region</th>
                                <th>Country</th>
                                <th>Type</th>
                                <th>Assigned SAM</th>
                                <th>Status</th>
                                <th>Approved</th>
                                <th>Created By</th>
                                <th>Created At</th>

							</tr>
						</thead>
						
						<tbody>
                        <?php
                            foreach($leads->result() as $row)
                                {
                                $SamCustomer = $this->customer_model->customersSam($row->id);
                        ?>
                                    <tr class="">
                                        <td><?=$row->id?></td>
                                    	<td><?=$row->customer?></td>
                                        <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                                        <td><?php echo $row->source ;?></td>
                                        <td><?php echo $this->admin_model->getRegion($row->region) ;?></td>
                                        <td><?php echo $this->admin_model->getCountry($row->country) ;?></td>
                                        <td><?php echo $this->customer_model->getType($row->type) ;?></td>
                                        <td id="SamTable_<?=$row->id?>">
                                        <?php if($row->approved == 1){ ?>
                                            <?php if($SamCustomer->num_rows() == 0){?>
                                            <!-- <?php if($permission->follow == 2){ ?> -->
<!--                                             <a href="#myModal<?php echo $row->id ;?>" data-toggle="modal" class="btn btn-success" >Assign SAM</a>
                                            <?php } ?> -->
                                            <?php }else{ ?>
                                            <table style="border-collapse:collapse;">
<!--                                             <?php if($permission->follow == 2){ ?>
                                              <td style="border: 1px solid #ddd;"></td>
                                              <td style="border: 1px solid #ddd;"></td>
                                            <?php } ?> -->
                                            <?php 
                                            $i=0;
                                            $count=$SamCustomer->num_rows();
                                          foreach($SamCustomer->result() as $sam)
                                          {
                                              //echo $i;
                                              ?>
                                                <tr>
                                                    <td style="border: 1px solid #ddd;"><?php echo $this->admin_model->getAdmin($sam->sam);?></td>
                                                  
                                              <?php if( $i < 1)
                                                {
                                              ?>
                                             
                                            <?php }
                                              ?>
                                          </tr>
                                             <?php 
                                        $i=$i+1;
                                        } ?>       
                                        </table>
                                            <?php } ?>
                                        <?php } ?>
                                        </td>
                                        <td><?php echo $this->customer_model->getStatus($row->status) ;?></td>
                                        <td><?php if($row->approved == 1){echo "Yes";}elseif($row->approved == 2){echo "No";}?></td>
                                        <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                                        <td><?=$row->created_at?></td>
 
                                        
                                    </tr>
                        <?php
                                }
                        ?>      
                        </tbody>
					</table>
					</body>
                    </html>