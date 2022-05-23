<?php
  require_once 'core/init.php';
  $firstname = '';
  $lastname = '';
  $middle = '';
  $birthday = '';
  $age = '';
  $address = '';
  $username = '';
  $password = '';
  
  if($_POST){
    $firstname = ((isset($_POST['firstname']) != '')?($_POST['firstname']):'');
    $lastname = ((isset($_POST['lastname']) != '')?($_POST['lastname']):'');
    $middle = ((isset($_POST['middlename']) != '')?($_POST['middlename']):'');
    $birthday = ((isset($_POST['birthday']) != '')?($_POST['birthday']):'');
    $age = ((isset($_POST['age']) != '')?($_POST['age']):'');
    $address = ((isset($_POST['address']) != '')?($_POST['address']):'');
    $username  = ((isset($_POST['username']) != '')?($_POST['username']):'');
    $password  = ((isset($_POST['password']) != '')?($_POST['password']):'');
    
   

    if(isset($_GET['edit'])){
      $query = $db->query("UPDATE client SET `firstname` = '$firstname', `lastname` = '$lastname', `middlename` = '$middle', `birthday` = '$birthday', `age` = '$age', `address` = '$address', `username` = '$username', `password` = '$password' WHERE `client` = '$id'");
      echo '<script>
        alert("Updated!");
        window.location="login.php";
      </script>';
    }else{
      $query = $db->query("INSERT INTO client(`firstname`, `lastname`, `middlename`, `birthday`, `age`, `address`, `username`, `password`) VALUES ('$firstname', '$lastname', '$middle', '$birthday', '$age', '$address', '$username', '$password')");
      echo '<script>
        alert("Added!");
        window.location="register.php";
      </script>';
    }
   
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
  <div class="register-logo">
    <a href="#"><b>Admin</b>LTE</a>
  </div>
  <div class="register-logo">
    <a href="#"><b>Admin</b>LTE</a>
  </div>
  <div class="register-logo">
    <a href="#"><b>Admin</b>LTE</a>
  </div>
  <div class="register-box">
  <div class="logo">
    <a href="#"><img src="images/login2.jpg" alt="logo"></a>
  </div>
 
  

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form id="quickForm" method="POST">
        <div class="input-group mb-3">
          <input type="text" name="firstname" class="form-control" placeholder="Firstname">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="lastname" class="form-control" placeholder="Lastname">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="middlename" class="form-control" placeholder="Middlename">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="date" name="birthday" class="form-control" placeholder="Birthday">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="age" class="form-control" placeholder="Age">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div> <div class="input-group mb-3">
          <input type="text" name="address" class="form-control" placeholder="Addrress">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <input type="submit" class="btn btn-primary btn-block" value="Register">
            
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="login.html" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="admin/"></script>
<!-- Bootstrap 4 -->
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.min.js"></script>
</body>
</html>
