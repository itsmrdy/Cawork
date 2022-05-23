<?php
  require_once '../core/init.php';
  $training = '';
  $description = '';
  $type= '';
  $payment= '';

  $id = $_COOKIE['id'];
  $result = $db->query("SELECT *, CONCAT(firstname,' ',lastname) AS name FROM reg_db WHERE id = $id");
  $fetch = mysqli_fetch_assoc($result);
  $name = $fetch['name'];

  if($_POST){
    $training = ((isset($_POST['training']) != '')?($_POST['training']):'');
    $description  = ((isset($_POST['description']) != '')?($_POST['description']):'');
    $type = ((isset($_POST['type']) != '')?($_POST['type']):'');
    $payment= ((isset($_POST['payment']) != '')?($_POST['payment']):'');
 




    if(isset($_GET['edit'])){
      $query = $db->query("UPDATE client SET `firstname` = '$firstname', `lastname` = '$lastname', `middlename` = '$middle', `birthday` = '$birthday', `age` = '$age', `address` = '$address', `username` = '$username', `password` = '$password' WHERE `client` = '$id'");
      echo '<script>
        alert("Updated!");
        window.location="client.php";
      </script>';
    }else{
      $query = $db->query("INSERT INTO training_db(`name`, `training_title`, `description`, `training_type`, `payment_method`, `training_id`) 
      VALUES ('$name','$training', '$description', '$type', '$payment', '$id')");
      echo '<script>
      alert("Training Submitted!");
        window.location="../trainor.php";
      </script>';
    }
   
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Profile update</title>

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
                <h3 class="card-title">* Training Post<small></small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <div class="card-body">
                  <div class="form-group">
                  <form class="row g-3" method="POST">
  <div class="col-md-4">
    <label for="inputEmail4" class="form-label">Training Title</label>
    <input type="text" name="training" class="form-control " id="inputEmail4" placeholder="Enter Training name">
  </div>
  
  <div class="col-md-5">
  <div class="form-group">
                    <label for="exampleInputEmail1">Training type</label>
                    
                    <select class="form-control" name="type"> 
                    <option value="face to face">Face to face</option>
                    <option value="module">Module</option>
                    <option value="online">Online training</option>
                  
                   </select>
                  </div>
  </div>
  <div class="col-md-4">
  <div class="form-group">
                    <label for="exampleInputEmail1">Mode of Payment</label>
                    
                    <select class="form-control" name="payment" > 
                    <option value="gcash" >Gcash</option>
                    <option value="paypal">Paypal</option>
                    <option value="bank" >Bank</option>
                    <option value="remittance">Remittance</option>
                   
                  
                   </select>
                  </div>
  </div>
  <div class="col-md-5">
    <label for="inputEmail4" class="form-label">Description</label>
    <textarea type="text" name="description" class="form-control" rows="3" col="5 "id="inputEmail4" placeholder="Enter Description"></textarea>
  </div>
</div>
<input type="submit" value="Submit Training" class="btn btn-primary "/>
  <a href="../trainor.php" class="btn btn-default">Cancel</a>
</form>

  


  
                 
  
                  
                  
                  
                  <!--div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <textarea name="description" id="description" class="form-control" cols="30" rows="10"><?= $description; ?></textarea>
                  </div>-->
                
                <!-- /.card-body -->
               
</div>
</div>



























          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">
          
          </div>
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
