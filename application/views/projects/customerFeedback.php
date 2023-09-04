
 <div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Customer Feedback
      </header>
          <?php if($this->session->flashdata('true')){ ?>
      <div class="alert alert-success" role="alert">
              <span class="fa fa-check-circle"></span>
              <span><strong><?=$this->session->flashdata('true')?></strong></span>
            </div>
      <?php  } ?>
      <?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert">
              <span class="fa fa-warning"></span>
              <span><strong><?=$this->session->flashdata('error')?></strong></span>
            </div>
      <?php  } ?>
      <div class="panel-body" style="overflow:scroll;">
         <div class="clearfix">
            <div class="btn-group">
            <?php if($permission->add == 1){ ?>
                  <a href="<?=base_url()?>projects/addCustomerFeedback" class="btn btn-primary " style="margin-right: 5rem;"><i class="fa fa-plus" aria-hidden="true"></i> Add Feedback</a>
              </br></br></br>
            <?php } ?>
            </div>
          </div>  
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Feedback</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Delete</th>
              </tr>
            </thead>
           <tbody>
           <?php foreach($feedback->result() as $row) { ?>
                  <tr class="">
                    <td><?= $row->id ;?></td>
                    <td><?=  $row->emails;?></td>
                    <td><?=  $row->feedback_message;?></td>
                    <td><?php echo $row->created_at ;?></td>
                    <td><?=$this->admin_model->getAdmin($row->created_by)?></td>
                    <td>
                      <?php if($permission->delete == 1){ ?>
                      <a href="<?php echo base_url()?>projects/deleteCustomerFeedback?t=<?=base64_encode($row->id)?>" title="delete" 
                      class="" onclick="return confirm('Are you sure you want to delete this feedback ?');">
                        <i class="fa fa-times text-danger text"></i> Delete
                      </a>
                      <?php } ?>
                    </td>
                  </tr>
               <?php } ?>   
            </tbody>
          </table>
          <nav class="text-center">
                         <?=$this->pagination->create_links()?>
                    </nav>
        </div>
      </div>
    </section>
  </div>
</div>