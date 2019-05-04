<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title; ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>

     <!-- order table -->
     <section class="content">
        <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Orders Queue</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                
                <table class="table" style="width: 100%">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">Order ID</th>
                        <th class="text-center" style="width: 10%">Order Type</th>
                        <th class="text-center" style="width: 10%">Total Price</th>
                        <th class="text-center" style="width: 10%">Order Time</th>
                        <th class="text-center" style="width: 10%">Order Date</th>
                        <th class="text-center" style="width: 10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                        if(count($orders) == 0) {
                           echo '<tr><td colspan="6" rowspan="10" class="text-center"><br><br><br><br><br><br><h2>No Current Order</h2><br><br><br><br><br><br></td></tr>';
                        }
                      ?>
                      <?php foreach($orders as $order) : ?>
                      <tr>
                        <td class="text-center"><?php echo $order->order_id ?></td>
                        <td class="text-center">
                          <?php 
                            switch ($order->order_type) {
                              case 0: echo "Dine-in"; break;
                              case 1: echo "Take-out"; break;
                              case 2: echo "Deliver"; 
                            }
                          ?>
                        </td>
                        <td class="text-center"><?php echo '&#x20B1; ' . number_format((float)$order->order_total_price, 2) ?></td>
                        <td class="text-center"><?php echo date( "h:i A", strtotime($order->order_date)) ?></td>
                        <td class="text-center"><?php echo date( "m/d/Y", strtotime($order->order_date)) ?></td>
                        <td class="text-center"><button class="btn btn-success my-circle completed" id="<?php echo $order->order_id; ?>">
                        <span class="fa fa-check"></span></button></td>
                      </tr>
                      <tr>
                        <td colspan="6">
                          <table class="table table-bordered" style="width: 70%; margin: auto" id="item-table">
                            <tr class="bg-primary">
                              <th class="text-center" style="width: 10%"></th>
                              <th class="text-center" style="width: 10%">ITEM</th>
                              <th class="text-center" style="width: 10%">SUBCAT</th>
                              <th class="text-center" style="width: 10%">QTY</th>
                              <th class="text-center" style="width: 10%"></th>
                            </tr>
                            <?php $index = 1; ?>
                            <?php foreach($items as $item) :?>
                              <?php 
                                $count = 0;
                                if ($item->order_id == $order->order_id) {
                                   $count++;
                                }
                              ?>
                              <?php for($i = 0; $i < $count; $i++): ?>
                                  <tr id="td_<?php echo $item->order_items_id; ?>">
                                    <?php if($order->order_id == $item->order_id): ?>
                                      <td><?php echo $index ?></td>
                                      <td><?php echo $item->item_name?></td>
                                      <td><?php echo $item->name?></td>
                                      <td><?php echo $item->qty ?></td>
                                      <td class="text-center"><button class="btn btn-warning my-circle item-served" id="<?php echo $item->order_items_id; ?>"><span class="fa fa-check"></span></button></td>
                                    <?php 
                                      $index++;
                                      endif; ?>
                                  </tr>
                              <?php endfor;?>
                            <?php endforeach; ?>
                            </h1>
                          </table>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- order table end -->
</div>

<script>

$(document).ready(function() {

  $(document).on('click', '.completed', function() {
    var order_id = $(this).attr('id');

    $.ajax({
      url: "<?php echo base_url(); ?>orders/completed",
      method: "POST",
      data: {order_id:order_id},
      success: function() {
        location.href = "<?php echo base_url(); ?>orders";
      }
    });
  });

  $(document).on('click','.item-served', function() {
    var item_id = $(this).attr('id');
    var myClass = $(this).children('span').attr('class');

    if (myClass == "fa fa-check") {
      $(this).children('span').removeClass('fa fa-check');
      $(this).children('span').addClass('fa fa-times');
      $("#td_" + item_id).css({"background-color":"#DD4132", "color":"#fff"});
    } else {    
      $(this).children('span').removeClass('fa fa-times');
      $(this).children('span').addClass('fa fa-check');
      $("#td_" + item_id).css({"background-color":"#fff", "color":"#000"});
    }
  });

});

</script>

