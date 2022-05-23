<?php
  require_once 'core/init.php';
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
</head>
<body class="sidebar-is-closed sidebar-collapse">
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
            <input type="text" readonly id="new_activity_start_date" class="form-control">
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