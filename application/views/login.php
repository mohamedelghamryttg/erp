<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.png">

    <title>Falaq | Site Manager Login</title>

    <!--Core CSS -->
    <link href="<?php echo base_url();?>assets/bs3/css/bootstrap.min.css"   rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-reset.css" rel="stylesheet">
    <!--link href="<?php echo base_url();?>application/font-awesome/css/font-awesome.css" rel="stylesheet" --/>

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url();?>assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<?php // echo base_url(); ?>
    <body class="login-body">

        <div class="container">

            <form class="form-signin" action="<?php echo base_url()?>Login/doLogin" method="post">
                <h2 class="form-signin-heading">sign in now</h2>
                <div class="login-wrap">
                <div class="user-login-info">
                <?php if($this->session->flashdata('true')){ ?>
                    <div class="alert alert-block alert-danger fade in">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        <strong>Error! </strong><?=$this->session->flashdata('true')?>
                    </div>
                <?php 
                } 
                ?>
                
                <input type="email" class="form-control" placeholder="Email" autofocus name="email" required>
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
            
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
        </div>
      </form>
    </div>
    
    <!-- Placed js at the end of the document so the pages load faster -->

    <!--Core js-->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/bs3/js/bootstrap.min.js"></script>

  </body>
</html>
