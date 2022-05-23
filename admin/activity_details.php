<?php
  require_once '../core/init.php';

  date_default_timezone_set('Asia/Manila');

  $activity_id = $_GET['activity'];

  $validate = $db->query("SELECT * FROM activities_db WHERE id = '$activity_id';");

  if (mysqli_num_rows($validate) > 0) {
    $activityData = mysqli_fetch_assoc($validate);

    $my_id = $_SESSION['userId'];

    $query = $db->query("SELECT user_type_id FROM reg_db WHERE id = '$my_id'");
    $user_data = mysqli_fetch_assoc($query);
    $user_type_id = $user_data['user_type_id'];

  } else {
?>
  <script>
    history.back();
  </script>
<?php
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Service Details</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="sidebar-is-closed sidebar-collapse">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
      <img src="../images/finallogo1.png" height="60" width="200">
      <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active rounded-lg" href="#">Activity Calendar</a></li>
            <li class="nav-item"><button class="btn btn-dark mx-2" id="home">Back</button></li>
      </ul>
      <ul class="navbar-nav ml-auto">
            <a href="../logout.php" class="btn btn-secondary"><i class="fas fa-power-off"></i></a>
        </li>
      </ul>
    </nav>
  
  
  <div class="content-wrapper">
    <div class="container"> 
            <br><br>
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Activity Detail<small></small></h3>
              </div>
              <div class="card-body">
                <h3 class="text-bold text-success"><?=$activityData['activity_title']?></h3>
                <div>
                  <p><?=$activityData['activity_description']?></p>
                </div>
                <p class="text-muted">Timeline: <span id="date_here"></span></p>
                
                <?php if($user_type_id == '3'): ?>
                  <button class="btn btn-primary" data-toggle="modal" data-target="#add_activity_modal">Edit Details</button>
                  <button class="btn btn-danger" onclick = "return confirmSubmit();">Delete</button>
                <?php endif; ?>
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
            <input type="text" class="form-control" id="new_activity_title" placeholder="Activity Title"
            value="<?= $activityData['activity_title'] ?>">
          </div>
          <div class="form-group">
            <label>
              Activity Date
            </label>
            <input type="text" readonly id="new_activity_start_date" class="form-control"
            value="<?= Date("Y-m-d", strtotime($activityData['activity_date_start'])) ?>">
          </div>
          <label>
            Activity Time
          </label>
          <div class="form-group">
            <input type="time" class="form-control" style="display: inline-block; width: 49%;" id="new_activity_start_time"
            value="<?= Date("h:i:s", strtotime($activityData['activity_date_start'])) ?>">
            <input type="time" class="form-control" style="display: inline-block; width: 49%;" id="new_activity_end_time"
            value="<?= Date("h:i", strtotime($activityData['activity_date_end'])) ?>">
          </div>
          <div class="form-group">
            <label>
              Description
            </label>
            <textarea class="form-control" id="new_activity_description" placeholder="Activity Description" rows="2"><?= $activityData['activity_description'] ?></textarea>
          </div>
          <div class="form-group">
            <p class="text-danger" id="activity_error_fields"><i class="fa fa-times"></i> All fields are required</p>
            <p class="text-danger" id="activity_date_error"><i class="fa fa-times"></i> Invalid Date</p>
            <button class="btn btn-primary" id="add_activity"><i class="fa fa-check"></i> Save</button>
            <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
          </div>
        </div>
      </div>
    </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
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
  $("#home").click(function(){
    window.history.back();
  });
  $('#activity_error_fields').hide();
  $('#activity_date_error').hide();

  $('#add_activity').click(function(){
    var request = 'add_activity';
    var activity_title = $('#new_activity_title').val();
    var activity_start_date = $('#new_activity_start_date').val();
    var activity_start_time = $('#new_activity_start_time').val();
    var activity_end_time = $('#new_activity_end_time').val();
    var activity_description = $('#new_activity_description').val();
    var whole_date_today = '<?=$whole_date_today?>';

    var reg_id = '<?=$my_id?>';

    var training_id = '<?=$training_id?>';

    var activity_id = "<?= $_GET['activity'] ?>";

    var activity_date_start = activity_start_date+'T'+activity_start_time;
    var activity_date_end = activity_start_date+'T'+activity_end_time;

    if (activity_title === '' || activity_start_date === '' || activity_start_time === '' || activity_end_time === '' || activity_description === '') {
      $('#activity_error_fields').fadeIn();
    } else {
      
      $('#activity_error_fields').hide();
    
        $.ajax({
          url: '../ajax_request.php',
          method: 'post',
          data: {
            request:request,
            activity_title:activity_title,
            activity_description:activity_description,
            activity_date_start:activity_date_start,
            activity_date_end:activity_date_end,
            reg_id:reg_id,
            training_id: training_id,
            activity_id: activity_id,
          },
          dataType: 'text',
          success:function(data){
            if (data === '1') {
              alert('Activity were update successfully');
            }
            else{
              alert("Something wen't wrong");
            }
            window.location.reload();
          }
        });
    }
  });
</script>

<script>
  function confirmSubmit(){
  var agree= confirm("Do you really want to delete this activity?");
  if (agree){
    var request = "remove_activity";
      var activity_id = "<?= $_GET['activity'] ?>";
      $.ajax({
          url: '../ajax_request.php',
          method: 'post',
          data: {
            request:request,
            activity_id: activity_id,
          },
          dataType: 'text',
          success:function(data){
            if (data === '1') {
              alert('Activity were deleted successfully');
              window.history.back();
            }
            else{
              alert("Something wen't wrong");
            }
            window.location.reload();
          }
      });
    return true;
  }else{
    return false;
  }
}
</script>

<script>
  $(document).ready(function(){
    var start_time = "<?=$activityData['activity_date_start']?>";
    var end_time = "<?=$activityData['activity_date_end']?>";

    var start = start_time.split('T');
    var end = end_time.split('T');

    var newText = start[1] + " to " + end[1];

    $('#date_here').text(newText);
  });
</script>
</body>
</html>