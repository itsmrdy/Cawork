<?php
  include_once '../work_arr.php';
  require_once '../core/init.php';
  $title = '';
  $category = '';
  $description = '';
  $top = '';
  $free = '';
  $exp = '';
  $pay = '';
  $budget = '';
  $payment = '';

  $id = $_SESSION['userId'];
  $my_id = $_SESSION['userId'];
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
    $category = ((isset($_POST['category']) != '')?($_POST['category']):'');
    $description = ((isset($_POST['description']) != '')?($_POST['description']):'');
    $top = ((isset($_POST['top']) != '')?($_POST['top']):'');
    $free = ((isset($_POST['free']) != '')?($_POST['free']):'');
    $exp = ((isset($_POST['exp']) != '')?($_POST['exp']):'');
    $pay  = ((isset($_POST['pay']) != '')?($_POST['pay']):'');
    $budget  = ((isset($_POST['budget']) != '')?($_POST['budget']):'');
    $payment  = ((isset($_POST['payment']) != '')?($_POST['payment']):'');


    $category = implode(', ', $category);
   

    if(isset($_GET['edit'])){
      $query = $db->query("UPDATE client SET `firstname` = '$firstname', `lastname` = '$lastname', `middlename` = '$middle', `birthday` = '$birthday', `age` = '$age', `address` = '$address', `username` = '$username', `password` = '$password' WHERE `client` = '$id'");
      echo '<script>
        alert("Updated!");
        window.location="client.php";
      </script>';
    }else{
      $date = Date("Y-m-d h:i:s a", strtotime('+8 hours')); 
      $query = $db->query("INSERT INTO job_db(`firstname`, `middlename`, `lastname`, `title`, `category`, `description`, `type_of_project`, `no_of_freelance`, `experience`, `payment_freelance`,`budget`, `mode_of_payment`, `job_id`, `time_posted`) VALUES ('$name', '$mname', '$lname', '".str_replace("'","",$title)."', '$category', '".str_replace("'","",$description)."', '$top', '$free', '$exp', '$pay','$budget','$payment','$id','$date')");
      echo '<script>
        alert("Job Posted");
        window.location="../client.php";
      </script>';
    }
   
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Client Profile</title>

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
          <div class="card card-success card-outline mt-4">
              <div class="card-header">
                <h3 class="card-title">Create Job<small></small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <div class="card-body">
                  <div class="form-group">
                  <form class="row g-3" method="post">
                      <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Job title</label>
                        <input type="text" name="title" class="form-control" id="inputEmail4" placeholder="Enter title" required>
                      </div>
                      <div class="col-md-4">
                        <label for="inputAddress" class="form-label">Category</label>
                        <div class="form-group">
                          <style>
                            .dropdown-check-list {
                              display: inline-block;
                            }

                            .dropdown-check-list .anchor {
                              position: relative;
                              display: inline-block;
                              padding: 5px 50px 5px 10px;
                              border: 1px solid #ccc;
                              border-radius: 5px;
                              width: 100%;
                            }

                            .dropdown-check-list .anchor:after {
                              position: absolute;
                              content: "";
                              border-left: 2px solid black;
                              border-top: 2px solid black;
                              padding: 5px;
                              right: 10px;
                              top: 20%;
                              -moz-transform: rotate(-135deg);
                              -ms-transform: rotate(-135deg);
                              -o-transform: rotate(-135deg);
                              -webkit-transform: rotate(-135deg);
                              transform: rotate(-135deg);
                            }

                            .dropdown-check-list .anchor:active:after {
                              right: 8px;
                              top: 21%;
                            }

                            .dropdown-check-list ul.items {
                              padding: 2px;
                              display: none;
                              margin: 0;
                              border: 1px solid #ccc;
                              border-top: none;
                            }

                            .dropdown-check-list ul.items li {
                              list-style: none;
                            }

                            .dropdown-check-list.visible .anchor {
                              color: #0094ff;
                            }

                            .dropdown-check-list.visible .items {
                              display: block;
                            }

                            #list1 label{
                              font-weight: lighter;
                            }
                          </style>

                          <select name="category[]" id="" class="form-control" required>
                             <option value="">Select Category</option>
                             <?php
                                foreach ($work_arr as $key => $value) {
                              ?>
                              <option value="<?=$value?>"> <?=$value?></option>
                              <?php
                                }
                              ?>
                          </select>
                          <!-- <div id="list1" class="dropdown-check-list col-md-12" tabindex="100">
                            <span class="anchor">Select Category</span>
                            <ul class="items">
                              <?php
                                foreach ($work_arr as $key => $value) {
                              ?>
                                <li></li>
                              <?php
                                }
                              ?>
                            </ul>
                          </div> -->
                          <script>
                            var checkList = document.getElementById('list1');
                            checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
                              if (checkList.classList.contains('visible'))
                                checkList.classList.remove('visible');
                              else
                                checkList.classList.add('visible');
                            }
                          </script>
                        </div>
                      </div>
                      <div class="col-6">
                        <label for="inputAddress" class="form-label">Description</label>
                        <textarea name="description" class="form-control" cols="30" rows="3" id="inputAddress" placeholder="Enter Description" required></textarea>
                      </div>
                      <div class="col-md-6">
                      <div class="form-group">
                                        <label for="exampleInputEmail1">Type of Project</label>
                                        
                                        <select class="form-control" name="top" required> 
                                        <option value="one-time project">One-time project</option>
                                        <option value="ongoing project">Ongoing project</option>
                                      
                                      </select>
                                      </div>
                      </div>
                      <div class="col-md-6">
                      <div class="form-group">
                                        <label for="exampleInputEmail1">Number of freelancer</label>
                                        
                                        <select class="form-control" name="free" required> 
                                        <option value="one freelancer">One freelancer</option>
                                        <option value="two or more freelancers">Two or more freelancers</option>
                                      
                                      </select>
                                      </div>
                      </div>
                      <div class="col-md-5">
                          <div class="form-group">
                                            <label for="exampleInputEmail1">Level of Experience</label>
                                            
                                            <select class="form-control" name="exp" required> 
                                            <option value="entry">Entry</option>
                                            <option value="intermediate">Intermediate</option>
                                            <option value="expert">Expert</option>
                                          
                                          </select>
                          </div>
                      </div>


                      
                      <div class="col-md-4">
                            <div class="form-group">
                                    <label for="exampleInputEmail1">How would you like to pay your freelancers?</label>
                                    <select class="form-control" name="pay" required> 
                                          <option value="pay per hour">Pay per hour</option>
                                          <option value="pay a fixed price">Pay a fixed price</option>
                                    </select>
                            </div>
                      </div>

                      <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Budget</label>
                                  <div class="input-group has-validation mt-4">
                                    <span class="input-group-text" id="inputGroupPrepend">₱</span>
                                    <input type="number" class="form-control rounded-lg" 
                                    min="0"
                                    max="999999"
                                    name="budget" id="validationCustomUsername" placeholder="0" required>
                                    <span class="input-group-text">.00</span>
                                    <div class="invalid-feedback">
                                  
                                    </div>
                                </div>
                             </div>
                      </div>
                      <div class="col-md-4">
                            <div class="form-group">
                                  <label for="exampleInputEmail1">Mode of Payment</label>
                                  <select class="form-control mt-4" name="payment" required> 
                                    <option value="gcash" >Gcash</option>
                                    <option value="paypal">Paypal</option>
                                    <option value="bank" >Bank</option>
                                    <option value="remittance">Remittance</option>
                                  </select>
                            </div>
                      </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                

                <input type="submit" id="submit_profile" value="Submit Job" class="btn btn-primary"
                onClick = "return confirmSubmit();"/>
                  <a href="../client.php" class="btn btn-default">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

<script>
  function confirmSubmit(){
    var agree= confirm("Are you sure you wish to continue?");
    if (agree)
      return true;
    else
      return false;
  }
</script>


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