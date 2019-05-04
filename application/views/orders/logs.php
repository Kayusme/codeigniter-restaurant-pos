<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title; ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li>Orders</li>
        <li class="active"><?php echo $title; ?></li>
        
      </ol>
    </section>

     <!-- order logs table -->
    <section class="content">
        <div class="box box-primary" id="myBox">
            <div class="box-header">
                <h3 class="box-title">Order History</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="item-table" class="table table-bordered" style="width: 100%">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">Order ID</th>
                        <th class="text-center" style="width: 20%">Cashier</th>
                        <th class="text-center" style="width: 10%">Order Type</th>
                        <th class="text-center" style="width: 10%">Order Price</th>
                        <th class="text-center" style="width: 20%">Discount</th>
                        <th class="text-center" style="width: 10%">Total Price</th>
                        <th class="text-center" style="width: 20%">Order Date</th>
                        <th class="text-center" style="width: 10%"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
    <!-- table end -->

</div>

<script>
    $(document).ready(function() {
        //load datatable
        var dataTable = $('#item-table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url(); ?>orders/fetch_all",
                method: "POST"
            }, 
            "columnDefs": [
                {
                    "targets": [ 1, 2,3,4, 5, 7],
                    "orderable": false
                }
            ] 
        });

        $(document).on('click','.view-items', function() {
            var order_id = $(this).attr('id');

            $.ajax({
                url: "<?php echo base_url(); ?>orders/view",
                method: "POST",
                data: {order_id:order_id},
                success: function(data) {
                    $('#myBox').html(data);
                }
            });
        });

        $(document).on('click','.back',function() {
            location.href =  "<?php echo base_url(); ?>orders/logs";
        });
    });

</script>

<!-- modal add edit  -->
<div class="modal fade" id="modal-view" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>     
        <div class="modal-body">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

      </div>
      
    </div>
  </div>