<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Late VPOs 
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
        <div class="adv-table editable-table ">
         
          <div class="space15"></div>
          
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th>Job Code</th>
                <th>Job Name</th>
                <th>Created By</th>
                <th>Created At</th>
                    
              </tr>
            </thead>
                <tbody>
                <?php foreach ($jobs->result() as $row) { 
                     $total = $row->tasks + $row->dtp + $row->translation ;
                     if($total == 0 ){ ?>
                     <tr> 
                        <td>
                           <a href="<?=base_url()?>projects/jobTasks?t=<?=base64_encode($row->id)?>"><?=$row->code?></a>
                        </td>
                        <td><?=$row->name?></td>
                        <td><?php echo $this->admin_model->getAdmin($row->created_by) ;?></td>
                        <td><?php echo $row->created_at ;?></td>
                    </tr>                  
                  <?php } }?>
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