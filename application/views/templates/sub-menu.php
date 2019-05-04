<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>assets/dist/img/default.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>
            <?php 
              if(isset($_SESSION['name'])) {
                  echo $_SESSION['name']; 
              } 
            ?>  
          </p>
          <a href="#"><i class="fa fa-circle text-success"></i>
            <?php 
              if(isset($_SESSION['usertype'])) {
                  echo $_SESSION['usertype']; 
              } 
            ?>
          </a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <?php if($_SESSION['usertype'] == 'admin'):?>
        <li>
          <a href="<?php echo base_url() ?>dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
          <?php endif; ?>
				<li>
					<a href="<?php echo base_url() ?>counter">
						<i class="fa fa-calculator"></i> <span>Counter</span>
					</a>
				</li>			
        
        <?php if($_SESSION['usertype'] == 'admin'):?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-shopping-basket"></i> <span>Orders</span><span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </a>           
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>orders"><i class="fa fa-circle-o"></i> View Orders</a></li>
              <li><a href="<?php echo base_url(); ?>orders/logs"><i class="fa fa-circle-o"></i> Orders History</a></li>
            </ul>
          </li>
        <?php endif; ?>
        <?php if($_SESSION['usertype'] != 'admin'):?>
           <li>
           <a href="<?php echo base_url(); ?>orders">
              <i class="fa fa-shopping-basket"></i> <span>Orders</span>
            </a>  
            </li>
        <?php endif; ?> 
          <?php if($_SESSION['usertype'] == 'admin'):?>
            <li class="treeview">
            <a href="#">
              <i class="glyphicon glyphicon-cutlery"></i> <span>Menu</span><span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()?>items"><i class="fa fa-circle-o"></i> Manage Items</a></li>
                <li><a href="<?php echo base_url()?>categories"><i class="fa fa-circle-o"></i> Categories</a></li>
              </ul>
            </li>
            <li>
              <a href="<?php echo base_url() ?>users">
                <i class="glyphicon glyphicon-user"></i> <span>Users</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url()?>sales">
                <i class="fa fa-money"></i> <span>Sales</span>
              </a>
            </li>
          <?php endif;?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>