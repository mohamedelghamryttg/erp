<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>assets/auth/assets/images/favicon.ico">
        <!-- App title -->
        <title> App Games Free</title>
        <link rel="stylesheet" href="<?=base_url()?>assets/auth/assets/plugins/morris/mirrors.css">
        <!-- Editatable  Css-->
        <link rel="stylesheet" href="<?=base_url()?>assets/auth/assets/css/magnific-popup.css" />
        <link rel="stylesheet" href="<?=base_url()?>assets/auth/assets/css/datatables.css" />
        <!-- App CSS -->
        <link href="<?=base_url()?>assets/auth/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/auth/assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/auth/assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/auth/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/auth/assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/auth/assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/auth/assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <!-- form Uploads -->
        <link href="<?=base_url()?>assets/auth/assets/css/dropify.min.css" rel="stylesheet" type="text/css" />

	        <?php 
	foreach($css_files as $file): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php endforeach; ?>
	<?php foreach($js_files as $file): ?>
		<script src="<?php echo $file; ?>"></script>
	<?php endforeach; ?>

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?=base_url()?>assets/auth/assets/js/modernizr.min.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-74137680-1', 'auto');
  ga('send', 'pageview');

</script>
        
    </head>
     <body>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a target="_blank" href="<?=base_url()?>" class="logo"><span>App Games<span> Free</span></span></a>
                    </div>
                    <!-- End Logo container-->


                    <div class="menu-extras">

                        <ul class="nav navbar-nav navbar-right pull-right">
                            <!-- <li>
                                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                                     <input type="text" placeholder="Search..." class="form-control">
                                     <a href=""><i class="fa fa-search"></i></a>
                                </form>
                            </li> -->
                            <li class="dropdown user-box">
                                <a href="" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown" aria-expanded="true">
                                    <img src="<?=base_url()?>assets/auth/assets/images/avatar2.png" alt="user-img" class="img-circle user-img">
                                    <div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="<?=base_url()?>auth/logout"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <li>
                                <a href="<?=base_url()?>admin"><i class="zmdi zmdi-view-dashboard"></i> <span> Dashboard </span> </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>admin/games"><i class="zmdi zmdi-playstation zmdi-hc-fw"></i> <span> Games </span> </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>admin/banner"><i class="zmdi zmdi-book-image zmdi-hc-fw"></i> <span> Banners Management </span> </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>admin/add_meta"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i> <span> Meta Tags </span> </a>
                            </li>
                        </ul>
                        <!-- End navigation menu  -->
                    </div>
                </div>
            </div>
        </header>
        <!-- End Navigation Bar-->
<body>
	
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
