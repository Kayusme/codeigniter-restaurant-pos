<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="my-content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $order_number; ?></h3>

              <p>Today's Number of Orders</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-basket"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>&#x20B1;<?php echo  number_format((float)$today_sales, 2); ?></h3>

              <p>Today's Total Sales</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>&#x20B1;<?php echo  number_format((float)$month_sales, 2); ?></h3>

              <p>Total Monthly Sales</p>
            </div>
            <div class="icon">
              <i class="fa fa-diamond"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

<!-- charts -->
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/bower_components/chart.js/Chart.js"></script>

    <section class="my-content">
        <div class="row">
            <div class="col-lg-6 col-s-12">
              <div class="box box-danger">
                  <div class="box-header with-border">
                      <h3 class="box-title">Monthly Sales</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <canvas id="canvas" class="my-chart"></canvas>
                  </div>
                </div>
            </div>
            <div class="col-lg-6 col-s-12">
              <div class="box box-danger">
                  <div class="box-header with-border">
                      <h3 class="box-title">Daily Sales</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
				            <canvas id="canvas2" class="my-chart"></canvas>
                  </div>
                </div>
		      	</div>
		  </div>
    </section>

	<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels : [<?php echo $months ?>],
		datasets : [
			{
				fillColor : "#ff666a",
				strokeColor : "#ff4441",
				highlightFill: "#81ff85",
				highlightStroke: "#81ff85",
				data : [<?php echo $sales_per_month ?>]
			}
		]

	}

		var lineChartData = {
			labels : [<?php echo $days ?>],
			datasets : [
				{
					label: "Daily Sales",
					fillColor : "#ff666a",
					strokeColor : "#ff4441",
					pointColor : "#81ff85",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [<?php echo $sales_per_day ?>]
				}
			]

		}

	window.onload = function(){
		var ctx = document.getElementById("canvas2").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
        var ctx2 = document.getElementById("canvas").getContext("2d");
	    	window.myBar = new Chart(ctx2).Bar(barChartData, {
			responsive : true
		});
	}

	</script>
    <!-- end chart -->

</div>
<!-- end wrapper -->