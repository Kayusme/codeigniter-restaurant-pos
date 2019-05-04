<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Restaurant POS System</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/AdminLTE.min.css">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>RESTAURANT</b><br> Point-of-Sale SYSTEM
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  <div style="width: 100%">
    <img src="<?php echo base_url() ?>assets/dist/img/default.jpg" alt="User Image" 
        width="50%" height="150" class="img-circle" style="margin-left: 25%;">
  </div>
    <p class="login-box-msg">Sign in to start the system</p>

    <form action="<?php echo base_url()?>login/submit" method="post">
      <?php  if (isset($_SESSION['login_failed'])) :  ?>
        <div class="alert alert-danger"><?php echo $_SESSION['login_failed']; ?></div>
      <?php endif; ?>
      <div class="form-group has-feedback">
        <span class="text-danger"><?php echo form_error('username'); ?></span>
        <label>Username</label>
        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username');?>" >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <span class="text-danger"><?php echo form_error('password'); ?></span>
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" >
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-danger btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
