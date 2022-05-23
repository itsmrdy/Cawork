<?php 
  require_once '../core/init.php';
   // Delete module
   if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $query = $db->query("UPDATE freelance SET `deleted` = 1 WHERE `flid` = '$id'");
    echo '<script>
        alert("Deleted!");
        window.location="data.php";
      </script>';
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>
    <ul class="navbar-nav ml-auto">
      <a href="../logout.php" class="btn btn-secondary">Logout</a>
    </ul>
  </nav>
  <!-- /.navbar -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="mt-5">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li>
            <h5 class="fw-bold text-light ml-1">Cawork</h5>
            <hr color="white">
          </li>
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Data Management
              </p>
            </a>
          </li>
          <li class="nav-header">FUNCTIONS</li>
          <li class="nav-item">
            <a href="profile_verify.php" class="nav-link">
              <i class="nav-icon far fa-circle fa-square"></i>
              <p class="text">Profile Verification</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reports.php" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>Reports</p>
            </a>
          </li>
        </ul>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Trainor Pre-record</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-dark table-striped">
                  <thead>
                  <tr>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Username</th>
                    <th>Password</th>
                   
                   <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $query = $db->query("SELECT * FROM reg_db WHERE `user_type_id` ='3' AND status = '2';"); //Eto yung query
                      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
                        $user_id = $freelancer['id'];
                    ?>
                    <tr>
                      <td><?= $freelancer['firstname']; ?></td>
                      <td><?= $freelancer['middlename']; ?></td>
                      <td><?= $freelancer['lastname']; ?></td>
                      <td><?= $freelancer['age']; ?></td>
                      <td><?= $freelancer['address']; ?></td>
                      <td><?= $freelancer['username']; ?></td>
                      <td><?= $freelancer['password']; ?></td>
                      
                      <td>
                      <div>
                        <a type="button" class="btn btn-primary" href="http://34.192.240.192/profile.php?log=<?= $user_id?>">View</a>
                          <!--<a href="data.php?delete=<?= $freelancer['id']; ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-md">Delete</a>-->
                        </div>
                      </td>
                    </tr>
                    <div class="modal fade" id="exampleModal_<?=$user_id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Trainor Profile</h5>
                          </div>
                          <div class="modal-body text-center" style="text-align: center;">
                            <div style="background: url('../uploads/<?=$freelancer['profile_picture']?>');width: 8rem;height: 8rem;background-size: 100%;background-position: center;border-radius: 150rem;margin: auto;"></div>
                            <h4 class="text-primary" style="text-transform: capitalize;"><?=$freelancer['firstname']." ".$freelancer['middlename']." ".$freelancer['lastname']?></h4>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Address: </span><?=$freelancer['street_no'].", ".$freelancer['subdivision'].", ".$freelancer['barangay'].", ".$freelancer['municipality'].", ".$freelancer['province']?></p>
                            </div>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Number: </span><?=$freelancer['number']?></p>
                            </div>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Email Address: </span><?=$freelancer['email']?></p>
                            </div>
                          <?php
                            if (!empty($freelancer['age'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Age: </span><?=$freelancer['age']?></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['student_no'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Student Number: </span><?=$freelancer['student_no']?></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['course'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Course: </span><?=$freelancer['course']?></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['student_id'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Student ID: </span><a target="_blank" href="../uploads/<?=$freelancer['student_id']?>">View Attachment</a></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['experience'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Experience: </span><?=$freelancer['experience']?></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['skills'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Skills: </span><?=$freelancer['skills']?></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['position'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Position: </span><?=$freelancer['position']?></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['certificate'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Certificate: </span><a target="_blank" href="../uploads/<?=$freelancer['certificate']?>">View Attachment</a></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['primary_id'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Primary ID: </span><a target="_blank" href="../uploads/<?=$freelancer['primary_id']?>">View Attachment</a></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['secondary_id'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Secondary ID: </span><a target="_blank" href="../uploads/<?=$freelancer['secondary_id']?>">View Attachment</a></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['police_clearance'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Police Clearance: </span><a target="_blank" href="../uploads/<?=$freelancer['police_clearance']?>">View Attachment</a></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['diploma'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Diploma: </span><a target="_blank" href="../uploads/<?=$freelancer['diploma']?>">View Attachment</a></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['barangay_clearance'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Barangay Clearance: </span><a target="_blank" href="../uploads/<?=$freelancer['barangay_clearance']?>">View Attachment</a></p>
                            </div>
                          <?php
                            }
                          ?>
                          <?php
                            if (!empty($freelancer['diploma'])) {
                          ?>
                            <div class="form-group">
                              <p class="text-dark" style="text-transform: capitalize;"><span class="text-primary">Diploma: </span><a target="_blank" href="../uploads/<?=$freelancer['diploma']?>">View Attachment</a></p>
                            </div>
                          <?php
                            }
                          ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php endwhile; ?> <!-- Eto naman yung end ng while loop -->
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <b>NO FUNCTION UNDER CONSTRUCTION!</b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">OK</button>
      </div>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
