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
  <div class="row content">

    <?php if (isset($_SESSION['user_added']))
        echo '<div class="alert alert-success text-center alert-dismissible fade in" id="msg"><a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none"> &times; </a>'. $_SESSION['user_added'] . '</div>';
    ?>    
    <?php if (isset($_SESSION['user_deleted']))
        echo '<div class="alert alert-success text-center alert-dismissible fade in" id="msg"><a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none"> &times; </a>'. $_SESSION['user_deleted'] . '</div>';
    ?>    
    <?php if (isset($_SESSION['user_edited']))
        echo '<div class="alert alert-success text-center alert-dismissible fade in" id="msg"><a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none"> &times; </a>'. $_SESSION['user_edited'] . '</div>';
    ?>    
    <span id="user-edited"></span>
    <!-- register form -->
    <div class="col-md-4 col-s-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">ADD NEW USER</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?php echo base_url() ?>users/add_user" method="POST">
                <div class="box-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo set_value('name'); ?>" >
                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>" >
                        <span class="text-danger"><?php echo form_error('username'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" >
                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password">
                        <span class="text-danger"><?php echo form_error('confirmpassword'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>User Type</label>
                        <select name="usertype" class="form-control">
                            <option value="cashier">Cashier</option>
                            <option value="manager">Manager</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!-- end register form -->


    <div class="col-md-8 col-s-12">
        <!-- box -->
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">USER LIST</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered text-center">
                    <tr class="bg-red">
                        <th style="width: 10%">NAME</th>
                        <th style="width: 10%">USERNAME</th>
                        <th style="width: 10%">PASSWORD</th>
                        <th style="width: 10%">USER TYPE</th>
                        <th style="width: 10%"></th>
                    </tr>
                    <?php foreach($users as $user) : ?>
                    <tr>
                        <td><?php echo $user->user_name; ?></td>
                        <td><?php echo $user->user_username; ?></td>
                        <td id="td_<?php echo $user->user_id; ?>">
                            <span id="password<?php echo $user->user_id ?>">
                                **********
                            </span>
                            <i class="glyphicon glyphicon-eye-open pull-right showpass" style="cursor: pointer" id="<?php echo $user->user_id?>"></i>
                        </td>
                        <td><?php echo $user->user_type; ?></td>
                        <td>
                            <button class="btn btn-info my-circle update" id="<?php echo $user->user_id; ?>"><i class="glyphicon glyphicon-edit"></i></button>
                            <button class="btn btn-danger my-circle delete" id="<?php echo $user->user_id; ?>"><i class="glyphicon glyphicon-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <!-- end box -->
    </div>
  </div>

</div>


<script>

    $(document).ready( function() {
        $(document).on('click', '.delete', function() {
            var id = $(this).attr('id');
            if (confirm('are you sure you want to delete this user?')) { 
                $.ajax({
                    url: '<?php echo base_url(); ?>users/delete_user',
                    method: 'POST',
                    data: {id:id},
                    success: function() {
                        location.href = '<?php echo base_url(); ?>users';
                    }
                });   
            }
        });

        $(document).on('click','.update', function() {
            $('#error').html('');
            $('#modal-edit').modal('show');
            var id = $(this).attr('id');
            $.ajax({
                url: '<?php echo base_url(); ?>users/fetch_user',
                method: 'POST',
                data: {id:id},
                dataType: 'json',
                success: function(data) {
                    $('#name').val(data.name);
                    $('#username').val(data.username);
                    $('#old_uname').val(data.username);
                    $('#password').val(data.password);
                    $('#confirmpassword').val(data.password);
                    $('#usertype').val(data.user_type);
                    $('#user_id').val(id);
                } 
            });

        });

        $(document).on('submit', '#form-edit', function(e) {
            e.preventDefault();

            var error = $('#error');
            var id = $('#user_id').val();      
            var name = $('#name').val();
            var username = $('#username').val();
            var password = $('#password').val();
            var confpass = $('#confirmpassword').val();
            var usertype = $('#usertype').val();
            var old_uname = $('#old_uname').val();

            if (name != "" && username != "" && password != "" && confpass != "") {
                if (password != confpass) {     
                    error.html('<div class="alert alert-danger text-center  alert-dismissible fade in">' + 
                    '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none"> &times; </a>' + 
                    'WARNING! Password Confirmation and Password Does Not Match!</div>');
                } else {
                    if (/^[a-zA-Z ]+$/i.test(name)) {
                        if (/^[a-zA-Z0-9_]+$/i.test(username)) { 
                            var isUsernameExist = false;
                            if (old_uname != username) {
                                $.ajax({
                                    url: '<?php echo base_url(); ?>users/fetch_users',
                                    method: 'POST',
                                    dataType: 'json',
                                    success: function(data) {
                                        data.forEach(function(value) {
                                            if (username == value) {
                                                error.html('<div class="alert alert-danger text-center  alert-dismissible fade in">' + 
                                                '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none"> &times; </a>' + 
                                                'WARNING! Username is Already Exist! Please Choose Another Username!</div>');
                                                isUsernameExist = true;
                                            }
                                        });
                                    },
                                    complete: function() {
                                        if (!isUsernameExist) { 
                                            $.ajax({
                                                url: '<?php echo base_url(); ?>users/update_user',
                                                method: 'POST',
                                                data: {id:id, name:name, username:username, password:password, usertype:usertype},
                                                success: function(){
                                                    $('#modal-edit').modal('hide');
                                                    location.href = '<?php echo base_url(); ?>users';
                                                }
                                            });   
                                        }
                                    }
                                });

                            } else {   
                                $.ajax({
                                    url: '<?php echo base_url(); ?>users/update_user',
                                    method: 'POST',
                                    data: {id:id, name:name, username:username, password:password, usertype:usertype},
                                    success: function(){
                                        $('#modal-edit').modal('hide');
                                        location.href = '<?php echo base_url(); ?>users';
                                    }
                                });   
                            }
                        } else {         
                            error.html('<div class="alert alert-danger text-center  alert-dismissible fade in">' + 
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none"> &times; </a>' + 
                            'WARNING! Invalid Character for Username, Please User Letters, Numbers and Underscore Only!</div>');
                        }
                    } else { 
                        error.html('<div class="alert alert-danger text-center  alert-dismissible fade in">' + 
                        '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none"> &times; </a>' + 
                        'WARNING! Invalid Character for Name, Please Use Letters and Spaces Only!</div>');
                    }
                }
            } else {
                error.html('<div class="alert alert-danger text-center  alert-dismissible fade in">' + 
                '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration:none"> &times; </a>' + 
                'WARNING! Please Fill Up All Fields!</div>');
            }
            

        });

        $(document).on('click','.showpass', function() {
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url(); ?>users/fetch_user',
                method: 'POST',
                data: {id:id},
                dataType: 'json',
                success: function(data) {
                    var show = $('#td_' + id).children('i').attr('class');
      
                    if ( show.includes("glyphicon glyphicon-eye-open")) {             
                        $('#td_' + id).children('i').removeClass('glyphicon glyphicon-eye-open');
                        $('#td_' + id).children('i').addClass('glyphicon glyphicon-eye-close');                   
                        $('#password'+id).text(data.password);   
                    } else {
                        $('#td_' + id).children('i').removeClass('glyphicon glyphicon-eye-close');
                        $('#td_' + id).children('i').addClass('glyphicon glyphicon-eye-open');                   
                        $('#password'+id).text('**********');   
                    }

                } 
            });   
        });
    });
</script>



<!-- modal edit  -->
<div class="modal fade" id="modal-edit" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">UPDATE USER</h4>
        </div>     
        <form id="form-edit" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <span id="error"></span>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <label>User Type</label>
                    <select name="usertype" class="form-control" id="usertype">
                        <option value="cashier">Cashier</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">  
                <input type="hidden" class="form-control" id="old_uname" name="old_uname">
                <input type="hidden"  name="user_id" id="user_id">   
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </form> 
      </div>
    </div> 
</div>
