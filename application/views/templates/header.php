<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>R-POS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- MY CSS --> 
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css"> 
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/skins/skin-red.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
  <script src="<?php echo base_url(); ?>assets/bower_components/datatable/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/bower_components/datatable/js/dataTables.bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url()?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url()?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>assets/dist/js/adminlte.min.js"></script>

</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">
<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>DH</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PALMERA</b> DIMSUMHOUSE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
       
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url() ?>assets/dist/img/default.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">
                <?php 
                  if(isset($_SESSION['name'])) {
                      echo $_SESSION['name']; 
                  }  
                ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url() ?>assets/dist/img/default.jpg" class="img-circle" alt="User Image">
                <p>
                  <?php 
                    if(isset($_SESSION['name'])) {
                        echo $_SESSION['name']; 
                    } 
                  ?>
                  <small>
                    <?php 
                    if(isset($_SESSION['usertype'])) {
                        echo $_SESSION['usertype']; 
                    } 
                    ?>
                  </small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-info btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url() ?>login/terminate" class="btn btn-warning btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>