<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                View Request 
            </header>
            
            <div class="panel-body">
                <div class="form">
                    <div class="form-group">
                    <div class="col-lg-12">
                    <table class="table table-striped table-hover table-bordered" id="">
                       
                        <tbody>
                                <tr>
                                    <td>ID</td>
                                    <td><?=$request->id?></td>
                                    <td>File Name</td>
                                    <td><?=$request->file_name?></td>
                                </tr>
                               
                               
                                 <tr>
                                    <td>Task Type</td>
                                    <td><?= $this->projects_model->getConversionTaskType($request->task_type) ?></td>
                                    <td>Attachment Type</td>
                                    <td><?= $request->attachment_type == 1 ? "Attachment" : "Link"   ?></td>
                                </tr>
                                <tr>
                                    <td>Attachment</td>
                                    <td><?=$request->attachment?></td>
                                    <td>Link</td>
                                    <td><a href="<?php echo $request->link ?>"><?= $request->link ?></a></td>
                                </tr>
                                <tr>
                                    <td>Created At</td>
                                    <td><?=$request->created_at?></td>
                                    <td>Created By</td>
                                    <td><?=$this->admin_model->getAdmin($request->created_by)?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td><?php  if($request->status == 1){
                                       echo "Running";
                                        }elseif ($request->status == 2) {
                                            echo "Closed";
                                        }elseif ($request->status == 3) {
                                            echo "Faild";
                                        } ?>
                                    
                                 </td>
                                    <td>Comment</td>
                                    <td><?=$request->reason?></td>
                                    
                                    
                                </tr> 
                                <tr>
                                    <td>Status At</td>
                                    <td><?=$request->status_at?></td>
                                    <td>Status By</td>
                                    <td><?=$this->admin_model->getAdmin($request->status_by)?></td>
                                </tr>
                        
                        		<tr>
                                    <td>Closed File</td>
                                <td><a href="<?=base_url()?>assets/uploads/pmConversionRequestDocument/<?=$request->closed_file?>">Click Here</a></td>
                                </tr>
                                
                        </tbody>
                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
