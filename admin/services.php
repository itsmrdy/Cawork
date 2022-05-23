<?php
  require_once '../core/init.php';
  $skills = '';
  $rate = '';
  $type= '';
  $description= '';
  $services= '';


  $id = $_SESSION['userId'];
  $my_id = $_SESSION['userId'];

  
  $result = $db->query("SELECT *, CONCAT(firstname,' ',lastname) AS name FROM reg_db WHERE id = $id");
  
  $fetch = mysqli_fetch_assoc($result);
  $name = $fetch['name'];

  $my_query = $db->query("SELECT * FROM reg_db WHERE id = '$my_id';");
  $my_row = mysqli_fetch_assoc($my_query);

  $my_skills = explode(', ', $my_row['skills']);

  if($_POST){
    $skills = ((isset($_POST['skills']) != '')?($_POST['skills']):'');
    $rate  = ((isset($_POST['rate']) != '')?($_POST['rate']):'');
    $type = ((isset($_POST['type']) != '')?($_POST['type']):'');
    $services = mysqli_real_escape_string($db, $_POST['services']);
    $description = mysqli_real_escape_string($db, $_POST['description']);

    if ($db->query("INSERT INTO service_db (`name`, `skills`, `rate`, `day_week`, `services`, `description`, `reg_id`) 
      VALUES ('$name', '$skills', '$rate', '$type', '$services', '$description', '$my_id')")) {
      echo '<script>
      alert("Service Submitted!");
        window.location="../freelance.php";
      </script>';
    } else {
      echo '<script>
      alert("An error occured");
        window.location="../freelance.php";
      </script>';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Services</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    .form-control{
      border-left: 2px solid green;
    }
  </style>
</head>
<body class="sidebar-is-closed sidebar-collapse">
<div class="wrapper">
   <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
          <a href="#" class="navbar-brand">
            <span class="brand-text font-weight-bold text-success"
            style="font-family: Comic Sans MS, Comic Sans, cursive">Cawork</span>
          </a>

          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse order-5" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="nav nav-tabs ml-3 p-3">
              <li class="nav-item">
                <a href="#" class="nav-link text-secondary active" data-toggle="tab">Create Service</a>
              </li>
              <li class="nav-item">
                <a href="../freelance.php" class="nav-link text-secondary">Home</a>
              </li>
            </ul>
          </div>
        </div>
        <a href="../logout.php" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i></a>
    </nav>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="container">
            <br>
            <!-- jquery validation -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Post Services<small></small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <div class="card-body">
                  <div class="form-group">
                    <form class="row g-3" method="POST">
    <div class="col-md-4">
      <label for="inputEmail4" class="form-label">Enter your Skills</label>
      <select class="form-control" required name="skills">
      <?php
        foreach ($my_skills as $key => $value) {
      ?>
        <option><?=$value?></option>
      <?php
        }
      ?>
      </select>
    </div>
    
    <div class="col-md-5">
  <div class="form-group">
                    <label for="exampleInputEmail1">Rate</label>
                    <div class="col-md-10">
                    <div class="input-group has-validation">
      <span class="input-group-text rounded-0" id="inputGroupPrepend">₱</span>
      <input type="number" class="form-control" name="rate" id="validationCustomUsername" placeholder="0" required>
      <span class="input-group-text rounded-0">.00</span>
      <div class="invalid-feedback">
      
      </div> 
      <select class="input-group-text rounded-0" name="type" aria-label="Default select example" required>
          
          <option selected value="day">/Day</option>
          <option value="week">/Week</option>
         
          </select> </div>

                  </div>
                 </div>
</div>
<div class="col-md-5">
    <label for="inputEmail4" class="form-label">Services <small>* Based on your skill what kind of services can you offer</small></label>
    <textarea type="text" name="services" class="form-control" rows="3" col="5 "id="myservice" placeholder="Enter Services" required
    maxlength = "1000"></textarea>
    <div class="service_counter float-right text-secondary"></div>
  </div>
  
  <div class="col-md-5">
    <label for="inputEmail4" class="form-label">Description</label>
    <textarea type="text" name="description" class="form-control" rows="3" col="5 "id="description" placeholder="Enter Description" required></textarea>
    <div class="description_counter float-right text-secondary"></div>
  </div>
</div>
<input type="submit" value="Post" class="btn btn-primary "/>
  <a href="../freelance.php" class="btn btn-default">Cancel</a>
</form>
</div>
</div>
          <div class="col-md-6">
          
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
     </div>
  </div>
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
  $('#myservice').keyup(function(){
     var txt_length = $("#myservice").val().length;
     $('.service_counter').html(txt_length + "/1000");
  });

  $('#description').keyup(function(){
     var txt_length = $("#description").val().length;
     $('.description_counter').html(txt_length + "/1000");
  });
</script>
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
