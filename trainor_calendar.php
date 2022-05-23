<?php
  require_once 'core/init.php';

  date_default_timezone_set('Asia/Manila');

  $date_today = date('Y-m-d');
  $time_today = date('H:i');
  $whole_date_today = date('Y-m-d').'T'.date('H:i');

  $query = $db->query("SELECT * FROM activities_db WHERE reg_id = '$my_id' AND delete_flg = '0';");

?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='calendar/lib/main.css' rel='stylesheet' />
<script src='calendar/lib/main.js'></script>
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
        calendar.unselect()
      },
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
      <?php
        while ($row = mysqli_fetch_assoc($query)) {
          $title = $row['activity_title'];
          $date_start = $row['activity_date_start'];
          $date_end = $row['activity_date_end'];
      ?>
        {
          title: '<?=$title?>',
          start: '<?=$date_start?>',
          end: '<?=$date_end?>'
        },
      <?php 
        }
      ?>
      ]
    });

    calendar.render();
  });

</script>
</head>
<body>

  <div id='calendar'></div>

</body>
</html>
<!-- jQuery -->
<script src="admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="admin/dist/js/demo.js"></script>
<!-- Trigger the modal with a button -->
<style>
  #modal_body{
    padding: 2rem;
  }
  #buttons{
    text-align: center;
  }
  #calendar{
    width: 80%;
    margin: auto;
  }
</style