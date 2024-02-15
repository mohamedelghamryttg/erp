<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
    .custom {
        font-weight: 700;
        color: #7E8299 ;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.1rem;
    }
    .label {
        height: 100%;
    }
    
</style>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <?php if ($this->session->flashdata('true')) { ?>
                <div class="alert alert-success" role="alert">
                    <span class="fa fa-check-circle"></span>
                    <span><strong><?= $this->session->flashdata('true') ?></strong></span>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <span class="fa fa-warning"></span>
                    <span><strong><?= $this->session->flashdata('error') ?></strong></span>
                </div>
            <?php } ?>
            <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><a class="text-dark" href="<?php echo base_url() ?>ProfitShare/">Profit Share Report</a></h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Record Details  </span>

                    </div>
                    <!--end::Search Form-->

                </div>
                <!--end::Details-->

            </div>
        </div>
              
            <!-- start search form card -->
            <div class="card card-custom gutter-b example example-compact">              
                <div class="card-body">
                    <table class="table table-head-custom table-bordered" width="100%" id="kt_datatable2">
                        <tbody>
                            <tr>
                                <td class="w-25">
                                    <p class="custom">Name</p>
                                </td>
                                <td colspan="3"><?= $this->automation_model->getEmpName($emp_id); ?>
                                    <br /><span class="label label-square label-dark label-inline font-weight-bold">
                                <?= $this->automation_model->getEmpDep($emp_id); ?></span>
                                    </td>
                            </tr>
                            <tr>
                                <td> <p class="custom">Year</p></td>
                                <td colspan="3"><?=$year?> <span class="label label-primary label-inline font-weight-bold"> Half : <?=$half?></span></td>
                            </tr> 
                            <tr>
                                <td>
                                    <p class="custom">Equation</p>
                                </td>
                                <td colspan="3"><?= $equation?></td>
                            </tr>
                             <tr>
                                <td>
                                    <p class="custom">Salary</p>
                                </td>
                                <td colspan="3"><?=  number_format($record['salary']) ?></td>                                
                            </tr>
                            <tr>
                                <td class="w-25">
                                    <p class="custom">Hiring Date</p>
                                </td>
                                <td class="w-25"><?= $record['hiring_date'] ?></td>
                                <td class="w-25">
                                    <p class="custom">Due vs. Hiring </p>
                                </td>
                                <td class="w-25"><?= $record['hiring_per'] ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="custom">Avg. Score</p>
                                </td>
                                <td><?= $record['avg_score'] ?></td>
                                <td>
                                    <p class="custom">Performance </p>
                                </td>
                                <td><?= $record['empPerformance'] ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="custom">Num. Of Brands</p>
                                </td>
                                <td><b><?= $record['brands_num'] ?></b>
                                <span class="label label-square label-dark label-inline font-weight-bold">
                                <?= $this->hr_model->getBrand($emp_brands); ?></span></td>
                                <td>
                                    <p class="custom">Coefficient </p>
                                </td>
                                <td><?= $record['brands_Coefficient'] ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="custom">Region</p>
                                </td>
                                <td colspan="3"><?= $this->profitShare_model->getEmpRegion($emp_id) ?></td>
                                
                            </tr>
                            <tr>                               
                                <td colspan="2">
                                    <table class="table table-head-custom table-bordered text-center" >
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="font-weight-bolder text-danger"><i class="flaticon-graphic-2 mr-2 text-danger"></i>Brand Region Achieved vs performance Matrix / corporate profitability share ( H<?= $half?> )</td>   
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
                                </td>
                                <td colspan="2">
                                    <table class="table table-head-custom table-bordered text-center" >
                                        <thead>
                                            <tr>
                                                <td class="font-weight-bolder text-danger"><i class="flaticon-pie-chart-1 mr-2 text-danger"></i>Brand Contribution</td>   
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <div id="chart" class="d-flex justify-content-center"></div>
                                        </tbody>
                                    </table>
                                </td>                                
                            </tr>
                            </tbody>
                    </table>   
                    <hr/><table class="table table-head-custom table-bordered" width="100%" id="kt_datatable2">
                      <tbody>
                            <tr class="bg-dark text-white">
                                <td>
                                    <p class="custom text-white">Net Profit Share Amount</p>
                                </td>
                                <td colspan="3">
                                    <b><?= number_format($record['profit_amount']) ?></b>
                                </td>
                            </tr>
                            <tr class="bg-dark text-white">
                                <td>
                                    <p class="custom text-white">Bonus</p>
                                </td>
                                <td colspan="3">
                                    <b><?= number_format($bonus_amount) ?></b>
                                    <a class="btn btn-sm ml-5 btn-danger" data-toggle="modal" data-target="#addModal"><i class='flaticon2-pen mr-2 text-white'></i> Edit Bouns</a>
                                </td>
                            </tr>                          
                            <tr class="bg-dark text-white">
                                <td>
                                    <p class="custom text-white">Total</p>
                                </td>
                                <td colspan="3">
                                    <b><?= number_format($record['profit_amount'] + $bonus_amount) ?></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>                   
                </div>               
                <!-- Modal-->
                <div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog"
                        aria-labelledby="staticBackdrop" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">add Bonus</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <form class="cmxform form-horizontal "
                                    action="<?php echo base_url() ?>ProfitShare/addEmpBonus" method="post"
                                    enctype="multipart/form-data">

                                    <div class="modal-body">
                                        <input type="hidden" name="year" value="<?=base64_encode($year)?>"/>
                                        <input type="hidden" name="half" value="<?=base64_encode($half)?>"/>    
                                        <input type="hidden" name="emp_id" value="<?=base64_encode($emp_id)?>"/>
                                        <div class="form-group row">
                                            <label class="col-lg-3 control-label" for="comment">Amount</label>
                                            <div class="col-lg-9">
                                                <input type='number' name="amount" class="form-control" required="" min="0" value="<?= $bonus_amount ?>" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-dark font-weight-bold">Save</button>
                                        <button type="button" class="btn btn-default font-weight-bold"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
            </div> 
                 
        </div>
    </div>
</div>
    
<!--begin::Page Scripts(used by this page)-->
<script src="<?= base_url()?>assets_new/js/pages/features/charts/apexcharts.js"></script>
<!--end::Page Scripts-->
<script>    
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
        _demo11();
    });
    </script>