<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Date Filter
      </header>
      
      <div class="panel-body">
       <form class="cmxform form-horizontal " id="hrReport" method="get" enctype="multipart/form-data">
        <div class="form-group">

            <label class="col-lg-2 control-label" for="role date">Date From</label>

            <div class="col-lg-3">

                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off" required="">
            </div>

            <label class="col-lg-2 control-label" for="role date">Date To</label>

            <div class="col-lg-3">
                 <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off" required="">
            </div>

        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="role date">Report Name</label>
            <div class="col-lg-3">
              <select name="report" class="form-control m-b" id="report" required />
                       <option disabled="disabled" selected="selected" value="">-- Select Report --</option>
                        <?php 
              if($_REQUEST['report'] == 1 ){?>
                  <option selected="" value = "<?=$_REQUEST['report']?>">Total Manpower</option>
                       <!-- <option value="2">Male Vs Female</option> -->
                       <option value="3">Turnover</option>
                       <!-- <option value="4">Hiring Vs. Turnover</option> -->
             <?php }
             elseif($_REQUEST['report'] == 2){ ?>
<!--                   <option selected="" value = "<?=$_REQUEST['report']?>">Male Vs Female</option>
                       <option value="1">Total Manpower</option>
                       <option value="3">Turnover</option>
                       <option value="4">Hiring Vs. Turnover</option> -->
             <?php }
             elseif($_REQUEST['report'] == 3){ ?>
                  <option selected="" value = "<?=$_REQUEST['report']?>">Turnover</option>
                       <option value="1">Total Manpower</option>
                      <!--  <option value="2">Male Vs Female</option>
                       <option value="4">Hiring Vs. Turnover</option> -->
             <?php }
             elseif($_REQUEST['report'] == 4){ ?>
                  <!-- <option selected="" value = "<?=$_REQUEST['report']?>">Hiring Vs. Turnover</option>
                       <option value="1">Turnover</option>
                       <option value="2">Male Vs Female</option>
                       <option value="3">Turnover</option>  -->
              <?php }
              else{?>
                       <option value="1">Total Manpower</option>
                     <!--   <option value="2">Male Vs Female</option> -->
                       <option value="3">Turnover</option>
                       <!-- <option value="4">Hiring Vs. Turnover</option> -->

              <?php }?>
              </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button class="btn btn-primary" onclick="var e2 = document.getElementById('hrReport'); e2.action='<?=base_url()?>hr/hrReports'; e2.submit();" name="search" type="submit"> Search</button>
                <button class="btn btn-success" onclick="var e2 = document.getElementById('hrReport'); e2.action='<?=base_url()?>hr/exportHrReports'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button>
               <a href="<?=base_url()?>hr/hrReports" class="btn btn-warning">(x) Clear Filter</a> 

            </div>
        </div>   
        </form>
      </div>
    </section>
  </div>
</div>
<!-- Total Manpower -->
<?php if($report == 1){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Total Manpower Report
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="5" style="text-align: center;">Total Manpower Report From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Function</th>
                <th>Total</th>
              </tr>
            </thead>

            <tbody>
          <?php  
            foreach ($manpower->result() as $manpower) { 

              $totalManpower = $this->db->query(" SELECT COUNT(*) AS total FROM `employees` WHERE department = '$manpower->id' AND status = 0 ")->row();
              ?>
            <tr>

              <td><?=$manpower->name?></td>
              <td><?=$totalManpower->total?></td>
            </tr>
        <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- End Total Manpower  -->
<!-- Male Vs Female -->
<?php if($report == 2){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Male Vs Female Report
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="5" style="text-align: center;">Male Vs Female Report From <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Male</th>
                <th>Female</th>
              </tr>
            </thead>

            <tbody>
              <?php  
        foreach ($gender->result() as $gender) {

              $male = $this->db->query(" SELECT * FROM `employees` WHERE gender = '1' ")->row(); 
              $female = $this->db->query(" SELECT COUNT(*) AS total FROM `employees` WHERE gender = '2' ")->row(); 
              
              ?>
            <tr>
              <td><?=$male->total?></td>
              <td><?=$female->total?></td>
            </tr>
        <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- Turnover -->
<?php if($report == 3){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Turnover
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="6" style="text-align: center;">Turnover <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Employee Name</th>
                <th>Function</th>
                <th>Termination Date</th>
                <th>Hiring Date</th>
                <th>Reason of Resignation</th>
              </tr>
            </thead>

            <tbody>
          <?php  
            foreach ($turnover->result() as $turnover) { 
              ?>
            <tr>
              <td><?=$turnover->name?></td>
              <td><?php echo $this->hr_model->getDepartment($turnover->department);?></td>
              <td><?=$turnover->resignation_date?></td>
              <td><?=$turnover->hiring_date?></td>
              <td></td>
            </tr>
     <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- End Turnover Table -->

<!-- Turnover -->
<?php if($report == 4){ ?>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      
      <header class="panel-heading">
        Hiring Vs. Turnover
      </header>

      <div class="panel-body">
        <div class="adv-table editable-table " style="overflow-y: scroll;">
          <div class="clearfix">
          </div>
          <div class="space15"></div>
          <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                <th colspan="6" style="text-align: center;">Hiring Vs. Turnover <?=$date_from?> TO <?=$date_to?></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Total Hired</th>
                <th>Terminated</th>
              </tr>
            </thead>
            <tbody>
            
            <tr>
              <td></td>
              <td></td>
            </tr>
        
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php } ?>
<!-- End Turnover Table -->