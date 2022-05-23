<?php
  require_once '../core/init.php';
  $skills = '';
  $rate = '';
  $type= '';
  $description= '';
  $services= '';

  if (!isset($_GET['service'])) {
?>
  <script>
    window.history.back()
  </script>
<?php
  }

  $service_id = $_GET['service'];

  $service_query = $db->query("SELECT * FROM service_db WHERE id = '$service_id';");
  $service_data = mysqli_fetch_assoc($service_query);


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
    $description= ((isset($_POST['description']) != '')?($_POST['description']):'');
    $services= ((isset($_POST['services']) != '')?($_POST['services']):'');
 




    $query = $db->query("UPDATE service_db SET skills = '$skills', rate = '$rate', services = '$services', description = '$description' WHERE `id` = '$service_id'");
      echo '<script>
        alert("Updated!");
        window.location="mypost_freelance.php";
      </script>';
   
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
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="sidebar-is-closed sidebar-collapse">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
      <img src="../images/finallogo1.png" height="60" width="200">
      <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active rounded-lg" href="#">My Services</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="../freelance.php">Home</a></li>
      </ul>
      <ul class="navbar-nav ml-auto">
            <a href="logout.php" class="btn btn-secondary"><i class="fas fa-power-off"></i></a>
      </ul>
    </nav>
  
  

  <div class="content-wrapper">
       <div class="container">
          <div class="card card-dark mt-5"
          style="height: 30rem">
              <div class="card-header">
                <h3 class="card-title">* Post Services<small></small></h3>
              </div>
              <div class="card-body">
                  <div class="form-group">
                    <form class="row g-3" method="POST">
                      <div class="col-md-4">
                        <label for="inputEmail4" class="form-label">Enter your Skills</label>
                        <select class="form-control" required name="skills">
                        <?php
                          foreach ($my_skills as $key => $value) {
                        ?>
                          <option <?php
                            if ($service_data['skills'] === $value) {
                              echo "selected";
                            }
                          ?>><?=$value?></option>
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
                              <span class="input-group-text" id="inputGroupPrepend">₱</span>
                              <input type="number" class="form-control mx-1" 
                              style="border-radius: 5px"
                              value="<?=$service_data['rate']?>" name="rate" id="validationCustomUsername" placeholder="0">
                              <span class="input-group-text">.00</span>
                              <div class="invalid-feedback">
                              
                              </div> 
                                <select class="input-group-text mx-1" name="type" aria-label="Default select example" required>
                                  <option selected value="day">/Day</option>
                                  <option value="week">/Week</option>
                                </select> 
                              </div>  
                            </div>
                          </div>
                      </div>
                      <div class="col-md-5">
                          <label for="inputEmail4" class="form-label">Services <small>* Based on your skill what kind of services can you offer</small></label>
                          <textarea type="text" name="services" class="form-control" rows="8" col="5 "id="inputEmail4" placeholder="Enter Services" required><?=$service_data['services']?></textarea>
                        </div>
                        
                        <div class="col-md-5">
                          <label for="inputEmail4" class="form-label">Description</label>
                          <textarea type="text" name="description" class="form-control" rows="8" col="5 "id="inputEmail4" placeholder="Enter Description" required><?=$service_data['description']?></textarea>
                        </div>
                      </div>
                        <input type="submit" value="Save" class="btn btn-primary"
                        style="width: 200px"/>
                        <a href="mypost_freelance.php" class="btn btn-default"
                        style="width: 200px">Cancel</a>
                      </form>
                  </div>
              </div>
            </div>
       </div>
  </div>
</div>
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
