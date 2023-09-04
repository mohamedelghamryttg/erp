
 <div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Time Table
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
       
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                    <th>#ID</th>
                    <th>Employee</th>
              </tr>
            </thead>
           <tbody>
           
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