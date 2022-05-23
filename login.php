<?php include_once "php/session_checker.php"?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cawork | Log in</title>
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
  crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <style>
    .centered{
      position: fixed;
      top: 30%;
      left: 40%;
      margin-top: -50px;
      margin-left: -100px;
    }
    .card-box{
      width: 500px;
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

<body>
<nav class="navbar navbar-expand navbar-light"
style="border: 1px solid #f0f2f5">
  <h5 class="text-bold m-3 text-success" 
  style="font-family: Comic Sans MS, Comic Sans, cursive">Cawork</h5>
</nav>
<div class="centered">
    <div class="card-box p-5">
      <div class="box-header d-flex justify-content-center py-3">
        <h3>Login to 
          <span class="text-bold text-success" 
          style="font-family: Comic Sans MS, Comic Sans, cursive">Cawork</span>
        </h3>
      </div>
      <div class="box-body px-3">
        <form action="controller/UserController.php" method="POST"> 
            <div class="input-group mb-3">
              <input type="text" name="username" id="username"   class="form-control"  placeholder="Username" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user-lock"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
              <input type="hidden"   name="login_token" value = "2021_caWorkWebSiteThesis">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <?php if(isset($_GET['errors'])): ?>
              <div class="d-flex justify-content-center my-3">
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                  <div class="fw-bold">
                    <?= $_GET['errors'] ?>
                  </div>
                </div>
              </div>
            <?php endif ?>
            <button type="submit" class="btn btn-success w-100">
              LOGIN
            </button>
            <hr>
            <div class="d-flex justify-content-center">
              <h6 class="text-secondary"
              style="font-family: Arial">Don't have a Cawork Account?</h6>
            </div>
            <a 
            href="../register.php?register"
            class="btn btn-outline-success mt-2 w-100"
            style="border-radius: 30px">
              Sign Up
            </a>
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
</body>
  <!-- <body class="hold-transition login-page"> -->
    <!-- <div class="logo">
      <a href="#"><img src="images/finallogo.jpg" alt="logo"></a>
    </div> -->
    <!-- <div class="login-box">
      <div class="card">
        <div class="card-body">
            <form action="controller/UserController.php" method="POST"> 
          <div>
        </div>

            <div class="input-group mb-3">
              <input type="text" name="username" id="username"   class="form-control"  placeholder="Username" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user-lock"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
              <input type="hidden"   name="login_token" value = "2021_caWorkWebSiteThesis">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            
            <?php if(isset($_GET['errors'])): ?>
              <div class="d-flex justify-content-center my-3">
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                  <div class="fw-bold">
                    <?= $_GET['errors'] ?>
                  </div>
                </div>
              </div>
            <?php endif ?>

            <button type="submit" value="Sign in"class="btn btn-primary btn-block">Login</button>

            <a
            href="../register.php?register"
            class="btn btn-success btn-block">Register</a>
          </form>
      </div>
    </div> -->

      <script src="admin/plugins/jquery/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" 
      integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" 
      crossorigin="anonymous"></script>
      <script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="admin/dist/js/adminlte.min.js"></script>
  <!-- </body> -->
</html>
