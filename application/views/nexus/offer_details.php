<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="">
            <meta name="author" content="">          
        </head>

        <body>
          <!-- <div class="header">
          </div> -->
          <div class="container">
            <table bgcolor="#e1e1e1" border="0" cellpadding="2" cellspacing="0" height="100%" style="margin:0 auto;" width="100%">
                <tbody>
                    <tr>
                        <td height="100%" width="1200">
                        <table border="0" cellpadding="2" cellspacing="0">
                            <tbody>

                           
                                <tr>
                                    <td    width="1200">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p >Hi Dear,<br/><br/>This job offer has no response from vendors, please check.</p>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td    width="1200" height="10" style="height:10px;">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            
                            	<tr>
                                    <td    width="1200">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p ><strong>Job Code:</strong> <?= $job->code ?> </p>                    
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            	<tr>
                                    <td    width="1200">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p ><strong>Subject:</strong> <?=$row->subject?> </p>                    
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            	<tr>
                                    <td    width="1200">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p ><strong>Task Type:</strong> <?=$this->admin_model->getTaskType($row->task_type)?> </p>                    
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td    width="1200">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p ><strong>Total Count:</strong> <?=$row->count?> <?=$this->admin_model->getUnit($row->unit)?> </p>                    
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td    width="1200">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p ><strong>Source Language:</strong> <?=$this->admin_model->getLanguage($jobPrice->source)?></p>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            
                            	<tr>
                                    <td    width="1200">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p ><strong>Target Language:</strong> <?=$this->admin_model->getLanguage($jobPrice->target)?></p>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td    width="1200">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p ><strong>Rate:</strong> <?=$row->rate?> <?=$this->admin_model->getCurrency($row->currency)?></p>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="1200" >
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p ><strong>Deadline for Delivery: </strong><?=$row->delivery_date?> <?=$this->admin_model->getTimeZone($row->time_zone)?></p>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="1200" >
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                  <p ><strong>Link: </strong><a href="<?= base_url() ?>/projectManagment/viewOffer?t=<?php
                                                                                                                echo
                                                                                                                base64_encode($row->id);
                                                                                                                ?>&j=<?= base64_encode($row->job_id); ?>">view job offer</p></p>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                              
                                                
                                <tr>
                                    <td    width="1200" height="20" style="height:20px;">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td    width="1200" height="30" style="height:30px;">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="1200">
                                                        <table border="1" cellpadding="2" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Vendor Name </th>
                                                                    <th>Email</th>
                                                                </tr>
                                                            </thead>

                                                    <tbody>
                                                        <?php foreach ($vendor_list as $k => $val) {
                                                            $vendor = $this->vendor_model->getVendorData($val);
                                                            if ($k + 1 == count($vendor_list))
                                                                continue; ?>
                                                            <tr>
                                                                <td><?= ++$k ?></td>
                                                                <td><?= $vendor->name ?></td>
                                                                <td><?= $vendor->email ?></td>

                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>

                              
                               

                                
                                
                            </tbody>
                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>
              
          </div>
        </body>
</html>