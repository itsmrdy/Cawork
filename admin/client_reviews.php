<?php
  require_once '../core/init.php';

  date_default_timezone_set('Asia/Manila');

  $my_id = $_GET['my_id'];

  
  $query = $db->query("SELECT CONCAT(reg_db.firstname,' ', reg_db.lastname)
  as client, profile_picture, id 
  FROM reg_db WHERE id = '$my_id'");
  $user_data = mysqli_fetch_assoc($query);
  $profile_data = $user_data['profile_picture'];
  $ratings = $db->query("SELECT AVG(rating) AS ave_rating, COUNT(id) as reviewers FROM ratings WHERE user_id = '$my_id'");
  $ratings_row = mysqli_fetch_assoc($ratings);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Reviews</title>

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
            style="font-family: Comic Sans MS, Comic Sans, cursive;">Cawork</span>
          </a>

          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse order-5" id="navbarCollapse">
            <ul class="nav nav-tabs ml-3 p-3">
              <li class="nav-item">
                <a href="#" class="nav-link text-secondary active" data-toggle="tab">Reviews</a>
              </li>
              <li class="nav-item">
                <a href="../client.php" class="nav-link text-secondary">Home</a>
              </li>
            </ul>
          </div>
        </div>
        <a href="../logout.php" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i></a>
    </nav>
  <div class="content-wrapper">
    <div class="container">
       <br><br>
       <div class="d-sm-flex mt-3 mb-3 p-3">
                  <?php if(file_exists("../uploads/profile/client/".$profile_data) && $profile_data != null): ?>
                    <img src="../uploads/profile/client/<?=$profile_data?>" alt="User profile picture"
                    style="width: 4rem; height: 4rem;" class="img-circle">
                  <?php else: ?>
                      <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                      style="width: 4rem; height: 4rem;" class="img-circle">
                  <?php endif; ?>
                  <div class="d-flex flex-column ml-3">
                    <a  href="http://34.192.240.192/profile.php?log=<?= $user_data['id']?>" class="ml-1 d-flex flex-column">
                      <span class="text-capitalize text-bold text-lg text-success"><?=$user_data['client']?></span>
                      <span class="text-dark">View Profile</span>
                    </a>
                  </div>
        </div>
       <div class="container bg-white">
         <div class="card-header">
           <h4 class="text-bold text-dark">Reviews</h4>
         </div>
         <div class="card-body">
                  <?php
                    if (empty($ratings_row['ave_rating'])) {
                  ?>
                    <div class="d-flex flex-column">
                          <div class="d-flex justify-content-center">
                              <img src="../images/result_no.png" alt=""
                                  height="500px" width="600px">
                          </div>
                          <div class="d-flex justify-content-center">
                              <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                          </div>
                    </div>
                  <?php
                    } else {
                  ?>
                   <div class="d-flex justify-content-center">
                      <h4 class="text-dark">Rating Overview</h4>
                    </div>
                    <div class="d-flex justify-content-center">
                      <div class="d-flex">
                        <h3 class="text-bold"><?= $ratings_row['ave_rating'] ?></h3>
                        <h6 class="mt-2">/5</h6>
                      </div>
                    </div>
                    <div class="d-flex justify-content-center">
                      <h3 class="text-bold"><?php 
                          if($ratings_row['ave_rating'] == 0){
                            for ($i=0; $i < 5; $i++) { 
                              print('<i class="fa fa-star text-secondary"></i>');
                            }
                          }
                          for ($i=0; $i < round($ratings_row['ave_rating'], 0) ; $i++) { 
                        ?>
                            <i class="fa fa-star text-warning"></i>
                        <?php
                          }
                        ?>
                      </h3>
                    </div>
                      <div class="d-flex justify-content-center">
                        <h6>based on <?= $ratings_row['reviewers'] ?> reviews</h6>
                      </div>
                      <div class="row mt-3">
                        <div class="col-md-1">
                            <h6>Excellent</h6>
                        </div>
                        <div class="col-md-10">
                          <div class="bg-primary" width="50%"
                            style="border-radius: 5px; color: transparent"
                            height="50px"> 
                            <h5 class="ml-1" style="color: transparent">3/5</h5>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-1">
                            <h6>Good</h6>
                        </div>
                        <div class="col-md-9">
                          <div class="bg-success" width="50%"
                            style="border-radius: 5px; color: transparent"
                            height="50px"> 
                            <h5 class="ml-1" style="color: transparent">3/5</h5>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-1">
                            <h6>Average</h6>
                        </div>
                        <div class="col-md-8">
                          <div class="bg-warning" width="50%"
                            style="border-radius: 5px; color: transparent"
                            height="50px"> 
                            <h5 class="ml-1" style="color: transparent">3/5</h5>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-1">
                            <h6>Below Average</h6>
                        </div>
                        <div class="col-md-7">
                          <div class="bg-dark" width="50%"
                            style="border-radius: 5px; color: transparent"
                            height="50px"> 
                            <h5 class="ml-1" style="color: transparent">2/5</h5>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-1">
                            <h6>Poor</h6>
                        </div>
                        <div class="col-md-6">
                          <div class="bg-danger" width="50%"
                            style="border-radius: 5px; color: transparent"
                            height="50px"> 
                            <h5 class="ml-1" style="color: transparent">2/5</h5>
                          </div>
                        </div>
                      </div>
                  <?php
                    }
                  ?>
                    
                  <div class="p-1 mt-3"
                    style="background: #f0f2f5; border-radius: 3px">
                        <h5 class="m-1">Ratings</h5>
                  </div>
                  <?php
                    $query = $db->query("SELECT
                                        from_reg.firstname,
                                        from_reg.lastname,
                                        from_reg.profile_picture,
                                        review.*
                                        FROM ratings review
                                        JOIN reg_db from_reg
                                        ON review.create_user = from_reg.id
                                        WHERE review.user_id = '$my_id';");                                                                                                                                                                                                                                                                                                                                                                                

                    while ($reviews = mysqli_fetch_assoc($query)):
                    $profile_picture = $reviews['profile_picture'];
                  ?>
                    <!-- <h5 class="text-bold text-success mt-4"><?=$reviews['services']?></h5> -->
                    <div>
                      <div class="d-flex mt-5">
                        <?php if(file_exists("../uploads/profile/freelance/".$profile_picture) && $profile_picture != null): ?>
                          <img src="../uploads/profile/freelance/<?=$profile_picture?>" alt="User profile picture"
                          style="width: 3rem; height: 3rem;" class="img-circle">
                        <?php else: ?>
                            <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                            style="width: 3rem; height: 3rem;" class="img-circle">
                        <?php endif; ?>
                        <div class="d-flex flex-column ml-3">
                          <h5 class="text-capitalize text-bold"><?=$reviews['firstname']." ".$reviews['lastname']?></h5>
                          <div class="d-flex justify-content-between">
                            <h6 class="text-bold">
                              <?php 
                                if($reviews['rating'] == 0){
                                  for ($i=0; $i < 5; $i++) { 
                                    print('<i class="fa fa-star text-secondary"></i>');
                                  }
                                }
                                for ($i=0; $i < round($reviews['rating'], 0) ; $i++) { 
                              ?>
                                  <i class="fa fa-star text-warning"></i>
                              <?php
                                }
                              ?>
                            </h6>
                            <h6 class="ml-3 text-bold"><?= round($reviews['rating'], 0)  ?> / 5</h6>
                          </div>
                        </div>
                      </div>
                      <h6 class="text-capitalize"><?=$reviews['review'] ?></h6>
                    </div>

                    <!-- <p style="text-transform: capitalize;">From: <?=$reviews['firstname']." ".$reviews['lastname']?><br><span class="text-muted"><?=$reviews['review']?></span><br>Ratings: <?=$reviews['rating']?><br><span class="text-muted"><?=$reviews['created_at']?></span></p>
                     -->
                  <?php
                    endwhile;
                  ?>
         </div>
       </div>
    </div>
  </div>

</div>

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

<script>
  var date_today = '<?=$js_dateToday?>';
  var start_date = '<?=$complete_start_at?>';

  if (date_today > start_date) {
    alert('Event already finished');
    history.back();
  }
  $('#button_join').click(function(){
    var request = 'join_event';
    var event_id = '<?=$event_id?>';
    var reg_id = '<?=$my_id?>';
    var x = confirm('Are you sure you want to join this event?');
    if (x === true) {
      $.ajax({
        url: '../ajax_request.php',
        method: 'post',
        data: {
          request:request,
          event_id:event_id,
          reg_id:reg_id
        },
        dataType: 'text',
        success:function(data){
          if (data === '1') {
            alert('Successfully joined this event');
          }
          else{
            alert('An error occured');
          }
          history.back();
        }
      });
    }
  });
</script>