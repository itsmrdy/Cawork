<?php
  require_once 'core/init.php';

  date_default_timezone_set('Asia/Manila');

  $date_today = date('Y-m-d');

  $query = $db->query("SELECT * FROM events_db WHERE delete_flg = '0';");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='calendar/lib/main.css' rel='stylesheet' />
<script src='calendar/lib/main.js'></script>
<script src="admin/plugins/jquery/jquery.min.js"></script>
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
      minDate: 0,
      select: function(arg) {
        // var title = prompt('Event Title:');
        // if (title) {
        //   calendar.addEvent({
        //     title: title,
        //     start: arg.start,
        //     end: arg.end,
        //     allDay: arg.allDay
        //   })
        // }
        var date_today = '<?=$date_today?>';
        if (date_today < arg.startStr) {
          $('#click_modal').click();
          $('#start_at').val(arg.startStr);
        }
        calendar.unselect()
      },
      // eventClick: function(arg) {
      //   if (confirm('Are you sure you want to delete this event?')) {
      //     arg.event.remove()
      //   }
      // },
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
        <?php
          while ($row = mysqli_fetch_assoc($query)) {
            $id = $row['id'];
            $title = $row['title'];
            $start_at = $row['start_at'];
            $end_at = $row['end_at'];
            echo "{title: '".$title."', start: '".$start_at."', end: '".$end_at."', url: 'admin/join_training.php?event_id=".$id."'},";
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
</style>