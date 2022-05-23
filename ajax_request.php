<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	    
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	require_once 'core/init.php';

	if ($_POST['request'] == 'service_proposal') {
		$service_id = $_POST['service_id'];
		$reg_id = $_POST['reg_id'];
		$id = $_SESSION['userId'];

		$validate = $db->query("SELECT id FROM service_proposal WHERE reg_id = '$reg_id' AND service_id = '$service_id' 
		AND create_user = '$id'
		AND delete_flg = '0';");

		if (mysqli_num_rows($validate) > 0) {
			if ($db->query("DELETE FROM service_proposal WHERE reg_id = '{$reg_id}' AND service_id = '{$service_id}'
			AND create_user = '{$id}'")) {
				echo 4;
			}else{
				echo 3;
			}
		}
		else{
			if ($db->query("INSERT INTO service_proposal (reg_id, service_id, create_user) VALUES ('$reg_id', '$service_id', '$id');")) {
				echo 1;
			}
			else{
				echo 2;
			}
		}
	}

	if ($_POST['request'] == 'service_proposal_accept') {
		$service_id = $_POST['service_id'];

		if ($db->query("UPDATE service_proposal SET status = '1' WHERE id = '$service_id';")) {
			echo 1;
		}
		else{
			echo 2;
		}
	}

	if ($_POST['request'] == 'service_proposal_decline') {
		$service_id = $_POST['service_id'];
		$userId = $_SESSION["userId"];
		if ($db->query("UPDATE service_proposal SET status = '4', update_user = '{$userId}' WHERE id = '$service_id';")) {
			echo 1;
		}
		else{
			echo 2;
		}
	}

	if ($_POST['request'] == 'finish_service_proposal') {
		$proposal_id = $_POST['proposal_id'];
		$job_type = $_POST['job_type']; 
		$job_service_id = $_POST['job_service_id']; 
		$worker_id = $_POST['worker_id'];
		$client_id = $_POST['client_id'];

		if ($db->query("UPDATE service_proposal SET status = '2' WHERE id = '$proposal_id';")) {
			$fieldnames = "(job_type,job_id,client_id,worker_id)";
			$sql = "INSERT INTO t_transaction_history $fieldnames
			VALUES('{$job_type}','{$job_service_id}','{$client_id}','{$worker_id}')";
			if($db->query($sql)){
			    echo 1;
			}else{
				echo 2;
			}
		}
		else{
			echo 2;
		}
	}

	if ($_POST['request'] == 'finish_service_proposal2') {
		$proposal_id = $_POST['proposal_id'];
		$job_type = $_POST['job_type']; 
		$job_service_id = $_POST['job_service_id']; 
		$worker_id = $_POST['worker_id'];
		$client_id = $_POST['client_id'];


		if ($db->query("UPDATE proposal_db SET status = '2' WHERE id = '$proposal_id';")) {
			$fieldnames = "(job_type,job_id,client_id,worker_id)";
			$sql = "INSERT INTO t_transaction_history_job $fieldnames
			VALUES('{$job_type}','{$job_service_id}','{$client_id}','{$worker_id}')";
			if($db->query($sql)){
			    echo 1;
			}else{
				echo 2;
			}
		}
		else{
			echo 2;
		}
	}

	if($_POST['request'] == "rate_client"){
		$rating = $_POST['rating'];
		$review = mysqli_real_escape_string($db, $_POST['review']);
		$reg_id = $_POST['reg_id'];
		$from_id = $_POST['from_id'];
		$service_id = $_POST['service_id'];
		$create_user = $_SESSION["userId"];

		if($db->query("INSERT INTO ratings (job_id,rating,review,user_id,create_user)
		VALUES('{$service_id}','{$rating}','{$review}','{$reg_id}','{$create_user}')")){
			echo 1;
		}else{
			echo 2;
		}
		
	}
	if ($_POST['request'] == 'rate') {
		$rating = $_POST['rating'];
		$review = mysqli_real_escape_string($db, $_POST['review']);
		$reg_id = $_POST['reg_id'];
		$from_id = $_POST['from_id'];
		$service_id = $_POST['service_id'];


		if ($db->query("UPDATE service_proposal SET status = '3' WHERE service_id = '$service_id' AND reg_id = '$from_id';")) {
			if ($db->query("INSERT INTO reviews_db (reg_id, rating, review, from_id, service_id) VALUES ('$reg_id', '$rating', '$review', '$from_id', '$service_id');")) {
				echo 1;
			}
			else{
				echo 2;
			}
		} else {
			echo 2;
		}
	}

	if ($_POST['request'] == 'ratefree') {
		$rating = $_POST['rating'];
		$review = mysqli_real_escape_string($db, $_POST['review']);
		$reg_id = $_POST['reg_id'];
		$from_id = $_POST['from_id'];
		$service_id = $_POST['service_id'];

		if ($db->query("UPDATE proposal_db SET status = '3' WHERE proposal_id = '$service_id' AND user_id = '$from_id' AND delete_flg = '0';")) {
			if ($db->query("INSERT INTO reviews_db (reg_id, rating, review, from_id, service_id) VALUES ('$reg_id', '$rating', '$review', '$from_id', '$service_id');")) {
				echo 1;
			}
			else{
				echo 2;
			}
		} else {
			echo 2;
		}
	}

	if ($_POST['request'] == 'add_training') {
		$title = $_POST['title'];
		$description = $_POST['description'];
		$training_type = $_POST['training_type'];
		$training_price = $_POST['training_price'];
		$mode_of_payment = $_POST['mode_of_payment'];
		$reg_id = $_POST['reg_id'];
		$date_start = $_POST['date_start'];
		$participants = $_POST['participants'];
		$field = $_POST['field'];
		$platform = $_POST['platform'];
		$payment_description = $_POST['payment_description'];
		$payment_start_date = $_POST['payment_start_date'];
		$payment_end_date = $_POST['payment_end_date'];

		if ($db->query("INSERT INTO events_db (reg_id, title, description, training_type, training_price, mode_of_payment, date_start, participants, field, platform, payment_description, payment_start_date, payment_end_date) VALUES ('$reg_id', '$title', '$description', '$training_type', '$training_price', '$mode_of_payment', '$date_start', '$participants', '$field', '$platform', '$payment_description', '$payment_start_date', '$payment_end_date');")) {
			echo 1;
		} else{
			echo 2;
		}
	}

	if ($_POST['request'] === 'add_activity') {
		$activity_title = $_POST['activity_title'];
		$activity_description = $_POST['activity_description'];
		$activity_date_start = $_POST['activity_date_start'];
		$activity_date_end = $_POST['activity_date_end'];
		$reg_id = $_POST['reg_id'];
		$training_id = $_POST['training_id'];


		if(isset($_POST['activity_id'])){
			$activity_id = $_POST['activity_id'];
			$sql = "UPDATE activities_db SET  
			activity_title = '{$activity_title}', 
			activity_description = '{$activity_description}', 
			activity_date_start = '{$activity_date_start}', 
			activity_date_end = '{$activity_date_end}'
			WHERE id = '{$activity_id}'";

			if($db->query($sql)){
				exit("1");
			}else{
				exit("2");
			}

		}else{
			if ($db->query("INSERT INTO activities_db (activity_title, activity_description, activity_date_start, activity_date_end, reg_id, training_id) VALUES ('$activity_title', '$activity_description', '$activity_date_start', '$activity_date_end', '$reg_id', '$training_id');")) {
				echo 1;
			} else {
				echo 2;
			}
		}
		
	}
	if ($_POST['request'] === 'remove_activity') {
		$activity_id = $_POST['activity_id'];
		$sql = "DELETE FROM activities_db WHERE id = '{$activity_id}'";
		if($db->query($sql)){
			exit("1");
		}else{
			exit("0");
		}
	}

	if ($_POST['request'] === 'add_activity_training') {
		$activity_title = $_POST['activity_title'];
		$activity_description = $_POST['activity_description'];
		$activity_date_start = $_POST['activity_date_start'];
		$activity_date_end = $_POST['activity_date_end'];
		$reg_id = $_POST['reg_id'];

		$result = $db->query("SELECT id FROM events_db ORDER BY id DESC");
		$row = mysqli_fetch_assoc($result);

		$training_id = $row['id'];

		if ($db->query("INSERT INTO activities_db (activity_title, activity_description, activity_date_start, activity_date_end, reg_id, training_id) VALUES ('$activity_title', '$activity_description', '$activity_date_start', '$activity_date_end', '$reg_id', '$training_id');")) {
			echo 1;
		} else {
			echo 2;
		}
	}

	if ($_POST['request'] == 'join_event') {
		$reg_id = $_POST['reg_id'];
		$event_id = $_POST['event_id'];
		
		$sql = "SELECT IF(
			(SELECT COUNT(id) FROM events_participants_db WHERE event_id = '$event_id' 
			AND reg_id = '{$reg_id}')
			>=
			(SELECT participants FROM events_db WHERE id = '$event_id' 
			AND reg_id = '{$reg_id}'), '1', '0') 
			AS cnt
			FROM events_db 
			LIMIT 1"; 
		$row = mysqli_fetch_assoc($db->query($sql));
		$chk = $row['cnt'];

		if($chk == 0){
			if ($db->query("INSERT INTO events_participants_db (reg_id, event_id) VALUES ('$reg_id', '$event_id');")) {
				echo 1;
			}
			else{
				echo 2;
			}
		}else{
			echo 3;
		}
	}

	if ($_POST['request'] == 'freelance_finish_job') {
		$proposal_id = $_POST['proposal_id'];
		$job_type = $_POST['job_type']; 
		$job_service_id = $_POST['job_service_id']; 
		$worker_id = $_POST['worker_id'];
		$client_id = $_POST['client_id'];

		if ($db->query("UPDATE proposal_db SET status = '2' WHERE id = '$proposal_id';")) {
			$fieldnames = "(job_type,job_id,client_id,worker_id)";
			$sql = "INSERT INTO t_transaction_history_job $fieldnames
			VALUES('{$job_type}','{$job_service_id}','{$client_id}','{$worker_id}')";
			if($db->query($sql)){
			    echo 1;
			}else{
				echo 2;
			}
		}
		else{
			echo 2;
		}
	}

	if ($_POST['request'] == 'freelance_finish_job2') {
		$proposal_id = $_POST['proposal_id'];
		$job_type = $_POST['job_type']; 
		$job_service_id = $_POST['job_service_id']; 
		$worker_id = $_POST['worker_id'];
		$client_id = $_POST['client_id'];

		if ($db->query("UPDATE service_proposal SET status = '2' WHERE id = '$proposal_id';")) {
			$fieldnames = "(job_type,job_id,client_id,worker_id)";
			$sql = "INSERT INTO t_transaction_history $fieldnames
			VALUES('{$job_type}','{$job_service_id}','{$worker_id}','{$client_id}')";
			if($db->query($sql)){
			    echo 1;
			}else{
				echo 2;
			}
		}
		else{
			echo 2;
		}
	}

	if ($_POST['request'] == 'report') {
		$from_id = $_POST['from_id'];
		$user_id = $_POST['user_id'];
		$reason = $_POST['reason'];

		$validate = $db->query("SELECT id FROM reports_db WHERE from_id = '$from_id' AND user_id = '$user_id' AND delete_flg = '0';");

		$validate_count = mysqli_num_rows($validate);

		if ($validate_count > 0) {
			echo 2;
		}
		else{
			if ($db->query("INSERT INTO reports_db (from_id, user_id, reason) VALUES ('$from_id', '$user_id', '$reason');")) {
				echo 1;
			}
			else{
				echo 3;
			}
		}
	}

	if ($_POST['request'] == 'decline_report') {
		$id = $_POST['id'];

		if ($db->query("UPDATE reports_db SET delete_flg = '1' WHERE id = '$id'")) {
			echo 1;
		}
		else{
			echo 2;
		}
	}

	if ($_POST['request'] == 'change_profile_status') {
		$status = $_POST['status'];
		$reg_id = $_POST['reg_id'];

		if ($db->query("UPDATE reg_db SET status = '$status' WHERE id = '$reg_id';")) {
			echo 1;
		} else{
			// echo 2;
		}
	}

	if ($_POST['request'] == 'event_update_status') {
		$event_participants_id = $_POST['event_participants_id'];
		$status_update = $_POST['status_update'];

		if ($db->query("UPDATE events_participants_db SET status = '$status_update' WHERE id = '$event_participants_id';")) {
			echo 1;
		} else {
			echo 2;
		}
	}

	if ($_POST['request'] === 'delete_training') {
		$training_id = $_POST['training_id'];

		if ($db->query("UPDATE events_db SET delete_flg = '1' WHERE id = '$training_id';")) {
			echo 1;
		} else {
			echo 2;
		}
	}

	if ($_POST['request'] == 'edit_training') {
		$edit_id = $_POST['edit_id'];
		$edit_title = $_POST['edit_title'];
		$edit_training_type = $_POST['edit_training_type'];
		$edit_description = $_POST['edit_description'];
		$edit_date_start = $_POST['edit_date_start'];
		$edit_participants = $_POST['edit_participants'];
		$edit_field = $_POST['edit_field'];
		$edit_platform = $_POST['edit_platform'];

		if ($db->query("UPDATE events_db SET title = '$edit_title', training_type = '$edit_training_type', description = '$edit_description', date_start = '$edit_date_start', participants = '$edit_participants', field = '$edit_field', platform = '$edit_platform' WHERE id = '$edit_id';")) {
			echo 1;
		} else {
			echo 2;
		}
	}

	if ($_POST['request'] == 'update_visibility') {
		$status = $_POST['status'];
		$training_id = $_POST['training_id'];

		if ($db->query("UPDATE events_db SET visible = '$status' WHERE id = '$training_id';")) {
			echo 1;
		} else {
			echo 2;
		}
	}

	if($_POST['request'] == "smtp"){
		exit("asdsa");
		$event_title = $_POST['event_title'];
	    $emailTo = $_POST['email'];
        $emailToName = $_POST['firstname']." ".$_POST['lastname'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
	    // $emailFrom = $smtpUsername;
		$mail_subject = "CaWork Training Verification";
	    $emailFromName = "CAWORK.COM";

		$message_html = '
					<div style="margin: auto;width: 80%;margin-top: 1rem;background-color: #33DDFF;border-radius: 5px;padding: 2rem;color: white;font-family: sans-serif;text-align: left;align-items: center;margin-bottom: 2rem;">
			    		<p style="margin-bottom: 2rem;">Welcome to CAWORK.COM!<br>Unfortunately, your request to join '.$event_title.' has been reject by the trainor.<br><br>Maybe they do not have more slots for any participants.</p>
			    	</div>';
			$mail = new PHPMailer(true);
			try {
				$mail->IsSMTP();
				$mail->SMTPDebug = 0;
				$mail->SMTPAuth = TRUE;
				$mail->SMTPSecure = "SSL";
				$mail->Port     = 587;  
				$mail->Username = 'cw.cawork@gmail.com';
				$mail->Password = "Caworksystem2021";
				$mail->Host = 'Smtp.gmail.com';
				$mail->Mailer   = "smtp";
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
				$mail->SetFrom('cw.cawork@gmail.com', "<no-reply>");
				$mail->AddReplyTo('cw.cawork@gmail.com', "PHPPot");
				
				$mail->AddAddress($emailTo);
				$mail->Subject = $mail_subject;
				$mail->WordWrap   = 500;
				$mail->MsgHTML($message_html);
				$mail->IsHTML(true);
				$mail->addAttachment('images/logo.png');
			
				if($mail->Send()){
					print("0");
				}else{
					print("1");
				}
			} catch (Exception $e) {
				return json_encode(array("invalid"));
			}
	}


	if ($_POST['request'] === 'update_join_request') {
		$link = "cw.cawork.com";
		$status = $_POST['status'];
		$event_participants_id = $_POST['event_participants_id'];
		$phone_number = $_POST['phone_number'];
		$event_title = $_POST['event_title'];
	    $emailTo = $_POST['email'];
        $emailToName = $_POST['firstname']." ".$_POST['lastname'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
	    // $emailFrom = $smtpUsername;
		$mail_subject = "CaWork Training Verification";
	    $emailFromName = "CAWORK.COM";

		$userId = $_SESSION["userId"];
		$sql = $db->query("SELECT events_db.*, 
		(SELECT reg_db.`firstname` FROM reg_db WHERE id = $event_participants_id) AS firstname, 
		(SELECT reg_db.`lastname` FROM reg_db WHERE id = $event_participants_id) AS lastname, 
		(SELECT reg_db.`middlename` FROM reg_db WHERE id = $event_participants_id) AS middlename, 
		(SELECT reg_db.`email` FROM reg_db WHERE id = $event_participants_id) AS email,
		(SELECT reg_db.`number` FROM reg_db WHERE id = $event_participants_id) AS number
		FROM events_db WHERE events_db.`reg_id` = $userId");

		$result = mysqli_fetch_assoc($sql); 

		$trainer_name = $result['lastname'].', '.$result['firstname']. ' '.$result['middlename'];
		// exit($event_participants_id);
		if ($status === '1') {
			$message = "CAWORK.COM\n\nYour request to join ".$event_title." have been approved.\n\nPlease check your email for more information";

			$message_html = 
				 '<div style="background-color: white; width: 500px; padding: 15px;
					margin: 2%; border-radius: 10px;
					border: 1px solid grey;
					box-shadow: 0px 1px 1px 1px grey">
					   <center>
					   	  <h4 style="font-weight: bold; display: flex; justify-content: center">Thankyou For Joining</h4>
					   </center>
					   <center>
					      <h6 style="display: flex; justify-content: center">'.$result['title'].'</h6>
					   </center>
					   <br>
					   <div class="d-flex flex-column">
							 <div style="border-bottom: 1px solid grey">
							<h5>Trainor Details</h5>
						  </div>
						  <br>
						  <h6>Trainor Name: <span style="font-weight: bold; float: right">'.$trainer_name.'</span></h6>
						  <h6>Email Address: <span style="font-weight: bold; float: right">'.$result['email'].'</span></h6>
						  <h6>Contact Number: <span style="font-weight: bold; float: right">'.$result['number'].'</span></h6>
					   </div>
				
					   <div class="d-flex flex-column" style="margin-top: 5%; ">
						  <div style="border-bottom: 1px solid grey">
							<h5>Training Details</h5>
						  </div>
						  <br>
						  <h6>Trainor Type: <span style="font-weight: bold; float: right">'.$result['training_type'].'</span></h6>
						  <h6>Date: <span style="font-weight: bold; float: right">'.$result['date_start'].'</span></h6>
						  <h6>Field: <span style="font-weight: bold; float: right">'.$result['field'].'</span></h6>
						  <h6>Platform: <span style="font-weight: bold; float: right">'.$result['platform'].'</span></h6>
					   </div>
				
				
					   <div class="d-flex flex-column" style="margin-top: 5%; ">
						  <div style="border-bottom: 1px solid grey">
							<h5>Payments</h5>
						  </div>
						  <br>
						  <h6>Training Fee: <span style="font-weight: bold; float: right">Php. '.$result['training_price'].'</span></h6>
						  <h6>Mode of Payment: <span style="font-weight: bold; float: right">'.$result['mode_of_payment'].'</span></h6>
						  <h6>Start of Payment: <span style="font-weight: bold; float: right">'.$result['payment_start_date'].'</span></h6>
						  <h6>End of Payment: <span style="font-weight: bold; float: right">'.$result['payment_end_date'].'</span></h6>
						  <h6>Payment Details: <span style="font-weight: bold; float: right">'.$result['payment_description'].'</span></h6>
					   </div>
					</div>';
		} elseif ($status === '2') {
			$message_html = '<div style="margin: auto;width: 80%;margin-top: 1rem;background-color: #33DDFF;border-radius: 5px;padding: 2rem;color: white;font-family: sans-serif;text-align: left;align-items: center;margin-bottom: 2rem;">
								<p style="margin-bottom: 2rem;">Hi, <br><br>Your training entitled '.$event_title.' have been removed from <br><br> Please check your email for more information </p>
							</div>';
			$message = "CAWORK.COM\n\nYour training entitled".$event_title.". have been removed from \n\nPlease check your email for more information";
		} 
		else {
			$message_html = '<div style="margin: auto;width: 80%;margin-top: 1rem;background-color: #33DDFF;border-radius: 5px;padding: 2rem;color: white;font-family: sans-serif;text-align: left;align-items: center;margin-bottom: 2rem;">
			    		<p style="margin-bottom: 2rem;">Welcome to CAWORK.COM!<br>You have been removed from the participants of '.$event_title.' by the trainor.<br><br>Please pay your training fee or watch your attitude next time.</p>
			    	</div>';

			$message = "CAWORK.COM\n\nYour have been removed from ".$event_title.".\n\nPlease check your email for more information";
		}

		if ($db->query("UPDATE events_participants_db SET status = '$status' WHERE id = '$event_participants_id';")) {

			$ch = curl_init();
			$parameters = array(
			    'apikey' => '41b31ff67936037d718bf89a44cedfde', //Your API KEY
			    'number' => $phone_number,
			    'message' => $message,
			    'sendername' => 'SEMAPHORE'
			);
			curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$output = curl_exec($ch);
			curl_close ($ch);



			$mail = new PHPMailer(true);
			try {
				$mail->IsSMTP();
				$mail->SMTPDebug = 0;
				$mail->SMTPAuth = TRUE;
				$mail->SMTPSecure = "TLS";
				$mail->Port     = 587;  
				$mail->Username = 'AKIA3KTA6G5U6RAJZDND';
				$mail->Password = "BNtpdJdiK4l7yPho++JyWu0Dxx9EJPkk7ynhRKhWddas";
				$mail->Host = 'email-smtp.us-east-1.amazonaws.com';
				$mail->Mailer   = "smtp";
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
				$mail->SetFrom('cw.cawork@gmail.com', "<no-reply>");
				$mail->AddReplyTo('cw.cawork@gmail.com', "PHPPot");
				$mail->AddAddress($emailTo);
				$mail->Subject = $mail_subject;
				$mail->WordWrap   = 500;
				$mail->MsgHTML($message_html);
				$mail->IsHTML(true);
				$mail->addAttachment('images/logo.png');
			
				if($mail->Send()){
					print("0");
				}else{
					print("1");
				}
			} catch (Exception $e) {
				return json_encode(array("invalid"));
			}
		} else {
			print("2");
		}
	}


	// if ($_POST['request'] === 'update_join_request') {
	// 	$link = "cw.cawork.com";

	// 	$status = $_POST['status'];
	// 	$event_participants_id = $_POST['event_participants_id'];
	// 	$phone_number = $_POST['phone_number'];
	// 	$event_title = $_POST['event_title'];
	    
	//     $smtpUsername = "admin@cw.cawork.com";
	//     $smtpPassword = "client@cawork";

	//     $emailTo = $_POST['email'];
    //     $emailToName = $_POST['firstname']." ".$_POST['lastname'];
    //     $firstname = $_POST['firstname'];
    //     $lastname = $_POST['lastname'];
	    
	//     // $smtpUsername = "donnfredericklucas@gmail.com";
	//     // $smtpPassword = "JonnaMarie26";
	    
	//     $emailFrom = $smtpUsername;
	//     $emailFromName = "CAWORK.COM";
	    
	//     // $emailTo = "donnfredericklucas@gmail.com";
	//     // $emailToName = "Donn Frederick Lucas";

	// 	if ($status === '1') {
	// 		$message = "CAWORK.COM\n\nYour request to join ".$event_title." have been approved.\n\nPlease check your email for more information";

	// 		$message_html = '<div style="margin: auto;width: 80%;margin-top: 1rem;background-color: #33DDFF;border-radius: 5px;padding: 2rem;color: white;font-family: sans-serif;text-align: left;align-items: center;margin-bottom: 2rem;">
	// 		    		<p style="margin-bottom: 2rem;">Welcome to CAWORK.COM!<br>Your request to join '.$event_title.' has been approved by your trainor.<br><br>Visit our website to check it out.</p>
	// 		    		<a target="_blank" href="'.$link.'" style="background-color: #e65251;color: white;border-radius: 5px;border-style: none;cursor: pointer;padding: 1rem 1.5rem 1rem 1.5rem;text-decoration: none;">Login</a>
	// 		    	</div>';

	// 	} elseif ($status === '2') {
	// 		$message_html = '<div style="margin: auto;width: 80%;margin-top: 1rem;background-color: #33DDFF;border-radius: 5px;padding: 2rem;color: white;font-family: sans-serif;text-align: left;align-items: center;margin-bottom: 2rem;">
	// 		    		<p style="margin-bottom: 2rem;">Welcome to CAWORK.COM!<br>Unfortunately, your request to join '.$event_title.' has been reject by the trainor.<br><br>Maybe they do not have more slots for any participants.</p>
	// 		    	</div>';

	// 		$message = "CAWORK.COM\n\nYour request to join ".$event_title." have been declined.\n\nPlease check your email for more information";
	// 	} else {
	// 		$message_html = '<div style="margin: auto;width: 80%;margin-top: 1rem;background-color: #33DDFF;border-radius: 5px;padding: 2rem;color: white;font-family: sans-serif;text-align: left;align-items: center;margin-bottom: 2rem;">
	// 		    		<p style="margin-bottom: 2rem;">Welcome to CAWORK.COM!<br>You have been removed from the participants of '.$event_title.' by the trainor.<br><br>Please pay your training fee or watch your attitude next time.</p>
	// 		    	</div>';

	// 		$message = "CAWORK.COM\n\nYour have been removed from ".$event_title.".\n\nPlease check your email for more information";
	// 	}

	// 	if ($db->query("UPDATE events_participants_db SET status = '$status' WHERE id = '$event_participants_id';")) {
	// 		$ch = curl_init();
	// 		$parameters = array(
	// 		    'apikey' => '5198c099330d7fa51ee076a0dbd2921b', //Your API KEY
	// 		    'number' => $phone_number,
	// 		    'message' => $message,
	// 		    'sendername' => 'CaWork'
	// 		);
	// 		curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
	// 		curl_setopt( $ch, CURLOPT_POST, 1 );

	// 		//Send the parameters set above with the request
	// 		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

	// 		// Receive response from server
	// 		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	// 		$output = curl_exec( $ch );
	// 		print($output);
	// 		curl_close ($ch);

	// 		//Show the server response
	// 		// echo $output;

	// 		// $mail_subject = "Email Verification | Tilaokvet.com";
	// 		// $mail = new PHPMailer;
	// 	    // $mail->isSMTP(); 
	// 	    // $mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
	// 	    // $mail->Host = "mail.cw.cawork.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
	// 	    // $mail->Port = 26; // TLS only
	// 	    // // $mail->SMTPSecure = 'tls'; // ssl is depracated
	// 	    // $mail->SMTPAuth = true;
	// 	    // $mail->Username = $smtpUsername;
	// 	    // $mail->Password = $smtpPassword;
	// 	    // $mail->setFrom($emailFrom, $emailFromName);
	// 	    // $mail->addAddress($emailTo, $emailToName);
	// 	    // $mail->Subject = $mail_subject;
	// 	    // $mail->msgHTML($message_html); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
	// 	    // $mail->AltBody = 'HTML messaging not supported';
	// 	    // // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
	// 	    // if($mail->send()){
	// 		//    echo 1;
	// 		// }else{
	// 		//    echo 3;
	// 		// }
	// 	} else {
	// 		echo 2;
	// 	}
	// }

	if ($_POST['request'] === 'rate_trainor') {
		$rate = $_POST['rating'];
		$comment = mysqli_real_escape_string($db, $_POST['review']);
		$reg_id = $_POST['reg_id'];
		$trainor_id = $_POST['trainor_id'];
		$training_id = $_POST['training_id'];

		if ($db->query("INSERT INTO trainor_ratings_db (rate, comment, reg_id, trainor_id, training_id) VALUES ('$rate', '$comment', '$reg_id', '$trainor_id', '$training_id');")) {
			echo 1;
		} else {
			echo 2;
		}
	}

	if ($_POST['request'] === 'edit_payment') {
		$edit_id = $_POST['edit_id'];
		$edit_training_price = $_POST['edit_training_price'];
		$edit_mode_of_payment = $_POST['edit_mode_of_payment'];
		$edit_payment_description = $_POST['edit_payment_description'];

		if ($db->query("UPDATE events_db SET training_price = '$edit_training_price', mode_of_payment = '$edit_mode_of_payment', payment_description = '$edit_payment_description' WHERE id = '$edit_id';")) {
			echo 1;
		} else {
			echo 2;
		}
	}

	if ($_POST['request'] === 'freelance_delete_job') {
		$service_id = $_POST['service_id'];
		if ($db->query("DELETE FROM service_db WHERE id = '$service_id';")) {
			echo 1;
		} else {
			echo 2;
		}
	}

	if ($_POST['request'] === 'client_delete_job') {
		$job_id = $_POST['job_id'];

		if ($db->query("DELETE FROM job_db WHERE id = '$job_id';")) {
			echo 1;
		} else {
			echo 2;
		}
	}
	if($_POST['request'] === 'send_mail_test'){
		$mail = new PHPMailer(true);
		try {
			$mail->IsSMTP();
			$mail->SMTPDebug = 1;
			$mail->SMTPAuth = TRUE;
			$mail->SMTPSecure = "TLS";
			$mail->Port     = 587;  
			$mail->Username = 'AKIA3KTA6G5U6RAJZDND';
			$mail->Password = "BNtpdJdiK4l7yPho++JyWu0Dxx9EJPkk7ynhRKhWddas";
			$mail->Host = 'email-smtp.us-east-1.amazonaws.com';
			$mail->Mailer   = "smtp";
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);
			$mail->SetFrom('cw.cawork@gmail.com', "<no-reply>");
			$mail->AddReplyTo('cw.cawork@gmail.com', "PHPPot");
			

			$mail_subject = $_POST['subject'];
			$message_html = "<h1> WELCOME TO AWS SMTP TEST </h1>";
			$emailTo = "itsmrdy@gmail.com";
			$mail->AddAddress($emailTo);
			$mail->Subject = $mail_subject;
			$mail->WordWrap   = 500;
			$mail->MsgHTML($message_html);
			$mail->IsHTML(true);
			// $mail->addAttachment('images/logo.png');
		
			if($mail->Send()){
				print("0");
			}else{
				print("1");
			}
		} catch (Exception $e) {
			return json_encode(array("invalid"));
		}
	}
?>