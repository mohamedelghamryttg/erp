<!DOCTYPE html>

<html lang="en">
    <head>
        <base href="">
        <meta charset="utf-8" />
        <title>Falaq | Site Manager</title>
        <meta name="description" content="Updates and statistics" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="canonical" href="https://keenthemes.com/metronic" />
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Page Vendors Styles(used by this page)-->
        <link href="<?php echo base_url(); ?>assets_new/plugins/custom/fullcalendar/fullcalendar.bundle.css"
              rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles-->
        <!--begin::Global Theme Styles(used by all pages)-->
        <link href="<?php echo base_url(); ?>assets_new/css/pages/wizard/wizard-2.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets_new/plugins/global/plugins.bundle.css" rel="stylesheet"
              type="text/css" />
        <link href="<?php echo base_url(); ?>assets_new/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet"
              type="text/css" />
        <link href="<?php echo base_url(); ?>assets_new/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

        <?php if ($this->brand == 1) { ?>
            <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo_ar.png" />
        <?php } elseif ($this->brand == 2) { ?>
            <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/localizera_logo.png" />
        <?php } elseif ($this->brand == 3) { ?>
            <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/europe.png" />
        <?php } elseif ($this->brand == 11) { ?>
            <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/columbus_logo.jpg" />
        <?php } ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="<?php echo base_url(); ?>assets_new/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
              type="text/css" />
        <script>
            function getBadReviewDiv() {
    var value = $("#myRange").val();
    if (value < 5) {
        var model_body = $("#setup").html();
        $(".bad_review").html(model_body);
    } else {
        $(".bad_review").html('');
    }

}
            </script>
    </head>
    <!--end::Head-->
    <!--begin::Body-->
 
    <body id="kt_body"
          class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed aside-enabled aside-static page-loading">
        <!--begin::Main-->
        <input id="base" type="hidden" value="<?= base_url() ?>">
        <div id="loading" style="display: none;">
            <img id="loading-image" src='<?= base_url() ?>assets/images/loader.gif'
                 style='margin-left: 31%;width:300px;height:300px;' />	
        </div>
        <!--begin::Header Mobile-->
        <div id="kt_header_mobile" class="header-mobile header-mobile-fixed">
            <!--begin::Logo-->
            <a href="<?= base_url() ?>admin">

                <?php if ($this->brand == 1) { ?>
                    <img alt="Logo" src="<?php echo base_url(); ?>assets/images/logo_ar.png" class="logo-default max-h-40px" />
                <?php } elseif ($this->brand == 2) { ?>
                    <img alt="Logo" src="<?php echo base_url(); ?>assets/images/localizera_logo.png"
                         class="logo-default max-h-20px" />
                     <?php } elseif ($this->brand == 3) { ?>
                    <img alt="Logo" src="<?php echo base_url(); ?>assets/images/europe.png" class="logo-default max-h-50px" />
                <?php } elseif ($this->brand == 11) { ?>
                    <img alt="Logo" src="<?= base_url(); ?>assets/images/columbus_logo.jpg" class="logo-default max-h-70px" />
                <?php } ?>
            </a>
            <!--end::Logo-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <button class="btn p-0 burger-icon rounded-0 burger-icon-left" id="kt_aside_tablet_and_mobile_toggle">
                    <span></span>
                </button>
                <button class="btn btn-hover-text-primary p-0 ml-3" id="kt_header_mobile_topbar_toggle">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                        <path
                            d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                            fill="#000000" fill-rule="nonzero" />
                        </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </button>
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header Mobile-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">
               
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <!--begin::Header-->
                    <div id="kt_header" class="header header-fixed">
                        <!--begin::Container-->
                        <div class="container d-flex align-items-stretch justify-content-between">
                            <!--begin::Left-->
                            <div class="d-none d-lg-flex align-items-center mr-3">                               
                                <!--begin::Logo-->
                                <a href="#">
                                         <?php if ($this->brand == 1) { ?>
                                        <img alt="Logo" src="<?php echo base_url(); ?>assets/images/logo_ar.png"
                                             class="logo-default max-h-50px" />
                                         <?php } elseif ($this->brand == 2) { ?>
                                        <img alt="Logo" src="<?php echo base_url(); ?>assets/images/localizera_logo.png"
                                             class="logo-default max-h-20px" />
                                         <?php } elseif ($this->brand == 3) { ?>
                                        <img alt="Logo" src="<?php echo base_url(); ?>assets/images/europe.png"
                                             class="logo-default max-h-70px" />
                                         <?php } elseif ($this->brand == 11) { ?>
                                        <img alt="Logo" src="<?= base_url(); ?>assets/images/columbus_logo.jpg"
                                             class="logo-default max-h-70px" />
<?php } ?>
                                </a>
                                <!--end::Logo-->
                            </div>
                            <!--end::Left-->
                          
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Header-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <br/>
                            <!--begin::Card-->
                            <div class="row">
                                <div class="col-lg-12">
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
                                                    <?php }?>
                                </div>
                            </div>
                            
                            <div class="card card-custom example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">Customer Evaluation</h3>

                                </div>
                                <!--begin::Form-->
                                <?php if($customerEv > 0){?>
                                      <div class="card-body min-h-500px"> 
                                    <span><strong>Thanks For Your Feedback</strong></span>  
                                      </div>
                                                  
                                <?php }else{?>
                                <form class="form"action="<?php echo base_url() ?>customerEvaluation/saveCustomerEvaluation" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="project_id"  value="<?=$project_id?>">
                                        <input type="hidden" name="customer_id"  value="<?=$customer_id?>">
                                        <input type="hidden" name="job_id"  value="<?=$job_id?>">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Rate </label>
                                            <div class="col-lg-9">
                                                <div class="slidecontainer">
                                                    <input type="range" name="ev_select" min="0" max="10" value="5" class="slider" id="myRange" onchange="getBadReviewDiv();" oninput="this.nextElementSibling.value = this.value" style="display: inline-block;width: auto;"><output style="display: inline-block;position: relative;top: -25px;left: -11%;">5</output>
                                                </div>
                                            </div>
                                        </div>
                                  
                                        <div class="bad_review">
                                          
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Note : </label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" name="note" rows="5" cols="10" ></textarea>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-6">
                                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                                <input class="btn btn-default" type="reset" value="Cancel"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php }?>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>
                </div> 
                </div> 
                </div> 
        <?php if($customerEv == 0){?>
<div id="setup" style="display:none">
     <table class="table table-head-custom table-checkable table-hover table-bordered" >
        <thead>
            <tr>
                <th width='10%'></th>
                <th>Items to be checked</th>           
            </tr>
        </thead>
        <tbody> 
            <?php for($x=1;$x<=6;$x++){
                  $c_ev_name = "c_ev_name".$x;                                      
                if($evaluation->$c_ev_name !=null){
                ?>
            <tr>
                <td>                   
                    <input type="checkbox" name="<?="c_ev_val".$x?>" value="1">
                </td>
                <td width='50'><?=$evaluation->$c_ev_name ?></td>           
            </tr>
            <?php } }?>
        </tbody>
    </table>
</div>
<?php } ?>
    </body>
</html>