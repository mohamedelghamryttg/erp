   <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                  <th>ID</th>
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
                  <th>Edit</th>
                  <th>Delete</th>
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
                                        <td><a href="<?=base_url()?>customer/leadContacts?t=<?=base64_encode($row->id)?>"><?php echo $this->customer_model->getCustomer($row->customer);?></a></td>
                                        <?php if(is_numeric($row->source)){ ?>
                                          <td><?php echo $this->customer_model->getSource($row->source);?></td>
                                        <?php }else{ ?>  
                                        <td><?=$row->source?></td>
                                        <?php } ?>    
                                        <td><?php echo $this->admin_model->getRegion($row->region) ;?></td>
                                        <td><?php echo $this->admin_model->getCountry($row->country) ;?></td>
                                        <td><?php echo $this->customer_model->getType($row->type) ;?></td>
                                        <td class="leadInfo" id="SamTable_<?=$row->id?>" data-id="<?=$row->id?>" data-customer="<?=$row->customer?>">
                                        <?php if($row->approved == 1){ ?>
                                            <?php if($SamCustomer->num_rows() == 0){?>
                                            <?php if($permission->follow == 2){ ?>
                                            <a href="#myModal" data-toggle="modal" class="btn btn-success" >Assign SAM</a>
                                            <?php } ?>
                                            <?php }else{ ?>
                                            <table style="border-collapse:collapse;">
                                            <tr><td style="border: 1px solid #ddd;">SAM Name</td>
                                            <?php if($permission->follow == 2){ ?>
                                              <td style="border: 1px solid #ddd;"></td>
                                              <td style="border: 1px solid #ddd;"></td>
                                            <?php } ?>
                                            </tr>
                                            <?php 
                                            $i=0;
                                            $count=$SamCustomer->num_rows();
                                          foreach($SamCustomer->result() as $sam)
                                          {
                                              //echo $i;
                                              ?>
                                                <tr>
                                                    <td style="border: 1px solid #ddd;"><?php echo $this->admin_model->getAdmin($sam->sam);?></td>
                                                   <?php if($permission->follow == 2){ ?>
                                                  <!-- <td style="border: 1px solid #ddd;"><a href="<?php echo base_url()?>customer/deleteSamCustomer?t=<?php echo base64_encode($sam->id); ?>">  -->
                                                  <td style="border: 1px solid #ddd;"><a onclick="deleteSamCustomer(<?=$sam->id?>,<?=$row->id?>)"> 
                                                    <i class="fa fa-times text-danger text"></i> </a></td><?php } ?>
                                              <?php if( $i < 1)
                                                {
                                              ?>
                                              <?php if($permission->follow == 2){ ?>
                                              <td rowspan="<?php echo $count; ?>" style="border: 1px solid #ddd;"><a href="#myModal" data-toggle="modal" class="btn btn-success" >Assign SAM</a></td><?php } ?>
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
                                        <td>
                                            <?php if($permission->edit == 1){ ?>
                                            <a href="<?php echo base_url()?>customer/editLead?t=<?php echo 
                                            base64_encode($row->id) ;?>" class="">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if(($permission->delete == 1 && $permission->follow == 2) || ($permission->delete == 1 && $row->created_by == $user)){ ?>
                                            <a href="<?php echo base_url()?>customer/deleteLead?t=<?php echo 
                                            base64_encode($row->id) ;?>" title="delete" 
                                            class="" onclick="return confirm('Are you sure you want to delete this Customer ?');">
                                                <i class="fa fa-times text-danger text"></i> Delete
                                            </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                        <?php
                                }
                        ?>      
                        </tbody>
              
                    </table>
                 