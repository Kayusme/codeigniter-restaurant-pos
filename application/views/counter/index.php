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
    <br>
    <section class="content">
      <div class="box box-danger">
        <div class="row">
            <!-- category section -->
            <div class="col-md-3 ">
                <!-- category -->
                <div class="box-header with-border">
                    <h3 class="box-title">Categories</h3><br>                    
                </div>
                    <!-- /.box-header -->
                <div class="box-body">
                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach($categories as $category): ?>
                            <li><button class="filter-category btn btn-primary btn-block" id="<?php echo $category->category_id?>">
                                <?php echo $category->category_name; ?>
                            </button></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>

            <!-- items section -->
            <div class="col-md-5" style="height: 520px;">
                <div class="box-header with-border">
                    <h3 class="box-title">Menu - Items</h3><br><br>
                    <div class="text-center">
                        <input type="text" placeholder="search items" class="form-control" id="search"><br>
                        <label class="radio-inline">
                            <input type="radio" name="optradio" value="0" class="opt-subcat" id="subcat-all" checked>
                            All
                            </label>
                        <?php foreach($subcategories as $subcategory): ?>
                            <label class="radio-inline">
                            <input type="radio" name="optradio" value="<?php echo $subcategory->id ?>" class="opt-subcat">
                            <?php echo $subcategory->name ?>
                            </label>
                        <?php endforeach;?>
                    </div>
                </div>
                    <!-- /.box-header -->
                <div class="box-body">  
                    <div class="flex" id="items-container"> 

                    </div>
                </div>
            </div>

            <!-- order summary -->
            <div class="col-md-4">
                <div class="">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Summary</h3>
                    </div>
                        <!-- /.box-header -->
                    <div class="box-body">
                        <div id="order">
                            
                        </div>
                    </div>
                </div>
            </div>  
         </div>
       </div> 
    </section>
</div>

<script>

$(document).ready(function(){
    var id = ""; 

   //display order onload 
   load_order_summary();

    //filter by category
    $(document).on("click",".filter-category", function() {
        var cat_id = $(this).attr('id');
        id = cat_id;
        var subcat_id = $('input[name=optradio]:checked').val();

        $('#items-container').html('loading....');

        $.ajax({
            url: "counter/filter_category",
            method: "POST",
            data: {cat_id:cat_id, subcat_id:subcat_id},
            dataType: 'html',
            success: function(data) {    
                $('#items-container').html(data);          
            }
        });
        
    }); 

    //filter item by textbox search
    $(document).on('change', '#search', function() {
        var search_text = $(this).val();
        $('#items-container').html('loading....');
        $('input[name=optradio][value=0]').click();
        $.ajax({
            url: "counter/filter_items",
            method: "POST",
            data: {search_text: search_text},
            dataType: 'html',
            success: function(data) {    
                $('#items-container').html(data);   
                $("#search").val('');             
            }
        });
    });

    //filter item by radio button
    $(document).on('change', '.opt-subcat', function() {
        var subcat_id = $('input[name=optradio]:checked').val();

        $('#items-container').html('loading....');

        $.ajax({
            url: "counter/filter_category",
            method: "POST",
            data: {cat_id:id, subcat_id:subcat_id},
            dataType: 'html',
            success: function(data) {    
                $('#items-container').html(data);          
            }
        });
    });

    //add item to summary
    $(document).on('click', '.items', function() {
        var item_id = $(this).attr('id');    
        $('.items').css('display', 'none');
        $.ajax({
            url: "counter/add_item",
            method: "POST",
            data: {item_id:item_id},
            dataType: "html",
            success: function(data) {    
                $('#order').html(data);     
                $('.items').css('display', 'block');
            }
        });
    });

    //delete an item
    $(document).on('click', '.delete-item', function() {
        var rowid = $(this).attr('id');
          
        $('.delete-item').attr('disabled', 'disabled');
        $.ajax({
            url: "counter/delete_item",
            method: "POST",
            data: {rowid:rowid},
            success: function(data) {         
                $('#order').html(data);      
            }
        });
    });

    // clear all items
    $(document).on('click', '.clear-item', function() {
        if (confirm("Are you sure you want to clear all items in the summary?")) {    
            $.ajax({
                url: "counter/clear_item",
                success: function(data) {         
                    $('#order').html(data);      
                }
            });   
        }
    });

    // change quantity by textbox
    $(document).on('change', '.order-input', function() {
        var rowid = $(this).attr('id');
        var qty = $(this).val();
        $.ajax({
            url: "counter/update_quantity",
            method: "POST",
            data: {rowid:rowid, qty:qty},
            success: function(data) {         
                $('#order').html(data);    
            }
        });
    });

    //get total price 
    $(document).on('click', '#tender', function() {
        reset_form();
        $('#modal-tender').modal('show');
        $('#form-tender')
        $.ajax({
            url: 'counter/get_total',
            method: 'POST',
            success: function(data) {
                $('#amount_due').html(data);
            }
        });
    })

    // change total price when discounted
    $(document).on('change','#discount', function() {
        var discount_id = $('#discount').val();
        $.ajax({
            url: 'counter/get_discounted_total',
            method: 'POST',
            data: {discount_id:discount_id},
            success: function(data) {
                $('#amount_due').html(data);
            }
        });
    });

    //pay order
    $(document).on('submit','#form-tender', function(e) {
        e.preventDefault();
        var payment = parseFloat($('#pay').val());
        var total = $('#amount_due').html();
        var length = total.length - 4
        var totalPrice = parseFloat(total.substr(1, length));
     
        if (payment != "" && payment >= totalPrice)  {
            $.ajax({
                url: 'counter/tender',
                method: 'post',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#modal-tender').modal('hide');   
                    $('#change').html(data);
                    $('#modal-success').modal('show');

                    load_order_summary();
                }
            });
        } else {
            alert('please input proper cash payment');
        }
    });

    $(document).on('click','#close',function() {
        $('#modal-success').modal('hide');
    });

    $(document).on('click','.print', function() {
        window.print();
    });

    //self-made functions

    function load_order_summary() {
        $.ajax({
            url: "counter/display_order",
            method: "POST",
            dataType: "html",
            success: function(data) {    
                $('#order').html(data);          
            }
        });
    }

    function reset_form() {
        $("#pay").val("");
        $("#discount").val(1);
    }
});
</script>



<!-- modal add edit  -->
<div class="modal fade" id="modal-tender" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-red">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title">Tendering </h2>
        </div>     
        <form id="form-tender" method="POST">
            <div class="modal-body">
                <h5>Amount Due</h5>
                <h1 id="amount_due" class="text-center">

                </h1>
                <div class="form-group">
                    <label for="pay"><h5>Cash Payment</h5></label><br>
                    <input type="text" name='pay' id="pay" class="form-control" autofocus>
                </div>
                
            <div class="form-group">
                    <label for="discount"><h5>Discount</h5></label>
                    <select name="discount" id="discount" class="form-control">

                        <?php foreach($discounts as $discount) :?>
                            <option value="<?php echo $discount->discount_id; ?>"><?php echo ucwords($discount->description); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br><br>
                    <div class="text-center">
                        <!-- 0 = dinein, 1 = takeout,  2 = deliver -->
                        <label class="radio-inline">
                            <input type="radio" name="order_type" value="0" class="order_type" checked>Dine-in    
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="order_type" value="1" class="order_type">Take-out       
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="order_type" value="2" class="order_type">Deliver      
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="submit" class="btn btn-primary btn-block my-padding" value="Check-out" id="submit">
            </div>
        </form> 
      </div>
      
    </div>
  </div>


<!-- modal after tendering  -->
<div class="modal fade" id="modal-success" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-red">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title"></h2>
        </div>     
        <div class="modal-body">
            <h2 class="text-center" style="margin: 50px 0">Change is: <strong><span id="change"></span></strong></h2>
    
            <br><br>
        </div>
        <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-danger btn-block my-padding" value="Close" id="close">
        </div>
      </div>
      
    </div>
  </div>