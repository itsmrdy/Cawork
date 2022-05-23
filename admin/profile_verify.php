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
    </ul>

    <ul class="navbar-nav ml-auto">
      <a href="../logout.php" class="btn btn-secondary">Logout</a>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
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
            <a href="profile_verify.php" class="nav-link active">
              <i class="nav-icon fa fa-check"></i>
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">
                 <h3>List of Registrants</h3>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="table-responsive-lg">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Type</th>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <th>Age</th>
                    <th>Gender</th>
                    
                    <th>Birthplace</th>
                    <th>Street</th>
                    <th>Subdivision</th>
                    <th>Barangay</th>
                    <th>Municipality</th>
                    <th>Zipcode</th>
                    <th>Number</th>
                    <th>Email</th>
                    <th>Education</th>
                    <th>Skills</th>
                    <th>Certificate</th>
                    <th>Primary ID</th>
                    <th>Secondary ID</th>
                    <th>Diploma</th>
                    <th>Barangay Clearance</th>
                    <th>Username</th>
                    <th>Password</th>

                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="text-sm">
                    <?php
                      $query = $db->query("SELECT * FROM reg_db WHERE status = '1';"); //Eto yung query
                      while($profile = mysqli_fetch_assoc($query)): //eto yung loop

                      $reg_id = $profile['id'];
                    ?>
                    <?php if($profile['user_type_id'] != 4): ?>
                      <tr>

                      <td>
                         <?php if(!empty($profile['profile_picture'])): ?>

                          <?php if($profile['user_type_id'] == 1):?>
                            <img style="width: 3rem; height: 3rem" src="../uploads/profile/client/<?=$profile['profile_picture']?>"
                            class="img-circle">
                          <?php elseif ($profile['user_type_id'] == 2): ?>
                            <img style="width: 3rem; height: 3rem" src="../uploads/profile/freelance/<?=$profile['profile_picture']?>"
                            class="img-circle">
                          <?php elseif ($profile['user_type_id'] == 3): ?>
                            <img style="width: 3rem; height: 3rem" src="../uploads/profile/trainor/<?=$profile['profile_picture']?>"
                            class="img-circle">
                          <?php endif; ?>

                        <?php else: ?> 
                          <img style="width: 3rem; height: 3rem" src="data:image/png;base64,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"
                            class="img-circle">
                        <?php endif; ?>
                      </td>
                      <td>
                      <?php
                        if ($profile['user_type_id'] === '1') {
                          echo "Client";
                        } elseif ($profile['user_type_id'] === '2') {
                          echo "Skilled Worker";
                        } elseif ($profile['user_type_id'] === '3') {
                          echo "Trainor";
                        } else {
                          echo "Administrator";
                        }
                      ?>
                      </td>
                      <td><?= $profile['firstname']; ?></td>
                      <td><?= $profile['middlename']; ?></td>
                      <td><?= $profile['lastname']; ?></td>
                      <td><?= $profile['age']; ?></td>
                      <td><?= $profile['gender']; ?></td>
                      <td><?= $profile['place_birth']; ?></td>
                      <td><?= $profile['street_no']; ?></td>
                      <td><?= $profile['subdivision']; ?></td>
                      <td><?= $profile['barangay']; ?></td>
                      <td><?= $profile['municipality']; ?></td>
                      <td><?= $profile['zipcode']; ?></td>
                      <td><?= $profile['number']; ?></td>
                      <td>
                        <?php if(!empty($profile['email'])): ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              <?= $profile['email']; ?>
                            </strong>
                          </i>
                        <?php else: ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              No email address included
                            </strong>
                          </i>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if (!empty($profile['education'])):  ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              <?= $profile['education']; ?>
                            </strong>
                          </i>
                        <?php else: ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              No attachment found
                            </strong>
                          </i>
                        <?php endif; ?>
                      </td>
                      <td>
                        
                      <?php if (!empty($profile['skills'])):  ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              <?= $profile['skills']; ?>
                            </strong>
                          </i>
                        <?php else: ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              No skills included
                            </strong>
                          </i>
                        <?php endif; ?></td>
                      <td>
                        <?php if (!empty($profile['certificate'])) { ?> 
                          <a target="_blank" 
                            href="
                            <?php 
                              if($profile['user_type_id'] == 1):
                                print("../uploads/documents/client/".$profile['certificate']);
                              elseif($profile['user_type_id'] == 2):
                                print("../uploads/documents/freelance/".$profile['certificate']);
                              elseif($profile['user_type_id'] == 3):
                                print("../uploads/documents/trainor/".$profile['certificate']);
                              endif; 
                            ?>
                            "
                          >
                            <?php if($profile['user_type_id'] == 1):?>
                              <a href="../uploads/documents/client/<?=$profile['certificate']?>" target="_blank"
                              class="float-right">
                                Attachment
                              </a>
                              <!--<img style="width: 3rem; height: 3rem; border-radius: 10px; float: right" src="../uploads/documents/client/<?=$profile['certificate']?>"> -->
                            <?php elseif ($profile['user_type_id'] == 2): ?>
                              <a href="../uploads/documents/freelance/<?=$profile['certificate']?>" target="_blank" class="float-right">
                                Attachment
                              </a>
                            <?php elseif ($profile['user_type_id'] == 3): ?>
                              <a href="../uploads/documents/trainor/<?=$profile['certificate']?>" target="_blank"  class="float-right">
                                Attachment
                              </a>
                            <?php endif; ?>
                          </a> 
                        <?php }
                           else { 
                        ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              No attachment found
                            </strong>
                          </i>
                        <?php 
                           } 
                        ?>
                      </td>
                      <td>
                        <?php if (!empty($profile['primary_id'])) { ?> 
                          <a target="_blank" href="
                             <?php 
                              if($profile['user_type_id'] == 1):
                                print("../uploads/documents/client/".$profile['primary_id']);
                              elseif($profile['user_type_id'] == 2):
                                print("../uploads/documents/freelance/".$profile['primary_id']);
                              elseif($profile['user_type_id'] == 3):
                                print("../uploads/documents/trainor/".$profile['primary_id']);
                              endif; 
                             ?>
                          ">
                            <?php if($profile['user_type_id'] == 1):?>
                              <a href="../uploads/documents/client/<?=$profile['primary_id']?>" target="_blank"
                              class="float-right">
                                Attachment
                              </a>
                            <?php elseif ($profile['user_type_id'] == 2): ?>
                              <a href="../uploads/documents/freelance/<?=$profile['primary_id']?>" target="_blank"
                              class="float-right">
                                Attachment
                              </a>
                            <?php elseif ($profile['user_type_id'] == 3): ?>
                              <a href="../uploads/documents/trainor/<?=$profile['primary_id']?>" target="_blank"
                              class="float-right">
                                Attachment
                              </a>
                            <?php endif; ?>
                          </a> 
                        <?php } 
                        else { 
                        ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              No attachment found
                            </strong>
                          </i>
                        <?php } ?>
                      </td>


                      <td>
                        <?php if (!empty($profile['secondary_id'])) { ?>
                          <a target="_blank" 
                            href="
                            <?php 
                              if($profile['user_type_id'] == 1):
                                print("../uploads/documents/client/".$profile['secondary_id']);
                              elseif($profile['user_type_id'] == 2):
                                print("../uploads/documents/freelance/".$profile['secondary_id']);
                              elseif($profile['user_type_id'] == 3):
                                print("../uploads/documents/trainor/".$profile['secondary_id']);
                              endif; 
                            ?>
                            "
                          >
                              <?php if($profile['user_type_id'] == 1):?>
                                <a href="../uploads/documents/client/<?=$profile['secondary_id']?>" target="_blank"
                                class="float-right">
                                  Attachment
                                </a>
                              <?php elseif ($profile['user_type_id'] == 2): ?>
                                <a href="../uploads/documents/freelance/<?=$profile['secondary_id']?>" target="_blank"
                                class="float-right">
                                  Attachment
                                </a>
                              <?php elseif ($profile['user_type_id'] == 3): ?>
                                <a href="../uploads/documents/trainor/<?=$profile['secondary_id']?>" target="_blank"
                                class="float-right">
                                  Attachment
                                </a>
                              <?php endif; ?>
                          </a> 
                        <?php } 
                        else { 
                        ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              No attachment found
                            </strong>
                          </i>
                        <?php 
                          } 
                        ?>
                      </td>
                      <td>
                        <?php if (!empty($profile['diploma'])) { ?> 
                          <a target="_blank" 
                            href="
                            <?php 
                              if($profile['user_type_id'] == 1):
                                print("../uploads/documents/client/".$profile['diploma']);
                              elseif($profile['user_type_id'] == 2):
                                print("../uploads/documents/freelance/".$profile['diploma']);
                              elseif($profile['user_type_id'] == 3):
                                print("../uploads/documents/trainor/".$profile['diploma']);
                              endif; 
                            ?>
                            "
                          >
                              <?php if($profile['user_type_id'] == 1):?>
                                <a href="../uploads/documents/client/<?=$profile['diploma']?>" target="_blank"
                                class="float-right">
                                  Attachment
                                </a>
                              <?php elseif ($profile['user_type_id'] == 2): ?>
                                <a href="../uploads/documents/freelance/<?=$profile['diploma']?>" target="_blank"
                                class="float-right">
                                  Attachment
                                </a>
                              <?php elseif ($profile['user_type_id'] == 3): ?>
                                <a href="../uploads/documents/trainor/<?=$profile['diploma']?>" target="_blank"
                                class="float-right">
                                  Attachment
                                </a>
                              <?php endif; ?>
                          </a> 
                        <?php } 
                        else { ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              No attachment found
                            </strong>
                          </i>
                        <?php } 
                        ?>
                      </td>
                      <td><?php if (!empty($profile['barangay_clearance'])) { ?> 
                        <a target="_blank" 
                            href="
                            <?php 
                              if($profile['user_type_id'] == 1):
                                print("../uploads/documents/client/".$profile['barangay_clearance']);
                              elseif($profile['user_type_id'] == 2):
                                print("../uploads/documents/freelance/".$profile['barangay_clearance']);
                              elseif($profile['user_type_id'] == 3):
                                print("../uploads/documents/trainor/".$profile['barangay_clearance']);
                              endif; 
                            ?>
                            "
                          >
                              <?php if($profile['user_type_id'] == 1):?>
                                <a href="../uploads/documents/client/<?=$profile['barangay_clearance']?>" target="_blank"
                                class="float-right">
                                  Attachment
                                </a>
                              <?php elseif ($profile['user_type_id'] == 2): ?>
                                <a href="../uploads/documents/freelance/<?=$profile['barangay_clearance']?>" target="_blank"
                                class="float-right">
                                  Attachment
                                </a>
                              <?php elseif ($profile['user_type_id'] == 3): ?>
                                <a href="../uploads/documents/trainor/<?=$profile['barangay_clearance']?>" target="_blank"
                                class="float-right">
                                  Attachment
                                </a>
                              <?php endif; ?>
                        </a> 
                        
                        <?php } else { ?>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              No attachment found
                            </strong>
                          </i>
                          <?php } ?></td>
                      
                      <td>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                            <?= $profile['username']; ?>
                            </strong>
                          </i>
                      </td>
                      <td>
                          <i class="ml-5 float-right">
                            <strong class="text-dark fw-bold">
                              <?= $profile['password']; ?>
                            </strong>
                          </i>
                      </td>
                    
                     
                      <td>
                        <div class="mt-3">
                          <button type="button" class="btn btn-success" onclick="update_status('<?=$reg_id?>', 2)"
                          style="border-radius: 10px">Accept</button>
                          <button type="button" class="btn btn-danger" onclick="update_status('<?=$reg_id?>', 3)"
                          style="border-radius: 10px">Decline</button>
                        </div>
                      </td>
                    </tr>
                    <?php endif; ?>
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
<script>
  function update_status(reg_id, status) {
    var request = 'change_profile_status';

    var text_confirm

    if (status === 2) {
      text_confirm = 'Are you sure you want to accept this request?';
    } else {
      text_confirm = 'Are you sure you want to decline this request?';
    }

    var x = confirm(text_confirm);

    if (x === true) {
      $.ajax({
        url: '../ajax_request.php',
        method: 'post',
        data: {
          request:request,
          status:status,
          reg_id:reg_id
        },
        success:function(data){
          if (data !== '1') {
            alert('An error occured');
          }
          window.location.reload();
        }
      });
    }
  }
</script>