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
  
  
  $result = $db->query("SELECT *, CONCAT(firstname,' ',lastname) AS name FROM reg_db WHERE id = $id");
  
  $fetch = mysqli_fetch_assoc($result);
  $name = $fetch['name'];
  
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

  function custom_echo($x, $length) {
    if(strlen($x)<=$length)
    {
      echo $x;
    }
    else
    {
      $y=substr($x,0,$length) . '...';
      echo $y;
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
                <a href="../freelance.php" class="nav-link text-secondary">Home</a>
              </li>
            </ul>
          </div>
        </div>
        <a href="../logout.php" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i></a>
    </nav>
  <!-- /.navbar -->

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <div class="container">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card mt-3">
              <div class="card-header">
                <h3 class="card-title">My Post<small></small></h3>
              </div>
              <!-- /.card-header -->
              
              <!-- form start -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                    <th>Skills</th>
                    <th>Rate</th>
                    <th>Day/Week</th>
                    <th>Services</th>
                    <th>Description</th>
                   
                    <th>Action</th>
                   
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $query = $db->query("SELECT * FROM service_db WHERE reg_id = '$my_id'"); //Eto yung query
                      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
                        $service_id = $freelancer['id'];
                    ?>
                    <tr>
                      <td><?= $freelancer['skills']; ?></td>
                      <td><?= $freelancer['rate']; ?></td>
                      <td><?= $freelancer['day_week']; ?></td>
                      <td><?= custom_echo($freelancer['services'], 100); ?></td>
                      <td><?= custom_echo($freelancer['description'], 100); ?></td>
                     
                     
                      <td>
                      <div>
                      <!--<a href="#" class="btn btn-info btn-md">Check </a>-->
                          <a href="edit_services.php?service=<?=$freelancer['id']?>" class="btn btn-success btn-sm mb-1"><i class="fas fa-edit"></i></a>
                          <a href="#" onclick="delete_post('<?=$service_id?>')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                        </div>
                      </td>
                    </tr>
                    <?php endwhile; ?> <!-- Eto naman yung end ng while loop -->
                  </tbody>
                  
                </table>
        </div>
      </div><!-- /.container-fluid -->
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

function delete_post(service_id) {
  var request = 'freelance_delete_job';

  if (confirm('Are you sure?') === true) {
    $.ajax({
      url: '../ajax_request.php',
      method: 'post',
      data: {
        service_id: service_id,
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
