<?php
  require_once '../core/init.php';

  date_default_timezone_set('Asia/Manila');

  $user_id = $_GET['user'];

  $result = $db->query("SELECT * FROM reg_db WHERE id = '$user_id';");
  $userRow = mysqli_fetch_assoc($result);

  $ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$user_id' AND delete_flg = '0';");
  $ratings_row = mysqli_fetch_assoc($ratings);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | User Profile</title>

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
                <h3 class="card-title">User Profile<small></small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <div class="card-body" style="text-align: center;align-content: center;">
                <div style="width: 60%;margin: auto;">
                  <img style="width: 7rem;height: 7rem;" class="profile-user-img img-fluid img-circle" src="../uploads/<?=$userRow['profile_picture']?>" alt="User profile picture">
                  <h3 class="text-primary" style="text-transform: capitalize;"><?=$userRow['firstname']?> <?=$userRow['middlename']?> <?=$userRow['lastname']?></h3>
                  <h5>
                <?php
                  if ($userRow['user_type_id'] === '1') {
                    echo "Client";
                  } else {
                    echo "Skilled Worker";
                  }
                ?>
                    <br>Email: <span class="text-primary"><?=$userRow['email']?></span>
                    <br>Number: <span class="text-primary"><?=$userRow['firstname']?></span>
                    <br>Ratings: <span class="text-primary">
                <?php
                  if (!empty($ratings_row['ave_rating'])) {
                    echo round($ratings_row['ave_rating'], 2);
                  } else{
                    echo "No ratings yet";
                  }
                ?>
                    </span>
                    <br>Skills:<br><span class="text-primary"><?=$userRow['skills']?></span>
                  </h5>
                </div>
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
</body>
</html>