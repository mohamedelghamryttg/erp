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
<!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
              
            
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">
                       <h3 class="card-label">Jobs Waiting for Your Action - <span class="btn btn-danger"><span><?=$project->num_rows()?></span></span></h3>
                    </div>
                    
                  </div>
                  <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="kt_datatable2">
                    <thead>
              <tr>
                       <th>Client Name</th>
                       <th>Job Name</th>
                       <th>Service</th>
                       <th>Source</th>
                       <th>Target</th>
                       <th>Job File</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($project->result() as $row) { 
            ?>
              <tr>
                <td><?php echo $this->customer_model->getCustomer($row->customer);?></td>
                <td><?=$row->name?></td>
                <td><?php echo $this->admin_model->getServices($row->service);?></td>
                <td><?php echo $this->admin_model->getLanguage($row->source);?></td>
                <td><?php echo $this->admin_model->getLanguage($row->target);?></td>
                <td><a target="_blank" href="http://europelocalize.com/assets/uploads/jobFile/<?=$row->job_file?>">Click Here ...</a></td>
              </tr>
            <?php } ?>
            </tbody>
              
                    </table>
                    <!--end: Datatable-->
 <!--begin::Pagination-->
         <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <?=$this->pagination->create_links()?>  
                  </div>
              <!--end:: Pagination-->
                  </div>
                </div>
                <!--end::Card-->
              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->