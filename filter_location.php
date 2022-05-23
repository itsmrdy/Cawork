<?php
	require_once 'core/init.php';

  if(!headers_sent() && empty(session_id())){
    session_start();
  }
	$my_id = $_SESSION['userId'];
  $id = $_SESSION['userId'];
	function checkProposal($proposal_id, $db, $id){
	    $query = $db->query("SELECT id FROM proposal_db WHERE user_id = '$id' AND proposal_id = '$proposal_id' AND delete_flg = '0';");

	    if (mysqli_num_rows($query) > 0) {
	      return 'true';
	    }
	    else{
	      return 'false';
	    }
	}

	$acc_status = $db->query("SELECT status FROM reg_db WHERE id = '$my_id';");
	$accstatus = mysqli_fetch_assoc($acc_status);

	$account_status = $accstatus['status'];

	$result = $db->query("SELECT * FROM reg_db WHERE id = $my_id");
	$time = $db->query("SELECT *, CONCAT(time_availability,' hours ',day_week) AS time FROM reg_db WHERE id = $my_id");
	$fetch = mysqli_fetch_assoc($result);
	$fetch1 = mysqli_fetch_assoc($time);
	$name = $fetch['firstname'];
	$mname = $fetch['middlename'];
	$lname = $fetch['lastname'];

	$availability = $fetch1['time'];
	$experience = $fetch['experience'];
	$location = $fetch['address'];
	$rate = $fetch['rate'];
	$education = $fetch['education'];
	$skills = $fetch['skills'];
	$email = $fetch['email'];

	$my_region = $fetch['region'];
	$my_province = $fetch['province'];
	$my_municipality = $fetch['municipality'];
	$my_barangay = $fetch['barangay'];


	if ($_POST['request'] === 'freelance') {
		$filter_by = $_POST['filter_by'];
		if ($filter_by === 'None') {
      $query = $db->query("SELECT * FROM job_db ORDER BY id DESC"); //Eto yung query
      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
        $job_id = $freelancer['job_id'];

        $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$job_id' AND delete_flg = '0';");
        $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

        $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$job_id';");
        $getClientDataRow = mysqli_fetch_assoc($getClientData);
    ?>
                          <div class="post p-3"
                            style="background: #FFFDF6;">
                              <div class="user-block">
                                <?php if(file_exists("uploads/profile/client/".$getClientDataRow['profile_picture']) && $getClientDataRow['profile_picture'] != null): ?>
                                  <img class="img-circle" src="uploads/profile/client/<?=$getClientDataRow['profile_picture']?>" alt="user image">
                                <?php else: ?>
                                    <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                    style="width: 3rem;height: 3rem;" class="mr-2 img-fluid img-circle">
                                <?php endif; ?>

                                <span class="username">
                                <?php
                                  if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                ?>
                                    <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-light" 
                                    style="float: right; border-radius: 30px; width: 150px"><b>Proposal Sent</b></a>
                                <?php  
                                  }
                                  else{
                                    if ($account_status != 2) {
                                ?>
                                  <button disabled href="#" class="btn btn-success text-bold" 
                                    style="float: right; border-radius: 30px" >
                                     Submit a proposal
                                  </button>
                                <?php
                                  }
                                    else{
                                      $my_skills = explode(', ', $skills);
                                      $categories = explode(', ', $freelancer['category']);
                                      if (array_intersect($categories, $my_skills)) {
                                ?>
                                  <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                    <b>Submit a proposal</b>
                                  </a>
                                <?php
                                      } else{
                                        $my_skills = explode(', ', $skills);
                                        $categories = explode(', ', $freelancer['category']);
                                        $encoded_str_cat = json_encode(json_encode($categories));
                                        $x = 0;
                                        for ($i = 0; $i < count($my_skills) ; $i++) { 
                                          $search = $my_skills[$i];
                                          if(preg_match("/{$search}/i", $encoded_str_cat)){
                                            $x++;
                                          }
                                        }
                                        if ($x > 0) {
                                      ?>
                                        <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                          <b>Submit a proposal</b>
                                        </a>
                                      <?php
                                        }else {
                                      ?>
                                        <h6 style="float:right">Not Qualified</h6>
                                      <?php
                                          }
                                      }
                                    }
                                  }
                                ?>

                                  <a class="text-capitalize"
                                  href="#"
                                  data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"
                                  > <?= $freelancer['firstname']; ?> <?= $freelancer['middlename']; ?> <?= $freelancer['lastname']; ?></a>
                                  
                                </span>
                                <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></span>
                                <!--<span class="description">Posted - 7:30 PM today</span>-->
                          </div>      
                              <h5 class="text-capitalize text-bold text-success"
                              style="cursor: pointer"
                              data-toggle="modal" data-target="#job_details<?= $freelancer["id"] ?>">
                                <?= $freelancer['title']; ?>
                              </h5>

                              <h6 class="text-dark">
                                Job Rate: <span class="text-bold">₱<?= $freelancer['budget']; ?></span>
                              </h6>
                              <h6 class="text-capitalize text-bold text-dark">
                                 <?= $freelancer['experience']; ?> 
                              </h6>

                              <p class="text-capitalize">
                                <?= $freelancer['description']; ?>
                              </p>
                              
                              <hr>
                              <h5 class="text-capitalize">
                                   <?php 
                                      $cats = explode(",", $freelancer['category']); 
                                      for ($i=0; $i < count($cats) ; $i++):
                                   ?>
                                     <span class="badge badge-pill p-2 text-dark m-1"
                                     style="background: #f0f2f5">
                                        <?= $cats[$i] ?>
                                     </span>
                                   <?php endfor; ?>
                              </h5>

                              <h6 class="text-capitalize text-dark px-2 text-bold">
                               <i class='fa fa-map-marker'></i>
                               <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                              </h6>

                              <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                              </p>
                              <div class="modal right fade" id="job_details<?= $freelancer["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                    <div class="modal-body">
                                      <h4 class="text-dark">
                                        <?= $freelancer['title'] ?>
                                      </h4>
                                      <h5 class="text-success text-bold"><?= $freelancer['category'] ?></h5>
                                      <h6>Posted <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></h6>
                                      <p>
                                        <i class="fa fa-book"></i> <?= $freelancer['description'] ?>
                                      </p>
                                      <h6>Project Type: <?= $freelancer['type_of_project'] ?></h6>
                                      <hr>
                                      <h5 class="text-dark">Skills and Expertise</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['experience'] ?> Level</h6>
                                      <h5 class="text-dark">Budget</h5>
                                      <h6 class="text-bold">Php. <?= number_format($freelancer['budget']) ?></h6>
                                      <hr>
                                      <h5 class="text-dark">No. of workers needed</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['no_of_freelance'] ?></h6>

                                      <h5 class="text-dark">Payment Type</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['payment_freelance'] ?></h6>
                                    </div>

                                    <div class="modal-footer">
                                    <?php
                                      if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                    ?>
                                        <form method="POST">
                                          <button class="btn btn-light" 
                                          onClick="return confirmSubmit();"
                                          type="submit" name="cancel_proposal"
                                          value = '<?= $freelancer['proposal_id']?>'
                                          style="float: right; border-radius: 30px; width: 150px"><b>Cancel Proposal</b></button>
                                      </form>
                                    <?php  
                                      }
                                      else{
                                        if ($account_status != 2) {
                                      ?>
                                        <button disabled href="#" class="btn btn-success text-bold" 
                                          style="float: right; border-radius: 30px" >
                                          Submit a proposal
                                        </button>
                                      <?php
                                        }
                                        else{
                                          $my_skills = explode(',', strtolower($skills));
                                          $categories = explode(',', strtolower($freelancer['category']));
                                          $encoded_str_cat = json_encode($categories);
                                          $x = 0;


                                          $tmp_categ = array(); 
                                          for ($a=0; $a < count($categories) ; $a++) { 
                                            array_push($tmp_categ, str_replace(" ","",strtolower($categories[$a])));
                                          }

                                          $tmp_skill = array();

                                          for ($q=0; $q < count($my_skills) ; $q++) { 
                                            array_push($tmp_skill, str_replace(" ", "",$my_skills[$q]));
                                          }
                                          
                                          if (array_intersect($tmp_skill, $tmp_categ)) {
                                        ?>
                                          <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                            <b>Submit Proposal</b>
                                          </a>
                                        <?php
                                          }else {
                                        ?>
                                          <h6 style="float:right">Not Qualified</h6>
                                        <?php
                                            }
                                          }
                                        }
                                      ?>

                                    </div>

                                  </div><!-- modal-content -->
                                </div><!-- modal-dialog -->
                              </div><!-- modal -->

                            </div>
                            <?php endwhile; ?>
      <?php
        if (empty($getClientDataRow)) {
      ?>
        <div class="d-flex flex-column">
              <div class="d-flex justify-content-center">
                  <img src="images/result_no.png" alt=""
                      height="500px" width="600px">
              </div>
              <div class="d-flex justify-content-center">
                  <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
              </div>
        </div>
      <?php
        }
      }elseif ($filter_by === 'Region') {
			$query = $db->query("SELECT job.* FROM job_db job JOIN reg_db reg ON job.job_id = reg.id WHERE reg.region = '$my_region' ORDER BY id DESC"); //Eto yung query
      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
        $job_id = $freelancer['job_id'];

        $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$job_id' AND delete_flg = '0';");
        $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

        $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$job_id';");
        $getClientDataRow = mysqli_fetch_assoc($getClientData);
    ?>
                         <div class="post p-3"
                            style="background: #FFFDF6;">
                              <div class="user-block">
                                <?php if(file_exists("uploads/profile/client/".$getClientDataRow['profile_picture']) && $getClientDataRow['profile_picture'] != null): ?>
                                  <img class="img-circle" src="uploads/profile/client/<?=$getClientDataRow['profile_picture']?>" alt="user image">
                                <?php else: ?>
                                    <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                    style="width: 3rem;height: 3rem;" class="mr-2 img-fluid img-circle">
                                <?php endif; ?>
                                <span class="username">
                                <?php
                                  if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                ?>
                                    <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-light" 
                                    style="float: right; border-radius: 30px; width: 150px"><b>Proposal Sent</b></a>
                                <?php  
                                  }
                                  else{
                                    if ($account_status != 2) {
                                ?>
                                  <button disabled href="#" class="btn btn-success text-bold" 
                                    style="float: right; border-radius: 30px" >
                                     Submit a proposal
                                  </button>
                                <?php
                                  }
                                    else{
                                      $my_skills = explode(', ', $skills);
                                      $categories = explode(', ', $freelancer['category']);
                                      if (array_intersect($categories, $my_skills)) {
                                ?>
                                  <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                    <b>Submit a proposal</b>
                                  </a>
                                <?php
                                      }  else{
                                        $my_skills = explode(', ', $skills);
                                        $categories = explode(', ', $freelancer['category']);
                                        $encoded_str_cat = json_encode(json_encode($categories));
                                        $x = 0;
                                        for ($i = 0; $i < count($my_skills) ; $i++) { 
                                          $search = $my_skills[$i];
                                          if(preg_match("/{$search}/i", $encoded_str_cat)){
                                            $x++;
                                          }
                                        }
                                        if ($x > 0) {
                                      ?>
                                        <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                          <b>Submit a proposal</b>
                                        </a>
                                      <?php
                                        }else {
                                      ?>
                                        <h6 style="float:right">Not Qualified</h6>
                                      <?php
                                          }
                                      }
                                    }
                                  }
                                ?>

                                  <a class="text-capitalize"
                                  href="#"
                                  data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"> <?= $freelancer['firstname']; ?> <?= $freelancer['middlename']; ?> <?= $freelancer['lastname']; ?></a>
                                  
                                </span>
                                <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></span>
                                <!--<span class="description">Posted - 7:30 PM today</span>-->
                          </div>      
                              <h5 class="text-capitalize text-bold text-success"
                              style="cursor: pointer"
                              data-toggle="modal" data-target="#job_details<?= $freelancer["id"] ?>">
                                <?= $freelancer['title']; ?>
                              </h5>

                              <h6 class="text-dark">
                                Job Rate: <span class="text-bold">₱<?= $freelancer['budget']; ?></span>
                              </h6>
                              <h6 class="text-capitalize text-bold text-dark">
                                 <?= $freelancer['experience']; ?> 
                              </h6>

                              <p class="text-capitalize">
                                <?= $freelancer['description']; ?>
                              </p>
                              
                              <hr>
                              <h5 class="text-capitalize">
                                   <?php 
                                      $cats = explode(",", $freelancer['category']); 
                                      for ($i=0; $i < count($cats) ; $i++):
                                   ?>
                                     <span class="badge badge-pill p-2 text-dark"
                                     style="background: #f0f2f5">
                                        <?= $cats[$i] ?>
                                     </span>
                                   <?php endfor; ?>
                              </h5>

                              <h6 class="text-capitalize text-dark px-2 text-bold">
                               <i class='fa fa-map-marker'></i>
                               <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                              </h6>

                              <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                              </p>
                              <div class="modal right fade" id="job_details<?= $freelancer["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                    <div class="modal-body">
                                      <h4 class="text-dark">
                                        <?= $freelancer['title'] ?>
                                      </h4>
                                      <h5 class="text-success text-bold"><?= $freelancer['category'] ?></h5>
                                      <h6>Posted <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></h6>
                                      <p>
                                        <i class="fa fa-book"></i> <?= $freelancer['description'] ?>
                                      </p>
                                      <h6>Project Type: <?= $freelancer['type_of_project'] ?></h6>
                                      <hr>
                                      <h5 class="text-dark">Skills and Expertise</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['experience'] ?> Level</h6>
                                      <h5 class="text-dark">Budget</h5>
                                      <h6 class="text-bold">Php. <?= number_format($freelancer['budget']) ?></h6>
                                      <hr>
                                      <h5 class="text-dark">No. of workers needed</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['no_of_freelance'] ?></h6>

                                      <h5 class="text-dark">Payment Type</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['payment_freelance'] ?></h6>
                                    </div>

                                    <div class="modal-footer">
                                    <?php
                                      if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                    ?>
                                        <form method="POST">
                                          <button class="btn btn-light" 
                                          onClick="return confirmSubmit();"
                                          type="submit" name="cancel_proposal"
                                          value = '<?= $freelancer['proposal_id']?>'
                                          style="float: right; border-radius: 30px; width: 150px"><b>Cancel Proposal</b></button>
                                      </form>
                                    <?php  
                                      }
                                      else{
                                        if ($account_status != 2) {
                                      ?>
                                        <button disabled href="#" class="btn btn-success text-bold" 
                                          style="float: right; border-radius: 30px" >
                                          Submit a proposal
                                        </button>
                                      <?php
                                        }
                                        else{
                                          $my_skills = explode(',', strtolower($skills));
                                          $categories = explode(',', strtolower($freelancer['category']));
                                          $encoded_str_cat = json_encode($categories);
                                          $x = 0;


                                          $tmp_categ = array(); 
                                          for ($a=0; $a < count($categories) ; $a++) { 
                                            array_push($tmp_categ, str_replace(" ","",strtolower($categories[$a])));
                                          }

                                          $tmp_skill = array();

                                          for ($q=0; $q < count($my_skills) ; $q++) { 
                                            array_push($tmp_skill, str_replace(" ", "",$my_skills[$q]));
                                          }
                                          
                                          if (array_intersect($tmp_skill, $tmp_categ)) {
                                        ?>
                                          <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                            <b>Submit Proposal</b>
                                          </a>
                                        <?php
                                          }else {
                                        ?>
                                          <h6 style="float:right">Not Qualified</h6>
                                        <?php
                                            }
                                          }
                                        }
                                      ?>

                                    </div>

                                  </div><!-- modal-content -->
                                </div><!-- modal-dialog -->
                              </div><!-- modal -->

                          </div>
                          <?php endwhile; ?>
      <?php
        if (empty($getClientDataRow)) {
      ?>
         <div class="d-flex flex-column">
            <div class="d-flex justify-content-center">
                <img src="images/result_no.png" alt=""
                height="500px"
                width="600px">
            </div>
            <div class="d-flex justify-content-center">
                <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
            </div>
         </div>
      <?php
        }
      } elseif ($filter_by === 'State') {
        $query = $db->query("SELECT job.* FROM job_db job JOIN reg_db reg ON job.job_id = reg.id WHERE reg.province = '$my_province' ORDER BY id DESC"); //Eto yung query
        while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
          $job_id = $freelancer['job_id'];

          $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$job_id' AND delete_flg = '0';");
          $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

          $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$job_id';");
          $getClientDataRow = mysqli_fetch_assoc($getClientData);
    ?>
                         <div class="post p-3"
                            style="background: #FFFDF6;">
                              <div class="user-block">
                                <?php if(file_exists("uploads/profile/client/".$getClientDataRow['profile_picture']) && $getClientDataRow['profile_picture'] != null): ?>
                                  <img class="img-circle" src="uploads/profile/client/<?=$getClientDataRow['profile_picture']?>" alt="user image">
                                <?php else: ?>
                                    <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                    style="width: 3rem;height: 3rem;" class="mr-2 img-fluid img-circle">
                                <?php endif; ?>
                                <span class="username">
                                <?php
                                  if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                ?>
                                    <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-light" 
                                    style="float: right; border-radius: 30px; width: 150px"><b>Proposal Sent</b></a>
                                <?php  
                                  }
                                  else{
                                    if ($account_status != 2) {
                                ?>
                                  <button disabled href="#" class="btn btn-success text-bold" 
                                    style="float: right; border-radius: 30px" >
                                     Submit a proposal
                                  </button>
                                <?php
                                  }
                                    else{
                                      $my_skills = explode(', ', $skills);
                                      $categories = explode(', ', $freelancer['category']);
                                      if (array_intersect($categories, $my_skills)) {
                                ?>
                                  <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                    <b>Submit a proposal</b>
                                  </a>
                                <?php
                                      }  else{
                                        $my_skills = explode(', ', $skills);
                                        $categories = explode(', ', $freelancer['category']);
                                        $encoded_str_cat = json_encode(json_encode($categories));
                                        $x = 0;
                                        for ($i = 0; $i < count($my_skills) ; $i++) { 
                                          $search = $my_skills[$i];
                                          if(preg_match("/{$search}/i", $encoded_str_cat)){
                                            $x++;
                                          }
                                        }
                                        if ($x > 0) {
                                      ?>
                                        <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                          <b>Submit a proposal</b>
                                        </a>
                                      <?php
                                        }else {
                                      ?>
                                        <h6 style="float:right">Not Qualified</h6>
                                      <?php
                                          }
                                      }
                                    }
                                  }
                                ?>

                                  <a class="text-capitalize"
                                  href="#"
                                  data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"> <?= $freelancer['firstname']; ?> <?= $freelancer['middlename']; ?> <?= $freelancer['lastname']; ?></a>
                                  
                                </span>
                                <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></span>
                                <!--<span class="description">Posted - 7:30 PM today</span>-->
                          </div>      
                              <h5 class="text-capitalize text-bold text-success"
                              style="cursor: pointer"
                              data-toggle="modal" data-target="#job_details<?= $freelancer["id"] ?>">
                                <?= $freelancer['title']; ?>
                              </h5>

                              <h6 class="text-dark">
                                Job Rate: <span class="text-bold">₱<?= $freelancer['budget']; ?></span>
                              </h6>
                              <h6 class="text-capitalize text-bold text-dark">
                                 <?= $freelancer['experience']; ?> 
                              </h6>

                              <p class="text-capitalize">
                                <?= $freelancer['description']; ?>
                              </p>
                              
                              <hr>
                              <h5 class="text-capitalize">
                                   <?php 
                                      $cats = explode(",", $freelancer['category']); 
                                      for ($i=0; $i < count($cats) ; $i++):
                                   ?>
                                     <span class="badge badge-pill p-2 text-dark m-1"
                                     style="background: #f0f2f5">
                                        <?= $cats[$i] ?>
                                     </span>
                                   <?php endfor; ?>
                              </h5>

                              <h6 class="text-capitalize text-dark px-2 text-bold">
                               <i class='fa fa-map-marker'></i>
                               <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                              </h6>

                              <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                              </p>

                              <div class="modal right fade" id="job_details<?= $freelancer["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                    <div class="modal-body">
                                      <h4 class="text-dark">
                                        <?= $freelancer['title'] ?>
                                      </h4>
                                      <h5 class="text-success text-bold"><?= $freelancer['category'] ?></h5>
                                      <h6>Posted <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></h6>
                                      <p>
                                        <i class="fa fa-book"></i> <?= $freelancer['description'] ?>
                                      </p>
                                      <h6>Project Type: <?= $freelancer['type_of_project'] ?></h6>
                                      <hr>
                                      <h5 class="text-dark">Skills and Expertise</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['experience'] ?> Level</h6>
                                      <h5 class="text-dark">Budget</h5>
                                      <h6 class="text-bold">Php. <?= number_format($freelancer['budget']) ?></h6>
                                      <hr>
                                      <h5 class="text-dark">No. of workers needed</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['no_of_freelance'] ?></h6>

                                      <h5 class="text-dark">Payment Type</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['payment_freelance'] ?></h6>
                                    </div>

                                    <div class="modal-footer">
                                    <?php
                                      if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                    ?>
                                        <form method="POST">
                                          <button class="btn btn-light" 
                                          onClick="return confirmSubmit();"
                                          type="submit" name="cancel_proposal"
                                          value = '<?= $freelancer['proposal_id']?>'
                                          style="float: right; border-radius: 30px; width: 150px"><b>Cancel Proposal</b></button>
                                      </form>
                                    <?php  
                                      }
                                      else{
                                        if ($account_status != 2) {
                                      ?>
                                        <button disabled href="#" class="btn btn-success text-bold" 
                                          style="float: right; border-radius: 30px" >
                                          Submit a proposal
                                        </button>
                                      <?php
                                        }
                                        else{
                                          $my_skills = explode(',', strtolower($skills));
                                          $categories = explode(',', strtolower($freelancer['category']));
                                          $encoded_str_cat = json_encode($categories);
                                          $x = 0;


                                          $tmp_categ = array(); 
                                          for ($a=0; $a < count($categories) ; $a++) { 
                                            array_push($tmp_categ, str_replace(" ","",strtolower($categories[$a])));
                                          }

                                          $tmp_skill = array();

                                          for ($q=0; $q < count($my_skills) ; $q++) { 
                                            array_push($tmp_skill, str_replace(" ", "",$my_skills[$q]));
                                          }
                                          
                                          if (array_intersect($tmp_skill, $tmp_categ)) {
                                        ?>
                                          <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                            <b>Submit Proposal</b>
                                          </a>
                                        <?php
                                          }else {
                                        ?>
                                          <h6 style="float:right">Not Qualified</h6>
                                        <?php
                                            }
                                          }
                                        }
                                      ?>

                                    </div>

                                  </div><!-- modal-content -->
                                </div><!-- modal-dialog -->
                              </div><!-- modal -->

                          </div>
                          <?php endwhile; ?>
      <?php
        if (empty($getClientDataRow)) {
      ?>
         <div class="d-flex flex-column">
            <div class="d-flex justify-content-center">
                <img src="images/result_no.png" alt=""
                height="500px"
                width="600px">
            </div>
            <div class="d-flex justify-content-center">
                <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
            </div>
         </div>
      <?php
        }
    } elseif ($filter_by === 'Municipality') {
      $query = $db->query("SELECT job.* FROM job_db job JOIN reg_db reg ON job.job_id = reg.id WHERE reg.municipality = '$my_municipality' ORDER BY id DESC"); //Eto yung query
      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
        $job_id = $freelancer['job_id'];

        $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$job_id' AND delete_flg = '0';");
        $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

        $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$job_id';");
        $getClientDataRow = mysqli_fetch_assoc($getClientData);
    ?>
                     <div class="post p-3"
                            style="background: #FFFDF6;">
                              <div class="user-block">
                                <?php if(file_exists("uploads/profile/client/".$getClientDataRow['profile_picture']) && $getClientDataRow['profile_picture'] != null): ?>
                                  <img class="img-circle" src="uploads/profile/client/<?=$getClientDataRow['profile_picture']?>" alt="user image">
                                <?php else: ?>
                                    <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                    style="width: 3rem;height: 3rem;" class="mr-2 img-fluid img-circle">
                                <?php endif; ?>
                                <span class="username">
                                <?php
                                  if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                ?>
                                    <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-light" 
                                    style="float: right; border-radius: 30px; width: 150px"><b>Proposal Sent</b></a>
                                <?php  
                                  }
                                  else{
                                    if ($account_status != 2) {
                                ?>
                                  <button disabled href="#" class="btn btn-success text-bold" 
                                    style="float: right; border-radius: 30px" >
                                     Submit a proposal
                                  </button>
                                <?php
                                  }
                                    else{
                                      $my_skills = explode(', ', $skills);
                                      $categories = explode(', ', $freelancer['category']);
                                      if (array_intersect($categories, $my_skills)) {
                                ?>
                                  <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                    <b>Submit a proposal</b>
                                  </a>
                                <?php
                                      }  else{
                                        $my_skills = explode(', ', $skills);
                                        $categories = explode(', ', $freelancer['category']);
                                        $encoded_str_cat = json_encode(json_encode($categories));
                                        $x = 0;
                                        for ($i = 0; $i < count($my_skills) ; $i++) { 
                                          $search = $my_skills[$i];
                                          if(preg_match("/{$search}/i", $encoded_str_cat)){
                                            $x++;
                                          }
                                        }
                                        if ($x > 0) {
                                      ?>
                                        <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                          <b>Submit a proposal</b>
                                        </a>
                                      <?php
                                        }else {
                                      ?>
                                        <h6 style="float:right">Not Qualified</h6>
                                      <?php
                                          }
                                      }
                                    }
                                  }
                                ?>

                                  <a class="text-capitalize"
                                  href="#"
                                  data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"> <?= $freelancer['firstname']; ?> <?= $freelancer['middlename']; ?> <?= $freelancer['lastname']; ?></a>
                                  
                                </span>
                                <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></span>
                                <!--<span class="description">Posted - 7:30 PM today</span>-->
                          </div>      
                              <h5 class="text-capitalize text-bold text-success"
                              style="cursor: pointer"
                              data-toggle="modal" data-target="#job_details<?= $freelancer["id"] ?>">
                                <?= $freelancer['title']; ?>
                              </h5>

                              <h6 class="text-dark">
                                Job Rate: <span class="text-bold">₱<?= $freelancer['budget']; ?></span>
                              </h6>
                              <h6 class="text-capitalize text-bold text-dark">
                                 <?= $freelancer['experience']; ?> 
                              </h6>

                              <p class="text-capitalize">
                                <?= $freelancer['description']; ?>
                              </p>
                              
                              <hr>
                              <h5 class="text-capitalize">
                                   <?php 
                                      $cats = explode(",", $freelancer['category']); 
                                      for ($i=0; $i < count($cats) ; $i++):
                                   ?>
                                     <span class="badge badge-pill p-2 text-dark m-1"
                                     style="background: #f0f2f5">
                                        <?= $cats[$i] ?>
                                     </span>
                                   <?php endfor; ?>
                              </h5>

                              <h6 class="text-capitalize text-dark px-2 text-bold">
                               <i class='fa fa-map-marker'></i>
                               <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                              </h6>

                              <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                              </p>

                              <div class="modal right fade" id="job_details<?= $freelancer["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                    <div class="modal-body">
                                      <h4 class="text-dark">
                                        <?= $freelancer['title'] ?>
                                      </h4>
                                      <h5 class="text-success text-bold"><?= $freelancer['category'] ?></h5>
                                      <h6>Posted <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></h6>
                                      <p>
                                        <i class="fa fa-book"></i> <?= $freelancer['description'] ?>
                                      </p>
                                      <h6>Project Type: <?= $freelancer['type_of_project'] ?></h6>
                                      <hr>
                                      <h5 class="text-dark">Skills and Expertise</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['experience'] ?> Level</h6>
                                      <h5 class="text-dark">Budget</h5>
                                      <h6 class="text-bold">Php. <?= number_format($freelancer['budget']) ?></h6>
                                      <hr>
                                      <h5 class="text-dark">No. of workers needed</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['no_of_freelance'] ?></h6>

                                      <h5 class="text-dark">Payment Type</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['payment_freelance'] ?></h6>
                                    </div>

                                    <div class="modal-footer">
                                    <?php
                                      if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                    ?>
                                        <form method="POST">
                                          <button class="btn btn-light" 
                                          onClick="return confirmSubmit();"
                                          type="submit" name="cancel_proposal"
                                          value = '<?= $freelancer['proposal_id']?>'
                                          style="float: right; border-radius: 30px; width: 150px"><b>Cancel Proposal</b></button>
                                      </form>
                                    <?php  
                                      }
                                      else{
                                        if ($account_status != 2) {
                                      ?>
                                        <button disabled href="#" class="btn btn-success text-bold" 
                                          style="float: right; border-radius: 30px" >
                                          Submit a proposal
                                        </button>
                                      <?php
                                        }
                                        else{
                                          $my_skills = explode(',', strtolower($skills));
                                          $categories = explode(',', strtolower($freelancer['category']));
                                          $encoded_str_cat = json_encode($categories);
                                          $x = 0;


                                          $tmp_categ = array(); 
                                          for ($a=0; $a < count($categories) ; $a++) { 
                                            array_push($tmp_categ, str_replace(" ","",strtolower($categories[$a])));
                                          }

                                          $tmp_skill = array();

                                          for ($q=0; $q < count($my_skills) ; $q++) { 
                                            array_push($tmp_skill, str_replace(" ", "",$my_skills[$q]));
                                          }
                                          
                                          if (array_intersect($tmp_skill, $tmp_categ)) {
                                        ?>
                                          <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                            <b>Submit Proposal</b>
                                          </a>
                                        <?php
                                          }else {
                                        ?>
                                          <h6 style="float:right">Not Qualified</h6>
                                        <?php
                                            }
                                          }
                                        }
                                      ?>

                                    </div>

                                  </div><!-- modal-content -->
                                </div><!-- modal-dialog -->
                              </div><!-- modal -->

                          </div>
                          <?php endwhile; ?>
      <?php
        if (empty($getClientDataRow)) {
      ?>
         <div class="d-flex flex-column">
            <div class="d-flex justify-content-center">
                <img src="images/result_no.png" alt=""
                height="500px"
                width="600px">
            </div>
            <div class="d-flex justify-content-center">
                <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
            </div>
         </div>
      <?php
        }
    } else {
      $query = $db->query("SELECT job.* FROM job_db job JOIN reg_db reg ON job.job_id = reg.id WHERE reg.barangay = '$my_barangay' ORDER BY id DESC"); //Eto yung query
      while($freelancer = mysqli_fetch_assoc($query)): //eto yung loop
        $job_id = $freelancer['job_id'];

        $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$job_id' AND delete_flg = '0';");
        $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

        $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$job_id';");
        $getClientDataRow = mysqli_fetch_assoc($getClientData);
    ?>
                      <div class="post p-3"
                            style="background: #FFFDF6;">
                              <div class="user-block">
                                <?php if(file_exists("uploads/profile/client/".$getClientDataRow['profile_picture']) && $getClientDataRow['profile_picture'] != null): ?>
                                  <img class="img-circle" src="uploads/profile/client/<?=$getClientDataRow['profile_picture']?>" alt="user image">
                                <?php else: ?>
                                    <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                    style="width: 3rem;height: 3rem;" class="mr-2 img-fluid img-circle">
                                <?php endif; ?>
                                <span class="username">
                                <?php
                                  if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                ?>
                                    <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-light" 
                                    style="float: right; border-radius: 30px; width: 150px"><b>Proposal Sent</b></a>
                                <?php  
                                  }
                                  else{
                                    if ($account_status != 2) {
                                ?>
                                  <button disabled href="#" class="btn btn-success text-bold" 
                                    style="float: right; border-radius: 30px" >
                                     Submit a proposal
                                  </button>
                                <?php
                                  }
                                    else{
                                      $my_skills = explode(', ', $skills);
                                      $categories = explode(', ', $freelancer['category']);
                                      if (array_intersect($categories, $my_skills)) {
                                ?>
                                  <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                    <b>Submit a proposal</b>
                                  </a>
                                <?php
                                      }  else{
                                        $my_skills = explode(', ', $skills);
                                        $categories = explode(', ', $freelancer['category']);
                                        $encoded_str_cat = json_encode(json_encode($categories));
                                        $x = 0;
                                        for ($i = 0; $i < count($my_skills) ; $i++) { 
                                          $search = $my_skills[$i];
                                          if(preg_match("/{$search}/i", $encoded_str_cat)){
                                            $x++;
                                          }
                                        }
                                        if ($x > 0) {
                                      ?>
                                        <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                          <b>Submit a proposal</b>
                                        </a>
                                      <?php
                                        }else {
                                      ?>
                                        <h6 style="float:right">Not Qualified</h6>
                                      <?php
                                          }
                                      }
                                    }
                                  }
                                ?>

                                  <a class="text-capitalize"
                                  href="#"
                                  data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"> <?= $freelancer['firstname']; ?> <?= $freelancer['middlename']; ?> <?= $freelancer['lastname']; ?></a>
                                  
                                </span>
                                <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></span>
                                <!--<span class="description">Posted - 7:30 PM today</span>-->
                          </div>      
                              <h5 class="text-capitalize text-bold text-success"
                              style="cursor: pointer"
                              data-toggle="modal" data-target="#job_details<?= $freelancer["id"] ?>">
                                <?= $freelancer['title']; ?>
                              </h5>

                              <h6 class="text-dark">
                                Job Rate: <span class="text-bold">₱<?= $freelancer['budget']; ?></span>
                              </h6>
                              <h6 class="text-capitalize text-bold text-dark">
                                 <?= $freelancer['experience']; ?> 
                              </h6>

                              <p class="text-capitalize">
                                <?= $freelancer['description']; ?>
                              </p>
                              
                              <hr>
                              <h5 class="text-capitalize">
                                   <?php 
                                      $cats = explode(",", $freelancer['category']); 
                                      for ($i=0; $i < count($cats) ; $i++):
                                   ?>
                                     <span class="badge badge-pill p-2 text-dark m-1"
                                     style="background: #f0f2f5">
                                        <?= $cats[$i] ?>
                                     </span>
                                   <?php endfor; ?>
                              </h5>

                              <h6 class="text-capitalize text-dark px-2 text-bold">
                               <i class='fa fa-map-marker'></i>
                               <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                              </h6>

                              <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                              </p>

                              <div class="modal right fade" id="job_details<?= $freelancer["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                    <div class="modal-body">
                                      <h4 class="text-dark">
                                        <?= $freelancer['title'] ?>
                                      </h4>
                                      <h5 class="text-success text-bold"><?= $freelancer['category'] ?></h5>
                                      <h6>Posted <?= Date("M/y/d h:i:s a", strtotime($freelancer['time_posted']))?></h6>
                                      <p>
                                        <i class="fa fa-book"></i> <?= $freelancer['description'] ?>
                                      </p>
                                      <h6>Project Type: <?= $freelancer['type_of_project'] ?></h6>
                                      <hr>
                                      <h5 class="text-dark">Skills and Expertise</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['experience'] ?> Level</h6>
                                      <h5 class="text-dark">Budget</h5>
                                      <h6 class="text-bold">Php. <?= number_format($freelancer['budget']) ?></h6>
                                      <hr>
                                      <h5 class="text-dark">No. of workers needed</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['no_of_freelance'] ?></h6>

                                      <h5 class="text-dark">Payment Type</h5>
                                      <h6 class="text-bold text-capitalize"><?= $freelancer['payment_freelance'] ?></h6>
                                    </div>

                                    <div class="modal-footer">
                                    <?php
                                      if (checkProposal($freelancer['id'], $db, $my_id) == 'true') {
                                    ?>
                                        <form method="POST">
                                          <button class="btn btn-light" 
                                          onClick="return confirmSubmit();"
                                          type="submit" name="cancel_proposal"
                                          value = '<?= $freelancer['proposal_id']?>'
                                          style="float: right; border-radius: 30px; width: 150px"><b>Cancel Proposal</b></button>
                                      </form>
                                    <?php  
                                      }
                                      else{
                                        if ($account_status != 2) {
                                      ?>
                                        <button disabled href="#" class="btn btn-success text-bold" 
                                          style="float: right; border-radius: 30px" >
                                          Submit a proposal
                                        </button>
                                      <?php
                                        }
                                        else{
                                          $my_skills = explode(',', strtolower($skills));
                                          $categories = explode(',', strtolower($freelancer['category']));
                                          $encoded_str_cat = json_encode($categories);
                                          $x = 0;


                                          $tmp_categ = array(); 
                                          for ($a=0; $a < count($categories) ; $a++) { 
                                            array_push($tmp_categ, str_replace(" ","",strtolower($categories[$a])));
                                          }

                                          $tmp_skill = array();

                                          for ($q=0; $q < count($my_skills) ; $q++) { 
                                            array_push($tmp_skill, str_replace(" ", "",$my_skills[$q]));
                                          }
                                          
                                          if (array_intersect($tmp_skill, $tmp_categ)) {
                                        ?>
                                          <a href="admin/proposal.php?edit=<?=$freelancer['id']?>" class="btn btn-primary" style="float: right; border-radius: 30px" >
                                            <b>Submit Proposal</b>
                                          </a>
                                        <?php
                                          }else {
                                        ?>
                                          <h6 style="float:right">Not Qualified</h6>
                                        <?php
                                            }
                                          }
                                        }
                                      ?>

                                    </div>

                                  </div><!-- modal-content -->
                                </div><!-- modal-dialog -->
                              </div><!-- modal -->

                          </div>
                          <?php endwhile; ?>
      <?php
        if (empty($getClientDataRow)) {
      ?>
         <div class="d-flex flex-column">
            <div class="d-flex justify-content-center">
                <img src="images/result_no.png" alt=""
                height="500px"
                width="600px">
            </div>
            <div class="d-flex justify-content-center">
                <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
            </div>
         </div>
      <?php
        }
    }
	} else {
    $filter_by = $_POST['filter_by'];
    if ($filter_by == 'Region') {
                        $query = "SELECT service.*, reg.id AS reg_id, service.skills,
                                 reg.age, reg.email, reg.education, reg.experience, reg.address, 
                                 (SELECT status FROM service_proposal WHERE service_id = service.id AND delete_flg = '0') as service_status,
                                  IF(service.id IN ( SELECT service_id  FROM service_proposal WHERE reg_id = '$my_id' AND service_id = service.id AND delete_flg = '0'
                                  ), '1', '0') as isHire
                                  FROM service_db service
                                  JOIN reg_db reg
                                  ON service.reg_id = reg.id
                                  WHERE reg.region = '$my_region'
                                  ORDER BY id DESC;";   
                        $result = $db->query($query); //Eto yung query
                        $count_result = mysqli_num_rows($result);
                        while($freelancer = mysqli_fetch_assoc($result)): //eto yung loop
                          $freelancer_id = $freelancer['reg_id'];

                          $ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $ratings_row = mysqli_fetch_assoc($ratings);

                          $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

                          $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$freelancer_id';");
                          $getClientDataRow = mysqli_fetch_assoc($getClientData);
                      ?>
                      <div class="post p-3"
                      style="background: #FFFDF6; 
                      display: <?php $freelancer['service_status'] == "1"? print("none"): print("block") ?>">
                        <div class="user-block">
                              <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                <img  src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" alt="..." class="img-circle">
                              <?php else: ?>
                                  <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                  class="img-circle">
                              <?php endif; ?>

                              <span class="username">
                                <a class="text-capitalize"
                                style="cursor: pointer;"
                                data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"
                                > <?= $freelancer['name']; ?></a>
                              </span>
                              <!-- <a href="admin/post_details.php?view=<?=$freelancer['service_id']?>&my_id=<?=$my_id?>" 
                                style="float: right; border-radius: 30px"
                                class="btn btn-success"
                                target="_blank">View</a> -->
                              <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time']))?></span>
                        </div>
                          
                        <h5 class="text-capitalize text-bold text-success">
                            <?= $freelancer['skills']; ?>
                        </h5>
                        <h6 class="text-dark">
                            Job Rate: <span class="text-bold">₱<?= $freelancer['rate']; ?></span>
                            <span class="text-secondary">/ <?= $freelancer['day_week']; ?> </span>
                        </h6>
                        <h6 class="text-capitalize text-bold text-dark">
                            <?= $freelancer['experience']; ?> 
                        </h6>
                        <p class="text-capitalize">
                            <?= $freelancer['description']; ?>
                        </p>      

                        <h6 class="text-capitalize text-dark px-2 text-bold">
                            <i class='fa fa-map-marker'></i>
                            <?php if($getClientDataRow["barangay"] != ""): ?>
                                <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                            <?php else:  ?>
                                No address to show
                            <?php endif;  ?>
                        </h6>

                        <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                        </p>
                      </div>
                      <div class="modal fade" 
                        id="view<?= $freelancer['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="p-3"
                                style="background-color: #f9d29d; background: url('/img/hero-area.jpg');">
                                      <div class="d-flex justify-content-center">
                                      <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                        <img src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" 
                                        alt="..." class="img-circle"
                                        height="200px"
                                        width="200px">
                                      <?php else: ?>
                                        <img class="img-circle"
                                            height="200px"
                                            width="200px"
                                            style="border: 10px double white"
                                            src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture">
                                      <?php endif; ?>
                                           
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h3 class="mt-2 text-capitalize text-light"><?= $freelancer['name']; ?></h3>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h6 class="text-capitalize text-light"><?= $freelancer['skills']; ?></h6>
                                      </div>

                                      <div class="d-flex justify-content-center">
                                              <?php
                                                if (empty($client_new_ratings_row['ave_rating'])) {
                                                  echo "<h5 class='text-light'>No ratings yet</h5>";
                                                } else {
                                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                                  for ($i=0; $i < $ratings ; $i++):
                                              
                                              ?>
                                              <i class='fa fa-star text-warning mx-1 mt-1'
                                                  style="font-size: 25px"></i>
                                              <?php endfor; 
                                              }?>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                      <button type="button" 
                                      onclick="hire_now('<?=$freelancer['id']?>', '<?=$id?>', '<?= $freelancer['isHire'] ?>')" 
                                      class="btn btn-light text-bold mt-4">
                                      <?php 
                                          if($freelancer['isHire'] == "0"):
                                            print("Hire Now");
                                          else: 
                                            print("Cancel Proposal");
                                          endif;
                                      ?>
                                      </button>
                                      </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top"  
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://www.pngitem.com/pimgs/m/117-1177878_square-academic-cap-graduation-ceremony-graduate-university-graduation.png" alt="Card image cap">
                                            <div class="card-body">
                                              <h5 class="card-title text-bold d-flex justify-content-center"><?= $freelancer['education']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Education</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              src="https://www.seekpng.com/png/detail/204-2048138_addressing-information-address-icon-logo.png" 
                                              height="100px"
                                              style="object-fit: cover"
                                              alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['address']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Address</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://th.bing.com/th/id/OIP.b4fmzMcI-x4KuYyYJltOgwHaHa?pid=ImgDet&rs=1" alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['experience']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Experience Level</h6>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php endwhile; 
                        if ($count_result < 1) {
                      ?>
                      <div class="d-flex flex-column">
                            <div class="d-flex justify-content-center">
                                <img src="images/result_no.png" alt=""
                                    height="500px" width="600px">
                            </div>
                            <div class="d-flex justify-content-center">
                                <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                            </div>
                      </div>
                      <?php
                        }
    } elseif ($filter_by == 'State') {
                        $query = "SELECT service.*, reg.id AS reg_id, service.skills, reg.age, reg.email, reg.education, reg.experience, reg.address,
                                  (SELECT status FROM service_proposal WHERE service_id = service.id AND delete_flg = '0') as service_status,
                                  IF(service.id IN ( SELECT service_id  FROM service_proposal WHERE reg_id = '$my_id' AND service_id = service.id AND delete_flg = '0'
                                  ), '1', '0') as isHire
                                  FROM service_db service
                                  JOIN reg_db reg
                                  ON service.reg_id = reg.id
                                  WHERE reg.province = '$my_province'
                                  ORDER BY id DESC;";   
                        $result = $db->query($query); //Eto yung query
                        $count_result = mysqli_num_rows($result);
                        while($freelancer = mysqli_fetch_assoc($result)): //eto yung loop
                          $freelancer_id = $freelancer['reg_id'];

                          $ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $ratings_row = mysqli_fetch_assoc($ratings);

                          $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

                          $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$freelancer_id';");
                          $getClientDataRow = mysqli_fetch_assoc($getClientData);
                      ?>
                      <div class="post p-3"
                      style="background: #FFFDF6; 
                      display: <?php $freelancer['service_status'] == "1"? print("none"): print("block") ?>">
                        <div class="user-block">
                              <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                <img  src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" alt="..." class="img-circle">
                              <?php else: ?>
                                  <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                  class="img-circle">
                              <?php endif; ?>

                              <span class="username">
                                <a class="text-capitalize"
                                style="cursor: pointer;"
                                data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"
                                > <?= $freelancer['name']; ?></a>
                              </span>
                              <!-- <a href="admin/post_details.php?view=<?=$freelancer['service_id']?>&my_id=<?=$my_id?>" 
                                style="float: right; border-radius: 30px"
                                class="btn btn-success"
                                target="_blank">View</a> -->
                              <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time']))?></span>
                        </div>
                          
                        <h5 class="text-capitalize text-bold text-success">
                            <?= $freelancer['skills']; ?>
                        </h5>
                        <h6 class="text-dark">
                            Job Rate: <span class="text-bold">₱<?= $freelancer['rate']; ?></span>
                            <span class="text-secondary">/ <?= $freelancer['day_week']; ?> </span>
                        </h6>
                        <h6 class="text-capitalize text-bold text-dark">
                            <?= $freelancer['experience']; ?> 
                        </h6>
                        <p class="text-capitalize">
                            <?= $freelancer['description']; ?>
                        </p>      

                        <h6 class="text-capitalize text-dark px-2 text-bold">
                            <i class='fa fa-map-marker'></i>
                            <?php if($getClientDataRow["barangay"] != ""): ?>
                                <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                            <?php else:  ?>
                                No address to show
                            <?php endif;  ?>
                        </h6>

                        <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                        </p>
                      </div>
                      <div class="modal fade" 
                        id="view<?= $freelancer['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="p-3"
                                style="background-color: #f9d29d; background: url('/img/hero-area.jpg');">
                                      <div class="d-flex justify-content-center">
                                        <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                          <img src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" 
                                          alt="..." class="img-circle"
                                          height="200px"
                                          width="200px">
                                        <?php else: ?>
                                          <img class="img-circle"
                                              height="200px"
                                              width="200px"
                                              style="border: 10px double white"
                                              src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture">
                                        <?php endif; ?>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h3 class="mt-2 text-capitalize text-light"><?= $freelancer['name']; ?></h3>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h6 class="text-capitalize text-light"><?= $freelancer['skills']; ?></h6>
                                      </div>

                                      <div class="d-flex justify-content-center">
                                              <?php
                                                if (empty($client_new_ratings_row['ave_rating'])) {
                                                  echo "<h5 class='text-light'>No ratings yet</h5>";
                                                } else {
                                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                                  for ($i=0; $i < $ratings ; $i++):
                                              
                                              ?>
                                              <i class='fa fa-star text-warning mx-1 mt-1'
                                                  style="font-size: 25px"></i>
                                              <?php endfor; 
                                              }?>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                        <button type="button" 
                                          onclick="hire_now('<?=$freelancer['id']?>', '<?=$id?>', '<?= $freelancer['isHire'] ?>')" 
                                          class="btn btn-light text-bold mt-4">
                                          <?php 
                                              if($freelancer['isHire'] == "0"):
                                                print("Hire Now");
                                              else: 
                                                print("Cancel Proposal");
                                              endif;
                                          ?>
                                        </button>
                                      </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top"  
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://www.pngitem.com/pimgs/m/117-1177878_square-academic-cap-graduation-ceremony-graduate-university-graduation.png" alt="Card image cap">
                                            <div class="card-body">
                                              <h5 class="card-title text-bold d-flex justify-content-center"><?= $freelancer['education']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Education</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              src="https://www.seekpng.com/png/detail/204-2048138_addressing-information-address-icon-logo.png" 
                                              height="100px"
                                              style="object-fit: cover"
                                              alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['address']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Address</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://th.bing.com/th/id/OIP.b4fmzMcI-x4KuYyYJltOgwHaHa?pid=ImgDet&rs=1" alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['experience']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Experience Level</h6>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php endwhile; 
                        if ($count_result < 1) {
                      ?>
                      <div class="d-flex flex-column">
                            <div class="d-flex justify-content-center">
                                <img src="images/result_no.png" alt=""
                                    height="500px" width="600px">
                            </div>
                            <div class="d-flex justify-content-center">
                                <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                            </div>
                      </div>
                      <?php
                        }
                  } elseif ($filter_by == 'Municipality') {
                        $query = "SELECT service.*, reg.id AS reg_id, service.skills, reg.age, reg.email, reg.education, reg.experience, reg.address,
                                  (SELECT status FROM service_proposal WHERE service_id = service.id AND delete_flg = '0') as service_status,
                                  IF(service.id IN ( SELECT service_id  FROM service_proposal WHERE reg_id = '$my_id' AND service_id = service.id AND delete_flg = '0'
                                  ), '1', '0') as isHire
                                  FROM service_db service
                                  JOIN reg_db reg
                                  ON service.reg_id = reg.id
                                  WHERE reg.municipality = '$my_municipality'
                                  ORDER BY id DESC;";   
                        $result = $db->query($query); //Eto yung query
                        $count_result = mysqli_num_rows($result);
                        while($freelancer = mysqli_fetch_assoc($result)): //eto yung loop
                          $freelancer_id = $freelancer['reg_id'];

                          $ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $ratings_row = mysqli_fetch_assoc($ratings);

                          $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

                          $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$freelancer_id';");
                          $getClientDataRow = mysqli_fetch_assoc($getClientData);
                      ?>
                      <div class="post p-3"
                      style="background: #FFFDF6; 
                      display: <?php $freelancer['service_status'] == "1"? print("none"): print("block") ?>">
                        <div class="user-block">
                              <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                <img  src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" alt="..." class="img-circle">
                              <?php else: ?>
                                  <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                  class="img-circle">
                              <?php endif; ?>

                              <span class="username">
                                <a class="text-capitalize"
                                style="cursor: pointer;"
                                data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"
                                > <?= $freelancer['name']; ?></a>
                              </span>
                              <!-- <a href="admin/post_details.php?view=<?=$freelancer['service_id']?>&my_id=<?=$my_id?>" 
                                style="float: right; border-radius: 30px"
                                class="btn btn-success"
                                target="_blank">View</a> -->
                              <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time']))?></span>
                        </div>
                          
                        <h5 class="text-capitalize text-bold text-success">
                            <?= $freelancer['skills']; ?>
                        </h5>
                        <h6 class="text-dark">
                            Job Rate: <span class="text-bold">₱<?= $freelancer['rate']; ?></span>
                            <span class="text-secondary">/ <?= $freelancer['day_week']; ?> </span>
                        </h6>
                        <h6 class="text-capitalize text-bold text-dark">
                            <?= $freelancer['experience']; ?> 
                        </h6>
                        <p class="text-capitalize">
                            <?= $freelancer['description']; ?>
                        </p>      

                        <h6 class="text-capitalize text-dark px-2 text-bold">
                            <i class='fa fa-map-marker'></i>
                            <?php if($getClientDataRow["barangay"] != ""): ?>
                                <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                            <?php else:  ?>
                                No address to show
                            <?php endif;  ?>
                        </h6>

                        <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                        </p>
                      </div>
                      <div class="modal fade" 
                        id="view<?= $freelancer['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="p-3"
                                style="background-color: #f9d29d; background: url('/img/hero-area.jpg');">
                                      <div class="d-flex justify-content-center">
                                      <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                        <img src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" 
                                        alt="..." class="img-circle"
                                        height="200px"
                                        width="200px">
                                      <?php else: ?>
                                        <img class="img-circle"
                                            height="200px"
                                            width="200px"
                                            style="border: 10px double white"
                                            src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture">
                                      <?php endif; ?>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h3 class="mt-2 text-capitalize text-light"><?= $freelancer['name']; ?></h3>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h6 class="text-capitalize text-light"><?= $freelancer['skills']; ?></h6>
                                      </div>

                                      <div class="d-flex justify-content-center">
                                              <?php
                                                if (empty($client_new_ratings_row['ave_rating'])) {
                                                  echo "<h5 class='text-light'>No ratings yet</h5>";
                                                } else {
                                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                                  for ($i=0; $i < $ratings ; $i++):
                                              
                                              ?>
                                              <i class='fa fa-star text-warning mx-1 mt-1'
                                                  style="font-size: 25px"></i>
                                              <?php endfor; 
                                              }?>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                        <button type="button" 
                                        onclick="hire_now('<?=$freelancer['id']?>', '<?=$id?>', '<?= $freelancer['isHire'] ?>')" 
                                        class="btn btn-light text-bold mt-4">
                                        <?php 
                                            if($freelancer['isHire'] == "0"):
                                              print("Hire Now");
                                            else: 
                                              print("Cancel Proposal");
                                            endif;
                                        ?>
                                        </button>
                                      </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top"  
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://www.pngitem.com/pimgs/m/117-1177878_square-academic-cap-graduation-ceremony-graduate-university-graduation.png" alt="Card image cap">
                                            <div class="card-body">
                                              <h5 class="card-title text-bold d-flex justify-content-center"><?= $freelancer['education']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Education</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              src="https://www.seekpng.com/png/detail/204-2048138_addressing-information-address-icon-logo.png" 
                                              height="100px"
                                              style="object-fit: cover"
                                              alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['address']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Address</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://th.bing.com/th/id/OIP.b4fmzMcI-x4KuYyYJltOgwHaHa?pid=ImgDet&rs=1" alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['experience']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Experience Level</h6>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php endwhile; 
                        if ($count_result < 1) {
                      ?>
                      <div class="d-flex flex-column">
                            <div class="d-flex justify-content-center">
                                <img src="images/result_no.png" alt=""
                                    height="500px" width="600px">
                            </div>
                            <div class="d-flex justify-content-center">
                                <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                            </div>
                      </div>
                      <?php
                        }
    } elseif ($filter_by == 'Barangay') {
                        $query = "SELECT service.*, reg.id AS reg_id,  service.skills, reg.age, reg.email, reg.education, reg.experience, reg.address,
                                  (SELECT status FROM service_proposal WHERE service_id = service.id AND delete_flg = '0') as service_status,
                                  IF(service.id IN ( SELECT service_id  FROM service_proposal WHERE reg_id = '$my_id' AND service_id = service.id AND delete_flg = '0'
                                  ), '1', '0') as isHire
                                  FROM service_db service
                                  JOIN reg_db reg
                                  ON service.reg_id = reg.id
                                  WHERE reg.barangay = '$my_barangay'
                                  ORDER BY id DESC;";   
                        $result = $db->query($query); //Eto yung query
                        $count_result = mysqli_num_rows($result);
                        while($freelancer = mysqli_fetch_assoc($result)): //eto yung loop
                          $freelancer_id = $freelancer['reg_id'];

                          $ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $ratings_row = mysqli_fetch_assoc($ratings);

                          $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

                          $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$freelancer_id';");
                          $getClientDataRow = mysqli_fetch_assoc($getClientData);
                      ?>
                      <div class="post p-3"
                      style="background: #FFFDF6; 
                      display: <?php $freelancer['service_status'] == "1"? print("none"): print("block") ?>">
                        <div class="user-block">
                              <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                <img  src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" alt="..." class="img-circle">
                              <?php else: ?>
                                  <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                  class="img-circle">
                              <?php endif; ?>

                              <span class="username">
                                <a class="text-capitalize"
                                style="cursor: pointer;"
                                data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"
                                > <?= $freelancer['name']; ?></a>
                              </span>
                              <!-- <a href="admin/post_details.php?view=<?=$freelancer['service_id']?>&my_id=<?=$my_id?>" 
                                style="float: right; border-radius: 30px"
                                class="btn btn-success"
                                target="_blank">View</a> -->
                              <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time']))?></span>
                        </div>
                          
                        <h5 class="text-capitalize text-bold text-success">
                            <?= $freelancer['skills']; ?>
                        </h5>
                        <h6 class="text-dark">
                            Job Rate: <span class="text-bold">₱<?= $freelancer['rate']; ?></span>
                            <span class="text-secondary">/ <?= $freelancer['day_week']; ?> </span>
                        </h6>
                        <h6 class="text-capitalize text-bold text-dark">
                            <?= $freelancer['experience']; ?> 
                        </h6>
                        <p class="text-capitalize">
                            <?= $freelancer['description']; ?>
                        </p>      

                        <h6 class="text-capitalize text-dark px-2 text-bold">
                            <i class='fa fa-map-marker'></i>
                            <?php if($getClientDataRow["barangay"] != ""): ?>
                                <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                            <?php else:  ?>
                                No address to show
                            <?php endif;  ?>
                        </h6>

                        <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                        </p>
                      </div>
                      <div class="modal fade" 
                        id="view<?= $freelancer['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="p-3"
                                style="background-color: #f9d29d; background: url('/img/hero-area.jpg');">
                                      <div class="d-flex justify-content-center">
                                      <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                        <img src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" 
                                        alt="..." class="img-circle"
                                        height="200px"
                                        width="200px">
                                      <?php else: ?>
                                        <img class="img-circle"
                                            height="200px"
                                            width="200px"
                                            style="border: 10px double white"
                                            src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture">
                                      <?php endif; ?>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h3 class="mt-2 text-capitalize text-light"><?= $freelancer['name']; ?></h3>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h6 class="text-capitalize text-light"><?= $freelancer['skills']; ?></h6>
                                      </div>

                                      <div class="d-flex justify-content-center">
                                              <?php
                                                if (empty($client_new_ratings_row['ave_rating'])) {
                                                  echo "<h5 class='text-light'>No ratings yet</h5>";
                                                } else {
                                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                                  for ($i=0; $i < $ratings ; $i++):
                                              
                                              ?>
                                              <i class='fa fa-star text-warning mx-1 mt-1'
                                                  style="font-size: 25px"></i>
                                              <?php endfor; 
                                              }?>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                      <button type="button" 
                                      onclick="hire_now('<?=$freelancer['id']?>', '<?=$id?>', '<?= $freelancer['isHire'] ?>')" 
                                      class="btn btn-light text-bold mt-4">
                                      <?php 
                                          if($freelancer['isHire'] == "0"):
                                            print("Hire Now");
                                          else: 
                                            print("Cancel Proposal");
                                          endif;
                                      ?>
                                      </button>
                                      </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top"  
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://www.pngitem.com/pimgs/m/117-1177878_square-academic-cap-graduation-ceremony-graduate-university-graduation.png" alt="Card image cap">
                                            <div class="card-body">
                                              <h5 class="card-title text-bold d-flex justify-content-center"><?= $freelancer['education']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Education</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              src="https://www.seekpng.com/png/detail/204-2048138_addressing-information-address-icon-logo.png" 
                                              height="100px"
                                              style="object-fit: cover"
                                              alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['address']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Address</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://th.bing.com/th/id/OIP.b4fmzMcI-x4KuYyYJltOgwHaHa?pid=ImgDet&rs=1" alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['experience']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Experience Level</h6>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                               </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php endwhile; 
                        if ($count_result < 1) {
                      ?>
                      <div class="d-flex flex-column">
                            <div class="d-flex justify-content-center">
                                <img src="images/result_no.png" alt=""
                                    height="500px" width="600px">
                            </div>
                            <div class="d-flex justify-content-center">
                                <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                            </div>
                      </div>
                      <?php
                        }
    } else {
                        $query = "SELECT service.*, reg.id AS reg_id, service.skills, reg.age, reg.email, reg.education, reg.experience, reg.address,
                                  (SELECT status FROM service_proposal WHERE service_id = service.id AND delete_flg = '0') as service_status,
                                  IF(service.id IN ( SELECT service_id  FROM service_proposal WHERE reg_id = '$my_id' AND service_id = service.id AND delete_flg = '0'
                                  ), '1', '0') as isHire
                                  FROM service_db service
                                  JOIN reg_db reg
                                  ON service.reg_id = reg.id
                                  ORDER BY id DESC;";   
                        $result = $db->query($query); //Eto yung query
                        $count_result = mysqli_num_rows($result);
                        while($freelancer = mysqli_fetch_assoc($result)): //eto yung loop
                          $freelancer_id = $freelancer['reg_id'];

                          $ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $ratings_row = mysqli_fetch_assoc($ratings);

                          $client_new_ratings = $db->query("SELECT AVG(rating) AS ave_rating FROM reviews_db WHERE reg_id = '$freelancer_id' AND delete_flg = '0';");
                          $client_new_ratings_row = mysqli_fetch_assoc($client_new_ratings);

                          $getClientData = $db->query("SELECT * FROM reg_db WHERE id = '$freelancer_id';");
                          $getClientDataRow = mysqli_fetch_assoc($getClientData);
                      ?>
                      <div class="post p-3"
                      style="background: #FFFDF6; 
                      display: <?php $freelancer['service_status'] == "1"? print("none"): print("block") ?>">
                        <div class="user-block">
                              <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                <img  src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" alt="..." class="img-circle">
                              <?php else: ?>
                                  <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                                  class="img-circle">
                              <?php endif; ?>

                              <span class="username">
                                <a class="text-capitalize"
                                style="cursor: pointer;"
                                data-toggle="modal" data-target="#view<?= $freelancer['id']; ?>"
                                > <?= $freelancer['name']; ?></a>
                              </span>
                              <!-- <a href="admin/post_details.php?view=<?=$freelancer['service_id']?>&my_id=<?=$my_id?>" 
                                style="float: right; border-radius: 30px"
                                class="btn btn-success"
                                target="_blank">View</a> -->
                              <span class="description">Posted - <?= Date("M/y/d h:i:s a", strtotime($freelancer['time']))?></span>
                        </div>
                          
                        <h5 class="text-capitalize text-bold text-success">
                            <?= $freelancer['skills']; ?>
                        </h5>
                        <h6 class="text-dark">
                            Job Rate: <span class="text-bold">₱<?= $freelancer['rate']; ?></span>
                            <span class="text-secondary">/ <?= $freelancer['day_week']; ?> </span>
                        </h6>
                        <h6 class="text-capitalize text-bold text-dark">
                            <?= $freelancer['experience']; ?> 
                        </h6>
                        <p class="text-capitalize">
                            <?= $freelancer['description']; ?>
                        </p>      

                        <h6 class="text-capitalize text-dark px-2 text-bold">
                            <i class='fa fa-map-marker'></i>
                            <?php if($getClientDataRow["barangay"] != ""): ?>
                                <?=$getClientDataRow['barangay']?>, <?=$getClientDataRow['municipality']?> <?=$getClientDataRow['province']?>
                            <?php else:  ?>
                                No address to show
                            <?php endif;  ?>
                        </h6>

                        <p class="text-dark text-bold mt-3">
                              <?php
                                if (empty($client_new_ratings_row['ave_rating'])) {
                                  echo "No ratings yet";
                                } else {
                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                  print("Ratings: ");
                                  for ($i=0; $i < $ratings ; $i++):
                               
                              ?>
                                 <i class='fa fa-star text-success'
                                   style="font-size: 12px"></i>
                                <?php endfor; 
                                }?>
                        </p>
                      </div>
                      <div class="modal fade" 
                        id="view<?= $freelancer['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="p-3"
                                style="background-color: #f9d29d; background: url('/img/hero-area.jpg');">
                                      <div class="d-flex justify-content-center">
                                      <?php if(file_exists("uploads/profile/freelance/".$getClientDataRow['profile_picture'])): ?>
                                        <img src="uploads/profile/freelance/<?=$getClientDataRow['profile_picture']?>" 
                                        alt="..." class="img-circle"
                                        height="200px"
                                        width="200px">
                                      <?php else: ?>
                                        <img class="img-circle"
                                            height="200px"
                                            width="200px"
                                            style="border: 10px double white"
                                            src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture">
                                      <?php endif; ?>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h3 class="mt-2 text-capitalize text-light"><?= $freelancer['name']; ?></h3>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                          <h6 class="text-capitalize text-light"><?= $freelancer['skills']; ?></h6>
                                      </div>

                                      <div class="d-flex justify-content-center">
                                              <?php
                                                if (empty($client_new_ratings_row['ave_rating'])) {
                                                  echo "<h5 class='text-light'>No ratings yet</h5>";
                                                } else {
                                                  $ratings = round($client_new_ratings_row['ave_rating'], 0);
                                                  for ($i=0; $i < $ratings ; $i++):
                                              
                                              ?>
                                              <i class='fa fa-star text-warning mx-1 mt-1'
                                                  style="font-size: 25px"></i>
                                              <?php endfor; 
                                              }?>
                                      </div>
                                      <div class="d-flex justify-content-center">
                                      <button type="button" 
                                      onclick="hire_now('<?=$freelancer['id']?>', '<?=$id?>', '<?= $freelancer['isHire'] ?>')" 
                                      class="btn btn-light text-bold mt-4">
                                      <?php 
                                          if($freelancer['isHire'] == "0"):
                                            print("Hire Now");
                                          else: 
                                            print("Cancel Proposal");
                                          endif;
                                      ?>
                                      </button>
                                      </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top"  
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://www.pngitem.com/pimgs/m/117-1177878_square-academic-cap-graduation-ceremony-graduate-university-graduation.png" alt="Card image cap">
                                            <div class="card-body">
                                              <h5 class="card-title text-bold d-flex justify-content-center"><?= $freelancer['education']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Education</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              src="https://www.seekpng.com/png/detail/204-2048138_addressing-information-address-icon-logo.png" 
                                              height="100px"
                                              style="object-fit: cover"
                                              alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['address']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Address</h6>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                          <div class="card mt-3" style="width: 15rem; height: 220px">
                                              <img class="card-img-top" 
                                              height="100px"
                                              style="object-fit: cover"
                                              src="https://th.bing.com/th/id/OIP.b4fmzMcI-x4KuYyYJltOgwHaHa?pid=ImgDet&rs=1" alt="Card image cap">
                                            <div class="card-body d-flex justify-content-center">
                                              <h5 class="card-title text-bold"><?= $freelancer['experience']; ?></h5>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center">
                                                <h6 class="mb-2 text-muted">Experience Level</h6>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php endwhile; 
                        if ($count_result < 1) {
                      ?>
                      <div class="d-flex flex-column">
                            <div class="d-flex justify-content-center">
                                <img src="images/result_no.png" alt=""
                                    height="500px" width="600px">
                            </div>
                            <div class="d-flex justify-content-center">
                                <h5 class="text-secondary text-bold mb-5">We couldn't find any results from the request you've sent to us</h5>
                            </div>
                      </div>
                      <?php
                        }
    }
  }
?>