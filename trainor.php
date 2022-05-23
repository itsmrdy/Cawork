<?php
  require_once 'core/init.php';
  $id = $_SESSION['userId'];
  $my_id = $_SESSION['userId'];

  $result = $db->query("SELECT *, CONCAT(firstname,' ',lastname) AS name FROM reg_db WHERE id = $id");
  $fetch = mysqli_fetch_assoc($result);
  
  $new_ratings = $db->query("SELECT AVG(rate) AS ave_rating FROM trainor_ratings_db WHERE 
  trainor_id = '$my_id' AND delete_flg = '0';");
  $new_ratings_row = mysqli_fetch_assoc($new_ratings);

  $fname = $fetch['firstname'];
  $mname = $fetch['middlename'];
  $lname = $fetch['lastname'];
  $name = $fetch['name'];
  $education = $fetch['course'];
  $location = $fetch['address'];
  $skills = $fetch['year_section'];
  $email = $fetch['email'];
  $profile_picture = $fetch['profile_picture'];

  $acc_status = $db->query("SELECT status FROM reg_db WHERE id = '$my_id';");
  $accstatus = mysqli_fetch_assoc($acc_status);

  $account_status = $accstatus['status'];

  date_default_timezone_set('Asia/Manila');

  $date_today = date('Y-m-d');
  $time_today = date('H:i');
  $whole_date_today = date('Y-m-d').'T'.date('H:i');
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Trainor Profile</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
<style>
  #participants_list{
    padding: 0;
  }
  #participants_list li{
    list-style: none;
    color: white;
    width: 100%;
    padding: 5px;
    border-radius: 3px;
  }
  .participants_list_pending{
    background-color: #212121;
  }
  .participants_list_decline{
    background-color: #c3c3c3;
  }
  .participants_list_approved{
    background-color: #33ddff;
  }
</style>
</head>
<body class="sidebar-is-closed sidebar-collapse">
<!-- <body class="hold-transition sidebar-mini"> -->
<div class="wrapper">
  <!-- Navbar -->
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
                <a href="#my_trainings" class="nav-link text-secondary active" data-toggle="tab">Trainings</a>
              </li>
              <li class="nav-item">
                <a href="#history" class="nav-link text-secondary" data-toggle="tab">History</a>
              </li>
            </ul>
          </div>
        </div>
        <a href="logout.php" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i></a>
    </nav>

  <!-- /.navbar -->

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="container">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <div class="card mt-5" style="border-top: 5px solid green;">
              <div class="card-body box-profile"
                  style="background: #e4ebe4">
                  <div class="text-center">
                      <?php if(file_exists("uploads/profile/trainor/".$profile_picture) && $profile_picture != null): ?>
                        <img src="uploads/profile/trainor/<?=$profile_picture?>" alt="User profile picture"
                        style="width: 7rem;height: 7rem;" class="profile-user-img img-fluid img-circle">
                      <?php else: ?>
                          <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                          style="width: 7rem;height: 7rem;" class="profile-user-img img-fluid img-circle">
                      <?php endif; ?>
                  </div>

                  
                <h4 class="profile-username text-capitalize text-center p1"><?= $fname;?> <?= $mname;?> <?= $lname;?></h4>
                <p class="text-muted text-center">TRAINOR</p>
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
                          
                  <a href="admin/training_profile.php?edit=<?=$id?>" class="btn btn-success btn-block">
                  
                  <?php if($account_status == 2):?>
                    <b>Profile</b>
                  <?php else: ?>
                    <b>Update Profile</b>
                  <?php endif; ?>
                  </a>
                  <?php
                    if ($account_status != 2) {
                  ?>
                      <button disabled class="btn btn-success btn-block" data-toggle="modal" data-target="#myModal"><b>Post Training</b></button>
                      <button disabled class="btn btn-success btn-block"><b>Ratings and Reviews</b></button>
                  <?php
                    } else {
                  ?>
                      <button class="btn btn-success btn-block" data-toggle="modal" data-target="#myModal"><b>Post Training</b></button>
                      <a href="admin/trainor_reviews.php?my_id=<?=$id?>" class="btn btn-success btn-block"><b>Ratings and Reviews</b></a>
                  <?php
                    }
                  ?>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card mt-5">
              <div class="card-header">
                <h5 class="text-bold text-dark">Trainings</h5>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="my_trainings">
                    <?php
                    $participants_num = 5;
                    $q = "SELECT * FROM events_db WHERE reg_id = '$my_id' AND delete_flg = '0' ORDER BY id DESC;";
                      $query = $db->query($q); //Eto yung query
                      $trainings_cont = mysqli_num_rows($query);
                      while($row = mysqli_fetch_assoc($query)): //eto yung loop
                      $id = $row['id'];
                      $event_id = $row['id'];
                      $title = $row['title'];
                      $training_type = $row['training_type'];
                      $training_price = $row['training_price'];
                      $mode_of_payment = $row['mode_of_payment'];
                      $description = $row['description'];
                      $reg_id = $row['reg_id'];
                      $date_start = $row['date_start'];
                      $participants = $row['participants'];
                      $field = $row['field'];
                      $platform = $row['platform'];
                      $pay_description = $row['payment_description'];

                      $countParticipants = $db->query("SELECT id FROM events_participants_db WHERE event_id = '$id' AND delete_flg = '0' AND status != '2';");
                      $countParticipants_count = mysqli_num_rows($countParticipants);
                    ?>
                    <div class="post rounded-lg p-1" style="background: #FFFDF6;">
                      <div class="card shadow-none"
                      style="background: #FFFDF6;">
                         <div class="card-body">
                         <button class="btn btn-primary float-right" data-toggle="modal" 
                          style="border-radius: 10px"
                          data-target="#view_participants_<?=$id?>">Participants</button>
                         <!-- <button style="border-radius: 10px" class="btn btn-primary float-right" 
                         onclick="edit_post('<?=$id?>', '<?=$title?>', '<?=$training_type?>', '<?=$training_price?>', '<?=$mode_of_payment?>', '<?=$description?>', '<?=$date_start?>', '<?=$participants?>', '<?=$field?>', '<?=$platform?>')">Edit Post</button> -->
                           <h5 class="text-success text-bold text-capitalize"><?= $row['title']; ?></h5>
                           <div>
                              <small class="text-bold text-dark">Posted: </small>
                              <small class="ml-1"><?= Date('Y-m-d h:i:s', strtotime($row['created']))?></small>
                           </div>
                           
                           <div>
                             <span>Training Price:</span> 
                             <span class="text-bold text-dark ml-1">
                             Php.
                             <?= number_format($row['training_price'],2,".",",")?></span>
                           </div>
                           
                           <h6>Date Start: <span class="text-bold text-dark ml-1"><?= $row['date_start']; ?></span></h6>
                           <h5>
                            <span>No of Participants: </span>
                            <span class="text-bold text-dark"><?=$countParticipants_count?> / <?=$row['participants']?></span>
                           </h5>
                         </div>
                         <div class="card-footer">
                          <button
                            <?php
                              if ($row['visible'] == 2) 
                              {
                                echo 'disabled';
                              }
                            ?>
                              style="border-radius: 30px;border: 1px solid #e0e0e0"
                              class="btn btn-light text-success text-bold" onclick="update_visibility('2', '<?=$id?>')">Close for Joining</button>

                          <button <?php if ($row['visible'] == 1) { echo 'disabled'; } ?>
                            style="border-radius: 30px;border: 1px solid #e0e0e0"
                            class="btn btn-light text-success text-bold" onClick="update_visibility('1', '<?=$id?>')">Open for Joining</button>



                          <button
                          style="border-radius: 30px;border: 1px solid #e0e0e0"
                          class="btn btn-light text-success text-bold"
                          onClick="edit_payment('<?=$id?>','<?=$training_price?>','<?=$mode_of_payment?>')">Edit Payment</button>

                          <textarea id="payment_description<?= $id ?>" 
                          class="d-none"
                          cols="30" rows="10"><?= $pay_description ?></textarea>


                          <button 
                           style="border-radius: 30px;border: 1px solid #e0e0e0"
                           class="btn btn-light text-success text-bold"
                           onclick="edit_post('<?=$id?>', '<?=$title?>', '<?=$training_type?>', '<?=$training_price?>', '<?=$mode_of_payment?>', '<?=$description?>', '<?=$date_start?>', '<?=$participants?>', '<?=$field?>', '<?=$platform?>')">Edit Post</button>
                         
                          <a href="activities.php?training_id=<?=$id?>" 
                            style="border-radius: 30px;border: 1px solid #e0e0e0"
                            class="btn btn-light text-success text-bold">Activity Calendar</a>
                          <button  
                          style="border-radius: 30px;border: 1px solid #e0e0e0"
                          class="btn btn-light text-success text-bold"
                          onclick="delete_training('<?=$id?>')"
                          >Delete</button>
                         </div>
                      </div>
                    </div>
                    <div id="view_participants_<?=$id?>" class="modal fade" role="dialog">
                      <div class="modal-dialog" style="width:100%;" style="margin-top: 2%;margin-bottom: 7%;">

                        <!-- Modal content-->
                        <div class="modal-content" style="width: 100%;">
                          <div class="modal-header">
                             <div class="d-flex">
                                <h5 class="text-bold text-dark">Participants</h5>
                                <h5 class="mx-2 text-dark text-bold">(<?=$countParticipants_count?> of <?=number_format($row['participants']); ?>)</h5>
                             </div>
                          </div>
                          <div class="modal-body" id="modal_body">
                                <?php
                                  $pQuery = "SELECT events_db.title, participants_db.id, participants.id as participant_id, participants.firstname, 
                                  participants.lastname, participants.number, participants.email, participants.profile_picture, participants_db.status, participants.id as 
                                  participant_id, participants.user_type_id FROM events_participants_db participants_db
                                  INNER JOIN reg_db 
                                  participants ON participants_db.reg_id = participants.id JOIN events_db ON participants_db.event_id = events_db.id WHERE participants_db.delete_flg = '0' 
                                  AND events_db.id = '$id' 
                                  AND participants_db.status != 2
                                  ORDER BY participants_db.id DESC;";
                                  $participants = $db->query($pQuery);


                                  while($participants_row = mysqli_fetch_assoc($participants)):
                                    $participants_id = $participants_row['id'];
                                    $phone_number = $participants_row['number'];
                                    $event_title = $participants_row['title'];
                                    $firstname = $participants_row['firstname'];
                                    $lastname = $participants_row['lastname'];
                                    $email = $participants_row['email'];
                                    $user_type_id = $participants_row['user_type_id'];
                                    $participant_id = $participants_row['participant_id'];


                                    $paymentQuery = "SELECT * FROM event_payment_db WHERE event_id = '$event_id' AND reg_id = '$participant_id';";
                                    $paymentResult = $db->query($paymentQuery);
                                    $paymentData = mysqli_fetch_assoc($paymentResult);
                                ?>

                                <div class="card card-widget widget-user">
                                  <!-- Add the bg color to the header using any of the bg-* classes -->
                                  <div class="widget-user-header bg-info">
                                    <h5><a href="http://34.192.240.192/profile.php?log=<?= $participants_row['participant_id']?>"
                                    class="text-light">
                                     <?=$participants_row['firstname']." ".$participants_row['lastname']?>
                                    </a></h5>
                                    <h5 class="widget-user-desc">
                                      <?php
                                        if ($participants_row['user_type_id'] === '1') {
                                          echo "Client";
                                        } else {
                                          echo "Skilled Worker";
                                        }
                                      ?>
                                    </h5>
                                  </div>
                                  <div class="widget-user-image">
                                       <?php if($user_type_id == 1): ?>
                                          <?php if(file_exists("uploads/profile/client/".$participants_row['profile_picture']) && 
                                          $participants_row['profile_picture'] != null): ?>
                                            <img src="uploads/profile/client/<?=$participants_row['profile_picture']?>" alt="User profile picture"
                                            style="width: 7rem;height: 7rem;" class="img-circle elevation-2">
                                          <?php else: ?>
                                              <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                              style="width: 7rem;height: 7rem;" class="img-circle elevation-2">
                                          <?php endif; ?>
                                       <?php endif; ?>

                                       <?php if($user_type_id == 2): ?>
                                          <?php if(file_exists("uploads/profile/freelance/".$participants_row['profile_picture']) && 
                                          $participants_row['profile_picture'] != null): ?>
                                            <img src="uploads/profile/freelance/<?=$participants_row['profile_picture']?>" alt="User profile picture"
                                            style="width: 7rem;height: 7rem;" class="img-circle elevation-2">
                                          <?php else: ?>
                                              <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                              style="width: 7rem;height: 7rem;" class="img-circle elevation-2">
                                          <?php endif; ?>
                                       <?php endif; ?>
                                  </div>

                                  <div class="card-footer">
                                    <div class="row">
                                      <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                          <h5 class="description-header text-truncate"><?=$participants_row['email']?></h5>
                                          <span class="description-text">EMAIL ADDRESS</span>
                                        </div>
                                        <!-- /.description-block -->
                                      </div>
                                      <!-- /.col -->
                                      <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                          <h5 class="description-header"><?=$participants_row['number']?></h5>
                                          <span class="description-text">Phone Number</span>
                                        </div>
                                        <!-- /.description-block -->
                                      </div>
                                      <!-- /.col -->
                                      <div class="col-sm-4">
                                        <div class="description-block">
                                          <h5 class="description-header">
                                              <?php 
                                                if (mysqli_num_rows($paymentResult) > 0) {
                                              ?>
                                                <a class="text-dark">Paid</a>
                                              <?php
                                                } else {
                                              ?>
                                                <a class="text-dark">Not Paid</a>
                                              <?php
                                                }
                                              ?>
                                          </h5>
                                          <span class="description-text">Payment Status</span>
                                        </div>
                                      </div>
                                    </div>
                                              
                                    <hr>
                                    <?php if(!empty($paymentData['description'])): ?>
                                      <h6 class="text-bold">Payment Description</h6>
                                      <p>
                                        <?= $paymentData['description']?>
                                      </p>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between">
                                      <div>
                                        <?php 
                                           if (mysqli_num_rows($paymentResult) > 0):
                                        ?>
                                        <?php if($user_type_id == '1'): ?>
                                          <a href="uploads/payments/client/<?=$paymentData['image']?>" target="_blank" 
                                            class="btn btn-success"
                                            style="border-radius: 10px">View Proof of Payment</a>
                                        <?php endif; ?>

                                        <?php if($user_type_id == '2'): ?>
                                          <a href="uploads/payments/worker/<?=$paymentData['image']?>" target="_blank" 
                                            class="btn btn-success"
                                            style="border-radius: 10px">View Proof of Payment</a>
                                        <?php endif; ?>
                                       
                                        <?php endif; ?>
                                      </div>

                                      <div class="div">
                                        <?php
                                          if ($participants_row['status'] === '1') {
                                        ?>
                                          <button class="btn btn-danger text-light" 
                                          
                                          style="float: right; border-radius: 15px" onclick="update_join_request('3', '<?=$participants_id?>', '<?=$phone_number?>', '<?=$event_title?>', '<?=$firstname?>', '<?=$lastname?>', '<?=$email?>')">Remove</button>
                                        <?php
                                          } elseif ($participants_row['status'] === '2') {

                                          } else {
                                        ?>
                                          <button style="float: right; border-radius: 10px" 
                                          onclick="update_join_request('2', '<?=$participants_id?>', '<?=$phone_number?>', '<?=$event_title?>', '<?=$firstname?>', '<?=$lastname?>', '<?=$email?>')" 
                                          class="btn btn-danger">Decline</button>


                                          <button style="float: right; border-radius: 10px" 
                                          onclick="update_join_request('1', '<?= $participants_id?>', '<?=$phone_number?>', '<?=$event_title?>', '<?=$firstname?>', '<?=$lastname?>', '<?=$email?>')" 
                                          class="btn btn-primary mr-1">Approve</button>
                                        <?php
                                          }
                                        ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            <?php
                              endwhile;
                                  $pQuery = "SELECT events_db.title, participants_db.id, participants.id as participant_id, participants.firstname, 
                                  participants.lastname, participants.number, participants.email, participants.profile_picture, participants_db.status, participants.id as 
                                  participant_id, participants.user_type_id FROM events_participants_db participants_db JOIN reg_db 
                                  participants ON participants_db.reg_id = participants.id JOIN events_db ON participants_db.event_id = events_db.id WHERE participants_db.delete_flg = '0' 
                                  AND events_db.id = '$id' 
                                  AND participants_db.status != 2
                                  ORDER BY participants_db.id DESC;";
                                  $participants = $db->query($pQuery);

                                  if(empty(mysqli_fetch_assoc($participants))){
                                    print("<h5 class='d-flex justify-content-center'>No participants found </h5>");
                                  }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                      <?php
                        endwhile;
                        if ($trainings_cont < 1) {
                      ?>
                              <div class="d-flex flex-column">
                                    <div class="d-flex justify-content-center">
                                        <img src="images/result_no.png" alt=""
                                        height="500px"
                                        width="600px">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <h5 class="text-secondary text-bold">We couldn't find any results from the request you've sent to us</h5>
                                    </div>
                              </div>
                      <?php
                        }
                      ?>

                  </div>

                  <div class="tab-pane" id="history">
                    <?php
                    $participants_num = 5;
                    $q = "SELECT * FROM events_db WHERE reg_id = '$my_id' AND delete_flg = '1' ORDER BY id DESC;";
                      $query = $db->query($q); //Eto yung query
                      $trainings_cont = mysqli_num_rows($query);
                      while($row = mysqli_fetch_assoc($query)): //eto yung loop
                      $id = $row['id'];
                      $title = $row['title'];
                      $training_type = $row['training_type'];
                      $training_price = $row['training_price'];
                      $mode_of_payment = $row['mode_of_payment'];
                      $description = $row['description'];
                      $reg_id = $row['reg_id'];
                      $date_start = $row['date_start'];
                      $participants = $row['participants'];
                      $field = $row['field'];
                      $platform = $row['platform'];

                      $countParticipants = $db->query("SELECT id FROM events_participants_db WHERE event_id = '$id' AND delete_flg = '0' AND status = '1';");
                      $countParticipants_count = mysqli_num_rows($countParticipants);
                    ?>
                    <div class="post p-3 rounded-lg" 
                       style="background: #FFFDF6;">
                      <h5 class="text-success text-bold"><?= $row['title']; ?></h5>
                      <div class="text-muted text-sm">Posted: <?=$row['created']?></div>
                      <h6>
                        <span>Training Type: </span>
                        <span class="text-bold mt-2"><?= $row['training_type']; ?></span>
                      </h6>
                      <h6>₱<?= $row['training_price']; ?></h6>
                      <h6>
                        <span>Date Start: </span>
                        <span class="text-bold"><?= $row['date_start']; ?></span>
                      </h6>
                      
                      <br>
                      <i class="fa fa-user"></i> <?=$countParticipants_count?> / <?=$row['participants']?>
                      </p>
                      </div>
                      <?php
                        endwhile;
                        if ($trainings_cont < 1) {
                      ?>
                        <p class="text-muted">No history of trainings</p>
                      <?php
                        }
                      ?>
                    <hr>
                  </div>

                  <div class="tab-pane" id="settings">
                 
       
      </li>
                  </div>
                
              
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="admin/dist/js/demo.js"></script>
</body>
</html>
<script>
  function update_status(event_participants_id, status){
    var request = 'event_update_status';

    var status_update;
    var confirm_text;

    if (status === '1') {
      status_update = 1;
      confirm_text = 'Accept this request?';
    } else if (status === '2') {
      status_update = 2;
      confirm_text = 'Decline this request?';
    } else {
      status_update = 2;
      confirm_text = 'Remove from Event?';
    }

    var x = confirm(confirm_text);

    if (x === true) {
      $.ajax({
        url: 'ajax_request.php',
        method: 'post', 
        data: {
          request:request,
          event_participants_id:event_participants_id,
          status_update:status_update
        },
        success:function(data){
          if (data === '2') {
            alert('Something went wrong sending an email');
          }
          window.location.reload();
        }
      });
    }
  }
  function delete_training(training_id){
    var x = confirm('Do you really want to delete this post? \nOnce you deleted this event all participants that part of this training can be send a report to admin. \nPlease send them first a message via email or text before you proceed deleting this training');
    var request = 'delete_training';
    if (x === true) {
      $.ajax({
        url: 'ajax_request.php',
        method: 'post',
        data: {
          request:request,
          training_id:training_id
        },
        success:function(data){
          if (data === '1') {
            alert('Training were deleted successfully');
          } else {
            alert('Something went wrong sending an email');
          }
          window.location.reload();
        }
      });
    }
  }
  function edit_post(edit_id, edit_title, edit_training_type, edit_training_price, edit_mode_of_payment, edit_description, edit_date_start, edit_participants, edit_field, edit_platform){
    $('#edit_id').val(edit_id);
    $('#edit_title').val(edit_title);
    $('#edit_training_type').val(edit_training_type);
    $('#edit_description').val(edit_description);
    $('#edit_date_start').val(edit_date_start);
    $('#edit_participants').val(edit_participants);
    $('#edit_field').val(edit_field);
    $('#edit_platform').val(edit_platform);
    $('#edit_post_click').click();
  }

  function edit_payment(edit_id, edit_training_price, edit_mode_of_payment){
    var description = $("#payment_description" + edit_id).val(); 
    $('#edit_id1').val(edit_id);
    $('#edit_training_price').val(edit_training_price);
    $('#edit_mode_of_payment').val(edit_mode_of_payment);
    $('#edit_payment_description').val(description);
    $('#edit_post_click1').click();
  }
</script>
<?php  require_once 'trainor_add.php'; ?>
<button style="display: none;" data-toggle="modal" data-target="#edit_post" id="edit_post_click"></button>
<div id="edit_post" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin-top: 2%;margin-bottom: 7%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body" id="modal_body">
        <h3>Edit Post</h3>
        <input type="hidden" id="edit_id">
        <div class="form-group">
          <label>
            Title
          </label>
          <input type="text" class="form-control" id="edit_title" placeholder="Training Title">
        </div>
        <div class="form-group">
          <label>
            Training type
          </label>
          <select id="edit_training_type" class="form-control">
            <option selected>Face to face</option>
            <option>Module</option>
            <option>Online Training</option>
          </select>
        </div>
        <div class="form-group">
          <label>
            Date
          </label>
          <input type="date" id="edit_date_start" class="form-control">
        </div>
        <div class="form-group">
          <label>
            Number of Participants
          </label>
          <input type="number" min="1" max="100" id="edit_participants" class="form-control" placeholder="How many participants will be occupied">
        </div>
        <div class="form-group">
          <label>
            Field
          </label>
          <input type="text" id="edit_field" class="form-control" placeholder="In which field the training include">
        </div>
        <div class="form-group">
          <label>
            Platform
          </label>
          <input type="text" id="edit_platform" class="form-control" placeholder="What platform will be used in the training">
        </div>
        <div class="form-group">
          <label>
            Description
          </label>
          <textarea class="form-control" id="edit_description" placeholder="Write a short description about this training" rows="2"></textarea>
        </div>
        <div class="form-group">
          <p class="text-danger" id="edit_error_fields"><i class="fa fa-times"></i> All fields are required</p>
          <p class="text-danger" id="edit_date_error"><i class="fa fa-times"></i> Cannot set date that is less than the current date</p>
          <button class="btn btn-success" id="submit_edit_post"><i class="fa fa-check"></i> Save</button>
          <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

<button style="display: none;" data-toggle="modal" data-target="#edit_payment" id="edit_post_click1"></button>
<div id="edit_payment" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin-top: 2%;margin-bottom: 7%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body" id="modal_body">
        <h3>Edit Post</h3>
        <input type="hidden" id="edit_id1">
        <div class="form-group">
          <label>
            Fee(Php)
          </label>
          <input type="number" id="edit_training_price" min="0" class="form-control" placeholder="How much is this training?">
        </div>
        <div class="form-group">
          <label>
            Mode of Payment
          </label>
          <select id="edit_mode_of_payment" class="form-control">
            <option selected>GCash</option>
            <option>Paypal</option>
            <option>Bank</option>
            <option>Remittance</option>
          </select>
        </div>
        <div class="form-group">
            <p>
              Please read carefully
              <br>
              Note: Write the complete information about the payment method of thsi training. Include link, number and any important details on how the participants can send their payment
              <br><br>
              Once the participants join the training, this payment information willbe also include in the <strong>email notification</strong>
              <br><br>
              Please ake sure to chec if the participat made the payment. If they did not pay on time, you can remove them from participants.
            </p>
          </div>
        <div class="form-group">
          <label>
            Payment Details
          </label>
          <textarea class="form-control" id="edit_payment_description" placeholder="Write complete information about payment" rows="2"></textarea>
        </div>
        <div class="form-group">
          <p class="text-danger" id="edit_error_fields1"><i class="fa fa-times"></i> All fields are required</p>
          <button class="btn btn-success" id="submit_edit_post1"><i class="fa fa-check"></i> Save</button>
          <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="add_activity_modal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin-top: 2%;margin-bottom: 7%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body" id="modal_body">
        <h3>Add Activity</h3>
        <div class="form-group">
          <label>
            Title
            </label>
          <input type="text" class="form-control" id="new_activity_title" placeholder="Activity Title">
        </div>
        <div class="form-group">
          <label>
            Activity Date
          </label>
          <input type="date" id="new_activity_start_date" class="form-control">
        </div>
        <label>
          Activity Time
        </label>
        <div class="form-group">
          <input type="time" class="form-control" style="display: inline-block; width: 49%;" id="new_activity_start_time">
          <input type="time" class="form-control" style="display: inline-block; width: 49%;" id="new_activity_end_time">
        </div>
        <div class="form-group">
          <label>
            Description
          </label>
          <textarea class="form-control" id="new_activity_description" placeholder="Activity Description" rows="2"></textarea>
        </div>
        <div class="form-group">
          <p class="text-danger" id="activity_error_fields"><i class="fa fa-times"></i> All fields are required</p>
          <p class="text-danger" id="activity_date_error"><i class="fa fa-times"></i> Invalid Date</p>
          <button class="btn btn-success" id="add_activity"><i class="fa fa-check"></i> Add</button>
          <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal_spinner">
  <div class="modal-dialog modal-dialog-centered bg-transparent" role="document">
    <div class="modal-content">
       <div class="modal-body bg-transparent">
         <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading please wait...</span>
            </div>
         </div>
       </div>
    </div>
  </div>
</div>

<script>
  $('#activity_error_fields').hide();
  $('#activity_date_error').hide();
  $('#edit_error_fields').hide();
  $('#edit_error_fields1').hide();
  $('#edit_date_error').hide();
  $('#submit_edit_post').click(function(){
    var request = 'edit_training';
    var edit_id = $('#edit_id').val();
    var edit_title = $('#edit_title').val();
    var edit_training_type = $('#edit_training_type').val();
    var edit_description = $('#edit_description').val();
    var edit_date_start = $('#edit_date_start').val();
    var edit_participants = $('#edit_participants').val();
    var edit_field = $('#edit_field').val();
    var edit_platform = $('#edit_platform').val();
    var edit_date_today = '<?=$date_today?>';

    if (edit_title === '' || edit_training_type === '' || edit_description === 'empty' || edit_date_start === '' || edit_participants === '' || edit_field === '' || edit_platform === '') {
      $('#edit_error_fields').fadeIn();
    } else {
      $('#edit_error_fields').hide();

      if (edit_date_start <= edit_date_today) {
        $('#edit_date_error').fadeIn();
      } else {
        if(confirm("Do you really want to edit this post?")){
          $.ajax({
          url: 'ajax_request.php',
          method: 'post',
          data: {
            edit_id:edit_id,
            edit_title:edit_title,
            edit_training_type:edit_training_type,
            edit_description:edit_description,
            edit_date_start:edit_date_start,
            edit_participants:edit_participants,
            edit_field:edit_field,
            edit_platform:edit_platform,
            request:request
          },
          dataType: 'text',
          success:function(data){
            if (data === '1') {
              alert('Post were updated successfully');
            } else {
              alert('An error occured');
            }
            window.location.reload();
          }
        });
        }
      }
    }
  });

  $('#submit_edit_post1').click(function(){
    var edit_id = $('#edit_id1').val();
    var edit_training_price = $("#edit_training_price").val();
    var edit_mode_of_payment = $("#edit_mode_of_payment").val();
    var edit_payment_description = $("#edit_payment_description").val();
    var request = 'edit_payment';

    if (edit_training_price === '' || edit_mode_of_payment === '' || edit_payment_description === '') {
      $('#edit_error_fields1').fadeIn();
    } else {
      $('#edit_error_fields1').hide();
      $.ajax({
        url: 'ajax_request.php',
        method: 'post',
        data: {
          edit_id:edit_id,
          edit_training_price:edit_training_price,
          edit_mode_of_payment:edit_mode_of_payment,
          edit_payment_description:edit_payment_description,
          request:request
        },
        success:function(data){
            if (data === '1') {
              alert('Success');
            } else {
              alert('An error occured');
            }
            window.location.reload();
          }
      });
    }
  });

  $('#add_activity').click(function(){
    var request = 'add_activity';

    var activity_title = $('#new_activity_title').val();
    var activity_start_date = $('#new_activity_start_date').val();
    var activity_start_time = $('#new_activity_start_time').val();
    var activity_end_time = $('#new_activity_end_time').val();
    var activity_description = $('#new_activity_description').val();
    var whole_date_today = '<?=$whole_date_today?>';

    var reg_id = '<?=$my_id?>';

    var activity_date_start = activity_start_date+'T'+activity_start_time;
    var activity_date_end = activity_start_date+'T'+activity_end_time;

    if (activity_title === '' || activity_start_date === '' || activity_start_time === '' || activity_end_time === '' || activity_description === '') {
      $('#activity_error_fields').fadeIn();
    } else {
      $('#activity_error_fields').hide();
      if (activity_date_start >= activity_date_end || whole_date_today >= activity_date_start) {
        $('#activity_date_error').fadeIn();
      } else {
        $.ajax({
          url: 'ajax_request.php',
          method: 'post',
          data: {
            request:request,
            activity_title:activity_title,
            activity_description:activity_description,
            activity_date_start:activity_date_start,
            activity_date_end:activity_date_end,
            reg_id:reg_id
          },
          dataType: 'text',
          success:function(data){
            if (data === '1') {
              alert('Acitivity Added');
            }
            else{
              alert('An error occured');
            }
            window.location = 'trainor.php';
          }
        });
      }
    }
  });

  function update_visibility(status, training_id){
    var confirm_text;

    if (status === 1) {
      confirm_text = 'Are you sure you want to open this training participants can be join?';
    } else {
      confirm_text = 'Are you sure you want to close this training, it will be hidden and participants cannot be joined?';
    }

    var request = 'update_visibility';

    var x = confirm(confirm_text);

    if (x) {
      $.ajax({
        url: 'ajax_request.php',
        method: 'post',
        data: {
          status:status,
          training_id:training_id,
          request:request
        },
        success:function(data){
          if (data === '1') {
            alert('Event updated');
          } else {
            alert('An error occured');
          }
          window.location = 'trainor.php';
        }
      });
    }
  }

  function update_join_request(status, event_participants_id, phone_number, event_title, firstname, lastname, email){
    var confirm_text;

    var request = 'update_join_request';

    if (status === '1') {
      confirm_text = 'Are you sure you want to accept this request?';
    } else if (status === '2') {
      confirm_text = 'Are you sure you want to decline this request?';
    } else {
      confirm_text = 'Are you sure you want to remove this participant?';
      status = '2';
    }

    var x = confirm(confirm_text);

    if (x) {
      $('#modal_spinner').modal('show');
      $.ajax({
        url: 'ajax_request.php',
        method: 'post',
        data: {
          status:status,
          event_participants_id:event_participants_id,
          request:request,
          phone_number:phone_number,
          event_title:event_title,
          firstname:firstname,
          lastname:lastname,
          email:email
        },
        success:function(data){
          if (data === '0') {
            alert("You have successfully accepted this trainee on your bootcamp. We sent an email to remind them that they request were accepted. Thankyou");
            $('#modal_spinner').modal('hide');
          }else {
            alert('Something went wrong sending an email');
          }
          window.location = 'trainor.php';
        }
      });
    }
  }
</script>
<?php
  if ($account_status === '3') {
?>
<script>
  alert('Your profile has been rejected by the administrator. Please try again to update your profile');
</script>
<?php
  }
?>