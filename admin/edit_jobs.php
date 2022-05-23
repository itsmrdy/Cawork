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
  $result = $db->query("SELECT * FROM reg_db WHERE id = $id");
  
  $fetch = mysqli_fetch_assoc($result);
  $name = $fetch['firstname'];
  $mname = $fetch['middlename'];
  $lname = $fetch['lastname'];

  if(isset($_GET['job'])){
    $job_id = $_GET['job']; 
    $query = $db->query("SELECT * FROM job_db WHERE id = '$job_id'");
    $job_data = mysqli_fetch_assoc($query);

    $edit_title = $job_data['title'];
    $edit_category = $job_data['category'];
    $edit_description = $job_data['description'];
    $edit_type_of_project = $job_data['type_of_project'];
    $edit_no_of_freelance = $job_data['no_of_freelance'];
    $edit_experience = $job_data['experience'];
    $edit_payment_freelance = $job_data['payment_freelance'];
    $edit_budget = $job_data['budget'];
    $edit_mode_of_payment = $job_data['mode_of_payment'];

    $edit_my_category = explode(', ', $edit_category);
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
   

    if(isset($_GET['job'])){
      $job_id = $_GET['job'];
      if ($db->query("UPDATE job_db SET title = '$title', category = '$category', description = '$description', type_of_project = '$top', no_of_freelance = '$free', experience = '$exp', payment_freelance = '$pay', budget = '$budget', mode_of_payment = '$payment' WHERE id = '$job_id';")) {
        echo '<script>
          alert("Updated!");
          window.location="../client.php";
        </script>';
      } else {
        echo '<script>
          alert("An error occurred!");
        </script>';
      }
    }else{
      $query = $db->query("INSERT INTO job_db(`firstname`, `middlename`, `lastname`, `title`, `category`, `description`, `type_of_project`, `no_of_freelance`, `experience`, `payment_freelance`,`budget`, `mode_of_payment`, `job_id`) VALUES ('$name', '$mname', '$lname', '$title', '$category', '$description', '$top', '$free', '$exp', '$pay','$budget','$payment','$id')");
      echo '<script>
        alert("Jobs Submitted! Wait for Verification!");
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
                <a href="#" class="nav-link text-secondary active" data-toggle="tab">Edit Post</a>
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
    <section class="container">
            <br><br>
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Creating Job Post <small></small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <div class="card-body">
                  <div class="form-group">
                  <form class="row g-3" method="post">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Job title</label>
    <input type="text" name="title" class="form-control" id="inputEmail4" placeholder="Enter title" required value="<?=$edit_title?>">
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
      <!-- <div id="list1" class="dropdown-check-list col-md-12" tabindex="100">
        <span class="anchor">Select Category</span>
        <ul class="items">
        <?php
          foreach ($work_arr as $key => $value) {
        ?>
          <li><label><input type="checkbox" id="category" name="category[]" value="<?=$value?>"
        <?php
            if (in_array($value, $edit_my_category)) {
              echo "checked";
            }
        ?>
          > <?=$value?></label></li>
        <?php
          }
        ?>
        </ul>
      </div> -->

       <select name="category[]" id="" class="form-control" required>
           <option value="">Select Category</option>
           <?php
              foreach ($work_arr as $key => $value) {
           ?>
             <option value="<?=$value?>"
             <?= $edit_category == $value ? "selected": null ?> > <?=$value?></option>
           <?php
              }
           ?>
      </select>
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
    <textarea name="description" class="form-control" cols="30" rows="3" id="inputAddress" placeholder="Enter Description" required><?=$edit_description?></textarea>
  </div>
  <div class="col-md-4">
  <div class="form-group">
                    <label for="exampleInputEmail1">Type of Project</label>
                    
                    <select class="form-control" name="top" required> 
                    <option value="one-time project"
                  <?php
                    if ($edit_type_of_project === 'one-time project') {
                      echo "selected";
                    }
                  ?>
                    >One-time project</option>
                    <option value="ongoing project"
                  <?php
                    if ($edit_type_of_project === 'ongoing project') {
                      echo "selected";
                    }
                  ?>
                    >Ongoing project</option>
                  
                   </select>
                  </div>
  </div>
  <div class="col-md-5">
  <div class="form-group">
                    <label for="exampleInputEmail1">Number of freelancer</label>
                    
                    <select class="form-control" name="free" required> 
                    <option value="one freelancer"
                  <?php
                    if ($edit_no_of_freelance === 'one freelancer') {
                      echo "selected";
                    }
                  ?>
                    >One freelancer</option>
                    <option value="two or more freelancers"
                  <?php
                    if ($edit_no_of_freelance === 'two or more freelancers') {
                      echo "selected";
                    }
                  ?>
                    >Two or more freelancers</option>
                  
                   </select>
                  </div>
  </div>
  <div class="col-md-5">
  <div class="form-group">
                    <label for="exampleInputEmail1">Level of Experience</label>
                    
                    <select class="form-control" name="exp" required> 
                    <option value="entry"
                  <?php
                    if ($edit_experience === 'entry') {
                      echo "selected";
                    }
                  ?>
                    >Entry</option>
                    <option value="intermediate"
                  <?php
                    if ($edit_experience === 'intermediate') {
                      echo "selected";
                    }
                  ?>
                    >Intermediate</option>
                    <option value="expert"
                  <?php
                    if ($edit_experience === 'expert') {
                      echo "selected";
                    }
                  ?>
                    >Expert</option>
                  
                   </select>
                  </div>
  </div>
  <div class="col-md-5">
  <div class="form-group">
                    <label for="exampleInputEmail1">How would you like to pay your freelancers?</label>
                    
                    <select class="form-control" name="pay" required> 
                    <option value="pay per hour"
                  <?php
                    if ($edit_payment_freelance === 'pay per hour') {
                      echo "selected";
                    }
                  ?>
                    >Pay per hour</option>
                    <option value="pay a fixed price"
                  <?php
                    if ($edit_payment_freelance === 'pay a fixed price') {
                      echo "selected";
                    }
                  ?>
                    >Pay a fixed price</option>
                    
                  
                   </select>
                  </div>
  </div>
  
  <div class="col-md-3">
  <div class="form-group">
                    <label for="exampleInputEmail1">Budget</label>
                    <div class="col-md-8">
                    <div class="input-group has-validation">
      <span class="input-group-text" id="inputGroupPrepend">₱</span>
      <input type="number" class="form-control" name="budget" id="validationCustomUsername" placeholder="0" required value="<?=$edit_budget?>">
      <span class="input-group-text">.00</span>
      <div class="invalid-feedback">
      
      </div> </div>

                  </div>
                 </div>
</div>
<div class="col-md-2">
  <div class="form-group">
                    <label for="exampleInputEmail1">Mode of Payment</label>
                    
                    <select class="form-control" name="payment" required> 
                    <option value="gcash"
                  <?php
                    if ($edit_mode_of_payment === 'gcash') {
                      echo "selected";
                    }
                  ?>
                    >Gcash</option>
                    <option value="paypal"
                  <?php
                    if ($edit_mode_of_payment === 'paypal') {
                      echo "selected";
                    }
                  ?>
                    >Paypal</option>
                    <option value="bank"
                  <?php
                    if ($edit_mode_of_payment === 'bank') {
                      echo "selected";
                    }
                  ?>
                    >Bank</option>
                    <option value="remittance"
                  <?php
                    if ($edit_mode_of_payment === 'remittance') {
                      echo "selected";
                    }
                  ?>
                    >Remittance</option>
                   
                  
                   </select>
                  </div>
  </div>

                 
  
                  
                  
                  
                  <!--div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <textarea name="description" id="description" class="form-control" cols="30" rows="10"><?= $description; ?></textarea>
                  </div>-->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                

                <input type="submit" id="submit_profile" value="Submit Job" class="btn btn-primary "/>
                  <a href="../client.php" class="btn btn-default">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
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