<?php 
  require_once '../core/init.php';
   // Delete module
  date_default_timezone_set('Asia/Manila');

   if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $query = $db->query("UPDATE freelance SET `deleted` = 1 WHERE `flid` = '$id'");
    echo '<script>
        alert("Deleted!");
        window.location="data.php";
      </script>';
   }

  if (isset($_POST['submit_btn'])) {
    $user_id = $_POST['user_id'];
    $id = $_POST['id'];

    $db->query("UPDATE reports_db SET delete_flg = '1' WHERE id = '$id';");

    if ($_POST['punishment'] == '1') {
      $month = date('m', strtotime("+1 month"));
      $penalty = date('Y-').$month.date('-d');
      $penalty_status = 1;
    } elseif ($_POST['punishment'] == '2') {
      $month = date('m', strtotime("+2 month"));
      $penalty = date('Y-').$month.date('-d');
      $penalty_status = 2;
    } elseif ($_POST['punishment'] == '3') {
      $month = date('m', strtotime("+3 month"));
      $penalty = date('Y-').$month.date('-d');
      $penalty_status = 3;
    } else {
      $penalty = '';
      $penalty_status = 4;
    }

    $db->query("INSERT INTO issues_db (until, user_id, status, valid) VALUES ('$penalty', '$user_id', '$penalty_status', '1');");

    header("Location: reports.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Pending post</title>

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
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      
    </ul>

    <!-- SEARCH FORM -->
    

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
          <li class="nav-header">Actions</li>
          <li class="nav-item">
            <a href="profile_verify.php" class="nav-link">
              <i class="nav-icon fa fa-check"></i>
              <p class="text">Profile Verification</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reports.php" class="nav-link active">
              <i class="nav-icon far fa-user"></i>
              <p>Reports</p>
            </a>
          </li>
        </ul>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card mt-3"
            style="height: 90vh">
              <div class="card-header">
                <div class="card-title">
                  <h3>List of Reported Accounts</h3>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Reported</th>
                    <th>Subject</th>
                    <th>Additional comment</th>
                    <th>Attachment</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $query = $db->query("SELECT reporter.firstname as reporter_firstname, reporter.lastname as reporter_lastname, reported.firstname as reported_firstname, reported.lastname as reported_lastname, reported.id as reported_id, report.subject, report.additional_comment, report.report_photo, report.id FROM reports_db report JOIN reg_db reporter ON report.from_id = reporter.id JOIN reg_db reported ON report.user_id = reported.id WHERE delete_flg = 0"); //Eto yung query
                      while($reports = mysqli_fetch_assoc($query)): //eto yung loop
                    ?>
                    <tr>
                      <td><?= $reports['reporter_firstname']." ".$reports['reporter_lastname']; ?></td>
                      <td><?= $reports['reported_firstname']." ".$reports['reported_lastname']; ?></td>
                      <td><?= $reports['subject']; ?></td>
                      <td><?= $reports['additional_comment']; ?></td>
                      <td>
                      <?php
                        if ($reports['report_photo'] === 'no_file') {
                      echo "No file";
                        } else {
                      ?>
                        <a href="../uploads/reports/<?=$reports['report_photo']?>" target="_blank">Attachment</a>
                      <?php
                        }
                      ?>
                      </td>
                      <td>
                      <div>
                      <button type="button" class="btn btn-success mx-1" data-toggle="modal" 
                      style="border-radius: 10px"
                      data-target="#punishment_modal_<?=$reports['id']?>">Accept
                      <button type="button" class="btn btn-danger" 
                    style="border-radius: 10px"
                      onclick="delete_report(' <?= $reports['id']?> ')">Decline
                        </div>
                      </td>
                    </tr>
                    <div class="modal fade" id="punishment_modal_<?=$reports['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                      <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="exampleModalLabel">Report</h5>
                          </div>
                          <div class="modal-body">
                            <form method="POST">
                              <input type="hidden" name="id" value="<?=$reports['id']?>">
                              <input type="hidden" name="user_id" value="<?=$reports['reported_id']?>">
                              <div class="form-group">
                                <select class="form-control" required name="punishment">
                                  <option disabled selected value="">Select Retribution</option>
                                  <option value="1">1 month suspension</option>
                                  <option value="2">2 months suspension</option>
                                  <option value="3">3 months suspension</option>
                                  <option value="4">Block Account</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <button class="btn btn-success w-100" name="submit_btn">Submit</button>
                                <button type="button" class="btn btn-secondary w-100 mt-2" data-dismiss="modal">Cancel</button>
                              </div>
                            </form>
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
      "responsive": true, "lengthChange": false, "autoWidth": true,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      "buttons": ["copy", "csv", "excel", "pdf"]
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
<script>
  function delete_report(id) {
    var x = confirm('Do you realy want to decline this report?');
    var request = 'decline_report';
    if (x === true) {
      $.ajax({
        url: '../ajax_request.php',
        method: 'post',
        data:{
          request:request,
          id:id
        },
        success:function(data){
          if (data === '2') {
            alert('An error occured');
          }
          window.location.reload()
        }
      });
    }
  }
</script>
