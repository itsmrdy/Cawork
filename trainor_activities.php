<?php
  require_once 'core/init.php';

  date_default_timezone_set('Asia/Manila');

  $date_today = date('Y-m-d');

  $query = $db->query("SELECT * FROM events_db WHERE reg_id = '$id' AND delete_flg = '0';");
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
            $title = $row['title'];
            $start_at = $row['start_at'];
            $end_at = $row['end_at'];
            echo "{title: '".$title."', start: '".$start_at."', end: '".$end_at."'},";
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
<button type="button" id="click_modal" style="display: none;" data-toggle="modal" data-target="#myModal">Open Modal</button>
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
<!-- Modal -->
<input type="hidden" id="error_status">
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin-top: 7%;margin-bottom: 7%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body" id="modal_body">
        <h4>Add Event</h4>
        <div class="form-group">
          <p class="text-danger" id="error_fields"><i class="fa fa-times"></i> All fields are required</p>
          <input type="text" class="form-control" name="title" id="title" placeholder="Event Name">
        </div>
        <div class="form-group">
          <textarea class="form-control" name="description" id="description" placeholder="Event Description" rows="2"></textarea>
        </div>
        <div class="form-group">
          <select id="training_type" class="form-control">
            <option disabled selected value="empty">Training type</option>
            <option>Face to face</option>
            <option>Module</option>
            <option>Online Training</option>
          </select>
        </div>
        <div class="form-group">
          <select id="mode_of_payment" class="form-control">
            <option disabled selected value="empty">Mode of Payment</option>
            <option>GCash</option>
            <option>Paypal</option>
            <option>Bank</option>
            <option>Remittance</option>
          </select>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="start_at" id="start_at" readonly>
        </div>
        <div class="form-group"><center>
          <p class="text-danger" id="error_time"><i class="fa fa-times"></i> Please select a valid time</p>
          <select class="form-control" style="display: inline-block; width: 49%;" name="start_time" id="start_time">
            <option value="empty">From</option>
            <option value="08:00">8:00am</option>
            <option value="08:30">8:30am</option>
            <option value="09:00">9:00am</option>
            <option value="09:30">9:30am</option>
            <option value="10:00">10:00am</option>
            <option value="10:30">10:30am</option>
            <option value="11:00">11:00am</option>
            <option value="11:30">11:30am</option>
            <option value="13:00">1:00pm</option>
            <option value="13:30">1:30pm</option>
            <option value="14:00">2:00pm</option>
            <option value="14:30">2:30pm</option>
            <option value="15:00">3:00pm</option>
            <option value="15:30">3:30pm</option>
            <option value="16:00">4:00nn</option>
            <option value="16:30">4:30pm</option>
          </select>
          <select class="form-control" style="display: inline-block; width: 49%;" name="end_time" id="end_time">
            <option value="empty">To</option>
            <option value="08:30">8:30am</option>
            <option value="09:00">9:00am</option>
            <option value="09:30">9:30am</option>
            <option value="10:00">10:00am</option>
            <option value="10:30">10:30am</option>
            <option value="11:00">11:00am</option>
            <option value="11:30">11:30am</option>
            <option value="13:00">1:00pm</option>
            <option value="13:30">1:30pm</option>
            <option value="14:00">2:00pm</option>
            <option value="14:30">2:30pm</option>
            <option value="15:00">3:00pm</option>
            <option value="15:30">3:30pm</option>
            <option value="16:00">4:00nn</option>
            <option value="16:30">4:30pm</option>
            <option value="17:00">5:00pm</option>
          </select>
        </center></div>
        <div class="form-group" id="buttons">
          <button class="btn btn-success" id="submit_modal"><i class="fa fa-check"></i> Add</button>
          <button class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </div>

  </div>
</div>
<script>
  $('#error_time').hide();
  $('#error_status').val(1);
  $('#error_fields').hide();
  $('#title').on('keyup', function(){
    var start = $('#start_time').val();
    var end = $('#end_time').val();

    if (start === end) {
      $('#error_time').fadeIn();
      $('#error_status').val(1)
    }
    else{
      $('#error_time').fadeOut();
      if ($('#start_time').val() !== 'empty' && $('#end_time').val() !== 'empty' && $('#title').val() !== '' && $('#description').val() !== '' && $('#training_type').val() !== 'empty' && $('#mode_of_payment').val() !== 'empty') {
        $('#error_status').val(2);
      }
      else{
        $('#error_status').val(1); 
      }
    }
  });
  $('#description').on('keyup', function(){
    var start = $('#start_time').val();
    var end = $('#end_time').val();

    if (start >= end) {
      $('#error_time').fadeIn();
      $('#error_status').val(1)
    }
    else{
      $('#error_time').fadeOut();
      if ($('#start_time').val() !== 'empty' && $('#end_time').val() !== 'empty' && $('#title').val() !== '' && $('#description').val() !== '' && $('#training_type').val() !== 'empty' && $('#mode_of_payment').val() !== 'empty') {
        $('#error_status').val(2);
      }
      else{
        $('#error_status').val(1); 
      }
    }
  });
  $('#training_type').on('change', function(){
    var start = $('#start_time').val();
    var end = $('#end_time').val();

    if (start >= end) {
      $('#error_time').fadeIn();
      $('#error_status').val(1)
    }
    else{
      $('#error_time').fadeOut();
      if ($('#start_time').val() !== 'empty' && $('#end_time').val() !== 'empty' && $('#title').val() !== '' && $('#description').val() !== '' && $('#training_type').val() !== 'empty' && $('#mode_of_payment').val() !== 'empty') {
        $('#error_status').val(2);
      }
      else{
        $('#error_status').val(1); 
      }
    }
  });
  $('#mode_of_payment').on('change', function(){
    var start = $('#start_time').val();
    var end = $('#end_time').val();

    if (start >= end) {
      $('#error_time').fadeIn();
      $('#error_status').val(1)
    }
    else{
      $('#error_time').fadeOut();
      if ($('#start_time').val() !== 'empty' && $('#end_time').val() !== 'empty' && $('#title').val() !== '' && $('#description').val() !== '' && $('#training_type').val() !== 'empty' && $('#mode_of_payment').val() !== 'empty') {
        $('#error_status').val(2);
      }
      else{
        $('#error_status').val(1); 
      }
    }
  });
  $('#start_time').on('change', function(){
    var start = $(this).val();
    var end = $('#end_time').val();

    if (start >= end) {
      $('#error_time').fadeIn();
      $('#error_status').val(1)
    }
    else{
      $('#error_time').fadeOut();
      if ($('#start_time').val() !== 'empty' && $('#end_time').val() !== 'empty' && $('#title').val() !== '' && $('#description').val() !== '' && $('#training_type').val() !== 'empty' && $('#mode_of_payment').val() !== 'empty') {
        $('#error_status').val(2);
      }
      else{
        $('#error_status').val(1); 
      }
    }
  });
  $('#end_time').on('change', function(){
    var start = $('#start_time').val();
    var end = $(this).val();

    if (start >= end) {
      $('#error_time').fadeIn();
      $('#error_status').val(1)
    }
    else{
      $('#error_time').fadeOut();
      if ($('#start_time').val() !== 'empty' && $('#end_time').val() !== 'empty' && $('#title').val() !== '' && $('#description').val() !== '' && $('#training_type').val() !== 'empty' && $('#mode_of_payment').val() !== 'empty') {
        $('#error_status').val(2);
      }
      else{
        $('#error_status').val(1); 
      }
    }
  });
  $('#submit_modal').click(function(){
    if ($('#error_status').val() === '1') {
      $('#error_fields').fadeIn();
    }
    else{
      var title = $('#title').val();
      var description = $('#description').val();
      var training_type = $('#training_type').val();
      var mode_of_payment = $('#mode_of_payment').val();
      var start_at = $('#start_at').val()+'T'+$('#start_time').val();
      var end_at = $('#start_at').val()+'T'+$('#end_time').val();
      var reg_id = '<?=$id?>';
      var request = 'add_training';
      $.ajax({
        url: 'ajax_request.php',
        method: 'post',
        data: {
          request:request,
          title:title,
          training_type:training_type,
          mode_of_payment:mode_of_payment,
          description:description,
          start_at:start_at,
          end_at:end_at,
          reg_id:reg_id
        },
        dataType: 'text',
        success:function(data){
          if (data === '1') {
            alert('Training Added');
          }
          else{
            alert('An error occured');
          }
          window.location = 'trainor.php';
        }
      });
    }
  });
</script>