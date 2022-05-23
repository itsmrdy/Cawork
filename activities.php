<?php
  require_once 'core/init.php';


  $my_id = $_SESSION['userId'];

  date_default_timezone_set('Asia/Manila');

  $date_today = date('Y-m-d');
  $time_today = date('H:i');
  $whole_date_today = date('Y-m-d').'T'.date('H:i');

  $training_id = $_GET['training_id'];

  $query = $db->query("SELECT * FROM activities_db WHERE training_id = '$training_id' AND delete_flg = '0';");
  $sql = $db->query("SELECT * FROM activities_db WHERE training_id = '$training_id' AND delete_flg = '0';");

  $my_id = $_SESSION['userId'];
  $userData = $db->query("SELECT * FROM reg_db WHERE id = '$my_id';");
  $userDatas = mysqli_fetch_assoc($userData);

  $userType = $userDatas['user_type_id'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='calendar/lib/main.css' rel='stylesheet' />
<script src='calendar/lib/main.js'></script>
<title>Activity Calendar</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<body>

<?php
        while ($row = mysqli_fetch_assoc($sql)):
          $title = $row['activity_title'];
          $date_start = $row['activity_date_start'];
          $date_end = $row['activity_date_end'];
?>
<div class="modal fade" id="modalEvent<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success text-bold"><?= $title ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column">
          <p><?= $row['activity_description'] ?></p>
          <h6>Event Date: <span class="text-bold"><?= Date('Y/m/d h:i', strtotime($date_start)) ?> - <?= Date('Y/m/d h:i', strtotime($date_end)) ?></span></h6>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php endwhile; ?>
</body>

<script src="admin/plugins/jquery/jquery.min.js"></script>
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="admin/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="admin/dist/js/demo.js"></script>

<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      initialDate: '<?=$date_today?>',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      select: function(arg) {
        var dateToday = '<?=$date_today?>';
        var userType = <?=$userType?>;
        if (userType === 3) { 
          if (dateToday >= arg.startStr) {
            alert('You must select future dates');
          } else {
            dateSelected(arg)
          }
        }
        calendar.unselect()
      },
      editable: true,
      dayMaxEvents: false, // allow "more" link when too many events
      displayEventTime: false,
      eventClick: function(info) {
            var eventObj = info.event;
                if (eventObj.title) {
                    $('#modalEvent'+ eventObj.id).modal("show");
                }
            },
      events: [
      <?php
        while ($row = mysqli_fetch_assoc($query)) {
          $title = $row['activity_title'];
          $date_start = $row['activity_date_start'];
          $date_end = $row['activity_date_end'];

          $time_start = Date("h:i", strtotime($date_start));
          $time_end = Date("h:i", strtotime($date_end));
      ?>
        {
          id:    '<?= $row['id'] ?>',
          title: '<?=$time_start?> - <?=$time_end?>',
          start: '<?= $date_start ?>',
          end:   '<?= $date_end ?>',
          url: ''
        },
      <?php 
        }
      ?>
      ], 
    });

    calendar.render();
  });


</script>
</head>
<body>
  <a href="#" onclick="history.back()" style="margin-left: 10%;margin-top: 3%;" class="btn btn-danger">Back</a>
  <div id='calendar'></div>
  <button data-toggle="modal" style="display: none;" data-target="#add_activity_modal" id="edit_post_click">Click</button>
</body>
  <?php
    include_once 'modal.php';
  ?>
</html>
<!-- Trigger the modal with a button -->
<style>
  #modal_body{
    padding: 2rem;
  }
  #buttons{
    text-align: center;
  }
  #calendar{
    width: 60%;
    margin: auto;
    margin-top: 2rem;
    margin-bottom: 5rem;
    font-family: sans-serif;
  }
</style>
<script>
  $('#activity_error_fields').hide();
  $('#activity_date_error').hide();
  function dateSelected(calendarArg){
    console.log(calendarArg);
    $('#new_activity_start_date').val(calendarArg.startStr);
    $('#edit_post_click').click();
  }
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
            reg_id:reg_id,
            training_id: training_id
          },
          dataType: 'text',
          success:function(data){
            if (data === '1') {
              alert('Activity Added');
            }
            else{
              alert('An error occured');
            }
            window.location.reload();
          }
        });
      }
    }
  });
</script>