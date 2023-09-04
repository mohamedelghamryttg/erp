<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="">
            <meta name="author" content="">
            <style>

            * {
            margin: 0;
            padding: 1px;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            }

            .header{
                height: 20px;
                background-color: #14587a;
                margin-bottom:30px
             }
             h2{
                color: #14587a;
             }
             .title-head{
                height: 100px;
             }
             .text-center{
              text-align:center;
             }
             .job-head{
                color: #14587a;
             }
             .message{
                margin-bottom:5px;
             }
 
            </style>
            <!--Core js-->
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
                                    <td width="1200" height="120" style="height:120px;">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="400">
                                                <img style="width:150px;border:0;" width="150" class="logo" src="cid:<?=$logo_cid?>">
                                                </td>
                                                <td width="800">
                                                  <h2>Task Cancelled </h2>
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
                                                  <p >Hi Dear, this job offer is no longer available in Nexus</p>
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
                                    <td width="1200" height="50" style="height:50px;">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="400">
                                                    <p class="job-head">Task Details</p>
                                                </td>
                                                <td width="400">
                                                    <p class="job-number"><?=$row->subject?></p>
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
                                    <td    width="1200" height="30" style="height:30px;">
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
                                                    <p>Thank you,
                                                    </p>                                    
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
                                                    <p>Project Management Team
                                                    </p>                                    
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
                                                    <p>Nexus 
                                                    </p>                                    
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