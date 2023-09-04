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
								<th>Name</th>
								<th>Source</th>
                                <th>Region</th>
                                <th>Country</th>
                                <th>Type</th>
                                <th>Assigned PM</th>
							</tr>
						</thead>
						
						<tbody>
						<?php
							foreach($branch->result() as $row)
								{
								$PmCustomer = $this->customer_model->customersPmRow($row->id);
						?>
									<tr class="">
										<td><?=$row->id?></td>
										<td><a href="<?=base_url()?>customer/leadContacts?t=<?=base64_encode($row->id)?>"><?php echo $this->customer_model->getCustomer($row->customer);?></a></td>
										<td><?php echo $row->source ;?></td>
										<td><?php echo $this->admin_model->getRegion($row->region) ;?></td>
										<td><?php echo $this->admin_model->getCountry($row->country) ;?></td>
										<td><?php echo $this->customer_model->getType($row->type) ;?></td>
										<td>
											<?php if($PmCustomer->num_rows() == 0){?>
											<?php if($permission->follow == 2){ ?>
											
											<?php } ?>
											<?php }else{ ?>
											<table style="border-collapse:collapse;">
                                            <tr><td style="border: 1px solid #ddd;">PM Name</td>
                                            <?php if($permission->follow == 2){ ?>
                                              <td style="border: 1px solid #ddd;"></td>
                                              <td style="border: 1px solid #ddd;"></td>
                                            <?php } ?>
                                            </tr>
                                            <?php 
                                         	$i=0;
                                      		$count=$PmCustomer->num_rows();
                                          foreach($PmCustomer->result() as $pm)
                                          {
                                              //echo $i;
                                              ?>
                                                <tr>
                                                    <td style="border: 1px solid #ddd;"><?php echo $this->admin_model->getAdmin($pm->pm);?></td>
                                                   <?php if($permission->follow == 2){ ?>
                                                  <td style="border: 1px solid #ddd;"><a href="<?php echo base_url()?>customer/deletePmCustomer?t=<?php echo base64_encode($pm->id); ?>"> 
                                                    <i class="fa fa-times text-danger text"></i> </a></td><?php } ?>
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
										</td>
									</tr>

									<!-- form of adding PM and brand to customer-->                                   
									
						<?php
								}
						?>		
						</tbody>
					</table>


				</body>
                    </html>