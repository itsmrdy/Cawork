<?php
  require_once 'core/init.php';

  $id = $_COOKIE['id'];
  
  
  $result = $db->query("SELECT *, CONCAT(firstname,' ',lastname) AS name FROM reg_db WHERE id = $id");
  
  $fetch = mysqli_fetch_assoc($result);
  $name = $fetch['name'];
  $job = $fetch['skills'];
  $location = $fetch['address'];
  $experience = $fetch['experience'];
  $email = $fetch['email'];
  $position = $fetch['position'];


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
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
</head>
<body class="sidebar-is-closed sidebar-collapse">
<!-- <body class="hold-transition sidebar-mini"> -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-dark"  style="position: -webkit-sticky !important; /* for Safari */ position: sticky; top: 0.0em; align-self: flex-start;">
  <img src="images/finallogo.jpg" height="50" width="200">
    <!-- Left navbar links -->
    <!-- <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
</ul> -->

      <ul class="nav nav-pills">
        
      <!--img src="images/taelang.jpg" alt="logo">-->
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Find Jobs</a></li>
                  <li class="nav-item"><a class="nav-link" href="#Discover" data-toggle="tab">Trainings</a></li>
                  <!--<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>-->
               
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-post form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <!--li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">-->
            <!-- Message Start -->
            <!--div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>-->
            <!-- Message End -->
         
            <!-- Message Start -->
            <!--div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>-->
            <!-- Message End -->
          </a>
          <!--div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">-->
            <!-- Message Start -->
            <!--div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>-->
            <!-- Message End -->
          
      <!-- Notifications Dropdown Menu -->
    
      <a href="logout.php" class="btn btn-secondary">Logout</a>
    </ul>
  </nav>
  <!-- /.navbar -->

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <?php include 'admin/includes/back.html'; ?>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <div class="logo">
          <!-- this for logo 

-->
           
          </div>
</div>
         
      </div><!-- /.container-fluid --> 
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3" style="position: -webkit-sticky !important; /* for Safari */ position: sticky; top: 5.5em; align-self: flex-start;">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="admin/dist/img/avatar4.png"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?= $name;?></h3>

                <p class="text-muted text-center">Client</p>

                <!--ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Rate</b> <a class="float-right">₱50.00 /hour</a>
                  </li>
                  <li class="list-group-item">
                    <b>Availability</b> <a class="float-right">30+hrs /week</a>
                  </li>
                  <li class="list-group-item">
                    <b> Jobs</b> <a class="float-right">15</a>
                  </li>
                  <li class="list-group-item">
                    <b> Experience</b> <a class="float-right">Expert</a>
                  </li>
                 
                </ul>-->
                <a href="admin/mypost_client.php" class="btn btn-primary btn-block"><b>My Post</b></a>
                <a href="admin/post1.php" class="btn btn-primary btn-block"><b>Post Jobs</b></a>
                <a href="admin/client_profile.php?edit=<?=$id?>" class="btn btn-primary btn-block"><b>Update profile</b></a>
                <a href="admin/active_proposal.php" class="btn btn-dark btn-block"><b>View Proposals</b></a>
               
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Jobs</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i>Position</strong>
               
                <p class="text-muted">
                <?= $position;?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?= $location;?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Experience Level</strong>

                <p class="text-muted"> 
                  <span class="tag tag-danger"><?= $experience;?> </span>
                  <!--span class="tag tag-success">Web Designer, </span>
                  <span class="tag tag-info">Taga Hugas ng plato</span>-->
                 
               
                </p>
                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Email</strong>

                <p class="text-muted"><?= $email;?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
          <div id="posts"></div>
          <button class="btn btn-success" onclick="display_posts();">See More</button>
            <div class="card">
              <div class="card-header p-2">
                
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <?php
                      $query = $db->query("SELECT * FROM service_db "); //Eto yung query
                      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
                    ?>
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="admin/dist/img/avatar2.png" alt="user image">
                        <span class="username">
                          <a href="#"><?= $freelancer['name']; ?> </a>
                          
                        </span>
                        <span class="description">Posted - 7:30 PM today</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                      <?= $freelancer['skills']; ?></p>
                      <p>
                      ₱<?= $freelancer['rate']; ?> <?= $freelancer['day_week']; ?></p>
                      <p>
                      <?= $freelancer['description']; ?></p>
                      
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#view<?= $freelancer['reg_id']; ?>">View profile</button>
                       
                      </p>
                      </div>
                      <?php endwhile; ?> <!-- Eto naman yung end ng while loop -->
                   
                    </div>
                    <!-- /.post -->

                   
                    <!-- /.post -->
                  
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="Discover">
                  <?php
                      $query = $db->query("SELECT * FROM training_db "); //Eto yung query
                      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
                    ?>
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="admin/dist/img/unisex.jpg" alt="user image">
                        <span class="username">
                          <a href="#"><?= $freelancer['name']; ?> </a>
                          
                        </span>
                        <span class="description">Posted - 7:30 PM today</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                      <b>Training Name:</b> <?= $freelancer['training_title']; ?></p>
                      <p>
                      <b> Description: :</b>  <?= $freelancer['description']; ?> </p>
                      <p>
                      <b>Training type:</b> <?= $freelancer['training_type']; ?></p>
                      <p>
                      <b> Payment Method: :</b>  <?= $freelancer['payment_method']; ?> </p>
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#view<?= $freelancer['training_id']; ?>">View profile</button>
                       
                      </p>
                      </div>
                      <?php endwhile; ?> <!-- Eto naman yung end ng while loop -->
                   
                    </div>
                    <!-- /.post -->
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      </div>
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
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Kennyjepollo15@gmail.com</b> 09652248221
    </div>
    <strong>Cavite State University CCAT CAMPUS </strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- MODAL -->
<?php
                      $query = $db->query("SELECT * FROM reg_db "); //Eto yung query
                      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
                    ?>

<div class="modal fade" id="view<?= $freelancer['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
        
     
      </div>
      <div class="modal-body">
      <div class="post">
                      <div class="user-justify">
                      <img class="profile-user-img img-fluid img-circle"
                       src="admin/dist/img/avatar2.png"
                       alt="User profile picture">
                        <span class="username">
                          <a href="#"><?= $freelancer['firstname']; ?> <?= $freelancer['lastname']; ?></a>
                          
                        </span>
                        
                        
                      </div>
                      <!-- /.user-block -->
                      <p>
                      <b>Skills: </b><?= $freelancer['skills']; ?></p>
                      <p>
                      <b>Rate: </b>₱ <?= $freelancer['rate']; ?></p>
                      <p>
                      <b>Experience Level: </b><?= $freelancer['experience']; ?> </p>
                      <p>
                      <b>Age: </b><?= $freelancer['age']; ?></p>
                      <p>
                      <b>Email: </b><?= $freelancer['email']; ?></p>
                      <p>
                      <b>Education: </b><?= $freelancer['education']; ?> </p>
                      
                      
                      
                      </p>

                     
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success">Invite</button>
      </div>
    </div>
  </div>
</div>
<?php endwhile; ?> <!-- Eto naman yung end ng while loop -->
<!-- MODAL2 -->




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
