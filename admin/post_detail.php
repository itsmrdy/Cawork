<?php
  require_once '../core/init.php';

  date_default_timezone_set('Asia/Manila');

  $view_id = $_GET['view'];

  $reg_id = $_GET['my_id'];

  if (empty($view_id) || empty($reg_id)) {
    header("Location: ../client.php");
  }

  $service_detail_q = $db->query("SELECT * FROM service_db WHERE id = '$view_id';");
  $service_detail = mysqli_fetch_assoc($service_detail_q);

  $service_id = $service_detail['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Service Details</title>

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
                <h3 class="card-title">Service Details<small></small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <div class="card-body">
                <h3><?=$service_detail['skills']?></h3>
                <p><?=$service_detail['services']?><br><br><?=$service_detail['description']?></p>
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
  var date_today = '<?=$js_dateToday?>';
  var start_date = '<?=$complete_start_at?>';

  if (date_today > start_date) {
    alert('Event already finished');
    history.back();
  }
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
            alert('Successfully joined this event');
          }
          else{
            alert('An error occured');
          }
          history.back();
        }
      });
    }
  });
  function hire_now(service_id, reg_id) {
    var request = 'service_proposal';
    $.ajax({
      method: 'post',
      url: 'ajax_request.php',
      data: {
        request:request,
        service_id:service_id,
        reg_id:reg_id
      },
      dataType:'text',
      success:function(data){
        if (data === "1") {
          alert('Service proposal has been sent. Wait for approval');
        }
        else if (data === "2") {
          alert('An error occured');
        }
        else{
          alert('Proposal already sent. Wait for approval');
        }
        window.location = 'client.php';
      }
    });
  }
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