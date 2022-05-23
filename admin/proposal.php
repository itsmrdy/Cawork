<?php
  require_once '../core/init.php';
    if(isset($_GET['edit'])){
      $id = $_GET['edit']; 
      $query = $db->query("SELECT * FROM job_db WHERE id = $id");
      $result = mysqli_fetch_assoc($query);
      $job_id = $result['job_id'];
      $title = ((isset($result['title']) != '')?($result['title']):'');
      $budget = ((isset($result['budget']) != '')?($result['budget']):'');
      $description = ((isset($result['description']) != '')?($result['description']):'');
      $experience_required = ((isset($result['experience']) != '')?($result['experience']):'');
      $type_of_project = ((isset($result['type_of_project']) != '')?($result['type_of_project']):'');
      $user_id = $_SESSION['userId'];
      $result = $db->query("SELECT *, CONCAT(firstname,' ',lastname) AS name FROM reg_db WHERE id = $user_id");
      $time = $db->query("SELECT *, CONCAT(time_availability,' hours ',day_week) AS time FROM reg_db WHERE id = $user_id");
      $fetch = mysqli_fetch_assoc($result);
      $fetch1 = mysqli_fetch_assoc($time);
      $name = $fetch['name'];
      $availability = $fetch1['time'];
      $level = $fetch['experience'];
      $rate = $fetch['rate'];
      $education = $fetch['education'];
      $skills = $fetch['skills'];

      $validate = $db->query("SELECT id FROM proposal_db WHERE proposal_id = '$id' AND user_id = '$user_id' AND delete_flg = '0' AND status != '3';");

      if (mysqli_num_rows($validate) > 0) {
        echo '<script>
          alert("Proposal was already submitted. Please wait for confirmation");
          window.location="../freelance.php";
        </script>';
      }

      if(isset($_POST['submit_btn'])) {
        $rate = $_POST['rate'];
        $availability = $_POST['availability'];
        $message  = mysqli_real_escape_string($db, ((isset($_POST['message']) != '')?($_POST['message']):''));
        $db->query("INSERT INTO proposal_db(`job_title`, `budget`, `description`, `experience_level`, `project_type`, `name`, `rate`, `availability`, `level`, `skills`, `message`, `proposal_id`, `user_id`, `status`) 
        VALUES ('$title', '$budget', '$description', '$experience_required', '$type_of_project', '$name', '$rate', '$availability', '$level', '$skills', '$message', '$id', '$user_id', '0')");
        echo '<script>
          alert("Proposal Submitted! Wait for aproval");
          window.location="../freelance.php";
        </script>';
      }
    }
   
  // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Proposal</title>

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
            style="font-family: Comic Sans MS, Comic Sans, cursive;">Cawork</span>
          </a>

          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse order-5" id="navbarCollapse">
            <ul class="nav nav-tabs ml-3 p-3">
              <li class="nav-item">
                <a href="#" class="nav-link text-secondary active" data-toggle="tab">Proposal</a>
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
    <br><br>
    <section class="container">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title text-bold">Job details</h3>
              </div>
              <!-- /.card-header -->
             
              <!-- form start -->
              <div class="card-body text-capitalize">
                <div class="form-group">
                  <form class="row g-3" method="POST">
                <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">Job title</label>
                  <input class="form-control" type="text" name="title" placeholder="<?= $title ?>" aria-label="Disabled input example" disabled readonly>
                </div>
                <div class="col-md-3">
                  <label for="inputPassword4" class="form-label">Budget</label>
                  <input class="form-control" type="text" name="budget" placeholder="₱ <?= $budget ?>" aria-label="Disabled input example" disabled readonly>
                </div>
                <div class="col-12">
                  <label for="inputAddress" class="form-label">Description</label>
                  <textarea type="text" name="description" class="form-control" cols="30" rows="5" aria-label="Disabled input example" disabled readonly><?= $description ?></textarea>
                </div>
                <div class="col-5">
                  <label for="inputAddress2" class="form-label">Experience level</label>
                  <input class="form-control" type="text" name="experience" placeholder="<?= $experience_required; ?>" aria-label="Disabled input example" disabled readonly>
                </div>
                <div class="col-5">
                  <label for="inputAddress2" class="form-label">Project type</label>
                  <input class="form-control text-capitalize" type="text" name="project" placeholder="<?= $type_of_project ?>" aria-label="Disabled input example" disabled readonly>
                </div>
            </div>
  </div>
  </div>
 
                <!--Second form -->
                <div class="card">
              <div class="card-header">
                <h3 class="card-title text-bold">Your details</h3>
              </div>
              <!-- /.card-header -->
          <?php
              $user_id = $_SESSION['userId'];
  
  
            $result = $db->query("SELECT *, CONCAT(firstname,' ',lastname) AS name FROM reg_db WHERE id = $user_id");
            $time = $db->query("SELECT *, CONCAT(time_availability,' hours ',day_week) AS time FROM reg_db WHERE id = $user_id");
            $fetch = mysqli_fetch_assoc($result);
            $fetch1 = mysqli_fetch_assoc($time);
            $name = $fetch['name'];
            $availability = $fetch1['time'];
            $experience = $fetch['experience'];
            $location = $fetch['address'];
            $rate = $fetch['rate'];
            $education = $fetch['education'];
            $skills = $fetch['skills'];
            $email = $fetch['email'];


  ?>
              
              <!-- form start -->
              <div class="card-body">
                  <div class="form-group row g-3">
                                  
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Name</label>
                    <input class="form-control text-capitalize" type="text" name="name" placeholder="<?= $name;?>" aria-label="Disabled input example" disabled readonly>
                  </div>
                  <div class="col-md-3">
                    <label for="inputPassword4" class="form-label">Rate</label>
                    <input class="form-control" type="text" name="rate" placeholder="₱ <?= $rate;?> hr" aria-label="Disabled input example" required>
                  </div>
                  <div class="col-md-3">
                    <label for="inputPassword4" class="form-label">Availability</label>
                    <input class="form-control" type="text" name="availability" placeholder="<?= $availability;?>" aria-label="Disabled input example" required>
                  </div>
                  
                  <div class="col-5">
                    <label for="inputAddress2" class="form-label">Experience level</label>
                    <input class="form-control" type="text" name="level" placeholder="<?= $experience;?>" aria-label="Disabled input example" disabled readonly>
                  </div>
                  <div class="col-5">
                    <label for="inputAddress2" class="form-label">skills</label>
                    <input class="form-control" type="text" name="skills" placeholder="<?= $skills;?>" aria-label="Disabled input example" disabled readonly>
                  </div>
                  <div class="col-10">
                    <label for="inputAddress2" class="form-label">Message to client</label>
                    <textarea class="form-control" type="text" cols="100" row="3" name="message" placeholder="Type here"></textarea>
                  </div>
                  </div>
                  <input type="submit" name="submit_btn" value="Submit Proposal" class="btn btn-primary"
                  onClick = "return confirmSubmit();"/>
                  <a href="../freelance.php" class="btn btn-default">Cancel</a>
                  </div>
                  </div>
                
                  
                  </form>
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
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
  function confirmSubmit(){
    var agree= confirm("Are you sure you wish to continue?");
    if (agree)
      return true;
    else
      return false;
  }
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
