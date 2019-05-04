<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title; ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li>Menu</li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>
    <br>
    <div class="row content">
        <div class="col-md-3 col-xs-12" style="margin:0">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Categories</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Add New" name="category" id="category">
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="submit" id="add-category"><i class="glyphicon glyphicon-plus"></i></button>
                        </div>
                    </div>
                    <br>
                    <?php foreach($categories as $category) : ?>
                        <div class="row" style="display:block; margin: auto;">
                            <div class="col-md-9 col-s-7">
                                <a href="<?php echo base_url(); ?>categories/view/<?php echo $category->category_id; ?>" class="my-anchor" >
                                    <h4><?php echo $category->category_name; ?></h4>
                                </a>                      
                            </div>
                            <div class="col-md-3 col-s-5"> 
                                <button class="btn btn-danger pull-right delete-category" id="<?php echo $category->category_id?>"><span class="fa fa-trash"></span></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div> 
        <div class="col-md-9 col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Category: <?php echo $category_name; ?></h3>
                </div>
                    <?php if(count($items) > 0) {    
                    ?>
                    <table class="table table-striped" style="width: 96%; margin: auto;">
                        <tr>
                            <th style="width: 10%">Name</th>
                            <th style="width: 10%">Price</th>
                            <th style="width: 10%">Sub-category</th>
                        </tr>
                        <?php foreach($items as $item) : ?>
                            <tr>
                                <td><?php echo $item->item_name; ?></td>
                                <td><?php echo '&#x20B1; '. $item->item_price; ?></td>
                                <td><?php echo $item->name; ?></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="text-center"><h4>Results: <?php echo count($items); ?></h4></td>
                            </tr>
                    </table>
                    <?php } else {
                        echo "<h1 class='text-center' style='height: 300px;'>No Item Found</h1>";
                    } ?>
                <div class="box-body">
                </div>
            </div>   
        </div>
  
    </div>

</div>
    
<script>
    $(document).ready(function(){
        $(document).on('click','#add-category', function() {
            var category = $('#category').val().trim();   
            if (category != "") {
                $.ajax({
                    url: "<?php echo base_url(); ?>categories/add",
                    method: "POST",
                    data: {category:category},
                    success: function(data) {
                        alert(data);
                        window.location.href = "<?php echo base_url(); ?>categories";
                    }
                });
            }
        });

        $(document).on('click', '.delete-category', function() {
            var id = $(this).attr('id');
            if(confirm("Are you sure?")) {
                $.ajax({
                    url: "<?php echo base_url(); ?>categories/delete",
                    method: "POST",
                    data: {id:id},
                    success: function(data) {
                        alert(data);
                        window.location.href = "<?php echo base_url(); ?>categories";
                    }
                });
            }
          
        });
    });
</script>