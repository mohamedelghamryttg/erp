<div class="d-flex flex-column-fluid">
<!--begin::Container-->
   <div class="container">
      <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Price List Details</h3>
                
            </div>
            <!--begin::Form-->
            <?php  $brand = $this->db->get_where('customer',array('id'=>$price->customer))->row()->brand;?>
            <form class="form"action="<?php echo base_url()?>customer/doApprovePriceList/<?=$id?>" method="post" enctypApprovePriceListe="multipart/form-data">
                 
                   
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                        <tbody>
                            <tr>
                                <th colspan="2">ID</th>
                                <td colspan="2"><?= $id ?></td>                               
                            </tr>
                            <tr>                                                             
                                <th colspan="2">Status</th>
                                <td colspan="2"><?= strip_tags($this->sales_model->getClientPriceStatus($price->approved))?> <br/> <?=$price->approved > 0 ?"BY <span class='text-danger'>". $this->admin_model->getAdmin($price->approved_by)."</span> AT <span class='text-danger'>".$price->approved_at.'</span>':"" ?></td>                               
                            </tr>
                            <tr>
                                <th colspan="2">Customer</th>
                                <td colspan="2"><?= $this->customer_model->getCustomer($price->customer) ?></td>                               
                            </tr>
                            <tr>                               
                                <th colspan="2">Brand</th>
                                <td colspan="2"> <?= $this->admin_model->getBrand($brand) ?></td>
                            </tr>
                            <tr>
                                <td>Region</td>
                                <td><?= $this->admin_model->getRegion($leadData->region); ?></td>
                                <td>Country</td>
                                <td> <?= $this->admin_model->getCountry($leadData->country); ?></td>

                            </tr>
                            <tr>
                                <td>Product Line</td>
                                <td><?= $this->customer_model->getProductLine($price->product_line); ?></td>
                                <td>Service</td>
                                <td> <?= $this->admin_model->getServices($price->service); ?></td>

                            </tr>
                            <tr>
                                <td>Task Type</td>
                                <td><?php echo $this->admin_model->getTaskType($price->task_type); ?></td>
                                <td>Subject Matter</td>
                                <td>  <?= $this->admin_model->getFields($price->subject) ?></td>

                            </tr>
                            <tr>
                                <td>Source Language</td>
                                <td><?= $this->admin_model->getLanguage($price->source); ?></td>
                                <td>Target Language</td>
                                <td> <?= $this->admin_model->getLanguage($price->target); ?></td>

                            </tr>
                            <tr>
                                <td>Unit</td>
                                <td><?= $this->admin_model->getUnit($price->unit); ?></td>
                                <td>Rate</td>
                                <td> <?= $price->rate; ?> <?= $this->admin_model->getCurrency($price->currency); ?></td>

                            </tr>

                            <tr>
                                <td>Number Of Columns</td>
                                <td><?= $fuzzy->num_rows() ?></td>
                                <td></td>
                                <td> </td>

                            </tr> 
                            <tr>
                                <th colspan="4">Fuzzy Match</th>


                            </tr>
                            <tr>
                                <td colspan="4">
                                    <?php
                                    $result_arr = array();
                                    echo ' <table class="table table-striped table-hover table-bordered text-center" style="overflow:scroll;max-width:100%">
                                        <thead>
                                            <tr>';
                                    $i = 1;
                                    foreach ($fuzzy->result() as $column) {
                                        echo ' <th>' . $column->prcnt . '</th> ';
                                        $i++;
                                    }
                                    echo ' <th>Min</th> ';
                                    echo '</tr></thead><tbody><tr>';
                                    $y = 1;
                                    foreach ($fuzzy->result() as $column) {
                                        echo '<td>' . $column->value . '</td>';
                                        $result = $column->value * $price->rate;
                                        array_push($result_arr, $result);
                                        $y++;
                                    }
                                    echo ' <td></td> ';
                                    echo '</tr></thead><tbody><tr>';
                                    for ($i = 0; $i < count($result_arr); $i++) {
                                        $z = $i + 1;
                                        echo '<td id="result_' . $z . '">' . $result_arr[$i] . '</td>';
                                    }
                                    $min = $price->rate * 250;
                                    echo '<td id="min">' . $min . '</td>';
                                    echo '</tr></tbody></table>';
                                    ?>
                                </td>

                            </tr>
                            <tr>
                                <td>Comment</td>
                                <td><?= $price->comment ?></td>
                                <td></td>
                                <td> </td>

                            </tr> 
                               <?php if ($price->approved > 0) { ?>
                            <tr>
                                <td>Approval Comment</td>
                                <td><?= $price->approved_comment ?></td>
                                <td></td>
                                <td> </td>

                            </tr> 
                               <?php }?>
                            <?php if ($price->approved == 0) { ?>
                                <tr>

                                    <td colspan="4">
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">Approval Comment</label>
                                            <div class="col-sm-6">
                                                <textarea name="approve_comment"  class="form-control" value="" rows="6"></textarea>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                    
                <div class="card-footer">
                    <?php if($price->approved==0){?>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <input class="btn btn-success" type="submit"  name="submit" value="Approve">
                            <input class="btn btn-danger" type="submit" name="reject"  value="Reject Price List">                                  
                            <a  href="<?php echo base_url()?>customer/priceListApproval" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>