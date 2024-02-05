<!--begin::Entry-->
<div class="d-flex flex-column-fluid py-5">
    <!--begin::Container-->
    <div class="container-fluid">
        <?php if ($this->session->flashdata('true')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong>
                        <?= $this->session->flashdata('true') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="fas fa-times-circle"></span>
                <span><strong>
                        <?= $this->session->flashdata('error') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <div class=" card card-custom gutter-b example example-compact " >
            <div class="card-header">
                <div class="card-title btn_lightgray">
                    <h3 class="card-label">Profit Share Report</h3>
                </div>
                <button id="button_filter" onclick="showAndHide('filter11', 'button_filter');"
                    class="btn btn-clean bg-hover-white"><i
                        class="fa fa-chevron-up"></i></button>

            </div>                      
            <form class="form" id="payrollFilter" action="<?php echo base_url() ?>profitShare/"
                  method="get" enctype="multipart/form-data"> 
                <div class="card-body pb-2" id="filter11" style="display:block">                                                               
                    <div class="form-group row">
                        <label class="col-lg-1 col-form-label text-lg-right">Year:</label>
                        <div class="col-lg-3 ">
                            <select name="year" class="form-control " id="year" required>
                                <option value="" selected="" disabled="">-- Select year --</option>
                            <?= $this->accounting_model->selectYear($year ? $year : ''); ?>
                            </select>
                        </div>                                       
                        <label class="col-lg-2 col-form-label text-lg-right" for="role name">Function</label>
                        <div class="col-lg-4">
                            <select name="department" class="form-control m-b" id="department" required="">
                            <option value="" selected="" disabled>-- Select Department --</option>
                            <?= $this->hr_model->selectDepartmentKpi($department??'') ?>
                            </select>
                        </div>
                    </div>                                    
                    <div class="form-group row">
                        <label class="col-lg-1 col-form-label text-lg-right">Half:</label>
                        <div class="col-lg-3">
                            <select name="half" class="form-control " id="half" required="">
                                <option value="" disabled="" selected>-- Select --</option>
                                <option value="1" <?=(isset($half) && $half == 1) ? 'selected' : ''?>>The First Half</option>
                                <option value="2" <?=(isset($half) && $half == 2) ? 'selected' : ''?>>The Second Half</option>

                            </select>
                        </div>                                       
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-sm btn-success mr-2" name="search" type="submit"><i class="flaticon-doc"></i> Extract Report</button>
                        </div>
                    </div>
                </div>
            </form>
                            
                        </div>
    <div class="clear-fix"></div>
    <!--begin::Card-->
    <div class="card">
       <div class="card-header border-0 card-header-right ribbon ribbon-clip ribbon-left">
  <div class="ribbon-target font-size-h3" style="top: 12px;">
   <span class="ribbon-inner bg-warning"></span>Test Data <small> support & production teams only</small>
  </div>
                      

        </div>
        <!--brand reports-->
       
        <div class="card-body">
             <?php if(isset($_GET['search'])){?>
             <div class="card card-custom gutter-b example example-compact">       
                 <div class="card-body">                     
                    <div class="row">  
                        <div class="col-xl-6">
                            <p class="font-weight-bolder font-size-lg"> <i class="flaticon-graphic-2 mr-2 text-danger"></i>Achieved % Per Region / Per Brand vs the matrix </p>
                                <table class="table table-head-custom table-bordered text-center ml-5" >
                                <thead>
                                    <tr>
                                        <td colspan="5" class="font-weight-bolder text-danger"> H<?= $half?> </td>   
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th></th>   
                                        <?php foreach ($regions as $region) { ?>                                                             
                                            <th><?= $region->name ?></th>
                                        <?php } ?>
                                            <th class="bg-success text-white"><span class="text-white"></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($brands as $val) {
                                         $brand_score = $this->profitShare_model->getBrandAchievedMatrix($year, $val->id,$half);?>
                                        <tr>
                                            <th><?= $val->abbreviations ?></th>
                                            <?php foreach ($regions as $region) {
                                                $region_score = $this->profitShare_model->getBrandRegionAchievedMatrix($year, $val->id, $region->id,$half);
                                                 ?>
                                            <td><?= $region_score ?> %</td>
                                            <?php } ?> 
                                            <td class="bg-success text-white"><?= $brand_score ?> %</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>                                        
                        <div class="col-xl-6">
                            <p class="font-weight-bolder font-size-lg ml-5"> <i class="flaticon-pie-chart-1 mr-2 text-danger"></i>Brand Contribution </p>
                            <div id="brand_contribution">
                                <div id="chart" class="d-flex justify-content-center"></div>
                            </div>
                        </div>                                        
                    </div>
                   
                    <h6 class="pt-5 text-danger"><i class="flaticon-notes text-danger"></i> Equation : <span class="text-dark font-size-base font-weight-bolder"><?=$equation?></span></h6>
                                                  
                    
                 </div>
             </div>
            <?php }?>
            <!--begin: Datatable-->
            <hr/>
            <hr class="mb-10"/>
            <table class="table table-head-custom" id="profit_datatable1">
                <thead>
                    <tr>
                        <th no-sort>#</th>
                        <th>name</th>
                        <th>brands num.</th>
                        <th>Coeffiecient</th>
                        <th>hiring date</th>
                        <th>num. of hiring
                            months</th>
                        <th>Due vs. Hir </th>
                        <th>avg. Score</th>
                        <th>Emp. Performance</th>
                        <th>Net Profit Share Amount</th>
                        <th></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($records)){
                            foreach ($records as $k=> $row) { ?>
                        <tr>
                            <td>
                                <?= $k ?>
                            </td>
                            <td>
                                <?= $row['name'] ?>
                            </td>
                            <td>
                                <?= $row['brands_num'] ?>
                            </td>                           
                            <td>
                                <?= $row['brands_Coeffiecient'] ?>
                            </td>
                            <td>
                                <?= $row['hiring_date'] ?>
                            </td>
                            <td>
                                <?= $row['hiring_months'] ?>
                            </td>
                            <td>
                                <?= $row['hiring_per'] ?>
                            </td>
                            <td>
                                <?= $row['avg_score'] ?>
                            </td>
                            <td><p>
                                <?= $row['empPerformance'] ?>
                                <?php if($row['num_score_months'] < 6 ){?>
                                    <span style="top: -7px;position: relative;" data-toggle="tooltip" title="Num. Of Kpis : <?=$row['num_score_months']?>"><i class="flaticon2-information text-danger"></i></span>
                                <?php }?>
                                </p>
                            </td>
                            <td>
                                <?= number_format($row['profit_amount']) ?>
                            </td>
                            <td>
                                  <a title="Team Leaders Kpis" href="<?= base_url() . 'profitShare/viewRecord?t=' . base64_encode($k); ?>" class="btn btn-sm btn-default mr-2  btn-hover-primary text-danger font-weight-bold">
                                        <i class="fab fa-buffer text-danger"></i>
                                            VIEW & EDIT
                                    </a>
                            </td>
                           
                           

                            
                        </tr>
                    <?php } }?>

                </tbody>
            </table>
            <!--end: Datatable-->

        </div>
    </div>
</div>
</div>
<!--end::Card-->
<style>
    .label {
        width: auto;
        padding: 10px;
    }

    .datepicker {
        z-index: 1100;
    }
    /*#kt_datatable1_info{ display: none}*/
</style>

<!--begin::Page Scripts(used by this page)-->
<script src="<?= base_url()?>assets_new/js/pages/crud/datatables/extensions/buttons.js"></script>
<script src="<?= base_url()?>assets_new/js/pages/features/charts/apexcharts.js"></script>
<!--end::Page Scripts-->
<script>
    var initTable1 = function() {
		// begin first table
		var table = $('#profit_datatable1').DataTable({
			responsive: true,
			// Pagination settings
			dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

			buttons: [
				'print',
				'copyHtml5',
				'excelHtml5',
				'pdfHtml5',
			],
                        colReorder: true,
                        paging: false,
			
		});

	};
        // chart
    var _demo11 = function () {
		const apexChart = "#chart";
                const labels = [];
                const series = [];
                <?php foreach ($brands as $val){
                    $brandTargetContribution = $this->profitShare_model->getBrandTargetContribution($year, $val->id);?>
                        labels.push("<?=$val->abbreviations?>");
                        series.push(<?=$brandTargetContribution?>);
                <?php }?>
		var options = { 
			series: series,
                        labels: labels,
                       
			chart: {
				width: 380,
				type: 'donut',
			},
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}],
			colors: ['#F64E60', '#1BC5BD', '#FFA800', '#6993FF']
		};

		var chart = new ApexCharts(document.querySelector(apexChart), options);
		chart.render();
	}
    $(document).ready(function(){
        initTable1();
        _demo11();
    });
    </script>