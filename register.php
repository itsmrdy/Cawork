<?php include_once "php/session_checker.php"?> 
<?php
  require_once 'core/init.php';
  $fname = '';
  $mname = '';
  $lname = '';
  $age = '';
  $address = '';
  $username = '';
  $password= '';
  $user_type_id = '';

  if (isset($_POST['register_submit'])) {
    $fname  = ((isset($_POST['fname']) != '')?($_POST['fname']):'');
    $mname  = ((isset($_POST['mname']) != '')?($_POST['mname']):'');
    $lname  = ((isset($_POST['lname']) != '')?($_POST['lname']):'');
    $age = ((isset($_POST['age']) != '')?($_POST['age']):'');
    $address = ((isset($_POST['address']) != '')?($_POST['address']):'');
    $username = ((isset($_POST['username']) != '')?($_POST['username']):'');
    $password = ((isset($_POST['password']) != '')?($_POST['password']):'');
    $password1 = ((isset($_POST['password1']) != '')?($_POST['password1']):'');
    $user_type_id = ((isset($_POST['user_type_id']) != '')?($_POST['user_type_id']):'');
    $email = ((isset($_POST['email']) != '')?($_POST['email']):'');

    $_SESSION['user_type_id'] = $user_type_id;
    $_SESSION['fname'] = $fname; 
    $_SESSION['mname'] = $mname; 
    $_SESSION['lname'] = $lname; 
    $_SESSION['age'] = $age; 
    $_SESSION['email'] = $email; 
    $_SESSION['address'] = $address; 
    $_SESSION['username'] = $username; 


    function reload(){
      unset($_SESSION['fname']);
      unset($_SESSION['mname']);
      unset($_SESSION['lname']);
      unset($_SESSION['age']);
      unset($_SESSION['email']);
      unset($_SESSION['address']);
      unset($_SESSION['username']);
    }
    
      if ($password === $password1) {
         $sql = $db->query("SELECT id, reg_db.status,user_type_id FROM reg_db WHERE username = '$username';");
         $result = mysqli_fetch_assoc($sql);
         if(!empty($result)){
           if($result['status'] == 3){
               // REMOVE EXISTING ACCOUNT FROM DATABASE
               $sql = "DELETE FROM reg_db WHERE username = '$username'";
               $db->query($sql);

               $query = "INSERT INTO reg_db (`firstname`, `middlename`, `lastname`, `age`, `username`, `password`, `user_type_id`, `email`) 
               VALUES ('$fname', '$mname', '$lname', '$age', '$username', '$password', '$user_type_id','$email')";
               $db->query($query);
               echo "<script>alert('We found that you have an existing record to Cawork. We updated your details, Please wait for the admin verification for complete access to Cawork');
                      window.location='login.php'</script>";
               reload();
           }else{
              print("<script>alert('Account already exists');</script>");
           }
         }else{
                $query = "INSERT INTO reg_db (`firstname`, `middlename`, `lastname`, `age`, `username`, `password`, `user_type_id`, `email`) 
                VALUES ('$fname', '$mname', '$lname', '$age', '$username', '$password', '$user_type_id','$email')";
                $db->query($query);
              
                $sql = $db->query("SELECT id, reg_db.status,user_type_id FROM reg_db WHERE username = '$username';");
                $result = mysqli_fetch_assoc($sql);

                $_SESSION['userId'] = $result['id'];
                if($result['user_type_id'] == 1){
                  print("<script>alert('You have successfully registered with cawork please update your profile first to verify your account'); window.location='client.php';</script>");
                }else if($result['user_type_id'] == 2){
                  print("<script>alert('You have successfully registered with cawork please update your profile first to verify your account'); window.location='freelance.php';</script>");
                }else if($result['user_type_id'] == 3){
                  print("<script>alert('You have successfully registered with cawork please update your profile first to verify your account'); window.location='trainor.php';</script>");
                }
         }
   
      }else {
        echo "<script>alert('Password does not match')</script>";
      }
  }
?>


<!--CLIENT FREELANCE TRAINER ADMIN/INDEX.PHP -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Registration Page</title>

  
  <?php include_once "php/headers.php" ?>
  
  <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    .centered{
      position: fixed;
      top: 22%;
      left: 38%;
      margin-top: -50px;
      margin-left: -100px;
    }
    .card-box{
      width: 600px;
      border-radius: 8px; 
      border: 1px solid #f0f2f5;
    }
    .footer{
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: red;
      color: white;
      text-align: center;
    }
  </style>
</head>
<body class="hold-transition">
  <nav class="navbar navbar-expand navbar-light"
  style="border: 1px solid #f0f2f5">
    <h5 class="text-bold m-3 text-success" 
    style="font-family: Comic Sans MS, Comic Sans, cursive">Cawork</h5>
  </nav>

  <div class="centered">
    <div class="card-box p-5">
        <div class="box-header d-flex justify-content-center py-3">
          <h3>Sign up to
            <span class="text-bold text-success" 
            style="font-family: Comic Sans MS, Comic Sans, cursive">Cawork</span>
          </h3>
        </div>

        <div class="card-body">
          <form id="quickForm" method="POST" class="needs-validation">
              <select class="form-select form-select-lg mb-3 text-secondary" name="user_type_id" 
                required>
                    <option value="">Select User Type</option>
                    <option value="1">Client</option>
                    <option value="2">Skilled Worker</option>
                    <option value="3">Trainor</option>
              </select>

              <div class="row">
                <div class="col-md-6">
                    <input type="text" name="fname" class="form-control" placeholder="Firstname" required
                    id="firstname"
                    value='<?= $_SESSION['fname'] ?>'>
                </div>
                <div class="col-md-6">
                    <input type="text" name="mname" class="form-control" placeholder="Middlename"
                    id="middlename"
                    value='<?= $_SESSION['mname'] ?>'>
                </div>
              </div>

              <input type="text" name="lname" class="form-control mt-3" placeholder="Lastname" required
                  id="lastname"
                  value='<?= $_SESSION['lname'] ?>'>

              <div class="row mt-3">
                <div class="col-md-4">
                  <input 
                    name="age" class="form-control" placeholder="Age" required
                    maxlength = "2"
                    id="age"
                    value='<?= $_SESSION['age'] ?>'>
                </div>

                
                <div class="col-md-8">
                  <input type="email" name="email" class="form-control" placeholder="Email address" required
                    value='<?= $_SESSION['email'] ?>'>
                </div>
              </div>

              <input type="text" name="username" class="form-control mt-3" placeholder="Username" required
                  value='<?= $_SESSION['username'] ?>'>

              <input type="password" name="password" class="form-control mt-3" placeholder="Password" required>

              <input type="password" name="password1" class="form-control mt-3" placeholder="Confirm Password" required>

              <button class="btn btn-success btn-block mt-3" name="register_submit" 
              style="border-radius: 30px"
              type="submit">Create my account</button>
              <div class="d-flex justify-content-center mt-3">
                <span>Already have an account?<a href="login.php" class="text-success text-bold ml-1 text-decoration-none">Sign up</a> </span>
              </div>
          </form>
        </div>
    </div>
  </div>

  <div class="footer bg-dark">
    <div class="d-flex flex-column m-2">
      
      <h5 class="text-bold" 
      style="font-family: Comic Sans MS, Comic Sans, cursive">Cawork</h5>
      <h6>All rights reserve &copy 2022</h6>
    </div>
  </div>
   <!-- <div class="container
   d-flex justify-content-center">
    <div class="card rounded-xl mt-5" style="width: 65vh;">
      <img src="images/finallogo.jpg" alt="logo" class="card-img-top rounded-lg">
      <div class="card-body ">
         <div class="card-text d-flex justify-content-center">
           <p class="fw-bold">Register a new membership</p>
         </div>
         <div class="card-text">
          <form id="quickForm" method="POST" class="row g-5 needs-validation">
              <div class="container">
                <select class="form-select form-select-lg mb-3" name="user_type_id" 
                required>
                    <option value="">Select User Type</option>
                    <option value="1">Client</option>
                    <option value="2">Skilled Worker</option>
                    <option value="3">Trainor</option>
                </select>
                
                <div class="note">
                  <i class="text-danger text-bold">*Please write your legal name it is important for your profile verification</i>
                </div>
                <div class="input-group mb-3 mt-3">
                  <input type="text" name="fname" class="form-control" placeholder="Firstname" required
                  id="firstname"
                  value='<?= $_SESSION['fname'] ?>'>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>  
                <div class="input-group mb-3">
                  <input type="text" name="mname" class="form-control" placeholder="Middlename"
                  id="middlename"
                  value='<?= $_SESSION['mname'] ?>'>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>

                <div class="input-group mb-3">
                  <input type="text" name="lname" class="form-control" placeholder="Lastname" required
                  id="lastname"
                  value='<?= $_SESSION['lname'] ?>'>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input 
                  name="age" class="form-control" placeholder="Age" required
                  maxlength = "2"
                  id="age"
                  value='<?= $_SESSION['age'] ?>'>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-address-card"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="email" name="email" class="form-control" placeholder="Email address" required
                  value='<?= $_SESSION['email'] ?>'>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="text-bold">@</span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" name="username" class="form-control" placeholder="Username" required
                  value='<?= $_SESSION['username'] ?>'>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" name="password" class="form-control" placeholder="Password" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div> 
                <div class="input-group mb-3">
                  <input type="password" name="password1" class="form-control" placeholder="Confirm Password" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div> 
                <button class="btn btn-primary btn-block" name="register_submit" type="submit">Register</button>
                <a href="login.php" class="btn btn-success btn-block" >Already have an account?</a>
              </div>
          </form>
         </div>
      </div>
    </div>
   </div> -->
</body>
  <script src="admin/"></script>
  <script src="admin/plugins/jquery/jquery.min.js"></script>
  <script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="admin/dist/js/adminlte.min.js"></script>
  <script>
    $(document).on('keypress', '#firstname', function (event) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('keypress', '#middlename', function (event) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('keypress', '#lastname', function (event) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('keypress', '#age', function (event) {
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    
  </script>
</html>
