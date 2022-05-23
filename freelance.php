<?php
  require_once 'core/init.php';

  if (!isset($_SESSION['userId'])) {
      header("Location: login.php");
  }
  
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
  $province = strtolower($fetch['province']);
  $municipality = strtolower($fetch['municipality']);
  $barangay = strtolower($fetch['barangay']);
  $profile_picture = $fetch['profile_picture'];

  $availability = $fetch1['time'];
  $experience = $fetch['experience'];
  $location = $fetch['address'];
  $rate = $fetch['rate'];
  $education = $fetch['education'];
  $skills = $fetch['skills'];
  $email = $fetch['email'];

  function checkProposal($proposal_id, $db, $id){
    $query = $db->query("SELECT id FROM proposal_db WHERE user_id = '$id' AND proposal_id = '$proposal_id' AND delete_flg = '0' AND status != 3");
    
    if (mysqli_num_rows($query) > 0) {
      return 'true';
    }
    else{
      return 'false';
    }
  }


  if(isset($_POST['search_job'])){
    $_SESSION['search_job'] = $_POST['search_job'];
  }

  if(isset($_POST['remove_filter'])){
    unset($_SESSION['search_job']);
  }


  if(isset($_POST['filter_by'])){
    if($_POST['filter_by'] == "None"){
      unset($_SESSION['filter_by']);
    }else{
      $_SESSION['filter_by'] = $_POST['filter_by'];
    }
  }


  if(isset($_POST['cancel_proposal'])){
    $id = $_POST['cancel_proposal'];
    $query = "DELETE FROM proposal_db WHERE id = '{$id}' AND user_id = $my_id";
    if($db->query($query)){
      header("Location: freelance.php");
    }
  }

  $issue = $db->query("SELECT * FROM issues_db WHERE user_id = '$my_id' AND delete_flg = '0';");
  $issue_count = mysqli_num_rows($issue);

  if ($issue_count < 1) {
    $ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$my_id' AND delete_flg = '0';");
    $ratings_row = mysqli_fetch_assoc($ratings);

    $ratings = $ratings_row['ave_rating'];

    $db->query("UPDATE issues_db SET delete_flg = '1' WHERE user_id = '$my_id'");

    if (!empty($ratings)) {
      if ($ratings <= 2.9 && $ratings >= 2.1) {
        $month = date('m', strtotime("+1 month"));
        $penalty = date('Y-').$month.date('-d');
        $db->query("INSERT INTO issues_db (until, user_id, status) VALUES ('$penalty', '$my_id', '1');");
      }
      elseif ($ratings <= 2.0 && $ratings >= 1.1) {
        $month = date('m', strtotime("+2 months"));
        $penalty = date('Y-').$month.date('-d');
        $db->query("INSERT INTO issues_db (until, user_id, status) VALUES ('$penalty', '$my_id', '2');");
      }
      elseif ($ratings <= 1.0) {
        $db->query("INSERT INTO issues_db (user_id, status) VALUES ('$my_id', '3');");
      }
    }
  } else {
    $issue_row = mysqli_fetch_assoc($issue);

    $until = $issue_row['until'];
    $date_today = date('Y-m-d');

    if ($issue_row['valid'] == 0) {
      if ($until > $date_today) {
        $status = $issue_row['status'];
  ?>
    <script>
      var status = '<?=$status?>';

      if (status === '1') {
        alert('Your account is suspended for 1 month due to your low rating');
      } else if (status === '2') {
        alert('Your account is suspended for 2 months due to your low rating')
      } else{
        alert('Your account is blocked due to your low rating');
      }

      window.location = 'logout.php';
      
    </script>  
  <?php
      } else {
        $status = $issue_row['status'];
        if ($status === "3") {
          echo "<script>alert('Your account is blocked due to your low rating');window.location = 'logout.php';</script>"; 
        }
      }
    } else {
      if ($until > $date_today) {
        $status = $issue_row['status'];
  ?>
    <script>
      var status = '<?=$status?>';

      if (status === '1') {
        alert('Your account has been suspended for 1 month due to suspicious activity reported');
      } else if (status === '2') {
        alert('Your account has been suspended for 2 months due to suspicious activity reported')
      } else if (status === '3') {
        alert('Your account has been suspended for 3 months due to suspicious activity reported')
      } else{
        alert('Your account is block due to suspicious activity reported');
      }

      window.location = 'logout.php';
      
    </script>  
  <?php
      } else {
        $status = $issue_row['status'];
        if ($status === "4") {
          echo "<script>alert('Your account is block due to suspicious activity reported');window.location = 'logout.php';</script>"; 
        }
      }
    }
  }

  $acc_status = $db->query("SELECT status FROM reg_db WHERE id = '$my_id';");
  $accstatus = mysqli_fetch_assoc($acc_status);
  $account_status = $accstatus['status'];



  $new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$my_id' AND delete_flg = '0';");
  $new_ratings_row = mysqli_fetch_assoc($new_ratings);

  include_once "to_dir.php";

  $allowed_type = array('png','jpg','jpeg', 'jfif', 'webp', 'PNG', 'JPG');

  if (isset($_POST['submit_report_btn'])) {
    $from_id = $_POST['from_id'];
    $user_id = $_POST['user_id'];
    $subject = mysqli_real_escape_string($db, $_POST['subject']);
    $additional_comment = mysqli_real_escape_string($db, $_POST['additional_comment']);

    $file = $_FILES['report_photo'];
    if (!empty($file['name'])) {
      $whole_filename = $file['name'];
      $from_dir = $file['tmp_name'];
      $whole_filename_slice = explode('.', $whole_filename);
      $extension = end($whole_filename_slice);
      $name = date('Ymdhis.').$whole_filename;
      $new_name = strtolower($name);
      $allowed_type = array('png','jpg','jpeg', 'jfif', 'webp', 'PNG', 'JPG');
      $new_dir = $to_dir.$new_name;
      $report_photo = $new_name;
      if (in_array($extension, $allowed_type)) {
        $move = move_uploaded_file($from_dir,"uploads/reports/".$new_name);
        if ($move) {
          $validate = $db->query("SELECT id FROM reports_db WHERE from_id = '$from_id' AND user_id = '$user_id' AND delete_flg = '0';");

          $validate_count = mysqli_num_rows($validate);

          if ($validate_count > 0) {
?>
  <script>
    alert('Report already submitted');
    window.location = 'freelance.php';
  </script>
<?php
          }
          else{
            if ($db->query("INSERT INTO reports_db (from_id, user_id, subject, additional_comment, report_photo) VALUES ('$from_id', '$user_id', '$subject', '$additional_comment', '$report_photo');")) {
?>
  <script>
    alert('Report submitted');
    window.location = 'freelance.php';
  </script>
<?php
            }
            else{
?>
  <script>
    alert('An error occured');
    window.location = 'freelance.php';
  </script>
<?php
            }
          }
        } else{
?>
  <script>
    alert('An error occured');
    window.location = 'freelance.php';
  </script>
<?php
        }
      } else{
?>
  <script>
    alert('Please upload image file only');
    window.location = 'freelance.php';
  </script>
<?php
      }
    } else {
      $report_photo = "no_file";
      $validate = $db->query("SELECT id FROM reports_db WHERE from_id = '$from_id' AND user_id = '$user_id' AND delete_flg = '0';");

      $validate_count = mysqli_num_rows($validate);

      if ($validate_count > 0) {
?>
  <script>
    alert('Report already submitted');
    window.location = 'freelance.php';
  </script>
<?php
      }
      else{
        if ($db->query("INSERT INTO reports_db (from_id, user_id, subject, additional_comment, report_photo) VALUES ('$from_id', '$user_id', '$subject', '$additional_comment', '$report_photo');")) {
?>
  <script>
    alert('Report submitted');
    window.location = 'freelance.php';
  </script>
<?php
        }
        else{
?>
  <script>
    alert('An error occured');
    window.location = 'freelance.php';
  </script>
<?php
        }
      }
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

  if (isset($_POST['submit_training_payment'])) {

    $file_name = $_FILES['payment_proof']['name'];
    $tmp_file = $_FILES['payment_proof']['tmp_name']; 
    $reg_id = $_POST['payment_my_id'];
    $event_id = $_POST['payment_event_id'];
    $description = str_replace(",","",$_POST['payment_description']);

    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $name = md5($reg_id)."_"."payment".$event_id.".".$extension;
    $move = move_uploaded_file($tmp_file, "/var/www/html/uploads/payments/worker/".$name);

    if($move){
      $query = "INSERT INTO event_payment_db (reg_id, event_id, image, description) VALUES ('$reg_id', '$event_id', '$name', '$description');";
      if($db->query($query)){
        print("<script>alert('Payment were submitted successfully');</script>");
      }else{
        print("<script>alert('Something went wrong inserting to database, Please try again');</script>");
      } 
    }else{
      print("<script>alert('Something went wrong, Please try again');</script>");
    } 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Skilled Worker</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">

  <style>
    .map-container{
      overflow:hidden;
      position:relative;
      padding: 0;
      height: 200px;
    }
    .map-container iframe{
      left:0;
      top:0;
      height:100%;
      width:100%;
      position:absolute;
    }
  </style>
</head>
<body class="sidebar-is-closed sidebar-collapse">
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
              <a href="#activity" class="nav-link text-secondary active" data-toggle="tab">Find Jobs</a>
            </li>
            <li class="nav-item">
              <a href="#Discover" class="nav-link text-secondary" data-toggle="tab">Training Services</a>
            </li>
            <li class="nav-item">
              <a href="#settings" class="nav-link text-secondary" data-toggle="tab">Clients</a>
            </li>
            <li class="nav-item">
              <a href="#my_training" class="nav-link text-secondary" data-toggle="tab">My Trainings</a>
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
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3" style="position: -webkit-sticky; /* for Safari */ position: sticky; top: 0.5em; align-self: flex-start;">
                <!-- Profile Image -->
                <div class="card mt-3" style="border-top: 5px solid green;">
                  <div class="card-body box-profile"
                  style="background: #e4ebe4">
                    <div class="text-center">
                      <?php if(file_exists("uploads/profile/freelance/".$profile_picture) && $profile_picture != null): ?>
                        <img src="uploads/profile/freelance/<?=$profile_picture?>" alt="User profile picture"
                        style="width: 7rem;height: 7rem;" class="profile-user-img img-fluid img-circle">
                      <?php else: ?>
                          <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                          style="width: 7rem;height: 7rem;" class="profile-user-img img-fluid img-circle">
                      <?php endif; ?>
                    </div>

                    <h4 class="profile-username text-capitalize text-center p1 text-bold"><?= $fname;?> <?= $mname;?> <?= $lname;?></h4>

                    <p class="text-muted text-center">Skilled Worker</p>
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
                          <button href="admin/mypost_freelance.php" disabled="true" class="btn btn-primary btn-block"><b>My Post</b></button>
                          <button href="admin/services.php" disabled="true" class="btn btn-primary btn-block"><b>Post Services</b></button>
                          <a href="admin/freelance_profile.php?edit=<?=$my_id?>" class="btn btn-primary btn-block"><b>Update Profile</b></a>
                          <button href="admin/freelance_reviews.php?my_id=<?=$my_id?>" disabled="true" class="btn btn-primary btn-block"><b>My Reviews</b></button>
                      <?php
                        } else{
                      ?>
                          <a href="admin/mypost_freelance.php" class="btn btn-success btn-block"><b>My Post</b></a>
                          <a href="admin/services.php" class="btn btn-success btn-block"><b>Post Services</b></a>
                          <a href="admin/freelance_profile.php?edit=<?=$my_id?>" class="btn btn-success btn-block"><b>Profile</b></a>
                          <a href="admin/freelance_reviews.php?my_id=<?=$my_id?>" class="btn btn-success btn-block"><b>My Reviews</b></a>
                      <?php
                        }
                      ?>
                </div>

                  
                  
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
              <div class="col-md-9">
                <div class="card mt-3">
                  <div class="card-header p-2">
                    <h5 class="text-bold mt-3 px-2">
                      Jobs you might like
                    </h5>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="activity">
                        <!-- Post -->
                        <div class="row mb-3">
                          <div class="col-md-4">
                              <select class="form-control form-control-sm" id="filter_location">
                                <option value="None">Select</option>
                                <option
                                <?= $_SESSION['filter_by'] == "Province"? "selected": null ?>
                                >Province</option>
                                <option 
                                <?= $_SESSION['filter_by'] == "Municipality"? "selected": null ?>>Municipality</option>
                                <option 
                                <?= $_SESSION['filter_by'] == "Barangay"? "selected": null ?>>Barangay</option>
                              </select>
                          </div>
                          <div class="col-md-3"></div>
                          <div class="col-md-5">
                            <form 
                                method="POST"
                                action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                  <div class="input-group input-group-sm">
                                    <input class="form-control form-control-navbar" type="search" 
                                    name="search_job"
                                    id="search_job"
                                    placeholder="Search" aria-label="Search">
                                    <div class="input-group-append">
                                      <button class="btn btn-success" 
                                      type="submit">
                                        <i class="fas fa-search"></i>
                                      </button>
                                    </div>
                                  </div>
                            </form>
                            
                            <?php 
                              if(isset($_SESSION['search_job'])): 
                            ?>
                            <h4 class="float-right mb-2 mt-3"><i class="badge badge-pill badge-light"
                              style="border: 1px solid #f0f2f5">
                              <?= $_SESSION['search_job'] ?>
                              <i class="fas fa-times m-1"
                              id="remove_filter"
                              style="cursor: pointer"></i>
                            </i></h4>
                            <?php endif; ?>
                          </div>
                        </div>
                        <style>h5 {
                                word-spacing: 0px;
                              }
                              .a {
                                color: blue;
                              }
                        </style>

                          <div id="job_results" class="form-group mt-5">


                            <?php 
                              $andLocation = null; 
                              if(isset($_SESSION['filter_by'])){
                                if(isset($_SESSION['search_job'])){
                                  $condition = " AND ";
                                }else{
                                  $condition = "AND";
                                }
                                switch ($_SESSION['filter_by']) {
                                  case 'Province':
                                    $andLocation.= "$condition reg.province LIKE '{$province}%'";
                                  break;
                                  case 'Municipality': 
                                    $andLocation.= "$condition reg.municipality LIKE '{$municipality}%'";
                                  break; 
                                  case 'Barangay': 
                                    $andLocation.= "$condition reg.barangay LIKE '{$barangay}%'";
                                  break; 
                                  default:
                                    $andLocation = null;
                                  break;
                                }
                              }
                            ?>
                            <?php
                              if(isset($_POST['search_job'])){
                                $search_job = $_POST['search_job'];
                                $searchText = "AND job_db.title LIKE '{$search_job}%'
                                OR job_db.category LIKE '{$search_job}%'";
                              }else{
                                $searchText = '';
                              }
                              $query = $db->query("SELECT * FROM job_db 
                              {$searchText}
                              ORDER BY id DESC"); 
                              $rslt = mysqli_fetch_assoc($query);
                            ?>
                            <!-- <?php 
                              if(empty($rslt)){
                            ?>
                        
                            <?php
                              }
                            ?> -->
                            <?php 
                              $query = $db->query("SELECT *,job_db.budget as job_budget, job_db.id as job, (SELECT review FROM ratings WHERE user_id = job_db.job_id AND job_id = job_db.id) as review, 
                              (SELECT rating FROM ratings WHERE user_id = job_db.job_id AND job_id = job_db.id) as rating, 
                              (SELECT CONCAT(job_db.firstname, ' ', job_db.middlename, ' ', job_db.lastname) FROM reviews_db 
                              WHERE job_db.id = (SELECT from_id FROM ratings WHERE user_id = job_db.job_id AND job_id = job_db.id)) as reviewer_name, 
                              (SELECT id FROM proposal_db WHERE proposal_id = job_db.id AND status != '3' LIMIT 1) as proposal_id FROM job_db 
                              INNER JOIN reg_db reg ON job_db.job_id = reg.id
                              WHERE job_db.id NOT IN (SELECT proposal_id FROM proposal_db WHERE status = 2 AND proposal_id = job_db.id )  
                              {$searchText}
                              {$andLocation}
                              ORDER BY job_db.id DESC"); 
                              
                              while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
                                $job_id = $freelancer['job_id'];
                                

                                $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM ratings WHERE user_id = '$job_id'");
                                $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);
                                $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$job_id';");
                                $getClientDataRow = mysqli_fetch_assoc($getClientData);
                            ?>
                            
                            <div class="post p-3"
                            style="background: #FFFDF6;">
                              <div class="user-block">

                                <?php if(file_exists("uploads/profile/client/".$getClientDataRow['profile_picture']) && $getClientDataRow['profile_picture'] != null): ?>
                                  <img class="img-circle" src="uploads/profile/client/<?=$getClientDataRow['profile_picture']?>" alt="user image">
                                <?php else: ?>
                                    <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                    style="width: 3rem;height: 3rem;" class="mr-2 img-fluid img-circle">
                                <?php endif; ?>
                                <span class="username">
                                <?php
                                  if (checkProposal($freelancer['job'], $db, $my_id) == 'true') {
                                ?>
                                    <form method="POST">
                                      <button class="btn btn-light" 
                                      onClick="return confirmSubmit();"
                                      type="submit" name="cancel_proposal"
                                      value = '<?= $freelancer['proposal_id']?>'
                                      style="float: right; border-radius: 30px; width: 150px"><b>Cancel Proposal</b></button>
                                   </form>
                                <?php  
                                  }
                                  else{
                                    if ($account_status != 2) {
                                  ?>
                                    <button disabled href="#" class="btn btn-success text-bold" 
                                      style="float: right; border-radius: 30px" >
                                      Submit a proposal
                                    </button>
                                  <?php
                                    }
                                    else{
                                      $my_skills = explode(',', strtolower($skills));
                                      $categories = explode(',', strtolower($freelancer['category']));
                                      $encoded_str_cat = json_encode($categories);
                                      $x = 0;


                                      $tmp_categ = array(); 
                                      for ($a=0; $a < count($categories) ; $a++) { 
                                         array_push($tmp_categ, str_replace(" ","",strtolower($categories[$a])));
                                      }

                                      $tmp_skill = array();

                                      for ($q=0; $q < count($my_skills) ; $q++) { 
                                        array_push($tmp_skill, str_replace(" ", "",$my_skills[$q]));
                                      }
                                      
                                      if (array_intersect($tmp_skill, $tmp_categ)) {
                                    ?>
                                      <a href="admin/proposal.php?edit=<?=$freelancer['job']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                        <b>Submit Proposal</b>
                                      </a>
                                    <?php
                                      }else {
                                    ?>
                                      <h6 style="float:right">Not Qualified</h6>
                                    <?php
                                        }
                                      }
                                    }
                                  ?>


                                  <a 
                                  class="text-capitalize"
                                  href="http://34.192.240.192/profile.php?log=<?= $freelancer['job_id']?>"
                                  > <?= $freelancer['firstname']; ?> <?= $freelancer['middlename']; ?> <?= $freelancer['lastname']; ?></a>
                                </span>
                                <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></span>
                                <!--<span class="description">Posted - 7:30 PM today</span>-->
                            </div>
                              
                              <!-- /.user-block -->
                              <h5 class="text-capitalize text-bold text-success"
                              style="cursor: pointer"
                              data-toggle="modal" data-target="#job_details<?= $freelancer["id"] ?>">
                                <?= $freelancer['title']; ?>
                              </h5>

                              <h6 class="text-dark">
                                Job Rate: <span class="text-bold text-dark">₱<?= number_format($freelancer['job_budget']); ?></span>
                              </h6>
                              <h6 class="text-capitalize text-bold text-dark">
                                 <?= $freelancer['experience']; ?> 
                              </h6>

                              <p class="text-capitalize">
                                <?= $freelancer['description']; ?>
                              </p>
                              
                              <hr>
                              <h5 class="text-capitalize">
                                   <?php 
                                      $cats = explode(",", $freelancer['category']); 
                                      for ($i=0; $i < count($cats) ; $i++):
                                   ?>
                                     <span class="badge badge-pill p-2 text-dark m-1"
                                     style="background: #f0f2f5">
                                        <?= $cats[$i] ?>
                                     </span>
                                   <?php endfor; ?>
                              </h5>

                              <h6 class="text-capitalize text-dark px-2 text-bold">
                               <i class='fa fa-map-marker'></i>
                               <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                              </h6>

                              <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                              </p>

                              <a href="admin/client_reviews.php?my_id=<?=$job_id?>"style="font-size: 15px"
                              class="text-success">Show more ratings</a>


                              
                              <div class="modal right fade" id="job_details<?= $freelancer["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                    <div class="modal-body">
                                      <h4 class="text-dark">
                                        <?= $freelancer['title'] ?>
                                      </h4>
                                      <h5 class="text-success text-bold"><?= $freelancer['category'] ?></h5>
                                      <h6>Posted <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></h6>
                                      <p>
                                        <i class="fa fa-book"></i> <?= $freelancer['description'] ?>
                                      </p>
                                      <h6>Project Type: <?= $freelancer['type_of_project'] ?></h6>
                                      <hr>
                                      <h5 class="text-dark">Skills and Expertise</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['experience'] ?> Level</h6>
                                      <h5 class="text-dark">Budget</h5>
                                      <h6 class="text-bold">Php. <?= number_format($freelancer['budget']) ?></h6>
                                      <hr>
                                      <h5 class="text-dark">No. of workers needed</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['no_of_freelance'] ?></h6>

                                      <h5 class="text-dark">Payment Type</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['payment_freelance'] ?></h6>
                                    </div>

                                    <div class="modal-footer">
                                    <?php
                                      if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                    ?>
                                        <form method="POST">
                                          <button class="btn btn-light" 
                                          onClick="return confirmSubmit();"
                                          type="submit" name="cancel_proposal"
                                          value = '<?= $freelancer['proposal_id']?>'
                                          style="float: right; border-radius: 30px; width: 150px"><b>Cancel Proposal</b></button>
                                      </form>
                                    <?php  
                                      }
                                      else{
                                        if ($account_status != 2) {
                                      ?>
                                        <button disabled href="#" class="btn btn-success text-bold" 
                                          style="float: right; border-radius: 30px" >
                                          Submit a proposal
                                        </button>
                                      <?php
                                        }
                                        else{
                                          $my_skills = explode(',', strtolower($skills));
                                          $categories = explode(',', strtolower($freelancer['category']));
                                          $encoded_str_cat = json_encode($categories);
                                          $x = 0;


                                          $tmp_categ = array(); 
                                          for ($a=0; $a < count($categories) ; $a++) { 
                                            array_push($tmp_categ, str_replace(" ","",strtolower($categories[$a])));
                                          }

                                          $tmp_skill = array();

                                          for ($q=0; $q < count($my_skills) ; $q++) { 
                                            array_push($tmp_skill, str_replace(" ", "",$my_skills[$q]));
                                          }
                                          
                                          if (array_intersect($tmp_skill, $tmp_categ)) {
                                        ?>
                                          <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                            <b>Submit Proposal</b>
                                          </a>
                                        <?php
                                          }else {
                                        ?>
                                          <h6 style="float:right">Not Qualified</h6>
                                        <?php
                                            }
                                          }
                                        }
                                      ?>

                                    </div>

                                  </div><!-- modal-content -->
                                </div><!-- modal-dialog -->
                              </div><!-- modal -->
                                
                            </div>
                              <?php endwhile; ?>
                              <?php
                                if (empty($getClientDataRow)) {
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
                        </div>
                        
                        <!-- /.post -->

                        

                      
                        
                        
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="Discover">
                            <div class="row">
                               <div class="col-md-6"></div>
                               <div class="col-md-6">
                                  <div class="input-group">
                                      <input class="form-control" type="search" 
                                      placeholder="Search for training"
                                      id="search_training_services"
                                      aria-label="Search">
                                      <div class="input-group-append">
                                        <button class="btn btn-success">
                                          <i class="fas fa-search"></i>
                                        </button>
                                      </div>
                                  </div>
                               </div>
                            </div>
                        <?php
                          $participants_num = 5;
                          $q = "SELECT event.id as event_id, event.reg_id as event_reg_id, event.title as event_title, event.description as event_description, event.training_type as event_training_type, event.training_price as event_training_price, event.mode_of_payment as event_mode_of_payment, event.date_start as event_date_start, event.participants as event_participants, event.field as event_field, event.platform as event_platform, event.visible as event_visible, event.created as event_created, trainor.firstname as trainor_firstname, trainor.lastname as trainor_lastname, trainor.profile_picture as trainor_profile_picture FROM events_db event JOIN reg_db trainor ON event.reg_id = trainor.id WHERE event.delete_flg = '0' AND event.visible = '1' ORDER BY event.id DESC;";
                          $query = $db->query($q); //Eto yung query
                          $trainings_cont = mysqli_num_rows($query);
                          while($row = mysqli_fetch_assoc($query)): //eto yung loop
                            $training_id = $row['event_id'];
                            $reg_id = $row['event_reg_id'];
                            $title = $row['event_title'];
                            $training_type = $row['event_training_type'];
                            $training_price = $row['event_training_price'];
                            $mode_of_payment = $row['event_mode_of_payment'];
                            $description = $row['event_description'];
                            $date_start = $row['event_date_start'];
                            $participants = $row['event_participants'];
                            $field = $row['event_field'];
                            $platform = $row['event_platform'];

                            $countParticipants = $db->query("SELECT id FROM events_participants_db WHERE event_id = '$training_id' AND delete_flg = '0' AND status = '1';");
                            $countParticipants_count = mysqli_num_rows($countParticipants);

                            $getRatings = $db->query("SELECT AVG(rate) AS ave_rating FROM trainor_ratings_db WHERE trainor_id = '$reg_id' AND delete_flg = '0';");
                            $getRatingsRow = mysqli_fetch_assoc($getRatings);
                            $countRatings = $db->query("SELECT count(id) AS total_id FROM trainor_ratings_db WHERE trainor_id = '$reg_id' AND delete_flg = '0';");
                            $countRatingsRow = mysqli_fetch_assoc($countRatings);
                            $getRatingsCount = $countRatingsRow['total_id'];

                            $joined = $db->query("SELECT id FROM events_participants_db WHERE reg_id = '$my_id' AND event_id = '$training_id' AND delete_flg = '0'
                            AND events_participants_db.status != 2;");
                            $joined_count = mysqli_num_rows($joined);
                        ?>
                        <div class="post">
                           <div class="card shadow-none" id="services_data">
                              <div class="card-body">
                                    <div class="user-block">
                                          <?php if(file_exists("uploads/profile/trainor/".$row['trainor_profile_picture']) && $row['trainor_profile_picture'] != null): ?>
                                            <img class="img-circle" src="uploads/profile/trainor/<?=$row['trainor_profile_picture']?>" alt="user image">
                                          <?php else: ?>
                                              <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                              style="width: 3rem;height: 3rem;" class="mr-2 img-fluid img-circle">
                                          <?php endif; ?>
                                      <span class="username">
                                        <a href="http://34.192.240.192/profile.php?log=<?= $row['event_reg_id']?>">
                                        <?= $row['trainor_firstname']; ?> <?= $row['trainor_lastname']; ?> </a>
                                      </span>
                                      <span class="description">Posted - <?=$row['event_created']?></span>
                                    </div>
                                    <div style="float: right;" class="mr-3">
                                      <h3 class="text-primary">Ratings</h3>
                                      <?php
                                        if ($getRatingsRow['ave_rating'] < 1) {
                                      ?>
                                       <h6 class="mr-4">No ratings yet</h6>
                                      <?php
                                        } else {
                                      ?>
                                        <!-- <p><?=round($getRatingsRow['ave_rating'], 2)?> / </p> -->
                                        <div class="d-flex flex-column">
                                            <h6 class="text-bold"><?php 
                                                if($getRatingsRow['ave_rating'] == 0){
                                                  for ($i=0; $i < 5; $i++) { 
                                                    print('<i class="fa fa-star text-secondary"></i>');
                                                  }
                                                }
                                                for ($i=0; $i < round($getRatingsRow['ave_rating'], 2) ; $i++) { 
                                              ?>
                                                  <i class="fa fa-star text-warning"></i>
                                              <?php
                                                }
                                              ?>
                                            </h6>
                                            <h6>base on <?=$getRatingsCount?> reviews</h6>
                                        </div>
                                      <?php
                                        }
                                      ?>
                                    </div>
                                    <div>
                                      <h5 class="text-success text-bold text-capitalize"><?= $title; ?></h5>
                                      <div class="d-flex flex-column">
                                          <span class="text-bold text-dark"><?= $training_type; ?></span>
                                          <small>Training Type</small>
                                      </div>
                                      <div class="d-flex flex-column mt-2">
                                          <span class="text-bold text-dark">Php. <?= number_format($training_price); ?></span>
                                          <small>Training Expense</small>
                                      </div>

                                      <div class="d-flex flex-column mt-2">
                                          <span class="text-bold text-dark"><?= $date_start; ?></span>
                                          <small>Date Start</small>
                                      </div>

                                      <!-- <h6><span>Training Type: </span><span class="text-bold text-dark"><?= $training_type; ?></span></h6> -->
                                      <!-- <h6><span>Training Expense: </span><span class="text-bold text-dark">Php.<?= $training_price; ?></span></h6> -->
                                      <!-- <h6><span>Date Start: </span><span class="text-bold text-dark"><?= $date_start; ?></span></h6> -->
                                      <h5 class="mt-3"><span class="text-bold text-dark">No of Participants:</span> <span class="text-bold text-dark"><?=$countParticipants_count?> of <?=$participants?></span></h5>
                                    </div>
                                   
                                  <?php
                                    if ($account_status != 2) {
                                  ?>
                                    <button disabled class="btn btn-primary">Join Training</button>
                                  <?php
                                    } else {
                                  ?>
                                    <?php 
                                     if($countParticipants_count < $participants): 
                                  ?>
                                    <button class="btn btn-light text-success text-bold"
                                        style="border-radius: 30px; border: 1px solid #f0f2f5"
                                        <?php if ($joined_count > 0)
                                            echo "disabled";  ?>
                                        onclick="join_training('<?=$training_id?>', '<?=$my_id?>')">

                                        <i class="fa fa-heart mr-1"></i>
                                        <?php if ($joined_count > 0):
                                            echo "Joined";  ?>
                                        <?php else:
                                            echo "Join Training";  
                                        endif ;?>
                                        
                                    </button>
                                  <?php endif; ?>
                                  
                                    <!-- <button class="btn btn-success"
                                    style="border-radius: 30px"
                                    <?php if ($joined_count > 0)
                                        echo "disabled";  ?>
                                    onclick="join_training('<?=$training_id?>', '<?=$my_id?>')">
                                    <?php if ($joined_count > 0):
                                        echo "Joined";  ?>
                                    <?php else:
                                        echo "Join Training";  
                                    endif ;?>
                                    </button> -->
                                  <?php
                                    }
                                  ?>
                                  
                                  <?php if($countParticipants_count >= $participants): 
                                          print("<h6 class='mt-3'>No slots available</h6>");
                                    endif;
                                  ?>
                              </div>
                              <div class="card-footer">
                                 <a href="#" data-toggle="modal" 
                                        class="text-sm text-success"
                                        data-target="#view_complete_info_<?=$training_id?>">View Complete Info</a>
                              </div>
                           </div>
                        </div>
                        
                      
                      <div id="view_complete_info_<?=$training_id?>" class="modal fade" role="dialog">
                      <div class="modal-dialog" style="width:100%;" style="margin-top: 2%;margin-bottom: 7%;">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title text-bold" id="exampleModalLongTitle">Complete Information</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="card">
                                       <div class="card-body">
                                          <div>
                                            <small class="text-secondary"><span>Training</span></small>
                                          </div>
                                          <h5 class="text-bold text-success"><?=$title?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Training Type</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$training_type?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Training Price</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark">Php. <?= number_format($training_price)?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Date Start</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$date_start?></h5>

                                          <div>
                                            <small class="text-secondary"><span>No of Participants</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$participants?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Field of Training</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$field?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Platform to Discuss</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$platform?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Mode of Payment</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$mode_of_payment?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Training Description</span></small>
                                          </div>
                                          <div style="border: 1px solid #f0f2f5; border-radius: 10px"
                                          class="p-3">
                                            <h6 class="text-dark"><?=$description?></h6>
                                          </div>

                                          <div class="form-group">
                                            <h4 class="mt-5 text-bold">Ratings</h4>
                                            <?php
                                              $getReviews = $db->query("SELECT trainor_ratings.comment, trainor_ratings.rate, from_id.id, from_id.firstname, from_id.lastname FROM trainor_ratings_db trainor_ratings JOIN reg_db from_id ON trainor_ratings.reg_id = from_id.id WHERE trainor_ratings.delete_flg = '0' AND trainor_ratings.trainor_id = '$reg_id';");
                                              if ($getRatingsRow['ave_rating'] < 1) {
                                            ?>
                                              <p>No ratings yet</p>
                                            <?php
                                              } else {
                                            ?>
                                              <h5 class="text-primary"><?=round($getRatingsRow['ave_rating'], 2)?></h5>
                                            <?php
                                                while ($getReviewsRow = mysqli_fetch_assoc($getReviews)):
                                            ?>
                                              <a href="http://34.192.240.192/profile.php?log=<?= $getReviewsRow['id']?>"
                                                style="text-transform: capitalize;"
                                                class="text-success text-bold fs-5">
                                                <?=$getReviewsRow['firstname']." ".$getReviewsRow['lastname']?>
                                              </a>
                                              <h6><span class="text-bold">Ratings: <?=$getReviewsRow['rate']?></span></h6>
                                              <p><?=$getReviewsRow['comment']?></p>
                                            <?php
                                                endwhile;
                                              }
                                            ?>
                                          </div>

                                          </div>
                                          <div class="form-group">
                                            <?php
                                              if ($account_status != 2) {
                                            ?>
                                              <button disabled class="btn btn-primary">Join Training</button>
                                            <?php
                                              } else {
                                            ?>
                                           
                                             <?php 
                                                if($countParticipants_count < $participants): 
                                              ?>
                                                <button class="btn btn-success ml-3"
                                                    style="border-radius: 30px"
                                                    <?php if ($joined_count > 0)
                                                        echo "disabled";  ?>
                                                    onclick="join_training('<?=$training_id?>', '<?=$my_id?>')">
                                                    <?php if ($joined_count > 0):
                                                        echo "Joined";  ?>
                                                    <?php else:
                                                        echo "Join Training";  
                                                    endif ;?>
                                                </button>
                                              <?php endif; ?>
                                            <?php
                                             }
                                            ?>
                                          </div>
                                       </div>
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
                                          height="500px" width="600px">
                                  </div>
                                  <div class="d-flex justify-content-center">
                                      <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                                  </div>
                            </div>
                        <?php
                          }
                        ?>
                      </div>

                      <div class="tab-pane" id="my_training">
                        <div class="tab-content">
                          <nav class="main-header navbar nav-light navbar-expand" style="margin-bottom: 2rem;">
                            <ul class="nav nav-tabs">
                              <li class="nav-item">
                                <a class="nav-link active" href="#my_trainings" data-toggle="tab">My Trainings</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="#training_history" data-toggle="tab">History</a>
                              </li>
                            </ul>
                          </nav>
                          <div class="tab-pane active" id="my_trainings">
                            <div class="row">
                               <div class="col-md-6"></div>
                               <div class="col-md-6">
                                  <div class="input-group">
                                      <input class="form-control" type="search" 
                                      placeholder="Search for training"
                                      id="search_training"
                                      aria-label="Search">
                                      <div class="input-group-append">
                                        <button class="btn btn-success">
                                          <i class="fas fa-search"></i>
                                        </button>
                                      </div>
                                  </div>
                               </div>
                            </div>
                            <?php
                              $participants_num = 5;
                              $q = "SELECT event.id as event_id, event.reg_id as event_reg_id, event.title as event_title, event.description as event_description, event.training_type as event_training_type, event.training_price as event_training_price, event.payment_description as event_payment_description, event.mode_of_payment as event_mode_of_payment, event.date_start as event_date_start, event.participants as event_participants, event.field as event_field, event.platform as event_platform, event.visible as event_visible, event.created as event_created, trainor.firstname as trainor_firstname, trainor.lastname as trainor_lastname, participants.id as event_participants_id, trainor.profile_picture as trainor_profile_picture FROM events_participants_db participants JOIN events_db event ON participants.event_id = event.id JOIN reg_db trainor ON event.reg_id = trainor.id WHERE event.delete_flg = '0' AND participants.status = '1' AND participants.delete_flg = '0' AND participants.reg_id = '$my_id' ORDER BY event.id DESC;";
                              $query = $db->query($q); //Eto yung query
                              $trainings_cont = mysqli_num_rows($query);
                              while($row = mysqli_fetch_assoc($query)): //eto yung loop
                                $training_id = $row['event_id'];
                                $reg_id = $row['event_reg_id'];
                                $title = $row['event_title'];
                                $training_type = $row['event_training_type'];
                                $training_price = $row['event_training_price'];
                                $event_payment_description = $row['event_payment_description'];
                                $mode_of_payment = $row['event_mode_of_payment'];
                                $description = $row['event_description'];
                                $date_start = $row['event_date_start'];
                                $participants = $row['event_participants'];
                                $field = $row['event_field'];
                                $platform = $row['event_platform'];
                                $event_participants_id = $row['event_participants_id'];

                                $countParticipants = $db->query("SELECT id FROM events_participants_db WHERE event_id = '$training_id' AND delete_flg = '0' AND status = '1';");
                                $countParticipants_count = mysqli_num_rows($countParticipants);

                                $getRatings = $db->query("SELECT AVG(rate) AS ave_rating FROM trainor_ratings_db WHERE trainor_id = '$reg_id' AND delete_flg = '0';");
                                $getRatingsRow = mysqli_fetch_assoc($getRatings);

                                $joined = $db->query("SELECT id FROM events_participants_db WHERE reg_id = '$my_id' AND event_id = '$training_id' AND delete_flg = '0';");
                                $joined_count = mysqli_num_rows($joined);
                            ?>
                            <div class="post mt-3">  
                                <div class="card shadow-none" id= "training_data">
                                  <div class="card-body">
                                    <div class="user-block">
                                      <?php if(file_exists("uploads/profile/trainor/".$row['trainor_profile_picture']) && $row['trainor_profile_picture'] != null): ?>
                                        <img class="img-circle" src="uploads/profile/trainor/<?=$row['trainor_profile_picture']?>" alt="user image">
                                      <?php else: ?>
                                          <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                          style="width: 3rem;height: 3rem;" class="mr-2 img-fluid img-circle">
                                      <?php endif; ?>
                                      <span class="username">
                                        <a href="http://34.192.240.192/profile.php?log=<?= $row['event_reg_id']?>"><?= $row['trainor_firstname']; ?> <?= $row['trainor_lastname']; ?> </a>
                                      </span>
                                      <span class="description">Posted - <?=$row['event_created']?></span>
                                    </div>
                                    <div>
                                      <button style="float: right;" class="btn btn-danger" onclick="update_join_request('<?=$event_participants_id?>')">Remove</button>
                                      <h5 class="text-bold text-success text-capitalize">
                                        <?= $title; ?>
                                      </h5>
                                      <div class="d-flex flex-column">
                                          <span class="text-bold text-dark"><?= $training_type; ?></span>
                                          <small>Training Type</small>
                                      </div>
                                      
                                      <div class="d-flex flex-column mt-3">
                                          <span class="text-bold text-dark">Php. <?= number_format($training_price); ?></span>
                                          <small>Training Price</small>
                                      </div>

                                      <div class="d-flex flex-column mt-3">
                                          <span class="text-bold text-dark"><?= $date_start; ?></span>
                                          <small>Date Start</small>
                                      </div>

                                      <br>
                                      <h5>Participants: <span class="text-bold text-dark"><?=$countParticipants_count?> of <?= number_format($participants)?></span></h5>
                                      </p>
                                    </div>
                                      <div class="card-footer">
                                        <button class="btn btn-light text-success text-bold" data-toggle="modal" data-target="#view_complete_info_2_<?=$training_id?>"
                                        style="border-radius: 30px;border: 1px solid #e0e0e0"
                                        >View Complete Info</button>


                                        <a href="activities.php?training_id=<?=$training_id?>" 
                                        class="btn btn-light text-success text-bold"
                                        style="border-radius: 30px;border: 1px solid #e0e0e0">Activity Calendar</a>


                                        <a class="btn btn-light text-success text-bold" href="add_rate_trainor.php?training_id=<?=$training_id?>&trainor_id=<?=$reg_id?>&my_id=<?=$my_id?>"
                                        style="border-radius: 30px;border: 1px solid #e0e0e0"
                                        >Rate and Review</a>
                                        <?php
                                          $payment_data = $db->query("SELECT id FROM event_payment_db WHERE reg_id = '$my_id' AND event_id = '$training_id' AND delete_flg = '0';");
                                        ?>
                                          
                                        <?php
                                          if (mysqli_num_rows($payment_data)  > 0) {
                                        ?>
                                          <button disabled class="btn btn-light text-success text-bold"  
                                          onclick="displayPaymentDescription('<?=$my_id?>', '<?=$training_id?>', '<?=$event_payment_description?>')"
                                          style="border-radius: 30px;border: 1px solid #e0e0e0"
                                          >Payment Sent</button>
                                        <?php
                                          } else {
                                        ?>
                                          <button class="btn btn-light text-success text-bold"  onclick="displayPaymentDescription('<?=$my_id?>', '<?=$training_id?>')"
                                          style="border-radius: 30px;border: 1px solid #e0e0e0"
                                          >Send Payment</button>

                                          <textarea id="training<?=$training_id?>" cols="30" rows="10"
                                          class="d-none"><?=$event_payment_description?></textarea>
                                        <?php
                                            }
                                        ?>
                                      </div>
                                    </div>
                                  </div>
                            </div>

                          <div class="modal fade" id="view_complete_info_2_<?=$training_id?>"
                            tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title text-bold" id="exampleModalLongTitle">Complete Information</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="card">
                                       <div class="card-body">
                                          <div>
                                            <small class="text-secondary"><span>Training</span></small>
                                          </div>
                                          <h5 class="text-bold text-success"><?=$title?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Training Type</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$training_type?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Training Price</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark">Php. <?=$training_price?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Date Start</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$date_start?></h5>

                                          <div>
                                            <small class="text-secondary"><span>No of Participants</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$participants?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Field of Training</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$field?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Platform to Discuss</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$platform?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Mode of Payment</span></small>
                                          </div>
                                          <h5 class="text-bold text-dark"><?=$mode_of_payment?></h5>

                                          <div>
                                            <small class="text-secondary"><span>Training Description</span></small>
                                          </div>
                                          <div style="border: 1px solid #f0f2f5; border-radius: 10px"
                                          class="p-3">
                                            <h6 class="text-dark"><?=$description?></h6>
                                          </div>

                                       </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                          height="500px" width="600px">
                                  </div>
                                  <div class="d-flex justify-content-center">
                                      <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                                  </div>
                            </div>
                            <?php
                              }
                            ?>
                          </div>

                          <div class="tab-pane" id="training_history">
                            <?php
                              $participants_num = 5;
                              $q = "SELECT events_db.id as event_id, events_db.reg_id as event_reg_id, events_db.title as event_title, events_db.description 
                              as event_description, events_db.training_type as event_training_type, events_db.training_price as event_training_price, 
                              events_db.mode_of_payment as event_mode_of_payment, events_db.date_start as event_date_start, events_db.participants as 
                              event_participants, events_db.field as event_field, events_db.platform as event_platform, events_db.visible as event_visible,
                              events_db.created as event_created, trainor.firstname as trainor_firstname, trainor.lastname as trainor_lastname, 
                              trainor.profile_picture as trainor_profile_picture FROM events_participants_db participants JOIN events_db ON participants.event_id = 
                              events_db.id JOIN reg_db trainor ON events_db.reg_id = trainor.id WHERE events_db.delete_flg = '0' 
                              AND participants.status = '2' AND participants.delete_flg = '0' AND participants.reg_id = '{$my_id}' ORDER BY events_db.id DESC;";
                              
                              $query = $db->query($q); //Eto yung query
                              $trainings_cont = mysqli_num_rows($query);
                              while($row = mysqli_fetch_assoc($query)): //eto yung loop
                                $training_id = $row['event_id'];
                                $reg_id = $row['event_reg_id'];
                                $title = $row['event_title'];
                                $training_type = $row['event_training_type'];
                                $training_price = $row['event_training_price'];
                                $mode_of_payment = $row['event_mode_of_payment'];
                                $description = $row['event_description'];
                                $date_start = $row['event_date_start'];
                                $participants = $row['event_participants'];
                                $field = $row['event_field'];
                                $platform = $row['event_platform'];

                                $countParticipants = $db->query("SELECT id FROM events_participants_db WHERE event_id = '$training_id' AND delete_flg = '0' AND status = '1';");
                                $countParticipants_count = mysqli_num_rows($countParticipants);

                                $getRatings = $db->query("SELECT AVG(rate) AS ave_rating FROM trainor_ratings_db WHERE trainor_id = '$reg_id' AND delete_flg = '0';");
                                $getRatingsRow = mysqli_fetch_assoc($getRatings);

                                $joined = $db->query("SELECT id FROM events_participants_db WHERE reg_id = '$my_id' AND event_id = '$training_id' AND delete_flg = '0';");
                                $joined_count = mysqli_num_rows($joined);
                            ?>
                            <div class="post rounded-lg p-3" 
                            style="background: #FFFDF6;">
                              <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="uploads/profile/trainor/<?=$row['trainor_profile_picture']?>" alt="user image">
                                <span class="username">
                                  <a href="http://34.192.240.192/profile.php?log=<?= $row['event_reg_id']?>"><?= $row['trainor_firstname']; ?> <?= $row['trainor_lastname']; ?> </a>
                                </span>
                                <span class="description">Posted - <?=$row['event_created']?></span>
                              </div>
                              <h6 class="float-right p-2 rounded-xxl"
                              style="background-color: #f0f2f5">Removed from training</h6>
                              <div>
                                <h5 class="text-bold text-success"><?= $title; ?></h5>
                                <?= $training_type; ?>
                                <br>
                                <!-- <span class="text-bold">Event Price: </span>
                                <span>Php. <?= $training_price; ?></span>
                                <br>
                                  <span class="text-bold">Event Start: </span>
                                  <span><?= $date_start; ?></span>
                                <br> -->
                              </div>
                            </div>
                            <?php
                              endwhile;

                              if ($trainings_cont < 1) {
                            ?>
                            <div class="d-flex flex-column">
                                  <div class="d-flex justify-content-center">
                                      <img src="images/result_no.png" alt=""
                                          height="500px" width="600px">
                                  </div>
                                  <div class="d-flex justify-content-center">
                                      <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                                  </div>
                            </div>
                            <?php
                              }
                            ?>
                          </div>
                        </div>
                      </div>
                        
                      <div class="tab-pane" id="settings" >
                      
                    <div class="col-md-12">
                      <div class="card shadow-none">
                        <div class="card-header">
                            <div class="card-header">
                              <ul class="nav nav-tabs card-header-tabs">
                                
                                  <li class="nav-item">
                                    <a class="nav-link active" href="#proposal" data-toggle="tab">Proposal</a>
                                  </li>

                                  <li class="nav-item">
                                    <a class="nav-link" href="#request" data-toggle="tab">Hiring Request</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#client" data-toggle="tab">My Client</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#finish" data-toggle="tab">Finish job</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#history" data-toggle="tab">History</a>
                                  </li>
                              </ul>
                            </div>
                        </div>
                        <div class="card-body">
                    <div class="tab-content">  
                      <div class="tab-pane" id="request">
                    <div class="container">
    
                <?php
                  $query = "SELECT proposal.id, service.rate, service.day_week, service.name, service.services, service.description, reg.firstname, reg.lastname, a.experience AS owner_exp, service.skills, reg.profile_picture, service.id as service_id, proposal.reg_id as client_id
                            FROM service_db service
                            JOIN service_proposal proposal
                            ON service.id = proposal.service_id
                            JOIN reg_db reg
                            ON reg.id = proposal.reg_id
                            JOIN reg_db a
                            ON a.id = service.reg_id
                            WHERE service.reg_id = '$my_id'
                            AND proposal.status = '0'
                            AND proposal.delete_flg = '0';";

                  $result = $db->query($query);
                  $res = mysqli_fetch_assoc($result);
                ?>
    
                <?php 
                        if(empty($res)): 
                      ?>
                          <div class="d-flex flex-column">
                            <div class="d-flex justify-content-center">
                              <img src="images/result_no.png" alt=""
                                  height="500px"
                                  width="600px">
                            </div>
                            <div class="d-flex justify-content-center">
                              <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                            </div>
                          </div>         
                <?php endif; ?>
                <?php
                  $query = "SELECT proposal.id, service.rate, service.day_week, service.name, service.services, proposal.create_user,
                            service.description, reg.firstname, reg.lastname, a.experience AS owner_exp, service.skills, reg.profile_picture, 
                            service.id as service_id, proposal.reg_id as client_id 
                            FROM service_db service 
                            INNER JOIN service_proposal proposal ON service.id = proposal.service_id 
                            INNER JOIN reg_db reg ON reg.id = proposal.create_user 
                            INNER JOIN reg_db a ON a.id = service.reg_id
                            WHERE service.reg_id = '$my_id' 
                            AND proposal.status = '0' 
                            AND proposal.delete_flg = '0';";

                  $result = $db->query($query);
                  while ($row = mysqli_fetch_assoc($result)):
                      $row_id = $row['id'];
                      $client_id = $row['client_id'];

                      $client_data = $db->query("SELECT * FROM reg_db WHERE id = '$client_id';");
                      $client = mysqli_fetch_assoc($client_data);
                ?>
                <div class="card bg-white text-white col-md-12">
                  <div class="card-body p1 text-capitalize ">
                      <div class="d-flex">
                        <?php if(file_exists("uploads/profile/client/".$row['profile_picture']) && $row['profile_picture'] != null): ?>
                              <img class="img-circle" src="uploads/profile/client/<?=$row['profile_picture']?>" alt="user image"
                              style="width: 3rem;
                              height: 3rem;">
                        <?php else: ?>
                              <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                              style="width: 3rem;
                              height: 3rem;" class="img-fluid img-circle">
                        <?php endif; ?>          
                        
                        <a class="d-flex flex-column" 
                        href="http://34.192.240.192/profile.php?log=<?= $row['create_user']?>"
                        style="font-size: 17px; cursor: pointer">
                          <span class="text-bold ml-2"><?=$row['firstname']?> <?=$row['lastname']?> </span>
                          <span class="ml-2 text-dark hover-me text-sm">View Profile</span>
                          <style>
                            .hover-me:hover{
                              text-decoration: underline;
                            }
                          </style>
                        </a>
                      </div>
                      <br>
                      <h5 class="text-bold mt-3 text-success"><?=$row['skills']?></h5>
                      <h6><?= $row['services'] ?></h6>
                      <h6><span class="text-bold">Availability: </span>
                        <span class="text-bold"><?=$row['rate']?> / <?=$row['day_week']?></span>
                      </h6>
                      <small>
                        <a href="#" 
                        data-target="#view_info<?=$row['service_id']?>"
                        data-toggle="modal">View Complete Info</a>
                      </small>
                      <br><br>
                      <button onclick="modify_proposal('<?=$row_id?>', 'accept')"
                      style="border-radius: 10px"
                      class="btn btn-success"><i class="fa fa-check"></i> Accept</button>
                      <button onclick="modify_proposal('<?=$row_id?>', 'decline')" 
                      style="border-radius: 10px"
                      class="btn btn-danger"><i class="fa fa-times"></i> Decline</button>
                  </div>
                </div>


                    <div class="modal" id="view_info<?= $row['service_id']; ?>">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="d-flex">
                                    <?php if(file_exists("uploads/profile/client/".$row['profile_picture']) && $row['profile_picture'] != null): ?>
                                          <img class="img-circle" src="uploads/profile/client/<?=$row['profile_picture']?>" alt="user image"
                                          style="width: 3rem;
                                          height: 3rem;">
                                    <?php else: ?>
                                          <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                          style="width: 3rem;
                                          height: 3rem;" class="img-fluid img-circle">
                                    <?php endif; ?>          
                                    
                                    <a class="d-flex flex-column" 
                                    href="http://34.192.240.192/profile.php?log=<?= $row['create_user']?>"
                                    style="font-size: 17px; cursor: pointer">
                                      <span class="text-bold ml-2 text-capitalize"><?=$row['firstname']?> <?=$row['lastname']?> </span>
                                      <span class="ml-2 hover-me text-dark text-sm">View Profile</span>
                                      <style>
                                        .hover-me:hover{
                                          text-decoration: underline;
                                        }
                                      </style>
                                    </a>
                                </div>
                              </div>
                              <div class="modal-body">
                                <div class="d-flex flex-column">
                                  <h5 class="text-bold text-success mt-3"><?=$row['skills']?></h5>
                                  <h6><?= $row['services'] ?></h6>
                                  <h6>Posted By: <a  class="text-capitalize" href="http://34.192.240.192/profile.php?log=<?= $row['client_id']?>">
                                    <span class="text-bold text-success text-bold mt-2">
                                          <?= $row["name"] ?>
                                    </span>
                                   </a>
                                  <h6><span class="text-bold">Availability: </span>
                                    <span class="text-bold"><?=$row['rate']?> / <?=$row['day_week']?></span>
                                  </h6>
                                  <p class="text-capitalize">
                                    <?= $row['description'] ?>
                                  </p>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button onclick="modify_proposal('<?=$row_id?>', 'accept')"
                                style="border-radius: 10px"
                                class="btn btn-success"><i class="fa fa-check"></i> Accept</button>
                                <button onclick="modify_proposal('<?=$row_id?>', 'decline')" 
                                style="border-radius: 10px"
                                class="btn btn-danger"><i class="fa fa-times"></i> Decline</button>
                              </div>
                            </div>
                          </div>
                    </div>

                    <div class="modal fade" 
                      id="view<?= $row['service_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="p-3"
                              style="background-color: #f9d29d; background: url('/img/hero-area.jpg');">
                                    <div class="d-flex justify-content-center">
                                      <?php if(file_exists("uploads/profile/client/".$client['profile_picture']) 
                                      && 
                                      $client['profile_picture'] != null): ?>
                                            <img class="img-circle" src="uploads/profile/client/<?=$client['profile_picture']?>" alt="user image"
                                            style="width: 200px;
                                            height: 200px;">
                                      <?php else: ?>
                                            <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                            style="width: 200px;
                                            height: 200px;" class="img-fluid img-circle">
                                      <?php endif; ?>     
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <h3 class="mt-2 text-capitalize text-light">
                                          <?= $client['firstname']; ?> <?= $client['middlename']; ?> <?= $client['lastname']; ?>
                                        </h3>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <h6 class="text-capitalize text-light"><?= $client['skills']; ?></h6>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                            <?php
                                              if (empty($ratings_row['ave_rating'])) {
                                                echo "<h5 class='text-light'>No ratings yet</h5>";
                                              } else {
                                                $ratings = round($ratings_row['ave_rating'], 0);
                                                for ($i=0; $i < $ratings ; $i++):
                                            
                                            ?>
                                            <i class='fa fa-star text-warning mx-1 mt-1'
                                                style="font-size: 25px"></i>
                                            <?php endfor; 
                                            }?>
                                    </div>
                              </div>
                              <div class="container">
                                  <div class="row">
                                      <div class="col-4">
                                        <div class="card mt-3" style="width: 15rem; height: 220px">
                                            <img class="card-img-top"  
                                            height="100px"
                                            style="object-fit: cover"
                                            src="https://www.pngitem.com/pimgs/m/117-1177878_square-academic-cap-graduation-ceremony-graduate-university-graduation.png" alt="Card image cap">
                                          <div class="card-body">
                                            <h5 class="card-title text-bold d-flex justify-content-center"><?= $client['education']; ?></h5>
                                          </div>
                                          <div class="card-footer d-flex justify-content-center">
                                              <h6 class="mb-2 text-muted">Education</h6>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-4">
                                        <div class="card mt-3" style="width: 15rem; height: 220px">
                                            <img class="card-img-top" 
                                            src="https://www.seekpng.com/png/detail/204-2048138_addressing-information-address-icon-logo.png" 
                                            height="100px"
                                            style="object-fit: cover"
                                            alt="Card image cap">
                                          <div class="card-body d-flex justify-content-center">
                                            <?php if($client['address'] == ""): ?>
                                              <h5 class="text-bold">No address to show</h5>
                                            <?php endif; ?>
                                            <h5 class="card-title text-bold"><?= $client['address']; ?></h5>
                                          </div>
                                          <div class="card-footer d-flex justify-content-center">
                                              <h6 class="mb-2 text-muted">Address</h6>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-4">
                                        <div class="card mt-3" style="width: 15rem; height: 220px">
                                            <img class="card-img-top" 
                                            height="100px"
                                            style="object-fit: cover"
                                            src="https://th.bing.com/th/id/OIP.b4fmzMcI-x4KuYyYJltOgwHaHa?pid=ImgDet&rs=1" alt="Card image cap">
                                          <div class="card-body d-flex justify-content-center">
                                            <h5 class="card-title text-bold"><?= $client['experience']; ?> Level</h5>
                                          </div>
                                          <div class="card-footer d-flex justify-content-center">
                                              <h6 class="mb-2 text-muted">Experience Level</h6>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>      
                <!-- <div class="modal fade" id="view<?= $row['service_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                                </div>
                                <div class="modal-body">
                                <div class="post">
                                  <div class="user-block">
                                    <img class="profile-user-img img-fluid img-circle" src="admin/dist/img/default.jpg" alt="User profile picture">
                                    <span class="username" style="text-transform: capitalize;">
                                      <?= $client['firstname']; ?> <?= $client['lastname']; ?>
                                    </span>
                                    <span class="description"><?= $client['address']; ?></span>
                                  </div>
                                    <p class="text-capitalize">
                                      <b>Ratings: </b>
                                    <?php
                                      if (!empty($ratings_row['ave_rating'])) {
                                        echo round($ratings_row['ave_rating'], 2);
                                      } else{
                                        echo "No ratings yet";
                                      }
                                    ?>
                                    </p>
                                    <p class="text-capitalize">
                                      <b>Age: </b>
                                      <?= $client['age']; ?>
                                    </p>
                                    <p>
                                      <b>Email: </b>
                                      <?= $client['email']; ?>
                                    </p>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div> -->
    <?php
      endwhile;
    ?>

        </div>
        </div>

                  <div class="active tab-pane" id="proposal">
                        <div class="container">
    
      
            <?php
              $query = "SELECT proposal.job_title, job.job_id, proposal.description, proposal.rate, job.experience, job.firstname, job.middlename, job.lastname, 
                        (SELECT profile_picture FROM reg_db WHERE id = job.job_id) as profile_photo
                        FROM proposal_db proposal
                        JOIN job_db job
                        ON proposal.proposal_id = job.id
                        WHERE proposal.user_id = '$my_id'
                        AND proposal.status = '0'
                        AND proposal.delete_flg = '0';";

              $result = $db->query($query);
            

            ?>
           
            <?php
              while ($row = mysqli_fetch_assoc($result)):
                $profile_picture = $row['profile_photo'];
            ?>
                                        <div class="card"
                                          style="border-top: 10px solid #f0f2f5">
                                            <div class="card-body">
                                              <div class="card-title text-capitalize">
                                                  <div class="d-flex justify-content-start">
                                                    <?php if(file_exists("uploads/profile/client/".$profile_picture) && $profile_picture != null): ?>
                                                      <img src="uploads/profile/client/<?=$profile_picture?>" alt="User profile picture"
                                                      style="width: 3rem;height: 3rem;" class="img-circle mt-2">
                                                    <?php else: ?>
                                                        <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                                        style="width: 3rem;height: 3rem;" class="img-circle">
                                                    <?php endif; ?>
                                                    <a 
                                                        class="text-capitalize d-flex flex-column"
                                                        href="http://34.192.240.192/profile.php?log=<?= $row['job_id']?>"
                                                        >
                                                        <span class="fw-bold text-bold mt-2 ml-2">
                                                            <?= $row["firstname"] ?> <?= $row["middlename"] ?> <?= $row["lastname"] ?>
                                                        </span>
                                                        <span class="ml-2 text-sm text-dark">View Profile</span>
                                                    </a>
                                                  </div>
                                                  <div class="card-text mt-3">
                                                      <div class="d-flex flex-column">
                                                        <h6>
                                                            <span class="text-bold">Job Rate</span>: 
                                                            <span> Php. <?= $row["rate"] ?></span>
                                                            <span> - </span>
                                                            <span> <?= $row["experience"] ?> level </span>
                                                        </h6>
                                                        <p class="text-md">
                                                          <?= $row["description"] ?>
                                                        </p>
                                                      </div>
                                                      <h5 class="text-capitalize">
                                                            <span class="badge badge-pill p-2 text-dark"
                                                            style="background: #f0f2f5">
                                                                Pending
                                                            </span>
                                                      </h5>
                                                  </div>
                                              </div>
                                            </div>
                                        </div>
            <?php
              endwhile;
            ?>
             <?php 
                $query = "SELECT proposal.job_title, job.job_id, proposal.description, proposal.rate, job.experience, job.firstname, job.middlename, job.lastname
                  FROM proposal_db proposal
                  JOIN job_db job
                  ON proposal.proposal_id = job.id
                  WHERE proposal.user_id = '$my_id'
                  AND proposal.status = '0'
                  AND proposal.delete_flg = '0';";
                $result = $db->query($query);
                $res = mysqli_fetch_assoc($result);
                 if(empty($res)): 
                  ?>
                      <div class="d-flex flex-column">
                        <div class="d-flex justify-content-center">
                          <img src="images/result_no.png" alt=""
                              height="500px"
                              width="600px">
                        </div>
                        <div class="d-flex justify-content-center">
                          <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                        </div>
                      </div>         
            <?php endif; ?>
      </div>
      </div>

      <div class="tab-pane" id="client">
        <div class="container">

      <?php
        $query = "SELECT job.*, reg.`latitude`,reg.`longitude`, (SELECT latitude FROM reg_db WHERE id = '{$my_id}') AS my_lat, 
            (SELECT longitude FROM reg_db WHERE id = '{$my_id}') AS my_long,
            reg.subdivision, job.job_id, reg.barangay, reg.municipality, reg.email, reg.number, proposal.id as proposal_id
            FROM proposal_db proposal
            JOIN job_db job
            ON proposal.proposal_id = job.id
            JOIN reg_db reg
            ON job.job_id = reg.id
            WHERE proposal.user_id = '{$my_id}'
            AND proposal.id NOT IN (SELECT job_id FROM t_transaction_history_job
              WHERE client_id = '{$my_id}' AND worker_id = job.job_id
            AND job_type = '1')  
            AND proposal.status NOT IN (0,3)
            AND proposal.status != 4
            AND
            proposal.delete_flg = '0';";
        $result = $db->query($query);

        $i = 0;

        while($row = mysqli_fetch_assoc($result)):
          $reg_id = $row['job_id'];
          $proposal_id = $row['proposal_id'];

          $job_type = "1"; 
          $job_service_id = $row['proposal_id'];
          $worker_id = $row['job_id'];
          $client_id = $my_id;

          $i++;
      ?>

          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-capitalize text-bold">
                <?=$row['type_of_project']?>
              </h5>
              <div class="card-text"> 
                <h6><?=$row['title']?></h6>
                <hr>
                <div class="d-flex flex-column">
                      <a class="text-capitalize text-success text-bold"
                         href="http://34.192.240.192/profile.php?log=<?= $row['job_id']?>"
                        >
                        <?= $row['firstname']; ?> <?= $row['middlename']; ?> <?= $row['lastname']; ?>
                      </a>

                    <span><?=$row['email']?></span>
                    <span><?=$row['number']?></span>
                    <span class="text-capitalize"><?=$row['subdivision']?> <?=$row['barangay']?>, <?=$row['municipality']?></span>
                </div>
                <p class="mt-4">
                  <?=$row['description']?>
                </p>
              </div>
              <!-- <a href="map.php?client=<?=$reg_id?>&my_id=<?=$my_id?>" target="_blank" class="btn btn-primary"><i class="fas fa-search-location"></i> View Location</a> -->
              <button class="btn btn-danger" onclick="report_modal('<?=$my_id?>', '<?=$reg_id?>')" style="float:right;">Report</button>
              <button onclick="finish_job('<?=$proposal_id?>', '<?=$job_type ?>', '<?= $job_service_id ?>','<?= $worker_id ?>','<?= $client_id ?>')" class="btn btn-success"><i class="fa fa-check"></i> Finish Job</button>

              <div class="card-footer mt-3">
                <div id="map-container-google-1" class="z-depth-1-half map-container">
                  <iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/directions?origin=<?= $row['my_lat']?>,<?= $row['my_long']?>&destination=<?= $row['latitude']?>,<?= $row['longitude']?>&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe>
                </div>
              </div>
            </div>
          </div>
      <?php
        endwhile;
      ?>

      <?php
      $query = "SELECT proposal.id, proposal.create_user as client_id, service.id as service_id,
                reg.`latitude`,reg.`longitude`, (SELECT latitude FROM reg_db WHERE id = proposal.create_user) AS my_lat, 
                (SELECT longitude FROM reg_db WHERE id = proposal.create_user) AS my_long,
                (SELECT CONCAT(firstname,' ',lastname) FROM reg_db WHERE id = proposal.create_user) as client_name,
                (SELECT profile_picture FROM reg_db WHERE id = proposal.create_user) as profile_picture,
                service.services, service.description, service.name, service.rate, service.day_week, t_owner.experience, t_owner.id as owner_id, proposal.reg_id as proposal_reg_id
                FROM service_proposal proposal
                JOIN service_db service
                ON proposal.service_id = service.id
                JOIN reg_db reg
                ON proposal.reg_id = reg.id
                JOIN reg_db t_owner
                ON service.reg_id = t_owner.id
                WHERE proposal.delete_flg = '0'
                AND proposal.status NOT IN (0,3)
                AND proposal.status != 4
                AND service.id NOT IN (SELECT job_id FROM t_transaction_history 
                   WHERE client_id = '{$my_id}' AND worker_id = proposal.create_user
                AND job_type = '0')
                AND t_owner.id = '$my_id';";

      $result = $db->query($query);

      $i = 0;

      while ($row = mysqli_fetch_assoc($result)):
        $proposal_id = $row['id'];
        $owner_id = $row['proposal_reg_id'];

        $job_type = "0";
        $client_id = $row['client_id'];
        $worker_id = $my_id; 
        $job_service_id = $row['service_id'];

        $profile_picture = $row['profile_picture'];
        $i++;
    ?>

          <div class="card" style="background: #FFFDF6">
            <div class="card-body">
              <div class="card-title">
                <div class="d-flex">
                  <?php if(file_exists("uploads/profile/client/".$profile_picture) && $profile_picture != null): ?>
                    <img src="uploads/profile/client/<?=$profile_picture?>" alt="User profile picture"
                    style="width: 3rem;height: 3rem;" class="img-circle mt-1">
                  <?php else: ?>
                      <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                      style="width: 3rem;height: 3rem;" class="img-circle mt-1">
                  <?php endif; ?>
                  <div class="d-flex flex-column">
                    <a class="text-capitalize text-bold mt-1 ml-2"
                            href="http://34.192.240.192/profile.php?log=<?= $row['client_id']?>"
                            >
                      <?= $row['client_name']; ?>
                    </a>
                    <small class="ml-2">View Profile</small>
                  </div>
                </div>
                <h5 class="text-capitalize text-bold text-success mt-3">
                    <?=$row['services']?>
                </h5>
              </div>
              <div class="card-text"> 
                <div class="d-flex flex-column">
                    <span class="text-bold text-capitalize"><?=$row['rate']?> /<?=$row['day_week']?></span>
                    <span><?=$row['experience']?></span>
                </div>
                <p class="mt-4">
                  <?=$row['description']?>
                </p>

              </div>
                <!-- <a href="map.php?client=<?=$owner_id?>&my_id=<?=$my_id?>" target="_blank" class="btn btn-primary"><i class="fas fa-search-location"></i> View Location</a> -->
                <button class="btn btn-danger" onclick="report_modal('<?=$my_id?>', '<?=$owner_id?>')" style="float:right;">Report</button>
                <button onclick="finish_job2('<?=$proposal_id?>', '<?=$job_type ?>', '<?= $job_service_id ?>','<?= $worker_id ?>','<?= $client_id ?>')" class="btn btn-success"><i class="fa fa-check"></i> Finish Job</button>

              <div class="card-footer mt-3">
                <div id="map-container-google-1" class="z-depth-1-half map-container">
                  <iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/directions?origin=<?= $row['my_lat']?>,<?= $row['my_long']?>&destination=<?= $row['latitude']?>,<?= $row['longitude']?>&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe>
                </div>
              </div>
            </div>
          </div>
    <?php
      
      endwhile;

    ?>


      <div id="report_modal" style="margin-top:10%;" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
               <h5 class="text-bold">Submit a Report</h5>
             </div>
             <div class="modal-body">
              <form method="POST" enctype="multipart/form-data" class="modal-body">
                <input type="hidden" name="from_id" id="from_id">
                <input type="hidden" name="user_id" id="user_id">
                <div class="form-group">
                  <input type="text" id="subject" class="form-control" name="subject" placeholder="Subject" required>
                </div>
                <div class="form-group">
                  <textarea id="additional_comment" class="form-control" name="additional_comment" placeholder="Additional comment" required></textarea>
                </div>

                <div class="form-group">
                    <label for="profile_photo" class="mt-2">Upload Report Photo</label>
                      <div style="border: 1px solid lightgrey;
                        border-radius: 10px"
                        class="p-2">
                          <input type="file"
                          id="report_photo"
                          name="report_photo"
                          class="form-control-file">
                          <style>
                            ::-webkit-file-upload-button{
                              border: 1px solid lightgrey;
                              font-weight: bold;
                              padding: 5px;
                              border-radius: 8px;
                            }
                          </style>
                      </div>
                </div>
                <button type="submit" name="submit_report_btn" class="btn btn-danger text-center">Report</button>
                <a class="btn btn-secondary text-center" data-dismiss="modal">Cancel</a>
              </form>
             </div>
          </div>
        </div>
      </div>

      <button style="display: none;" data-toggle="modal" data-target="#report_modal" id="click_report_modal"></button>

      <script>
        function report_modal(from_id, user_id){
          $('#from_id').val(from_id);
          $('#user_id').val(user_id);

          $('#click_report_modal').click();
        }
      </script>

        </div>
      </div>
      <div class="tab-pane" id="finish">
        
      <div class="container">
    
      
      <?php
        $query = "SELECT job_db.*, t_transaction_history_job.worker_id as client_id,
        (SELECT profile_picture FROM reg_db WHERE id = t_transaction_history_job.worker_id) as profile_picture,
        t_transaction_history_job.job_id
        FROM 
        job_db 
        INNER JOIN proposal_db ON job_db.id = proposal_db.proposal_id
        INNER JOIN 
        t_transaction_history_job ON proposal_db.id = t_transaction_history_job.job_id
        WHERE proposal_db.id NOT IN (
            SELECT job_id FROM ratings WHERE 
            user_id = job_db.job_id  AND create_user = '{$my_id}'
        )
        AND t_transaction_history_job.client_id = '{$my_id}'";

        $result = $db->query($query);
        ?>
    
      <?php    
        while ($row = mysqli_fetch_assoc($result)):
          $client_id = $row['client_id'];
          $job_id = $row['job_id'];
      ?>
        <div class="card">
          <div class="card-body d-flex flex-column">
                    <div class="d-flex">
                        <?php if(file_exists("uploads/profile/client/".$row['profile_picture']) && $row['profile_picture'] != null): ?>
                              <img class="img-circle" src="uploads/profile/client/<?=$row['profile_picture']?>" alt="user image"
                              style="width: 3rem;
                              height: 3rem;">
                        <?php else: ?>
                              <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                              style="width: 3rem;
                              height: 3rem;" class="img-fluid img-circle">
                        <?php endif; ?>          
                        
                        <a class="d-flex flex-column" 
                        href="http://34.192.240.192/profile.php?log=<?= $row['create_user']?>"
                        style="font-size: 17px; cursor: pointer">
                          <span class="text-bold ml-2"><?=$row['firstname']?> <?=$row['lastname']?> </span>
                          <span class="ml-2 text-dark hover-me text-sm">View Profile</span>
                          <style>
                            .hover-me:hover{
                              text-decoration: underline;
                            }
                          </style>
                        </a>
                      </div>
              <!-- <a href="http://34.192.240.192/profile.php?log=<?= $row['client_id']?>"
              class="text-primary text-bold text-capitalize">
                <?=$row['firstname']?> <?=$row['lastname']?>
              </a> -->
              <span class="description text-sm mt-3">Posted - <?= Date("M/y/d h:i:s a", strtotime($row['time_posted']))?></span>
              <h5 class="text-success text-bold"><?=$row['title']?> </h5>
              <a href="add_rate.php?client_id=<?=$client_id?>&job_id=<?=$job_id?>&from=<?=$my_id?>" class="btn btn-success mt-3" style="float: right">Rate and Review Client</a>
          </div>
        </div>
    
      <?php
        endwhile;
      ?>




        <?php
          $query = "SELECT service_db.*, t_transaction_history.worker_id as client_id,
          t_transaction_history.job_id, reg_db.firstname, reg_db.lastname, reg_db.profile_picture
          FROM 
          service_db 
          INNER JOIN 
          t_transaction_history 
          ON service_db.id = t_transaction_history.job_id
          INNER JOIN reg_db ON t_transaction_history.worker_id = reg_db.id
          WHERE service_db.id NOT IN (
            SELECT job_id FROM ratings WHERE 
            user_id = t_transaction_history.worker_id  AND create_user = '{$my_id}')
          AND t_transaction_history.client_id = '{$my_id}'";

          $result = $db->query($query);
          ?>
      
        <?php    
          while ($row = mysqli_fetch_assoc($result)):
            $client_id = $row['client_id'];
            $job_id = $row['job_id'];
        ?>
          <div class="card">
            <div class="card-body d-flex flex-column">
                  <div class="d-flex">
                        <?php if(file_exists("uploads/profile/client/".$row['profile_picture']) && $row['profile_picture'] != null): ?>
                              <img class="img-circle" src="uploads/profile/client/<?=$row['profile_picture']?>" alt="user image"
                              style="width: 3rem;
                              height: 3rem;">
                        <?php else: ?>
                              <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                              style="width: 3rem;
                              height: 3rem;" class="img-fluid img-circle">
                        <?php endif; ?>          
                        
                        <a class="d-flex flex-column" 
                        href="http://34.192.240.192/profile.php?log=<?= $row['client_id']?>"
                        style="font-size: 17px; cursor: pointer">
                          <span class="text-bold ml-2"><?=$row['firstname']?> <?=$row['lastname']?> </span>
                          <span class="ml-2 text-dark hover-me text-sm">View Profile</span>
                          <style>
                            .hover-me:hover{
                              text-decoration: underline;
                            }
                          </style>
                        </a>
                    </div>
                <span class="description text-sm mt-3">Posted - <?= Date("M/y/d h:i:s a", strtotime($row['time']))?></span>
                <h5 class="text-success text-bold"><?=$row['services']?> </h5>

                <a href="add_rate.php?client_id=<?=$client_id?>&job_id=<?=$job_id?>&from=<?=$my_id?>" class="btn btn-success mt-3" style="float: right">Rate and Review Client</a>
            </div>
          </div>
      
        <?php
          endwhile;
        ?>

     
        </div>
      </div>
      <div class="tab-pane" id="history">
      <div class="table-responsive-lg">
                    <div class="card-body table-responsive-lg">
                    
                    <table id="example1" class="table table-light table-striped table-sm text-center
                    table-bordered">
                          <thead>
                          <tr>
                            <th>#</th>
                            <th>Client Name</th>
                            <th>Jobs</th>
                            <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php $x = 1; ?>
                              <?php
                                $query = "SELECT service_proposal.*, service_db.*, 
                                (SELECT firstname FROM reg_db WHERE id = service_proposal.create_user) AS firstname, 
                                (SELECT lastname FROM reg_db WHERE id = service_proposal.create_user) AS lastname
                                FROM service_proposal 
                                INNER JOIN service_db 
                                ON service_proposal.service_id = service_db.id
                                WHERE service_proposal.update_user = '{$my_id}'
                                AND service_proposal.`status` = 4";
                                $result = $db->query($query);
                                while($row = mysqli_fetch_assoc($result)):
                              ?>  

                                  <tr>
                                    <td> <?= $x ?> </td>
                                    <td class="text-capitalize text-bold"> <?=$row['firstname']?> <?=$row['lastname']?> </td>
                                    <td> <?=$row['services']?> </td>
                                    <?php if($row['status'] == "4"):?>
                                      <td class="text-danger text-bold">Rejected</td>
                                    <?php else: ?>
                                      <td class="text-success text-bold">Finished</td>
                                    <?php endif; ?>
                                  </tr>

                              <?php
                                ++$x;
                                endwhile;
                              ?>



                              <?php
                                $query = "SELECT c.id, 
                                service.services, service.description, service.name, service.rate, 
                                (SELECT firstname FROM reg_db WHERE id = proposal.create_user) as firstname, 
                                (SELECT lastname FROM reg_db WHERE id = proposal.create_user) as lastname, 
                                service.day_week, c.experience, service.id AS service_id
                                FROM service_proposal proposal
                                JOIN service_db service
                                ON proposal.service_id = service.id
                                JOIN reg_db reg
                                ON proposal.reg_id = reg.id
                                JOIN reg_db c
                                ON service.reg_id = c.id
                                WHERE proposal.status = '2'
                                AND proposal.delete_flg = '0'
                                AND service.id IN (
                                  SELECT job_id FROM ratings WHERE 
                                  create_user = '{$my_id}' AND user_id = proposal.create_user
                                )
                                AND proposal.reg_id = '{$my_id}';";
                                $result = $db->query($query);
                                while($row = mysqli_fetch_assoc($result)):
                              ?>  

                                  <tr>
                                    <td> <?= $x ?> </td>
                                    <td class="text-capitalize text-bold"> <?=$row['firstname']?> <?=$row['lastname']?> </td>
                                    <td> <?=$row['services']?> </td>
                                    <td class="text-success text-bold">Finished</td>
                                  </tr>

                              <?php
                                ++$x;
                                endwhile;
                              ?>




                              <?php
                                $query = "SELECT job_db.* FROM job_db
                                INNER JOIN proposal_db ON job_db.id = proposal_db.proposal_id
                                WHERE proposal_db.id IN (
                                SELECT job_id FROM ratings WHERE 
                                    create_user = '{$my_id}' AND user_id = job_db.job_id
                                ) AND proposal_db.user_id = '{$my_id}'";
                                $result = $db->query($query);
                                while($row = mysqli_fetch_assoc($result)):
                              ?>  

                                  <tr>
                                    <td> <?= $x ?> </td>
                                    <td class="text-capitalize text-bold"> <?=$row['firstname']?> <?=$row['lastname']?> </td>
                                    <td> <?=$row['title']?> </td>
                                    <td class="text-success text-bold">Finished</td>
                                  </tr>

                              <?php
                                ++$x;
                                endwhile;
                              ?>







                              <?php
                                $query = "SELECT job_db.firstname, job_db.lastname, 
                                proposal_db.job_title as services, proposal_db.status
                                FROM job_db
                                INNER JOIN proposal_db
                                ON job_db.id = proposal_db.proposal_id 
                                WHERE proposal_db.user_id = '{$my_id}'
                                AND proposal_db.status = '3'";
                                $result = $db->query($query);
                                while($row = mysqli_fetch_assoc($result)):
                              ?>  

                                  <tr>
                                    <td> <?= $x ?> </td>
                                    <td class="text-capitalize"> <?=$row['firstname']?> <?=$row['lastname']?> </td>
                                    <td> <?=$row['services']?> </td>
                                    <td class="text-danger text-bold">Declined</td>
                                  </tr>

                              <?php
                                ++$x;
                                endwhile;
                              ?>
                           </tbody>
                        </table> 
                      </div>
                    
                      </div>
                      <!-- /.tab-pane -->

                    
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
        <!-- /.content -->
      </div>
    </div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
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

<button style="display: none" id="toggle_modal" data-toggle="modal" data-target="#myModal">Modal Error</button>

<!-- Modal -->
<div id="myModal" style="margin-top:10%;" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p class="text-danger"><i class="fa fa-times"></i> Your skills are not qualified to apply in this job</p>
        <button class="btn btn-secondary text-center" data-dismiss="modal">OK</button>
      </div>
    </div>

  </div>
</div>

<script>
  $("#search_training").keyup(function(){
    var filter = $(this).val();
    $("#my_trainings .post #training_data").each(function(){
       if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).fadeOut();
       } else {
          $(this).show();
       }
    });
  });

  $("#search_training_services").keyup(function(){
    var filter = $(this).val();
    $(".post #services_data").each(function(){
       if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).fadeOut();
       } else {
          $(this).show();
       }
    });
  });
</script>


<script>
  function validate_skills(job_id, my_skills, skills_required){
    if (my_skills === skills_required) {
      window.location = 'admin/proposal.php?edit='+job_id;
    }
    else{
      $('#toggle_modal').click();
    }
  }
  function modify_proposal(service_id, type) {
    var validate;
    var request;
    if (type === 'accept') {
      request = 'service_proposal_accept';
      validate = confirm('Accept Proposal?');
    }
    else{
      request = 'service_proposal_decline';
      validate = confirm('Are you sure?');
    }
    if (validate === true) {
      $.ajax({
        method: 'post',
        url: 'ajax_request.php',
        data: {
          request: request,
          service_id:service_id
        },
        dataType: 'text',
        success:function(data){
          if (data === '1') {
            if (type === 'accept') {
              alert('Proposal Accepted');
            }
            else{
              alert('Proposal Declined');
            }
          }
          else{
            alert('An error occured');
          }
          window.location = 'freelance.php';
        }
      });
    }
  }

  function finish_job(proposal_id,job_type,job_service_id,worker_id,client_id) {
    var request = 'freelance_finish_job';

    if(confirm('Are you sure this job was finished?')){
      $.ajax({
        url: 'ajax_request.php',
        method: 'post',
        dataType: 'text',
        data: {
          request:request,
          proposal_id:proposal_id, 
          job_type: job_type, 
          job_service_id: job_service_id, 
          worker_id: worker_id, 
          client_id: client_id
        },
        success:function(data){
          if (data === '1') {
            alert("Service were finished successfully");
            window.location = 'freelance.php';
          }
          else{
            alert('An error occured');
          }
        }
      });
    }
  }

  function finish_job2(proposal_id,job_type,job_service_id,worker_id,client_id) {
    

    var request = 'freelance_finish_job2';

    var x = confirm('Are you sure this job was finished?');

    if (x === true) {
      $.ajax({
        url: 'ajax_request.php',
        method: 'post',
        dataType: 'text',
        data: {
          request:request,
          proposal_id:proposal_id, 
          job_type: job_type, 
          job_service_id: job_service_id, 
          worker_id: worker_id, 
          client_id: client_id
        },
        success:function(data){
          if (data === '1') {
            window.location = 'freelance.php';
          }
          else{
            alert('An error occured');
          }
        }
      });
    }
  }

  function report(from_id, user_id, uniq) {
    var request = 'report';

    var reason = $('#reason_'+uniq).val();

    $.ajax({
      url: 'ajax_request.php',
      method: 'post',
      data: {
        request: request,
        reason: reason,
        from_id: from_id,
        user_id: user_id
      },
      success:function(data){
        if (data === '1') {
          alert('Report submitted');
        }
        else if (data === '2') {
          alert('Report already submitted');
        }
        else{
          alert('An error occured');
        }
        window.location.reload()
      }
    });
  }

  function join_training(event_id, reg_id){
    var request = 'join_event';
    var x = confirm('Are you sure you want to join this training?');
    if (x === true) {
      $.ajax({
        url: 'ajax_request.php',
        method: 'post',
        data: {
          request:request,
          event_id:event_id,
          reg_id:reg_id
        },
        dataType: 'text',
        success:function(data){
          if(data == 1){
            alert('You have successfully joined to a training');
          }else if(data == 2){
            alert('Something wen\'\t wrong');
          }
          else if(data == 3){
            alert('This training have limited slot for accepting participants. Please check your email address and mobile number if there are accepted notification for this training. If there are no accepting notification sent into you, it means that this training reached the limited slot and will not accept your request to join this training.');
          }
          window.location.reload()
        }
      });
    }
  }
  function update_join_request(event_participants_id){
    var confirm_text = 'Are you sure you want remove this training?';

    var request = 'update_join_request';

    var x = confirm(confirm_text);

    var status = 2;

    if (x) {
      $.ajax({
        url: 'ajax_request.php',
        method: 'post',
        data: {
          status:status,
          event_participants_id:event_participants_id,
          request:request
        },
        success:function(data){
          if (data === '1') {
            alert('Your training were deleted successfully');
          } else {
            alert('Something went wrong in sending email');
          }
          window.location = 'freelance.php';
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

  <button style="display: none;" data-target="#send_payment" data-toggle="modal" id="send_payment_modal"></button>  

  <div id="send_payment" style="margin-top:10%;" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="text-bold">Send Payment</h5>
        </div>
        <form method="POST" enctype="multipart/form-data" class="modal-body">
          <h5>Send the proof of payments to inform trainor about your payments</h5>
          <input type="hidden" name="payment_my_id" id="payment_my_id">
          <input type="hidden" name="payment_event_id" id="payment_event_id">
           <div class="form-group">
              <label for="payment_proof" class="mt-2">Upload Payment Photo</label>
              <div style="border: 1px solid lightgrey;
                  border-radius: 10px"
                  class="p-2">
                  <input type="file" class="form-control-file" id="profile_photo" name="payment_proof">
                  <style>
                    ::-webkit-file-upload-button{
                    border: 1px solid lightgrey;
                    font-weight: bold;
                    padding: 5px;
                    border-radius: 8px;
                    }
                  </style>
              </div>
           </div>
          <div class="form-group">
            <textarea rows="3" class="form-control" name="payment_description" placeholder="Write a message (optional)"></textarea>
          </div>
          <button type="submit" name="submit_training_payment" class="btn btn-success"
          onClick='return confirmSubmit()'>Submit</button>
          <a class="btn btn-secondary text-center" data-dismiss="modal">Cancel</a>
        </form>
      </div>
    </div>
  </div>


<script>
   $('#filter_location').change(function(){
    var filter_by = $(this).val();
    var request = 'freelance'
    $.ajax({
      url: 'freelance.php',
      method: 'post',
      data: {
        filter_by:filter_by,
        request:request
      },
      success:function(data){
        window.location = 'freelance.php';
      }
    })
  })

  $("#remove_filter").click(function(){
    var isRemove = 1;
    $.ajax({
      url: 'freelance.php',
      method: 'post',
      data: {  remove_filter: isRemove },
      success:function(data){
        window.location = 'freelance.php';
      }
    })
  });

</script>
<script>
  function displayPaymentDescription(my_id, event_id){
    var payment_description = $("training" + event_id).val(); 
    $('#display_description_here').text(payment_description);
    $('#payment_my_id').val(my_id);
    $('#payment_event_id').val(event_id);
    $('#send_payment_modal').click();
  }
</script>


<script>
function confirmSubmit(){
  var agree= confirm("Are you sure you wish to continue?");
  if (agree)
  return true ;
  else
  return false ;
}
</script>