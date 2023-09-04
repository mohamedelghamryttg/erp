<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.png">
    <title>Falaq| Site Manager</title>
    
    
    
    <!--Core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables.min.css"/>


    <!--link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-switch.css" /-->
    <link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css" />
  <!--link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-switch.css" /-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/bootstrap-timepicker/css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/jquery-tags-input/jquery.tagsinput.css" />


    <!--  MultiSelect -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <link href="<?php echo base_url();?>assets/css/select2.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/js/file-uploader/css/jquery.fileupload.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/js/file-uploader/css/jquery.fileupload-ui.css">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet" />
  
  <link rel="stylesheet" href="<?php echo base_url();?>assets/js/data-tables/DT_bootstrap.css" />
  
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.steps.css">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url();?>app/views/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  
  <style>
  section#unseen
  {
    overflow: scroll;
    width: 100%
  }
    .table-bordered{
        white-space: nowrap;
    }
    .table-bordered > thead {
        white-space: normal;
    }
    .numberCircle {
      display:inline-block;
      line-height:0px;
      color: white;
      font-weight: bold;
      border-radius:50%;
      border:2px solid;
      background-color: #F24149;
      font-size:12px;
    }

    .numberCircle span {
      display:inline-block;

      padding-top:50%;
      padding-bottom:50%;

      margin-left:8px;
      margin-right:8px;
    }
  </style>
  <!--Core js-->
  
    <style type="text/css">
        #loading {
           width: 100%;
           height: 100%;
           top: 0;
           left: 0;
           position: fixed;
           display: block;
           opacity: 0.7;
           background-color: #fff;
           z-index: 99;
           text-align: center;
        }

        #loading-image {
          position: absolute;
          top: 100px;
          left: 240px;
          z-index: 100;
        }
    </style>
  <style type="text/css">
      /*btn*/
      .btn-success {
  color:#fff !important;
  background-color: #28a745!important;
  border-color: #28a745;
}

.btn-success:hover {
  color:#fff !important;
  background-color: #28a745!important;
  border-color: #1e7e34;
}
.btn-info {
  color: #fff;
  background-color: #17a2b8;
  border-color: #17a2b8;
}

.btn-info:hover {
  color: #fff;
  background-color: #138496;
  border-color: #117a8b;
}
.btn-warning {
  color: #212529;
  background-color: #ffc107;
  border-color: #ffc107;
}

.btn-warning:hover {
  color: #212529;
  background-color: #e0a800;
  border-color: #d39e00;
}
.btn-danger {
  color: #fff !important;
  background-color:#dc3545!important;
  border-color: #dc3545;
}

.btn-danger:hover {
  color: #fff !important;
  background-color:#dc3545!important;
  border-color: #bd2130;
} 

    </style>

</head>

<body>
<input id="base" type="hidden" value="<?= base_url() ?>">
    <div id="loading" style="display: none;">
    <img id="loading-image" src='<?=base_url()?>assets/images/loader.gif' style='margin-left: 31%;width:300px;height:300px;' />
    </div>
<!-- test bootstrab nav bar -->
<nav class="navbar navbar-expand-lg "style="padding-bottom:10px;background-color:#185898;">
  <a class="navbar-brand" href="#">
    <?php if($this->brand == 1){ ?>
        <img src="<?php echo base_url();?>assets/images/logo_ar.png" alt="" style="height: 53px;width:100%;margin-top:-20px;">
        <?php }elseif ($this->brand == 2) { ?>
            <img src="<?php echo base_url();?>assets/images/dtp_zone.jpg" alt="" style="height: 53px;width:100%;margin-top:-20px;">
        <?php }elseif ($this->brand == 3) { ?>
            <img src="<?php echo base_url();?>assets/images/europe.png" alt="" style="height: 53px;width:100%;margin-top:-20px;">
        <?php } ?>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon" style="background-color:white;"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link text-white" href="<?php echo base_url()?>admin" title="Dashboard">Dashboard <span class="sr-only">(current)</span></a>
      </li>
      <?php foreach ($group as $group) {
        $permission = $this->admin_model->getScreenByGroupAndRole($group->groups, $this->session->userdata('role'));
        ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= ucfirst($this->admin_model->getGroup($group->groups)->name) ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <?php foreach ($permission as $permission) {
            $screen = $this->admin_model->getScreen($permission->screen);
        ?>
          <a class="dropdown-item text-info" href="<?php echo base_url().$screen->url; ?>" title="<?= $screen->name; ?>"><?= $screen->name; ?></a>
        <?php } ?>
        </div>
      </li>
      <?php } ?>
      <li class="nav-item">
            <a class="nav-link text-white" href="<?php echo base_url();?>admin/profile">
            Profile</a>
        </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="<?php echo base_url()?>Login/logout" title="Logout">
            <span>LogOut</span>
    </a>
      </li>
        
    </ul>
  </div>
</nav>
<!-- -->


<!-- sidebar menu end-->
<!--main content start-->
<section id="main-content"class="mx-auto" style="margin-top:5;">
  <section class="">