<?php
  require_once '../core/init.php';
// Delete module
if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $query = $db->query("UPDATE proposal_db SET `status` = 1 WHERE `id` = '$id'");
  echo '<script>
      alert("Deleted!");
      window.location="active_proposal.php";
    </script>';
 }
 // Delete module
if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $query = $db->query("UPDATE proposal_db SET `status` = 2 WHERE `id` = '$id'");
  echo '<script>
      alert("Proposal Accepted!");
      window.location="active_proposal.php";
    </script>';
 }
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
</head>
<body class="sidebar-is-closed sidebar-collapse">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar  navbar-dark navbar-dark">
  <img src="../images/finallogo.jpg" height="100" width="220">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
     
    </ul>

    <!-- SEARCH FORM -->
   

    <!-- Right navbar links -->
    
    <ul class="navbar-nav ml-auto">
        
     
    
    </ul>
  </nav>
  <!-- /.navbar -->

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
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
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Pending Proposals<small></small></h3>
                
              </div>
              <!-- /.card-header -->
              
              <!-- form start -->
              <div class="card-body">
                <table id="example1" class="table table-dark table-striped">
                  <thead>
                  <tr>
                    <th>Job Title</th>
                    <th>Budget</th>
                    <th>Description</th>
                    <th>Experience Level <small>*need</small></th>
                    <th>Project Type</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Availability</th>
                    <th>Level</th>
                    <th>Skills</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                     $user_id = $_COOKIE['id'];
                      $query = $db->query("SELECT * FROM proposal_db WHERE proposal_id=$user_id and status=0 "); //Eto yung query
                      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
                       
                    ?>
                    <tr>
                      <td><?= $freelancer['job_title']; ?></td>
                      <td><?= $freelancer['budget']; ?></td>
                      <td><?= $freelancer['description']; ?></td>
                      <td><?= $freelancer['experience_level']; ?></td>
                      <td><?= $freelancer['project_type']; ?></td>
                      <td><?= $freelancer['name']; ?></td>
                      <td><?= $freelancer['rate']; ?></td>
                      <td><?= $freelancer['availability']; ?></td>
                      <td><?= $freelancer['level']; ?></td>
                      <td><?= $freelancer['skills']; ?></td>
                      <td><?= $freelancer['message']; ?></td>
                     
                      <td>
                      <div>
                      <!--<a href="#" class="btn btn-info btn-md">Check </a>-->
                          <a href="active_proposal.php?edit=<?= $freelancer['id']; ?>" onclick="return confirm('Accept Proposal?');" class="btn btn-success btn-sm"><i class="fas fa-user-check"></i></a>
                          <a href="active_proposal.php?delete=<?= $freelancer['id']; ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm"><i class="fas fa-user-times"></i></a>
                        </div>
                      </td>
                    </tr>
                    <?php endwhile; ?> <!-- Eto naman yung end ng while loop -->
                  </tbody>
                  
                </table> 
  
        
        
  

  
  
 
  

            
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
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0-rc
    </div>
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
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
</script>
</body>
</html>
