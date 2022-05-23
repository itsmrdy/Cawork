<?php
  require_once 'core/init.php';
  $firstname = '';
  $middlename = '';
  $lastname= '';
  $birthday= '';
  $gender= '';
  $age= '';
  $place_birth = '';
  $street_no= '';
  $subdivision = '';
  $barangay = '';
  $municipality = '';
  $zipcode = '';
  $number = '';
  $email = '';
  $username = '';
  $password = '';
  $user_type_id = '';
 
  
  

 
    
    
   
    
   
  
  

  if($_POST){
    
    $firstname = ((isset($_POST['firstname']) != '')?($_POST['firstname']):'');
    $middlename  = ((isset($_POST['middlename']) != '')?($_POST['middlename']):'');
    $lastname = ((isset($_POST['lastname']) != '')?($_POST['lastname']):'');
    $birthday= ((isset($_POST['birthday']) != '')?($_POST['birthday']):'');
    $gender= ((isset($_POST['gender']) != '')?($_POST['gender']):'');
    $age = ((isset($_POST['age']) != '')?($_POST['age']):'');
    $place_birth  = ((isset($_POST['place_birth']) != '')?($_POST['place_birth']):'');
    $street_no  = ((isset($_POST['street_no']) != '')?($_POST['street_no']):'');
    $subdivision  = ((isset($_POST['subdivision']) != '')?($_POST['subdivision']):'');
    $barangay = ((isset($_POST['barangay']) != '')?($_POST['barangay']):'');
    $municipality  = ((isset($_POST['municipality']) != '')?($_POST['municipality']):'');
    $zipcode  = ((isset($_POST['zipcode']) != '')?($_POST['zipcode']):'');
    $number= ((isset($_POST['number']) != '')?($_POST['number']):'');
    $email= ((isset($_POST['email']) != '')?($_POST['email']):'');
    $user_type_id = ((isset($_POST['user_type_id']) != '')?($_POST['user_type_id']):'');
    $username = ((isset($_POST['username']) != '')?($_POST['username']):'');
    $password = ((isset($_POST['password']) != '')?($_POST['password']):'');
   




    if(isset($_GET['edit'])){
      $query = $db->query("UPDATE reg_db SET `firstname` = '$firstname', `middlename` = '$middlename', `lastname` = '$lastname', `age` = '$age', `gender` = '$gender', `place_birth` = '$place_birth', `street_no` = '$street_no', `subdivision` = '$subdivision', `barangay` = '$barangay', `municipality` = '$municipality', `zipcode` = '$zipcode', `number` = '$number', `email` = '$email', `user_type_id` = '$user_type_id', `username` = '$username', `password` = '$password' WHERE id = '$id'");
      echo '<script>
        alert("Updated!");
        window.location="../client.php";
      </script>';
    }else{
      //$hashed = password_hash($password,PASSWORD_DEFAULT);
      $query = $db->query("INSERT INTO reg_db (`firstname`, `middlename`, `lastname`, `birthday`, `gender`, `age`, `place_birth`, `street_no`, `subdivision`, `barangay`, `municipality`, `zipcode`, `number`, `email`, `user_type_id`, `username`, `password`) 
      VALUES ('$firstname', '$middlename', '$lastname', '$birthday', '$gender', '$age', '$place_birth', '$street_no', '$subdivision', '$barangay', '$municipality', '$zipcode', '$number', '$email', '$user_type_id', '$username', '$password')");
      echo '<script>
      alert("Registered!");
        window.location="index.php";
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
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
</head>
<body class="sidebar-is-closed sidebar-collapse">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <img src="images/finallogo.jpg" height="50" width="200">
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
                <h3 class="card-title">* Basic Information<small></small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <div class="card-body">
                  <div class="form-group">
                  <form id="quickForm" class="row g-3" method="POST">
  <div class="col-md-4">
    <label for="inputEmail4" class="form-label">Firstname</label>
    <input type="text" name="firstname" class="form-control " id="inputEmail4" placeholder="Enter firstname">
    
  </div>
  <div class="col-md-4">
    <label for="inputEmail4" class="form-label">Middlename</label>
    <input type="text" name="middlename" class="form-control" id="inputEmail4" placeholder="Enter middlename">
  </div>
  <div class="col-md-4">
    <label for="inputEmail4" class="form-label">Lastname</label>
    <input type="text" name="lastname" class="form-control" id="inputEmail4" placeholder="Enter lastname">
  </div>

  <div class="col-md-3">
    <label for="inputEmail4" class="form-label">Birthday</label>
    <input type="date" name="birthday" class="form-control" id="inputEmail4" placeholder="Enter lastname">
  </div>
  <div class="col-md-3">
  <div class="form-group">
                    <label for="exampleInputEmail1" >Gender</label>
                    
                    <select class="form-control" name="gender" > 
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    </select>
                  </div>
                    
 </div>
  <div class="col-3">
    <label for="inputAddress" class="form-label">Age</label>
    <input type="number" name="age" class="form-control" id="inputEmail4" placeholder="Enter age">
  </div>
  <div class="col-3">
    <label for="inputAddress" class="form-label">Place of birth</label>
    <input type="text" name="place_birth" class="form-control" id="inputEmail4" placeholder="Enter birthplace" require>
  </div>

  <div class="col-3">
    <label for="inputAddress" class="form-label">House street no.</label>
    <input type="text" name="street_no" class="form-control" id="inputEmail4" placeholder="Enter House street no." require>
  </div>
  <div class="col-3">
    <label for="inputAddress" class="form-label">Subdivision</label>
    <input type="text" name="subdivision" class="form-control" id="inputEmail4" placeholder="Enter Subdivision" require>
  </div>
  <div class="col-3">
    <label for="inputAddress" class="form-label">Barangay</label>
    <input type="text" name="barangay" class="form-control" id="inputEmail4" placeholder="Enter Barangay" require>
  </div>
  <div class="col-3">
    <label for="inputAddress" class="form-label">Municipality</label>
    <input type="text" name="municipality" class="form-control" id="inputEmail4" placeholder="Enter Municipality" require>
  </div>

  <div class="col-3">
    <label for="inputAddress" class="form-label">Zipcode</label>
    <input type="number" name="zipcode" class="form-control" id="inputEmail4" placeholder="Enter Zipcode" require>
  </div>
  <div class="col-3">
    <label for="inputAddress" class="form-label">Cellphone Number</label>
    <input type="number" name="number" class="form-control" id="inputEmail4" placeholder="Enter Cellphone number" require>
  </div>
  <div class="col-3">
    <label for="inputAddress" class="form-label">Email Address</label>
    <input type="text" name="email" class="form-control" id="inputEmail4" placeholder="Enter Email Address" require>
  </div>
  <div class="col-md-3">
  <div class="form-group">
                    <label for="exampleInputEmail1" >User type</label>
                    
                    <select class="form-control" name="user_type_id" > 
                    <option value="1">Client</option>
                    <option value="2">Freelance</option>
                    <option value="3">Trainor</option>
                    </select>
                  </div>
                    
 </div>
 <div class="col-3">
    <label for="inputAddress" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" id="inputEmail4" placeholder="Enter Username" require>
  </div>
  <div class="col-3">
    <label for="inputAddress" class="form-label">Password</label>
    <input type="text" name="password" class="form-control" id="inputEmail4" placeholder="Enter Password" require>
  </div></div>
  <div class="col-4">
            <input type="submit" value="Register" class="btn btn-primary "/>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
           
          </div>
          </form>
          </div>

          

  


  
                 
  
                  
                  
                  
                  <!--div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <textarea name="description" id="description" class="form-control" cols="30" rows="10"><?= $description; ?></textarea>
                  </div>-->
                
                <!-- /.card-body -->
               
             
              
           
            <!-- /.card -->
            
 


























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
<script src="admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="admin/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="admin/dist/js/demo.js"></script>
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
