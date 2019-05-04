<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title; ?>
        <small>add | edit | delete</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li>Menu</li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>
    
    <!-- item table -->
    <section class="content">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Item List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right">      
                    <button class="btn btn-primary my-btn" id="btn-addedit">
                        <i class="fa fa-plus"></i> Add New
                    </button>
                </div>
                <br><br><br>
                <table id="item-table" class="table table-bordered" style="width: 100%">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">ID</th>
                        <th class="text-center" style="width: 10%">Name</th>
                        <th class="text-center" style="width: 10%">Price</th>
                        <th class="text-center" style="width: 10%">Sub-Category</th>
                        <th class="text-center" style="width: 10%">Category</th>
                        <th class="text-center" style="width: 10%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
    <!-- item table end -->

    <!-- datatable scripts -->
    <script>
        $(document).ready(function() {
            //load datatable
            var dataTable = $('#item-table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url(); ?>items/fetch_all",
                    method: "POST"
                }, 
                "columnDefs": [
                    {
                        "targets": [2,5],
                        "orderable": false
                    }
                ] 
            });
            //when click change action to add
            $(document).on("click", "#btn-addedit",function() {    
                reset_form();   
                $(".modal-title").html("ADD NEW ITEM");
                $("#modal-addedit").modal("show");
                $("#action").val("add");
            });

            //change action to edit and fetch single data
            $(document).on("click", ".update",function() {
                $(".modal-title").html("EDIT ITEM");
                $("#modal-addedit").modal("show");
                $("#action").val("edit");
                var item_id = $(this).attr('id');
                $.ajax({
                    url: "<?php echo base_url() ?>items/fetch_single",
                    method: "POST",
                    data: {item_id:item_id},
                    dataType: "json",
                    success: function(data) {
                        $("#item_id").val(data.id);
                        $("#name").val(data.name);
                        $("#price").val(data.price);
                        $("#category").val(data.category);
                        $("#subcategory").val(data.sub_category);
                    }
                });
            });

            //submit data 
            $(document).on("submit", "#form-addedit", function(e){
                e.preventDefault();
                var action = $("#action").val();
                var name = $("#name").val();
                var price = $("#price").val();
                var category = $("#category").val();
                var subcategory = $("#subcategory").val();
                var item_id = $('#item_id').val();
                if (name != "" &&  price != "" && category != "0" && subcategory != "0"  ) {
                    if (action === "add") { 
                        $.ajax({
                            url: "<?php echo base_url(); ?>items/add_item",
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                alert(data); 
                                $('#modal-addedit').modal('hide');
                                dataTable.ajax.reload();    
                            }
                        });   
                    }
                    if (action === "edit") {
                        $.ajax({
                            url: "<?php echo base_url(); ?>items/edit_item",
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                alert(data); 
                                $('#modal-addedit').modal('hide');
                                dataTable.ajax.reload();    
                            }
                        });
                    }
                } else {
                    alert("Please Fill Up All Fields!");
                }
            });

            //delete item
            $(document).on('click','.delete', function() {
                if (confirm("Are you sure? you want to delete this item?")) {
                    var item_id = $(this).attr('id');
                    $.ajax({
                        url: "<?php echo base_url() ?>items/delete_item",
                        method: "POST",
                        data: {item_id:item_id},
                        success: function(data) {
                            alert(data);
                            $('#modal-addedit').modal('hide');
                            dataTable.ajax.reload();    
                        }
                    });
                } 
            });

            //self-made functions
            function reset_form() {
                $("#name").val("");
                $("#price").val("");
                $("#category").val(1);
                $("#subcategory").val(4);
            }
        });

    </script>
</div>


<!-- modal add edit  -->
<div class="modal fade" id="modal-addedit" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">ADD NEW ITEM</h4>
        </div>     
        <form id="form-addedit" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Price</label>
                    <input type="number" name="price" id="price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="address">Category</label>
                    <select name="category" id="category" class="form-control">
                        <?php foreach($categories as $category ) :?>
                            <option value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subcategory">Sub-Category</label>
                    <select name="subcategory" id="subcategory" class="form-control">
                         <?php foreach($sub_categories as $subcategory ) :?>
                            <option value="<?php echo $subcategory->id ?>"><?php echo $subcategory->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input type='hidden' name="id" id="item_id" value="">
                <input type="hidden" name="action" id="action">
                <input type="submit" name="submit" class="btn btn-primary" value="SAVE" id="submit">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form> 
      </div>
      
    </div>
  </div>
