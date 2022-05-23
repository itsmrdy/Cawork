<?php
  require_once 'core/init.php';

  date_default_timezone_set('Asia/Manila');

  $date_today = date('Y-m-d');
  $time_today = date('H:i');
  $whole_date_today = date('Y-m-d').'T'.date('H:i');
  $plus_five = date('d', strtotime("+5 days"));
  $plus_five_date = date('Y-m-').$plus_five;

?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='calendar/lib/main.css' rel='stylesheet' />
<script src='calendar/lib/main.js'></script>
<script src="admin/plugins/jquery/jquery.min.js"></script>
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
<!-- Modal -->
<input type="hidden" id="error_status">
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin-top: 2%;margin-bottom: 7%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body" id="modal_body">
        <h4>Add Event</h4>
        <div id="training_tabs">
          <ul>
            <li id="form_1_indicator" class="active">Step 1</li>
            <li id="form_2_indicator" class="inactive">Step 2</li>
            <li id="form_3_indicator" class="inactive">Step 3</li>
          </ul>
        </div>
        <div id="form_1" class="form_modal_active">
          <h3>Training Information</h3>
          <div class="form-group">
            <label>
              Title
            </label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Training Title">
          </div>
          <div class="form-group">
            <label>
              Training type
            </label>
            <select id="training_type" class="form-control">
              <option selected>Face to face</option>
              <option>Module</option>
              <option>Online Training</option>
            </select>
          </div>
          <div class="form-group">
            <label>
              Date
            </label>
            <input type="date" name="date_start" id="date_start" class="form-control">
          </div>
          <div class="form-group">
            <label>
              Number of Participants
            </label>
            <input type="number" min="1" max="100" name="participants" id="participants" class="form-control" placeholder="How many participants will be occupied">
          </div>
          <div class="form-group">
            <label>
              Field
            </label>
            <input type="text" name="field" id="field" class="form-control" placeholder="In which field the training include">
          </div>
          <div class="form-group">
            <label>
              Platform
            </label>
            <input type="text" name="platform" id="platform" class="form-control" placeholder="What platform will be used in the training">
          </div>
          <div class="form-group">
            <label>
              Description
            </label>
            <textarea class="form-control" name="description" id="description" placeholder="Write a short description about this training" rows="2"></textarea>
          </div>
        </div>
        <div id="form_2" class="form_modal_inactive">
          <h3>Payment</h3>
          <div class="form-group">
            <label>
              Fee(Php)
            </label>
            <input type="number" id="training_price" min="0" name="training_price" class="form-control" placeholder="How much is this training?">
          </div>
          <div class="form-group">
            <label>
              Mode of Payment
            </label>
            <select id="mode_of_payment" class="form-control">
              <option selected>GCash</option>
              <option>Paypal</option>
              <option>Bank</option>
              <option>Remittance</option>
            </select>
          </div>
          <div class="form-group">
            <p>
              Please read carefully
              <br>
              Note: Write the complete information about the payment method of thsi training. Include link, number and any important details on how the participants can send their payment
              <br><br>
              Once the participants join the training, this payment information willbe also include in the <strong>email notification</strong>
              <br><br>
              Please ake sure to chec if the participat made the payment. If they did not pay on time, you can remove them from participants.
            </p>
          </div>
          <div class="form-group">
            <label>Payment Details</label>
            <textarea class="form-control" id="payment_description" rows="2" placeholder="Write complete information about payment"></textarea>
          </div>
          <div class="form-group">
            <label>Start of Payment</label>
            <input type="date" id="payment_start_date" class="form-control">
          </div>
          <div class="form-group">
            <label>End of Payment</label>
            <input type="date" id="payment_end_date" class="form-control">
          </div>
        </div>
        <div id="form_3" class="form_modal_inactive">
          <h3>Set Calendar Activities</h3>
          <div class="form-group">
            <label>
              Title
            </label>
            <input type="text" class="form-control" id="activity_title" placeholder="Activity Title">
          </div>
          <div class="form-group">
            <label>
              Activity Date
            </label>
            <input type="date" id="activity_start_date" class="form-control">
          </div>
          <label>
            Activity Time
          </label>
          <div class="form-group">
            <input type="time" class="form-control" style="display: inline-block; width: 49%;" id="activity_start_time">
            <input type="time" class="form-control" style="display: inline-block; width: 49%;" id="activity_end_time">
          </div>
          <div class="form-group">
            <label>
              Description
            </label>
            <textarea class="form-control" id="activity_description" placeholder="Activity Description" rows="2"></textarea>
          </div>
        </div>
        <div class="form-group" id="buttons">
          <p class="text-danger" id="error_fields"><i class="fa fa-times"></i> All fields are required</p>
          <p class="text-danger" id="error_fields2"><i class="fa fa-times"></i> All fields are required</p>
          <p class="text-danger" id="error_fields3"><i class="fa fa-times"></i> All fields are required</p>
          <p class="text-danger" id="date_error"><i class="fa fa-times"></i> Invalid Date</p>
          <p class="text-danger" id="date_error2"><i class="fa fa-times"></i> Invalid Date</p>
          <p class="text-danger" id="date_error3"><i class="fa fa-times"></i> Invalid Date</p>
          <div id="form_1_buttons" class="form_modal_active">
            <button class="btn btn-primary" id="next_modal" class="">Next</button>
            <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          </div>
          <div id="form_2_buttons" class="form_modal_inactive">
            <button class="btn btn-primary" id="next_modal1" class="">Next</button>
            <button class="btn btn-warning" id="back_modal1" class="">Back</button>
            <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          </div>
          <div id="form_3_buttons" class="form_modal_inactive">
            <button class="btn btn-success" id="submit_both_modal" class="">Post</button>
            <button class="btn btn-secondary" id="submit_modal" class="">Skip</button>
            <button class="btn btn-warning" id="back_modal" class="">Back</button>
            <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<style>
  #training_tabs{
    width: 90%;
    margin: auto;
    text-align: center;
  }
  #training_tabs ul{
    padding: 0;
    text-align: center;
  }
  #training_tabs ul li{
    width: 32%;
    display: inline-block;
    margin: auto;
  }
  #training_tabs ul .active{
    background: #212121;
    color: white;
  }
  #training_tabs ul .inactive{
    background: #c3c3c3;
    color: white;    
  }
  .form_modal_active{
    display: block;
  }
  .form_modal_inactive{
    display: none;
  }
</style>
<script>
  var date_today = '<?=$date_today?>';
  // $('#payment_start_date').val(date_today);
  var date_today_plus_five = '<?=$plus_five_date?>';
  // $('#payment_end_date').val(date_today_plus_five);
  $('#date_error').hide();
  $('#date_error2').hide();
  $('#date_error3').hide();
  $('#error_fields').hide();
  $('#error_fields2').hide();
  $('#error_fields3').hide();
  $('#next_modal').click(function(){
    var title = $('#title').val();
    var description = $('#description').val();
    var training_type = $('#training_type').val();
    var training_price = $('#training_price').val();
    var mode_of_payment = $('#mode_of_payment').val();
    var date_start = $('#date_start').val();
    var participants = $('#participants').val();
    var field = $('#field').val();
    var platform = $('#platform').val();
    var date_today = '<?=$date_today?>';
    if (title === '' || description === '' || training_type === 'empty' || date_start === '' || participants === '' || field === '' || platform === '') {
      $('#error_fields').fadeIn();
    } else {
      $('#error_fields').hide();
      if (date_start <= date_today) {
        $('#date_error').fadeIn();
      } else {
        $('#date_error').hide();
        $('#form_1').removeClass('form_modal_active');
        $('#form_1').addClass('form_modal_inactive');
        $('#form_2').removeClass('form_modal_inactive');
        $('#form_2').addClass('form_modal_active');
        $('#form_1_indicator').removeClass('active');
        $('#form_1_indicator').addClass('inactive');
        $('#form_2_indicator').removeClass('inactive');
        $('#form_2_indicator').addClass('active');
        $('#form_1_buttons').removeClass('form_modal_active');
        $('#form_1_buttons').addClass('form_modal_inactive');
        $('#form_2_buttons').removeClass('form_modal_inactive');
        $('#form_2_buttons').addClass('form_modal_active');
      }
    }
  });
  $('#next_modal1').click(function(){
    var training_price = $('#training_price').val();
    var mode_of_payment = $('#mode_of_payment').val();
    var payment_description = $('#payment_description').val();
    var payment_start_date = $('#payment_start_date').val();
    var payment_end_date = $('#payment_end_date').val();

    if (training_price === '' || mode_of_payment === '' || payment_description === '' || payment_start_date === '' || payment_end_date === '') {
      $('#error_fields2').fadeIn();
    } else {
      $('#error_fields2').hide();

      $('#form_2').removeClass('form_modal_active');
      $('#form_2').addClass('form_modal_inactive');
      $('#form_3').removeClass('form_modal_inactive');
      $('#form_3').addClass('form_modal_active');
      $('#form_2_indicator').removeClass('active');
      $('#form_2_indicator').addClass('inactive');
      $('#form_3_indicator').removeClass('inactive');
      $('#form_3_indicator').addClass('active');
      $('#form_2_buttons').removeClass('form_modal_active');
      $('#form_2_buttons').addClass('form_modal_inactive');
      $('#form_3_buttons').removeClass('form_modal_inactive');
      $('#form_3_buttons').addClass('form_modal_active');
    }
  });
  $('#back_modal1').click(function(){
    $('#form_1').addClass('form_modal_active');
    $('#form_1').removeClass('form_modal_inactive');
    $('#form_2').addClass('form_modal_inactive');
    $('#form_2').removeClass('form_modal_active');
    $('#form_1_indicator').addClass('active');
    $('#form_1_indicator').removeClass('inactive');
    $('#form_2_indicator').addClass('inactive');
    $('#form_2_indicator').removeClass('active');
    $('#form_1_buttons').addClass('form_modal_active');
    $('#form_1_buttons').removeClass('form_modal_inactive');
    $('#form_2_buttons').addClass('form_modal_inactive');
    $('#form_2_buttons').removeClass('form_modal_active');
  });

  $('#back_modal').click(function(){
    $('#form_2').addClass('form_modal_active');
    $('#form_2').removeClass('form_modal_inactive');
    $('#form_3').addClass('form_modal_inactive');
    $('#form_3').removeClass('form_modal_active');
    $('#form_2_indicator').addClass('active');
    $('#form_2_indicator').removeClass('inactive');
    $('#form_3_indicator').addClass('inactive');
    $('#form_3_indicator').removeClass('active');
    $('#form_2_buttons').addClass('form_modal_active');
    $('#form_2_buttons').removeClass('form_modal_inactive');
    $('#form_3_buttons').addClass('form_modal_inactive');
    $('#form_3_buttons').removeClass('form_modal_active');
  });
  $('#submit_modal').click(function(){
    var title = $('#title').val();
    var description = $('#description').val();
    var training_type = $('#training_type').val();
    var training_price = $('#training_price').val();
    var mode_of_payment = $('#mode_of_payment').val();
    var date_start = $('#date_start').val();
    var participants = $('#participants').val();
    var field = $('#field').val();
    var platform = $('#platform').val();
    var reg_id = '<?=$my_id?>';
    var request = 'add_training';
    var payment_description = $('#payment_description').val();
    var payment_start_date = $('#payment_start_date').val();
    var payment_end_date = $('#payment_end_date').val();
    $.ajax({
      url: 'ajax_request.php',
      method: 'post',
      data: {
        request:request,
        title:title,
        training_type:training_type,
        training_price:training_price,
        mode_of_payment:mode_of_payment,
        description:description,
        reg_id:reg_id,
        date_start:date_start,
        participants:participants,
        field:field,
        platform:platform,
        payment_description:payment_description,
        payment_start_date:payment_start_date,
        payment_end_date:payment_end_date
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
  });

  $('#submit_both_modal').click(function(){
    var activity_title = $('#activity_title').val();
    var activity_start_date = $('#activity_start_date').val();
    var activity_start_time = $('#activity_start_time').val();
    var activity_end_time = $('#activity_end_time').val();
    var activity_description = $('#activity_description').val();
    var whole_date_today = '<?=$whole_date_today?>';

    var activity_date_start = activity_start_date+'T'+activity_start_time;
    var activity_date_end = activity_start_date+'T'+activity_end_time;

    var title = $('#title').val();
    var description = $('#description').val();
    var training_type = $('#training_type').val();
    var training_price = $('#training_price').val();
    var mode_of_payment = $('#mode_of_payment').val();
    var date_start = $('#date_start').val();
    var participants = $('#participants').val();
    var field = $('#field').val();
    var platform = $('#platform').val();
    var reg_id = '<?=$my_id?>';
    var request = 'add_training';
    var payment_description = $('#payment_description').val();
    var payment_start_date = $('#payment_start_date').val();
    var payment_end_date = $('#payment_end_date').val();

    if (activity_title === '' || activity_start_date === '' || activity_start_time === '' || activity_end_time === '' || activity_description === '') {
      $('#error_fields3').fadeIn();
    } else {
      $('#error_fields3').hide();
      if (activity_date_start >= activity_date_end || whole_date_today >= activity_date_start) {
        $('#date_error3').fadeIn();
      } else {
        $.ajax({
          url: 'ajax_request.php',
          method: 'post',
          data: {
            request:request,
            title:title,
            training_type:training_type,
            training_price:training_price,
            mode_of_payment:mode_of_payment,
            description:description,
            reg_id:reg_id,
            date_start:date_start,
            participants:participants,
            field:field,
            platform:platform,
            payment_description:payment_description,
            payment_start_date:payment_start_date,
            payment_end_date:payment_end_date
          },
          dataType: 'text',
          success:function(data){
            if (data === '1') {
              add_activity();
            }
            else{
              alert('An error occured on adding training');
              window.location = 'trainor.php';
            }
          }
        });
      }
    }
  });

  function add_activity(){
    var request = 'add_activity_training';

    var activity_title = $('#activity_title').val();
    var activity_start_date = $('#activity_start_date').val();
    var activity_start_time = $('#activity_start_time').val();
    var activity_end_time = $('#activity_end_time').val();
    var activity_description = $('#activity_description').val();

    var activity_date_start = activity_start_date+'T'+activity_start_time;
    var activity_date_end = activity_start_date+'T'+activity_end_time;

    var reg_id = '<?=$my_id?>';

    $.ajax({
      url: 'ajax_request.php',
      method: 'post',
      data: {
        request:request,
        activity_title:activity_title,
        activity_description:activity_description,
        activity_date_start:activity_date_start,
        activity_date_end:activity_date_end,
        reg_id:reg_id
      },
      dataType: 'text',
      success:function(data){
        if (data === '1') {
          alert('Activity Added');
        }
        else{
          alert('An error occured');
        }
        window.location = 'trainor.php';
      }
    });
  }
</script>