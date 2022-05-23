<?php
  require_once '../core/init.php';
  $title = '';
  $budget = '';
  $description = '';
  $experience = '';
  $project = '';
  $name = '';
  $rate = '';
  $availability = '';
  $level = '';
  $skills = '';
  $message = '';

  $id = $_SESSION['userId'];
  $my_id = $_SESSION['userId'];
  
  date_default_timezone_set('Asia/Manila');
  
  $result = $db->query("SELECT * FROM reg_db WHERE id = $id");
  $time = $db->query("SELECT *, CONCAT(time_availability,' hours ',day_week) AS time FROM reg_db WHERE id = $id");
  $fetch = mysqli_fetch_assoc($result);
  $fetch1 = mysqli_fetch_assoc($time);
  $name = $fetch['firstname'];
  $mname = $fetch['middlename'];
  $lname = $fetch['lastname'];
  $fname = $fetch['firstname'];
  $mname = $fetch['middlename'];
  $lname = $fetch['lastname'];
  $profile_picture = $fetch['profile_picture'];


  $availability = $fetch1['time'];
  $experience = $fetch['experience'];
  $location = $fetch['address'];
  $rate = $fetch['rate'];
  $education = $fetch['education'];
  $skills = $fetch['skills'];
  $email = $fetch['email'];
  
  
  $acc_status = $db->query("SELECT status FROM reg_db WHERE id = '$my_id';");
  $accstatus = mysqli_fetch_assoc($acc_status);
  $account_status = $accstatus['status'];

  
  $new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM ratings WHERE user_id = '$my_id'");
  $new_ratings_row = mysqli_fetch_assoc($new_ratings);


  if(isset($_GET['edit'])){
    $id = $_GET['edit']; 
    $query = $db->query("SELECT * FROM client WHERE clientid = '$id'");
    $result = mysqli_fetch_assoc($query);
    $firstname = $result['firstname'];
    $lastname = $result['lastname'];
    $middle = $result['middlename'];
    $birthday = $result['birthday'];
    $age = $result['age'];
    $address = $result['address'];
    $username = $result['username'];
    $password = $result['password'];
    
  }

  if($_POST){
    $title = ((isset($_POST['title']) != '')?($_POST['title']):'');
    $budget = ((isset($_POST['budget']) != '')?($_POST['budget']):'');
    $description = ((isset($_POST['description']) != '')?($_POST['description']):'');
    $experience = ((isset($_POST['experience']) != '')?($_POST['experience']):'');
    $project = ((isset($_POST['project']) != '')?($_POST['project']):'');
    $name = ((isset($_POST['name']) != '')?($_POST['name']):'');
    $rate  = ((isset($_POST['rate']) != '')?($_POST['rate']):'');
    $availability  = ((isset($_POST['availability']) != '')?($_POST['availability']):'');
    $level = ((isset($_POST['level']) != '')?($_POST['level']):'');
    $skills  = ((isset($_POST['skills']) != '')?($_POST['skills']):'');
    $message  = ((isset($_POST['message']) != '')?($_POST['message']):'');
   

    if(isset($_GET['edit'])){
      $query = $db->query("UPDATE client SET `firstname` = '$firstname', `lastname` = '$lastname', `middlename` = '$middle', `birthday` = '$birthday', `age` = '$age', `address` = '$address', `username` = '$username', `password` = '$password' WHERE `client` = '$id'");
      echo '<script>
        alert("Updated!");
        window.location="client.php";
      </script>';
    }else{
      $query = $db->query("INSERT INTO proposal_db(`job_title`, `budget`, `description`, `experience_level`, `project_type`, `name`, `rate`, `availability`, `level`, `skills`, `message`) 
      VALUES ('$title', '$budget', '$description', '$experience', '$project', '$name', '$rate', '$availability', '$level', '$skills', '$message')");
      echo '<script>
        alert("Proposal Submitted! Wait for aproval");
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
  <title>CaWork | Active Proposals</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    #module {
      font-size: 1rem;
      line-height: 1.5;
    }

    #module p.collapse[aria-expanded="false"] {
      display: block;
      height: 3rem !important;
      overflow: hidden;
    }

    #module p.collapse.show[aria-expanded="false"] {
      height: 3rem !important;
    }

    #module a.collapsed:after {
      content: '+ Show More';
    }

    #module a:not(.collapsed):after {
      content: '- Show Less';
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
                <a href="#" class="nav-link text-secondary active" data-toggle="tab">Post</a>
              </li>
              <li class="nav-item">
                <a href="../client.php" class="nav-link text-secondary">Home</a>
              </li>
            </ul>
          </div>
        </div>
        <a href="../logout.php" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i></a>
    </nav>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container">
        <div class="row">
          <div class="col-md-3">
          <div class="card mt-4" style="border-top: 5px solid green;">
              <div class="card-body box-profile"
                  style="background: #e4ebe4">
                    <div class="text-center">
                      <?php if(file_exists("../uploads/profile/client/".$profile_picture) && $profile_picture != null): ?>
                        <img src="../uploads/profile/client/<?=$profile_picture?>" alt="User profile picture"
                        style="width: 7rem;height: 7rem;" class="profile-user-img img-fluid img-circle">
                      <?php else: ?>
                          <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                          style="width: 7rem;height: 7rem;" class="profile-user-img img-fluid img-circle">
                      <?php endif; ?>
                    </div>

                    <h4 class="profile-username text-capitalize text-center p1 text-bold"><?= $fname;?> <?= $mname;?> <?= $lname;?></h4>

                    <p class="text-muted text-center">I am a client</p>
                  </div> 
                  <div class="card-footer">
                      <div class="container rounded-lg bg-warning">
                        <ul class="list-group list-group-unbordered mb-3">
                          <li class="list-group-item text-capitalize p-3">
                            <b><span class="text-dark">Ratings</span></b> 
                            <a class="float-right">
                              <?php
                                if (empty($new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  echo round($new_ratings_row['ave_rating'], 2);
                                }
                              ?>
                            </a>
                          </li>
                        </ul>
                      </div>
                      <?php
                        if ($account_status != 2) {
                      ?>
                        <button disabled href="../admin/mypost_client.php" class="btn btn-success btn-block"><b>My Post</b></button>
                        <button disabled href="../admin/post1.php" class="btn btn-success btn-block"><b>Post Jobs</b></button>
                        <a href="../admin/client_profile.php?edit=<?=$id?>" class="btn btn-success btn-block"><b>Update profile</b></a>
                        <button disabled href="../admin/client_reviews.php?my_id=<?=$my_id?>" class="btn btn-success btn-block"><b>My reviews</b></button>
                      <?php    
                        } else {
                      ?>
                        <a href="../admin/mypost_client.php" class="btn btn-success btn-block"><b>My Post</b></a>
                        <a href="../admin/post1.php" class="btn btn-success btn-block"><b>Post Jobs</b></a>
                        <a href="../admin/client_profile.php?edit=<?=$id?>" class="btn btn-success btn-block"><b>Profile</b></a>
                        <a href="../admin/client_reviews.php?my_id=<?=$my_id?>" class="btn btn-success btn-block"><b>My reviews</b></a>
                      <?php
                        }
                      ?>
                      
                </div>
              </div>
          </div>
          <div class="col-md-9">
                <?php 
                  $result= mysqli_query($db, "SELECT * FROM job_db WHERE job_id = '$id'");
                  $rowcount= mysqli_num_rows($result);
                ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="card mx-1 mt-4" style="width: 86%; background-color:#d7ecf4">
                    <div class="card-header">
                      <h5 class="text-bold card-title text-primary">Showing <?= $rowcount ?> Jobs</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <?php 
                $query = $db->query("SELECT * FROM job_db WHERE job_id = '$id'"); 
                while($freelancer = mysqli_fetch_assoc($query)):
                  $job_id = $freelancer['id'];
                ?>
                <div class="col-md-5 mx-2">
                  <div class="card" style="width: 100%">
                    <div class="card-body">
                      <h5 class="text-bold text-capitalize"><?= $freelancer['title']; ?></h5>
                        <p class="card-text"  data-toggle="collapse" href="#showMore<?=$job_id?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <?= substr($freelancer['description'],0, 50) ?> 
                            <?php if(strlen($freelancer['description']) > 50): ?>
                              <span class="collapse" id="showMore<?=$job_id?>">
                                <?= substr($freelancer['description'], 50,strlen($freelancer['description'])) ?>
                              </span>
                              <span class="text-primary">... <i class="fa fa-chevron-right text-dark"
                              style="font-size: 12px"></i></span>
                            <?php endif; ?>
                        </p>

                      <div class="text-capitalize text-secondary">
                        <span class="mr-1 text-bold text-dark">Job Rate: </span>
                        <span class="text-bold text-capitalize text-dark">Php. <?= $freelancer['budget']; ?></span>
                      </div>

                      <div class="text-capitalize text-secondary">
                        <span class="mr-1">Payment Via: </span>
                        <span class="text-bold text-capitalize text-dark"><?= $freelancer['mode_of_payment']; ?></span>
                      </div>
                      <div class="row">
                        <div class="col-md-5">
                          <h5><span class="badge text-primary mt-3 text-capitalize" style="background-color: lightblue "><?= $freelancer['type_of_project']; ?></span></h5>
                        </div>
                        <div class="col-md-7">
                          <h5><span class="badge text-primary mt-3 text-capitalize" style="background-color: lightblue "><?= $freelancer['no_of_freelance']; ?></span></h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <h5><span class="badge text-primary text-capitalize" style="background-color: lightblue"><?= $freelancer['experience']; ?> Level</span></h5>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="edit_jobs.php?job=<?=$freelancer['id']?>" class="btn btn-primary">EDIT POST</a>
                      <a href="#" onclick="delete_post('<?=$job_id?>')" class="btn btn-danger">REMOVE</a>
                    </div>
                  </div>
                </div>
                <?php endwhile; ?>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0-rc
    </div>
    <strong>Copyright &copy; 2020-2021</strong> All rights reserved.
  </footer>

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

function delete_post(job_id) {
  var request = 'client_delete_job';

  if (confirm('Are you sure?') === true) {
    $.ajax({
      url: '../ajax_request.php',
      method: 'post',
      data: {
        job_id: job_id,
        request: request
      },
      dataType: 'text',
      success:function(data){
        if (data === '1') {
          alert('Successfully deleted');
        } else {
          alert('An error occured');
        }
        window.location.reload();
      }
    });
  }
}
</script>
</body>
</html>
