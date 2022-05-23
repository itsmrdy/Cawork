<?php
  require_once '../core/init.php';

  date_default_timezone_set('Asia/Manila');

  $my_id = $_COOKIE['id'];

  $event_id = $_GET['event_id'];

  $validate = $db->query("SELECT id FROM events_participants_db WHERE event_id = '$event_id' AND reg_id = '$my_id' AND delete_flg = '0';");
  $validate_count = mysqli_num_rows($validate);

  $query = $db->query("SELECT event.title, event.description, event.training_type, reg.firstname, reg.lastname FROM events_db event JOIN reg_db reg ON event.reg_id = reg.id WHERE event.delete_flg = '0' AND event.id = '$event_id';");

  $event_row = mysqli_fetch_assoc($query);

  $event_count = mysqli_num_rows($query);

  $acc_status = $db->query("SELECT status FROM reg_db WHERE id = '$my_id';");
  $accstatus = mysqli_fetch_assoc($acc_status);

  $account_status = $accstatus['status'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Join Event</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="sidebar-is-closed sidebar-collapse">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <img src="../images/finallogo.jpg" height="100" width="220">
    <!-- Left navbar links -->
    <!--<ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li> -->
      <!--<li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>-->

    <!-- SEARCH FORM -->
    <!--
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <a href="../logout.php" class="btn btn-secondary">Logout</a>
     
    </ul>
  </nav>
  <!-- /.navbar -->
  
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
          <!--div class="col-sm-6">
            <h1>Creating Job Post STEP #1</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Job Post</li>
            </ol>
          </div>
        </div>--->
     

    <!-- Main content -->
    <section class="content">
     
            <!-- jquery validation -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Event Information<small></small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <div class="card-body">
              <?php
                if ($event_count > 0) {
                  if ($account_status == 0) {
              ?>
                <button disabled style="float: right;" class="btn btn-primary" id="button_join">Join Event</button>
              <?php
                  }
                  else{
              ?>
                <button style="float: right;" class="btn btn-primary" id="button_join">Join Event</button>
              <?php
                  }
              ?>
                
                <h3><?=$event_row['title']?></h3>
                <p class="text-muted"><?=$event_row['description']?></p>
                <p>Event Type: <?=$event_row['training_type']?></p>
                <p>Event Host: <?=$event_row['firstname']?> <?=$event_row['lastname']?></p>
              <?php
                }
              ?>
              </div>
          <!-- right column -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  $('#quickForm').validate({
    rules: {
      title: {
        required: true,
        minlength: 5
      },
      description: {
        required: true,
        minlength: 10
      },
      terms: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
</body>
</html>

<script>
  $('#button_join').click(function(){
    var request = 'join_event';
    var event_id = '<?=$event_id?>';
    var reg_id = '<?=$my_id?>';
    var x = confirm('Are you sure you want to join this event?');
    if (x === true) {
      $.ajax({
        url: '../ajax_request.php',
        method: 'post',
        data: {
          request:request,
          event_id:event_id,
          reg_id:reg_id
        },
        dataType: 'text',
        success:function(data){
          if (data === '1') {
            $('#training_joined_cilck').click();
          }
          else{
            alert('An error occured');
            window.location.reload();
          }
        }
      });
    }
  });
</script>
<?php
  if ($validate_count > 0) {
?>
  <script>
    $('#button_join').hide();
  </script>
<?php
  }
?>
<button data-toggle="modal" data-target="#training_joined" style="display: none;" id="training_joined_cilck"></button>
<div id="training_joined" style="margin-top:10%;" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h3>Notice</h3>
        <p class="text-dark"><i class="fa fa-exclamation-circle"></i> This training have limited slot for accepting participants. Please check your email address and mobile number if there are accepted notification for this training. If there are "no" accepting notification sent to you, it means that this training reach the limited slot and will not accept your request to join the training.</p>
        <center><button class="btn btn-secondary text-center" onclick="history.back();">OK</button></center>
      </div>
    </div>

  </div>
</div>