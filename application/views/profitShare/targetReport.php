<style>
    .table.table-head-custom tbody th {
        font-weight: 600;
        color: #B5B5C3 !important;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.1rem;
    }
    </style>
<div class="d-flex flex-column-fluid mt-2">
    <!--begin::Container-->
    <div class="container">
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
                <span class="fa fa-warning"></span>
                <span><strong>
                        <?= $this->session->flashdata('error') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact"  >
            <div class="card-header">
                <h3 class="card-title text-dark-50"><i class="flaticon-analytics mr-2 text-danger"></i> Company Performance <?=$row->year?></h3>
            </div>
            <div class="card-body" style="text-transform: uppercase;">
                <p class="font-weight-bolder font-size-lg"> <i class="flaticon-pie-chart mr-2 text-danger"></i>Target  
                    <a title="Edit Target" href="<?= base_url() . 'profitShare/editProfitShareSettings?t=' . base64_encode($row->id); ?>" class="btn btn-sm btn-clean btn-icon btn-hover-primary ">
                                   <i class='flaticon2-pen mr-2'></i> </a>
                </p>                    
                <table class="table table-head-custom table-bordered text-center ml-6 mb-10" style="width:98%!important">
                    <thead>
                        <tr><th > </th>   
                            <?php foreach ($regions as $region) { ?>                                                             
                                <th><?= $region->name ?></th>
                            <?php } ?>
                                <th class="bg-radial-gradient-dark text-white"><span class="text-white">Total</span></th>
                                <th class="bg-radial-gradient-dark text-white"><span class="text-white">Target<br/> Contribution </span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($brands as $val) {
                            $brandTargetContribution = $this->profitShare_model->getBrandTargetContribution($row->year, $val->id);
                            $total = 0;?>
                            <tr>
                                <th><?= $val->name ?></th>
                                <?php foreach ($regions as $region) {
                                    $value = $this->profitShare_model->getBrandRegionTarget($row->year, $val->id, $region->id);
                                    $total += $value; ?>
                                    <td><?=  number_format($value); ?> $</td>
                                <?php } ?> 
                                <td class="bg-radial-gradient-dark text-white"><?= number_format($total) ?> $</td>
                                <td class="bg-radial-gradient-dark text-white"><?= $brandTargetContribution ?> %</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <hr/>
                <hr/>
                <p class="font-weight-bolder font-size-lg mt-10"> <i class="flaticon-apps mr-2 text-danger"></i>Achieved % Per Region / Per Brand
                    <a title="Edit Achieved" href="<?= base_url() . 'profitShare/editProfitAchieved?t=' . base64_encode($row->id); ?>" class="btn btn-sm btn-clean btn-icon btn-hover-primary ">
                                  <i class='flaticon2-pen mr-2'></i> </a>
                </p>                    
                <div class="row mt-2">
                    <!--begin::Chart-->
                     <div class="col-xl-6">
                        <div id="chart_h1"></div>                    
                    </div>
                     <div class="col-xl-6">
                        <div id="chart_h2"></div>                    
                    </div>
                    <!--end::Chart-->
                </div>
                <div class="row mt-2">
                        <?php for($i=1;$i<=2;$i++){?>                       
                            <table class="table table-head-custom table-bordered text-center ml-6 mb-10" style="width:98%!important" >
                                <thead>
                                    <tr>
                                        <td colspan="9" class="font-weight-bolder text-danger"> H<?= $i?>  
                                            <button id="button_filter<?= $i?>" onclick="showAndHide2('filter2<?= $i?>', 'button_filter<?= $i?>');"
                                                class="btn btn-icon btn-outline-danger btn-circle btn-sm mr-2"><i class="far fa-arrow-alt-circle-up"></i></button>
                                        </td>   
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th rowspan="2"></th>   
                                        <?php foreach ($regions as $region) { ?>                                                             
                                            <th colspan="2"><?= $region->name ?></th>
                                        <?php } ?>
                                            <th colspan="2" class="bg-success text-white"><span class="text-white">Total</span></th>
                                    </tr>
                                    <tr>                                        
                                        <?php foreach ($regions as $region) { ?>   
                                        <th>$</th>   
                                        <th>%</th>  
                                        <?php }?>
                                        <th class="bg-success text-white"><span class="text-white">$</span></th>   
                                        <th class="bg-success text-white"><span class="text-white">%</span></th> 
                                    </tr>
                                </thead>
                                <tbody id="filter2<?= $i?>">
                                    <?php
                                    foreach ($brands as $val) {
                                        $total = 0;?>
                                        <tr>
                                            <th><?= $val->abbreviations ?></th>
                                            <?php foreach ($regions as $region) {
                                                $value = $this->profitShare_model->getBrandRegionAchieved($row->year, $val->id, $region->id,$i);
                                                $valuePer = $this->profitShare_model->getBrandRegionAchievedPer($row->year, $val->id, $region->id,$i);
                                                $total += $value; ?>
                                                <td><?= number_format($value) ?> $</td>
                                                <td  class="bg-light-dark text-white"><?= $valuePer ?> %</td>
                                            <?php } ?> 
                                            <td class="bg-success text-white"><?= number_format($total) ?> $</td>
                                            <td class="bg-success text-white"><?= $this->profitShare_model->getBrandAchievedPer($row->year, $val->id,$i) ?> %</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                       
                        <?php }?>                    
                    </div>
                <hr/>
                <hr/>
                 <p class="font-weight-bolder font-size-lg mt-10"> <i class="flaticon-graphic-2 mr-2 text-danger"></i>Brand Region Achieved vs performance Matrix ( corporate profitability share ) 
                  
                </p>
                      <div class="row mt-2">
                        <?php for($i=1;$i<=2;$i++){?>
                        <div class="col-xl-6">
                            <table class="table table-head-custom table-bordered text-center <?=$i==1?'ml-5':''?>" >
                                <thead>
                                    <tr>
                                        <td colspan="5" class="font-weight-bolder text-danger"> H<?= $i?> </td>   
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
                                         $brand_score = $this->profitShare_model->getBrandAchievedMatrix($row->year, $val->id,$i);?>
                                        <tr>
                                            <th><?= $val->abbreviations ?></th>
                                            <?php foreach ($regions as $region) {
                                                $region_score = $this->profitShare_model->getBrandRegionAchievedMatrix($row->year, $val->id, $region->id,$i);
                                                 ?>
                                            <td><?= $region_score ?> %</td>
                                            <?php } ?> 
                                            <td class="bg-success text-white"><?= $brand_score ?> %</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php }?>                    
                </div>
            </div>
               
        
        </div>
    </div>
</div>
<script src="<?= base_url()?>assets_new/js/pages/features/charts/apexcharts.js"></script>
<script>
     $(document).ready(function(){
      
        _demo3();
    });
     const categories = [];
     const dataEMEA = [];const dataEMEA2 = [];
     const dataAPAC = [];const dataAPAC2 = [];
     const dataAmericas = [];const dataAmericas2 = [];
    <?php foreach ($brands as $val){
            foreach ($regions as $region) {
                $regionPer[$region->id] =  $this->profitShare_model->getBrandRegionAchievedPer($row->year, $val->id, $region->id,1);
                $regionPer2[$region->id] =  $this->profitShare_model->getBrandRegionAchievedPer($row->year, $val->id, $region->id,2);}?>
        categories.push("<?=$val->abbreviations?>");     
            dataAmericas.push(<?=$regionPer[1]?>);                
            dataAPAC.push(<?=$regionPer[2]?>);                
            dataEMEA.push(<?=$regionPer[3]?>);                 
            dataAmericas2.push(<?=$regionPer2[1]?>);                
            dataAPAC2.push(<?=$regionPer2[2]?>);                
            dataEMEA2.push(<?=$regionPer2[3]?>);                 
    <?php }?>
    var _demo3 = function () {
		const apexChart = "#chart_h1";
		const apexChart2 = "#chart_h2";
		var options = {
			series: [{
				name: 'EMEA',
				data: dataEMEA
			}, {
				name: 'APAC',
				data: dataAPAC
			}, {
				name: 'Americas',
				data: dataAmericas
			}],
			chart: {
				type: 'bar',
				height: 350
			},
                        plotOptions: {
				bar: {
                                    horizontal: false,
                                    columnWidth: '55%',
                                    endingShape: 'rounded',
                                    dataLabels: {
                                       orientation: 'vertical',
                                       position: 'center' // top, center, bottom
                                     },
                            },
			},
			dataLabels: {
				enabled: true,
                                 formatter: function (val) {
                                    return val + "%";
                                  },                                   
                                style: {
                                    fontSize: '10px',
                                    colors: ["#fff"]
                                }
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			title: {
				text: 'Achieved % Per Region/Brand H1'
			},
			xaxis: {
				categories: categories,
			},
			yaxis: {
				title: {
					text: '% (percentage)'
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return  val + " %"
					}
				}
			},
			colors: ['#F64E60', '#1BC5BD', '#FFA800']
		};
		var options2 = {
			series: [{
				name: 'EMEA',
				data: dataEMEA2
			}, {
				name: 'APAC',
				data: dataAPAC2
			}, {
				name: 'Americas',
				data: dataAmericas2
			}],
			chart: {
				type: 'bar',
				height: 350
			},
			plotOptions: {
				bar: {
                                    horizontal: false,
                                    columnWidth: '55%',
                                    endingShape: 'rounded',
                                    dataLabels: {
                                       orientation: 'vertical',
                                       position: 'center' // top, center, bottom
                                     },
                            },
			},
			dataLabels: {
				enabled: true,
                                 formatter: function (val) {
                                    return val + "%";
                                  },                                   
                                style: {
                                    fontSize: '10px',
                                    colors: ["#fff"]
                                }
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			title: {
				text: 'Achieved % Per Region/Brand H2'
			},
			xaxis: {
				categories: categories,
			},
			yaxis: {
				title: {
					text: '% (percentage)'
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return  val + " %"
					}
				}
			},
			colors: ['#F64E60', '#1BC5BD', '#FFA800']
		};

		var chart = new ApexCharts(document.querySelector(apexChart), options);
		chart.render();
		var chart2 = new ApexCharts(document.querySelector(apexChart2), options2);
		chart2.render();
	}
        
   
</script>