<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title; ?>
        <small>reports | statistics</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li>Menu</li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>
    <br>
    <div class="content">    
      <div class="box box-danger">
          <div class="box-header with-border">
              <h3 class="box-title">Sales</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="pull-left">
                <!-- Date and time range -->
                <div class="form-group">
                  <div class="input-group">
                    <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                      <span>
                        <i class="fa fa-calendar"></i> Date range picker
                      </span>
                      <i class="fa fa-caret-down"></i>
                    </button>
                    <button id="generate" class="btn btn-primary">Generate</button>
                  </div>
                </div>
                <!-- /.form group -->
            </div>
            <div class="pull-right">      
                  <button  class="btn btn-success my-btn excel"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                  <button  class="btn btn-danger my-btn pdf"><i class="fa fa-file-pdf-o"></i> Export to PDF</button>
              </div>
            <div id="result"></div>
          </div>

    </div>


  </div>
</div>
<!-- date-range-picker -->
<script src="<?php echo base_url()?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url()?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url()?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
 $(document).ready(function() {
    var startdate;
    var enddate;

    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        startdate = start;
        enddate = end;
      }
    );

    $(document).on('click', '#generate', function() {
      var start = startdate.format('MM/D/YYYY');
      var   end = enddate.format('MM/D/YYYY');
        $.ajax({
          url: "<?php echo base_url() ?>sales/fetch",
          method: "POST",
          data: {start:start, end:end},
          dataType: "html",
          success: function(data) {
              $("#result").html(data);
          }
        });
    });

    $(document).on('click', '.excel', function() {
      var start = startdate.format('MM/D/YYYY');
      var   end = enddate.format('MM/D/YYYY');
        $.ajax({
          url: "<?php echo base_url() ?>excel_export/action",
          success: function() {
            open("<?php echo base_url() ?>excel_export/action?start="+start+"&end="+end, '_blank');
          }
        });
    });

    $(document).on('click', '.pdf', function() {
      var start = startdate.format('MM/D/YYYY');
      var   end = enddate.format('MM/D/YYYY');
        $.ajax({
          url: "<?php echo base_url() ?>pdf_export/action",
          success: function() {
            open("<?php echo base_url() ?>pdf_export/action?start="+start+"&end="+end, '_blank');
          }
        });
    });

  
 });
</script>