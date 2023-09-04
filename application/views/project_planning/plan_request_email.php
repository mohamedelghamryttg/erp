<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?= base_url() ?>'assets/images/favicon.png">
        <title>Falaq| Site Manager</title>
        <style>
            body {
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                font-size: 14px;
                line-height: 1.428571429;
                color: #333;
            }
            section#unseen
            {
                overflow: scroll;
                width: 100%
            }
            th{
                border: 1px solid;
            }
            td {
                border: 1px solid;
            }
        </style>
        <!--Core js-->
    </head>

    <body>
        <?php if($requestType == 1){?>
        <p>This is a Heads Up Request , Please response via this link : <a href="<?=base_url('translation')?>" >Click Here..</a> <p>
        <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
            <thead>
                <tr>
                    <th>Task Code</th> 
                    <th>Task Name</th>                       
                    <th>Task Type</th>                      
                    <th>Count</th>
                    <th>Unit</th>
                    <th>Attachment</th>
                    <th>Start Date</th>
                    <th>Delivery Date</th>
                    <th>PM</th>
                    <th>Created Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> Translation-<?=$requestData->id?></td>                         
                    <td><?=$requestData->subject?></td>
                    <td><?=$this->admin_model->getTaskType($requestData->task_type)?></td>
                    <td><?=$requestData->count?></td>
                    <td><?=$this->admin_model->getUnit($requestData->unit)?></td>
                    <td><?=$attachment?></td>
                    <td><?=$requestData->start_date?></td>
                    <td><?=$requestData->delivery_date?></td>
                    <td><?=$this->admin_model->getAdmin($requestData->created_by)?></td>
                    <td><?=$requestData->created_at?></td>
                </tr>
            </tbody>
        </table>
        <?php }elseif ($requestType == 2) {?>
         <p>This is a Heads Up Request , Please response via this link : <a href="<?=base_url('le')?>" >Click Here..</a> <p>
            <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
                    <thead>
                      <tr>                        
                        <th>Task Code</th>
                        <th>Task Name</th>
                        <th>Task Type</th>
                        <th>Linguist Format</th>
                        <th>Deliverable Format</th>
                        <th>Unit</th>
                        <th>Volume</th>
                        <th>Complexicty</th>
                        <th>Rate</th>
                        <th>Start Date</th>
                        <th>Delivery Date</th>
                        <th>Task File</th>
                        <th>PM</th>
                        <th>Created Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>                        
                        <td> LE-<?=$requestData->id?></td>
                        <td><?=$requestData->subject?></td>
                        <td><?=$this->admin_model->getLETaskType($requestData->task_type)?></td> ';  
                        <?php if(is_numeric($requestData->linguist) && is_numeric($requestData->deliverable)){ ?>
                         <td><?=$this->admin_model->getLeFormat($requestData->linguist)?></td>
                        <td><?= $this->admin_model->getLeFormat($requestData->deliverable)?></td>
                        <?php  }else{ ?>
                        <td><?=$requestData->linguist?></td>
                        <td><?=$requestData->deliverable?></td>';
                        <?php    } ?>
                        <td><?=$this->admin_model->getUnit($requestData->unit)?></td>
                        <td><?=$requestData->volume?></td>
                        <td><?=$this->projects_model->getLeComplexictyForM($requestData->complexicty) ?></td> 
                        <td><?=$requestData->rate?></td>
                        <td><?=$requestData->start_date?></td>
                        <td><?=$requestData->delivery_date?></td>
                        <td><?=$attachment?></td>                            
                        <td><?=$this->admin_model->getAdmin($requestData->created_by)?></td>
                        <td><?=$requestData->created_at?></td>
                      </tr>
                      </tbody>
                    </table>
      <?php  }elseif ($requestType == 3 ) {?>
          <p>This is a Heads Up Request , Please response via this link : <a href="<?=base_url('dtp')?>" >Click Here..</a> <p>
         
            <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
                    <thead>
                      <tr>
                        <th>Task Code</th>                       
                        <th>Task Name</th>
                        <th>Task Type</th>
                        <th>Volume</th>
                        <th>Unit</th>                       
                        <th>File Attachment</th>
                        <th>Start Date</th>
                        <th>Delivery Date</th>
                        <th>PM</th>
                        <th>Created Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                          <td> DTP-<?=$requestData->id?></td>
                          <td><?=$requestData->task_name?></td>
                          <td><?=$this->admin_model->getDTPTaskType($requestData->task_type)?></td>
                          <td><?=$requestData->volume?></td>
                           <td><?=$this->admin_model->getUnit($requestData->unit)?></td>
                            <td><?=$attachment?></td> 
                          <td><?=$requestData->start_date?></td>
                          <td><?=$requestData->delivery_date?></td>
                          <td><?=$this->admin_model->getAdmin($requestData->created_by)?></td>
                          <td><?=$requestData->created_at?></td>
                      </tr>
                      </tbody>
                    </table>
      <?php  }?>
    </body>
</html>