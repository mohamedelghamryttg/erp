<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				<button id="button_filter" onclick="showAndHide('filter','button_filter');" style="padding-top:0pc; float: right;background-color: transparent;font-size: 15px;" class="btn btn-sm btn-light text-dark"><i class="fa fa-chevron-down"></i></button> Request Filter
			</header>
			
			
			<div id="filter" class="panel-body">
			  <form class="cmxform form-horizontal " id="translationProductionReport" action="<?php echo base_url()?>translation/translationProductionReport" method="get" enctype="multipart/form-data">
         		<div class="form-group">
		            <label class="col-lg-2 control-label" for="role date">Date From</label>
		            <div class="col-lg-3">
		                 <input class="form-control date_sheet" type="text" name="date_from" autocomplete="off">
		            </div>
		            <label class="col-lg-2 control-label" for="role date">Date To</label>
		            <div class="col-lg-3">
		                 <input class="form-control date_sheet" type="text" name="date_to" autocomplete="off">
		            </div>
		        </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                      <button class="btn btn-primary" name="search" type="submit">Search</button>
                      <button class="btn btn-success" onclick="var e2 = document.getElementById('translationProductionReport'); e2.action='<?=base_url()?>translation/exportTranslationProductionReport'; e2.submit();" name="export" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Export To Excel</button> 
                  </div>
              </div>      
              </form>
			</div>
		</section>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<section class="panel">
			
			<header class="panel-heading">
				Translation Production Report
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
			<div class="panel-body">
				<div class="adv-table editable-table " style="overflow:scroll;">
					
					<div class="space15"></div>
					
					<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
						<thead>
							<tr>
                              	<th>Number of Requests</th>
                             	 <th>unit</th>
                             	 <th>Total WWC</th>
                             	 <th>TM</th>

							</tr>
						</thead>
						<tbody>
		                   <?php foreach ($unit as $row) { 
								$req = $this->db->query(" SELECT COUNT(*) AS total_requests,u.brand FROM `translation_request` LEFT OUTER JOIN users AS u ON u.id = translation_request.created_by WHERE translation_request.created_at BETWEEN '$date_from' AND '$date_to' AND translation_request.unit = '$row->id' AND translation_request.status != 4  AND u.brand = '$this->brand' GROUP BY brand; ")->row()->total_requests;
                          	if($req > 0){
                            	$data = $this->db->query(" SELECT SUM(count) AS wwc, SUM(tm) AS tm,u.brand FROM `translation_request` LEFT OUTER JOIN users AS u ON u.id = translation_request.created_by WHERE translation_request.created_at BETWEEN '$date_from' AND '$date_to' AND translation_request.unit = '$row->id' AND translation_request.status != 4 AND u.brand = '$this->brand' GROUP BY brand; ")->row();
                        	?>
							<tr>
								<td><?=$req?></td>
								<td><?php echo $row->name ;?></td>
								<td><?=$data->wwc?></td>
								<td><?=$data->tm?></td>
							</tr>
						<?php }}  ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>