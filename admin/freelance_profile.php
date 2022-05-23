<?php
  require_once '../core/init.php';
  $firstname = '';
  $middlename = '';
  $lastname= '';
  $birthday= '';
  $gender= '';
  $age= '';
  $place_birth = '';
  $street_no= '';
  $subdivision = '';
  $barangay = '';
  $municipality = '';
  $zipcode = '';
  $number = '';
  $email = '';
  $education = '';
  $skills = '';
  $rate= '';
  $time = '';
  $hour_week= '';
  $experience = '';
  $certificate = '';
  $primary= '';
  $secondary= '';
  $police = '';
  $diploma = '';
  $barangay_clearance= '';
  $region = '';
  $province = '';
  $dbpath = '';
  
  include_once '../work_arr.php';

  if(isset($_GET['edit'])){
    $id = $_GET['edit']; 
    $query = $db->query("SELECT * FROM reg_db WHERE reg_db.id = '$id'");
    $result = mysqli_fetch_assoc($query);
  }

  

  
  $acc_status = $db->query("SELECT status FROM reg_db WHERE id = '$id';");
  $accstatus = mysqli_fetch_assoc($acc_status);
  $account_status = $accstatus['status'];


  if(isset($_POST['submit_achievement_btn'])){
    $description = $_POST['additional_comment'];
    $subject = $_POST['subject'];
    $name = $_FILES['achievement_photo']['name'];
    $tmp_name = $_FILES['achievement_photo']['tmp_name'];
    $query = $db->query("SELECT id FROM t_user_achievements
    WHERE create_user = '{$id}' ORDER BY id DESC LIMIT 1");
    $r = mysqli_fetch_assoc($query);
    if(!empty($r)){
      $cert_id = md5($r['id']);
    }else{
      $cert_id = md5("1");
    }
    
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    $name = md5($id)."_"."achievement".$cert_id.".".$extension;
    $move = move_uploaded_file($tmp_name, "/var/www/html/uploads/achievements/".$name);

    if($move){
      $fields = "(achievement_title,achievement_description,achievement_photo,create_date,area,create_user)";
      $sql = "INSERT INTO t_user_achievements $fields 
      VALUES('{$subject}','{$description}','{$name}',NOW(),'Test','{$id}')";
      $r = $db->query($sql);
    }
  }
  if(isset($_POST['submit_certificate_btn'])){
    $description = $_POST['additional_comment'];
    $subject = $_POST['subject'];
    $name = $_FILES['certificate_photo']['name'];
    $tmp_name = $_FILES['certificate_photo']['tmp_name'];



    $query = $db->query("SELECT id FROM t_user_certificates
    WHERE create_user = '{$id}' ORDER BY id DESC LIMIT 1");
    $r = mysqli_fetch_assoc($query);
    if(!empty($r)){
      $cert_id = md5($r['id']);
    }else{
      $cert_id = md5("1");
    }
    
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    $name = md5($id)."_"."certificate_".$cert_id.".".$extension;
    $move = move_uploaded_file($tmp_name, "/var/www/html/uploads/certificates/".$name);

    if($move){
      $fields = "(certificate_title,certificate_description,certificate_photo,create_date,area,create_user)";
      $sql = "INSERT INTO t_user_certificates $fields 
      VALUES('{$subject}','{$description}','{$name}',NOW(),'','{$id}')";
      $r = $db->query($sql);
    }
  }

  //FETCH CERTIFICATES
  $query = $db->query("SELECT * FROM t_user_certificates WHERE create_user = '{$id}'");
  $certs = $query->fetch_all(MYSQLI_ASSOC);


  
  //FETCH CERTIFICATES
  $query = $db->query("SELECT * FROM t_user_experience WHERE create_user = '{$id}'");
  $exp_result = $query->fetch_all(MYSQLI_ASSOC);

  $query = $db->query("SELECT * FROM t_user_achievements WHERE create_user = '{$id}'");
  $achievement_data = $query->fetch_all(MYSQLI_ASSOC);

  if($_POST){

    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];

    $firstname = ((isset($_POST['firstname']) != '')?($_POST['firstname']):'');
    // $middlename  = ((isset($_POST['middlename ']) != '')?($_POST['middlename ']):'');
    $middlename = $_POST['middlename'];
    $lastname = ((isset($_POST['lastname']) != '')?($_POST['lastname']):'');
    $birthday= ((isset($_POST['birthday']) != '')?($_POST['birthday']):'');
    $gender= ((isset($_POST['gender']) != '')?($_POST['gender']):'');
    $age = ((isset($_POST['age']) != '')?($_POST['age']):'');
    $primary_name = $_POST['primary_id_name'] ?? "";
    $secondary_name = $_POST['secondary_id_name'] ?? "";
    // $place_birth  = ((isset($_POST['place_birth ']) != '')?($_POST['place_birth ']):'');
    $place_birth = $_POST['place_birth'];
    $street_no  = ((isset($_POST['street_no']) != '')?($_POST['street_no']):'');
    $subdivision  = ((isset($_POST['subdivision']) != '')?($_POST['subdivision']):'');
    $barangay = ((isset($_POST['barangay']) != '')?($_POST['barangay']):'');
    $municipality  = ((isset($_POST['municipality']) != '')?($_POST['municipality']):'');
    $zipcode  = ((isset($_POST['zipcode']) != '')?($_POST['zipcode']):'');
    $number= ((isset($_POST['number']) != '')?($_POST['number']):'');
    $email= ((isset($_POST['email']) != '')?($_POST['email']):'');
    $education = mysqli_real_escape_string($db, $_POST['education']);
    $skills  = ((isset($_POST['skills']) != '')?($_POST['skills']):'');
    $rate  = ((isset($_POST['rate']) != '')?($_POST['rate']):'');
    $time  = ((isset($_POST['time']) != '')?($_POST['time']):'');
    $hour_week  = ((isset($_POST['hour_week']) != '')?($_POST['hour_week']):'');
    $experience= ((isset($_POST['experience']) != '')?($_POST['experience']):'');
    $region = $_POST['region'];
    $province = $_POST['province'];

    include_once "../to_dir.php";

    $allowed_type = array('png','jpg','jpeg', 'jfif', 'webp', 'PNG', 'JPG');
  
    if(isset($_FILES['primary']['name'])){
      if (!empty($_FILES['primary']['name'])) {
        $file = $_FILES['primary'];
        $whole_filename = $file['name'];
        $from_dir = $file['tmp_name'];
        $extension = pathinfo($whole_filename, PATHINFO_EXTENSION);
        $name = $id."_"."primary_id.".$extension;
        $new_name = strtolower($name);
        $new_dir = $to_dir.$new_name;
        if (in_array($extension, $allowed_type)) {
          for ($i = 0; $i < count($allowed_type) ; $i++) { 
            if(file_exists("../uploads/documents/freelance/".$id."_"."primary_id.".$allowed_type[$i])){
              chmod("/var/www/html/uploads/documents/freelance/".$id."_"."primary_id.".$allowed_type[$i], 0777);
              unlink("/var/www/html/uploads/documents/freelance/".$id."_"."primary_id.".$allowed_type[$i]);
            }
          }
          chmod("/var/www/html/uploads/documents/freelance/".$new_name, 0777);
          $move = move_uploaded_file($from_dir, "/var/www/html/uploads/documents/freelance/".$new_name);
          if ($move) {
          } else{
            $error = "There was a problem uploading your primary photo.";
          }
        } else{
          $error = "Please upload image file only";
        }
          $primary = $new_name;
      }else{
           $primary = $result['primary_id'];
      }
    }

    
    if(isset($_FILES['secondary']['name'])){
      if (!empty($_FILES['secondary']['name'])) {
        $file = $_FILES['secondary'];
        $whole_filename = $file['name'];
        $from_dir = $file['tmp_name'];
        $extension = pathinfo($whole_filename, PATHINFO_EXTENSION);
        $name = $id."_"."secondary_id.".$extension;
        $new_name = strtolower($name);
        $new_dir = $to_dir.$new_name;
        if (in_array($extension, $allowed_type)) {
          for ($i = 0; $i < count($allowed_type) ; $i++) { 
            if(file_exists("../uploads/documents/freelance/".$id."_"."secondary_id.".$allowed_type[$i])){
              chmod("/var/www/html/uploads/documents/freelance/".$id."_"."secondary_id.".$allowed_type[$i], 0777);
              unlink("/var/www/html/uploads/documents/freelance/".$id."_"."secondary_id.".$allowed_type[$i]);
            }
          }
          chmod("/var/www/html/uploads/documents/freelance/".$new_name, 0777);
          $move = move_uploaded_file($from_dir, "/var/www/html/uploads/documents/freelance/".$new_name);
          if ($move) {
          } else{
            $error = "There was a problem uploading your secondary photo.";
          }
        } else{
          $error = "Please upload image file only";
        }
          $secondary = $new_name;
      }else{
          $secondary = $result['secondary_id'];
      }
    }



    
    if(isset($_FILES['certificate']['name'])){
      if (!empty($_FILES['certificate']['name'])) {
        $file = $_FILES['certificate'];
        $whole_filename = $file['name'];
        $from_dir = $file['tmp_name'];
        $extension = pathinfo($whole_filename, PATHINFO_EXTENSION);
        $name = $id."_"."certificate_id.".$extension;
        $new_name = strtolower($name);
        $new_dir = $to_dir.$new_name;
        if (in_array($extension, $allowed_type)) {
          for ($i = 0; $i < count($allowed_type) ; $i++) { 
            if(file_exists("/var/www/html/uploads/documents/freelance/".$id."_"."certificate_id.".$allowed_type[$i])){
              chmod("/var/www/html/uploads/documents/freelance/".$id."_"."certificate_id.".$allowed_type[$i], 0777);
              unlink("/var/www/html/uploads/documents/freelance/".$id."_"."certificate_id.".$allowed_type[$i]);
            }
          }
          chmod("/var/www/html/uploads/documents/freelance/".$new_name, 0777);
          $move = move_uploaded_file($from_dir, "/var/www/html/uploads/documents/freelance/".$new_name);
          if ($move) {
          } else{
            $error = "There was a problem uploading your certification photo.";
          }
        } else{
          $error = "Please upload image file only";
        }
          $certificate = $new_name;
      }else{
          $certificate = $result['certificate'];
      }
    }

   

    
    if(isset($_FILES['barangay_clearance']['name'])){
      if (!empty($_FILES['barangay_clearance']['name'])) {
        $file = $_FILES['barangay_clearance'];
        $whole_filename = $file['name'];
        $from_dir = $file['tmp_name'];
        $extension = pathinfo($whole_filename, PATHINFO_EXTENSION);
        $name = $id."_"."barangay_clearance_id.".$extension;
        $new_name = strtolower($name);
        $new_dir = $to_dir.$new_name;
        if (in_array($extension, $allowed_type)) {
          for ($i = 0; $i < count($allowed_type) ; $i++) { 
            if(file_exists("../uploads/documents/freelance/".$id."_"."barangay_clearance_id.".$allowed_type[$i])){
              chmod("/var/www/html/uploads/documents/freelance/".$id."_"."barangay_clearance_id.".$allowed_type[$i], 0777);
              unlink("/var/www/html/uploads/documents/freelance/".$id."_"."barangay_clearance_id.".$allowed_type[$i]);
            }
          }
          chmod("/var/www/html/uploads/documents/freelance/".$new_name, 0777);
          $move = move_uploaded_file($from_dir, "/var/www/html/uploads/documents/freelance/".$new_name);
          if ($move) {
          } else{
            $error = "There was a problem uploading your barangay clearance photo.";
          }
        } else{
          $error = "Please upload image file only";
        }
          $barangay_clearance = $new_name;
      }else{
          $barangay_clearance = $result['barangay_clearance'];
      }
    }



    
    
    if(isset($_FILES['diploma']['name'])){
      if (!empty($_FILES['diploma']['name'])) {
        $file = $_FILES['diploma'];
        $whole_filename = $file['name'];
        $from_dir = $file['tmp_name'];
        $extension = pathinfo($whole_filename, PATHINFO_EXTENSION);
        $name = $id."_"."diploma_id.".$extension;
        $new_name = strtolower($name);
        $new_dir = $to_dir.$new_name;
        if (in_array($extension, $allowed_type)) {
          for ($i = 0; $i < count($allowed_type) ; $i++) { 
            if(file_exists("../uploads/documents/freelance/".$id."_"."diploma_id.".$allowed_type[$i])){
              chmod("/var/www/html/uploads/documents/freelance/".$id."_"."diploma_id.".$allowed_type[$i], 0777);
              unlink("/var/www/html/uploads/documents/freelance/".$id."_"."diploma_id.".$allowed_type[$i]);
            }
          }
          chmod("/var/www/html/uploads/documents/freelance/".$new_name, 0777);
          $move = move_uploaded_file($from_dir, "/var/www/html/uploads/documents/freelance/".$new_name);
          if ($move) {
          } else{
            $error = "There was a problem uploading your diploma photo.";
          }
        } else{
          $error = "Please upload image file only";
        }
          $diploma = $new_name;
      }else{
          $diploma = $result['diploma'];
      }
    }

    
    if (!empty($_FILES['profile']['name'])) {
      $file = $_FILES['profile'];
      $whole_filename = $file['name'];
      $from_dir = $file['tmp_name'];
      $extension = pathinfo($whole_filename, PATHINFO_EXTENSION);
      $name = $id."_"."freelance.".$extension;
      $new_name = strtolower($name);
      $new_dir = $to_dir.$new_name;
      if (in_array($extension, $allowed_type)) {
        for ($i = 0; $i < count($allowed_type) ; $i++) { 
          if(file_exists("../uploads/profile/freelance/".$id."_"."freelance.".$allowed_type[$i])){
            chmod("/var/www/html/uploads/documents/freelance/".$id."_"."freelance.".$allowed_type[$i], 0777);
            unlink("/var/www/html/uploads/profile/freelance/".$id."_"."freelance.".$allowed_type[$i]);
          }
        }
        $move = move_uploaded_file($from_dir, "/var/www/html/uploads/profile/freelance/".$new_name);
        if ($move) {
        } else{
          $error = "There was a problem uploading your profile photo.";
        }
      } else{
        $error = "Please upload image file only";
      }
        $profile = $new_name;
    }else{
         $profile = $result['profile_picture'];
    }

    if(isset($_POST['delete_certificates'])){
      $certification_id = $_POST['delete_certificates'];
      $q = "DELETE FROM t_user_certificates WHERE id = '{$certification_id}'";
      $res = $db->query($q);
      header("Location: ../admin/freelance_profile.php?edit=$id");
    }

    if(isset($_POST['delete_achievement'])){
      $achievement_id = $_POST['delete_achievement'];
      $q = "DELETE FROM t_user_achievements WHERE id = '{$achievement_id}'";
      $res = $db->query($q);
      header("Location: ../admin/freelance_profile.php?edit=$id");
    }

    if(isset($_POST['delete_experience'])){
      $experience_id = $_POST['delete_experience'];
      $q = "DELETE FROM t_user_experience WHERE id = '{$experience_id}'";
      $res = $db->query($q);
      header("Location: ../admin/freelance_profile.php?edit=$id");
    }
    if(isset($_POST['submit_experience_btn'])){
      $currently_work = $_POST['currently_work'];
      $start_date = $_POST['start_date'];
      $subject = $_POST['subject'];
      $company_name = $_POST['company_name'];
      $additional_comment = $_POST['additional_comment'];
      $end_date = $currently_work == ""? $_POST['end_date']: Date("Y-m-d H:i:s");

      $current = $currently_work == ""? "0": "1";
      $fields = "(work_experience,company_name,work_description,start_date,end_date,create_user,current)";
      $exp_sql = "INSERT INTO t_user_experience $fields 
      VALUES('{$subject}','{$company_name}','{$additional_comment}','{$start_date}','{$end_date}','{$id}', '$current')";
      $db->query($exp_sql);
      header("Location: ../admin/freelance_profile.php?edit=$id");
    }

    
    if (empty($error)) {
      $skills = implode(', ', $skills);
      if(isset($_POST['submit'])){


        if($account_status == 3 || $account_status == 0 || $account_status == 1){
          $modified_status = 1; 
        }else{
          $modified_status = 2;
        }

        $query = $db->query("UPDATE reg_db SET `firstname` = '$firstname', `middlename` = '$middlename', 
        `lastname` = '$lastname', 
        `age` = '$age', 
        `gender` = '$gender',
        `place_birth` = '$place_birth', 
        `street_no` = '$street_no', 
        `subdivision` = '$subdivision', 
        `zipcode` = '$zipcode', 
        `number` = '$number', 
        `email` = '$email', 
        `education` = '$education', 
        `skills` = '$skills', 
        `rate` = '$rate', 
        `time_availability` = '$time', 
        `day_week` = '$hour_week', 
        `experience` = '$experience', 
        `primary_id` = '$primary', 
        `primary_id_name` = '$primary_name',
        `secondary_id` = '$secondary', 
        `secondary_id_name` = '$secondary_name',
        `police_clearance` = '$police', 
        `diploma` = '$diploma', 
        `barangay_clearance` = '$barangay_clearance', 
        `longitude` = '$longitude', 
        `latitude` = '$latitude', 
        `birthday` = '$birthday',
        profile_picture = '$profile', 
        certificate = '$certificate',
        status = '$modified_status',
        region = (SELECT regDesc FROM refregion WHERE regCode = '{$region}' OR regDesc = '{$region}' LIMIT 1), 
        province = (SELECT provDesc FROM refprovince WHERE provCode = '{$province}' OR provDesc = '{$province}' LIMIT 1),
        `barangay` = (SELECT brgyDesc FROM refbrgy WHERE brgyCode = '{$barangay}' OR  brgyDesc ='{$barangay}' LIMIT 1),
        `municipality` = (SELECT citymunDesc FROM refcitymun WHERE citymunCode = '{$municipality}' OR citymunDesc = '{$municipality}' LIMIT 1)  
        WHERE id = '$id'");


        $sql_delete = $db->query("DELETE FROM profile_db WHERE id = '$id'");
        if($sql_delete){
          $sql_insert = $db->query("INSERT INTO profile_db(`id`, `fname`, `mname`, `lname`, `birthday`, `gender`, `age`, `place_birth`, `street_no`, `subdivision`, `barangay`, `municipality`, `zipcode`, `number`, `email`, `education`, `skills`, `rate`, `time_availability`, `day_week`, `experience`, `certificate`, `primary_id`, `secondary_id`, `police_clearance`, `diploma`, `barangay_clearance`,`status`) 
          VALUES ('$id', '$firstname', '$middlename', '$lastname', '$birthday', '$gender', '$age', '$place_birth', '$street_no', '$subdivision', '$barangay', '$municipality', '$zipcode', '$number', '$email', '$education', '$skills', '$rate', '$time', '$hour_week', '$experience','$certificate','$primary', '$secondary', '$police', '$diploma', '$barangay_clearance','$modified_status')");
          
          if($account_status != 2){
            print("<script>alert('Your profile has been submitted to the administrator. If your profile is approved you can use all the features of cawork. If this is denied, you will need to resubmit your profile')</script>");
          }else{
            print("<script>alert('Your profile were updated successfully')</script>");
          }
        }

        
      echo "<script>window.location='../admin/freelance_profile.php?edit=$id'</script>";
      }
    } else {
      echo "<script>alert('".$error."');</script>";
    }
   
  }

  $educations_select = array('Primary Education', 'Secondary Education', 'Undergraduate', "Bachelor's Degree", "Master's Degree", "Doctor's Degree");

  $skills_selected = explode(', ', $result['skills']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaWork | Profile update</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
 
  <style>
    body{}
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    .card{
      border-top: 5px solid green;
    }
    .form-control{
      border-left: 2px solid green;
    }
  </style>
</head>
<body class="sidebar-is-closed sidebar-collapse">
  <div class="content-wrapper">
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
          <a href="#" class="navbar-brand">
            <span class="brand-text font-weight-bold text-success"
            style="font-family: Comic Sans MS, Comic Sans, cursive">Cawork</span>
          </a>

          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse order-5" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="nav nav-tabs ml-3 p-3">
              <li class="nav-item">
                <a href="#" class="nav-link text-secondary active" data-toggle="tab">Profile</a>
              </li>
              <li class="nav-item">
                <a href="../freelance.php" class="nav-link text-secondary">Home</a>
              </li>
            </ul>
          </div>
        </div>
        <a href="../logout.php" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i></a>
    </nav>
  


  <div>
    <div class="container">
      <form action="" method="POST" enctype="multipart/form-data">
        <!--START OF CARD 1 -->
        <a class="btn btn-light mt-3 text-success text-bold px-3"
        href="http://34.192.240.192/profile.php?log=<?= $_GET['edit']?>"
        style="border-radius: 30px; border: 1px solid #f0f2f5">
          See Public View
        </a>
        <div class="card mt-3">
              <div class="card-header">
                Basic Information
              </div>
              <div class="card-body">
                <div class="card-text">
                    <div class = "row">
                        <div class="col-md-4">
                          <label for="inputEmail4" class="form-label">Firstname</label>
                          <input type="text" name="firstname" class="form-control text-capitalize" id="inputEmail4" placeholder="Enter firstname" required value="<?=$result['firstname']?>"
                          readonly>
                        </div>
                        <div class="col-md-4">
                          <label for="inputEmail4" class="form-label">Middlename</label>
                          <input type="text" name="middlename" class="form-control text-capitalize" id="inputEmail4" placeholder="Enter middlename" required value="<?=$result['middlename']?>"
                          readonly>
                        </div>
                        <div class="col-md-4">
                          <label for="inputEmail4" class="form-label">Lastname</label>
                          <input type="text" name="lastname" class="form-control text-capitalize" id="inputEmail4" placeholder="Enter lastname" required value="<?=$result['lastname']?>"
                          readonly>
                        </div>
                    </div>

                    <div class = "row mt-3">
                        <div class="col-md-4">
                          <label for="inputEmail4" class="form-label">Birthday</label>
                          <input type="date" name="birthday" class="form-control" id="inputEmail4" placeholder="mm/dd/yyyy" 
                           value="<?= !empty($result['birthday']) ? Date("Y-m-d",  strtotime($result['birthday'])): ""?>" required>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="exampleInputEmail1" >Gender</label>
                            <select class="form-control" required name="gender" > 
                              <option value="male">Male</option>
                              <option value="female">Female</option>
                            </select>
                          </div>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="inputAddress" class="form-label">Age</label>
                            <input type="number" name="age" class="form-control" id="inputEmail4" placeholder="Enter age" required value="<?=$result['age']?>">
                        </div>
                    </div>

                    <div class = "row mt-2">
                        <div class="col-md-4">
                            <label for="inputAddress" class="form-label">Place of birth</label>
                            <input type="text" name="place_birth" class="form-control" id="inputEmail4" placeholder="Enter birthplace" required value="<?=$result['place_birth']?>">
                        </div>
                        <div class="col-md-4">
                            <label for="inputAddress" class="form-label">House street no.</label>
                            <input type="text" name="street_no" class="form-control" id="inputEmail4" placeholder="Enter House street no." required value="<?=$result['street_no']?>">
                        </div>
                        
                        <div class="col-md-4">
                            <label for="inputAddress" class="form-label">Subdivision</label>
                            <input type="text" name="subdivision" class="form-control" id="inputEmail4" placeholder="Enter Subdivision" required value="<?=$result['subdivision']?>">
                        </div>
                    </div>

                    <div class = "row mt-2">
                        <div class="col-3">
                          <label for="inputAddress" class="form-label">Regions</label>
                          <select name="region" class="form-control" required
                          id="region_select">
                              <?php 
                                  $sql_query = $db->query("SELECT * FROM refregion");
                                  while ($rslt = mysqli_fetch_assoc($sql_query)) {
                              ?>
                                  <?php if($rslt["regDesc"] == $result['region']): ?>
                                    <option value="<?= $rslt['regCode']?>" selected><?= $rslt['regDesc']?></option>
                                  <?php else: ?>
                                    <option value="<?= $rslt['regCode']?>"><?= $rslt['regDesc']?></option>
                                  <?php endif; ?>
                              <?php 
                                  }
                              ?>
                          </select>
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label">State/District</label>
                          <select id="province_element" name="province" class="form-control" required>
                            <option value="">State/District</option>
                          </select>
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label">Municipality</label>
                          <select id="city_select" name="municipality" class="form-control" required>
                            <option value="">Municipality</option>
                          </select>
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label">Barangay</label>
                          <select id="barangay_element" name="barangay" class="form-control">
                            <option value="">Barangay</option>
                          </select>
                        </div>
                    </div>


                    <div class = "row mt-2">
                        <div class="col-3">
                            <label for="inputAddress" class="form-label">Zipcode</label>
                            <input type="number" name="zipcode" class="form-control" id="inputEmail4" placeholder="Enter Zipcode" required value="<?=$result['zipcode']?>">
                        </div>
                        <div class="col-3">
                            <label for="inputAddress" class="form-label">Cellphone Number</label>
                            <input type="number" name="number" class="form-control" id="inputEmail4" max="9999999999" placeholder="Enter Cellphone number" required value="<?=$result['number']?>">
                        </div>
                        <div class="col-3">
                            <label for="inputAddress" class="form-label">Email Address</label>
                            <input type="text" name="email" class="form-control" id="inputEmail4" placeholder="Enter Email Address" required value="<?=$result['email']?>">
                        </div>
                        <div class="col-3">
                            <label for="inputAddress" class="form-label">Education</label>
                            <select name="education" required class="form-control">
                                <option value="">Education Completed</option>
                            <?php foreach ($educations_select as $key => $value): ?>
                                <option 
                                  <?php 
                                  if ($result['education'] === $value): 
                                      echo "selected";
                                  endif;
                                  ?>
                                >
                                  <?=$value?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                                  
                    
                    <!-- <div class="input-group mt-3">
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Profile Picture</span>
                      </div>
                      <div class="custom-file">
                        <input type="file" id="image" name="profile" class="custom-file-input">
                        <label class="custom-file-label" for="formFile">Choose file</label>
                      </div>
                    </div>     -->

                    <div class="form-group">
                      <label for="profile_photo" class="mt-2">Upload profile photo</label>
                      <div class="d-flex">
                                  <?php if(!empty($result['profile_picture'])) :?>
                                    <img src="../uploads/profile/freelance/<?= $result['profile_picture']?>" 
                                    height="50px" width="50px"
                                    class="img-circle mr-2" alt="">
                                  <?php endif; ?>

                        <div style="border: 1px solid lightgrey;
                        border-radius: 10px"
                        class="p-2">
                          <input type="file"
                          class="form-control-file" id="profile_photo"
                          value="<?= $result['profile_picture']; ?>"
                          name="profile">
                          <style>
                            ::-webkit-file-upload-button{
                              border: 1px solid lightgrey;
                              font-weight: bold;
                              padding: 5px;
                              border-radius: 8px;
                            }
                          </style>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>            
        </div>

      <!--END OF CARD 1 -->


      <!--START OF CARD 1 -->
        <div class="container">
          <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">* Skilled Worker Information<small></small></h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Select Skills</label>
                            <div class="select2-purple">
                              <select class="select2" 
                              multiple="multiple" data-placeholder="Select a Skills" 
                              name="skills[]"
                              data-dropdown-css-class="select2-purple" style="width: 100%;">
                                <?php
                                    foreach ($work_arr as $key => $value) {
                                  ?>
                                    <?php if(in_array($value, $skills_selected)): ?> 
                                      <option value="<?=$value?>" selected> <?=$value?></option>
                                    <?php else: ?> 
                                      <option value="<?=$value?>"> <?=$value?></option>
                                    <?php endif; ?>
                                  <?php
                                  }
                                ?>
                              </select>
                            </div>
                        </div>
                      </div>

                      <div class="col-md-5">
                            <div class="form-group">
                                  <label for="exampleInputEmail1">Time Availability</label>
                                  <div class="col-md-10">
                                    <div class="input-group has-validation">
                                    <input type="number" class="form-control mx-2" required name="time" id="validationCustomUsername" placeholder="0" value="<?=$result['time_availability']?>">
                                    <span class="input-group-text mx-1">Hours</span>
                                    <div class="invalid-feedback"></div>
                                        <select class="input-group-text" name="hour_week" aria-label="Default select example" required>
                                          <option selected value="day">/Day</option>
                                          <option value="week">/Week</option>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                      </div>
                      <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Experience</label>
                                <select class="form-control" required name="experience"> 
                                  <option value="Entry" <?php if ($result['experience'] === 'Entry') { echo "selected"; } ?>>Entry</option>
                                  <option value="Intermediate" <?php if ($result['experience'] === 'Intermediate') { echo "selected"; } ?>>Intermediate</option>
                                  <option value="Expert" <?php if ($result['experience'] === 'Expert') { echo "selected"; } ?>>Expert</option>
                              </select>
                            </div>
                      </div>
                    </div>

                    
                  <!-- <div class="form-group mt-3">
                      <label for="profile_photo" class="mt-2">Certificate (Optional)</label>

                      <div class="d-flex">
                      <img src="../uploads/documents/freelance/<?= $result['certificate']?>" 
                          height="50px" width="50px"
                          class="img-circle mr-2" alt="">
                        <div style="border: 1px solid lightgrey;
                        border-radius: 10px"
                        class="p-2">
                        <input type="file"
                          class="form-control-file" id="image"
                         value="<?= $result['certificate']; ?>"
                         name="certificate">
                          <style>
                            ::-webkit-file-upload-button{
                              border: 1px solid lightgrey;
                              font-weight: bold;
                              padding: 5px;
                              border-radius: 8px;
                            }
                          </style>
                        </div>
                      </div>
                  </div> -->
              </div>
          </div>
        </div>
      <!--END OF CARD 2-->

      
      <!--START OF CARD 3 -->
      <div class="container">
        <?php if($account_status != 2): ?>
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">* Requirements<small></small></h3>
              </div>
              <div class="card-body">
                  <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="photo" class="mx-2">Primary ID
                            <small>
                              <select class="form-control" name="primary_id_name" required>
                                <option value="">Select Primary ID</option>
                                <option value="Philippine Passport" 
                                <?php 
                                   if($result["primary_id_name"] == "Philippine Passport"){
                                     print("selected");
                                   }
                                ?>
                                >Philippine Passport</option>
                                <option value="Drivers License"
                                <?php 
                                   if($result["primary_id_name"] == "Drivers License"){
                                     print("selected");
                                   }
                                ?>
                                >Drivers License</option>
                                <option value="PhilHealth ID"
                                <?php 
                                   if($result["primary_id_name"] == "PhilHealth ID"){
                                     print("selected");
                                   }
                                ?>
                                >PhilHealth ID</option>
                                <option value="SSS UMID Card"
                                <?php 
                                   if($result["primary_id_name"] == "SSS UMID Card"){
                                     print("selected");
                                   }
                                ?>
                                >SSS UMID Card</option>
                                <option value="Postal ID"
                                <?php 
                                   if($result["primary_id_name"] == "Postal ID"){
                                     print("selected");
                                   }
                                ?>
                                >Postal ID</option>
                                <option value="TIN ID"
                                <?php 
                                   if($result["primary_id_name"] == "TIN ID"){
                                     print("selected");
                                   }
                                ?>
                                >TIN ID</option>
                                <option value="Voters ID"
                                <?php 
                                   if($result["primary_id_name"] == "Voters ID"){
                                     print("selected");
                                   }
                                ?>
                                >Voters ID</option>
                                <option value="PRC ID"
                                <?php 
                                   if($result["primary_id_name"] == "PRC ID"){
                                     print("selected");
                                   }
                                ?>
                                >PRC ID</option>
                                <option value="Senior Citizen ID"
                                <?php 
                                   if($result["primary_id_name"] == "Senior Citizen ID"){
                                     print("selected");
                                   }
                                ?>
                                >Senior Citizen ID</option>
                                <option value="OFW ID"
                                <?php 
                                   if($result["primary_id_name"] == "OFW ID"){
                                     print("selected");
                                   }
                                ?>
                                >OFW ID</option>
                              </select>
                            </small>
                          </label>

                          <div class="form-group mt-3">
                              <label for="profile_photo" class="mt-2">Photo of your id</label>
                              <div class="d-flex">
                                  <?php if(!empty($result['primary_id'])) :?>
                                    <img src="../uploads/documents/freelance/<?= $result['primary_id']?>" 
                                    height="50px" width="50px"
                                    class="img-circle mr-2" alt="">
                                  <?php endif; ?>

                                <div style="border: 1px solid lightgrey;
                                border-radius: 10px"
                                class="p-2">
                                <input type="file"
                                  class="form-control-file"  id="image"
                                value="<?= $result['primary_id']; ?>"
                                name="primary">
                                  <style>
                                    ::-webkit-file-upload-button{
                                      border: 1px solid lightgrey;
                                      font-weight: bold;
                                      padding: 5px;
                                      border-radius: 8px;
                                    }
                                  </style>
                                </div>
                              </div>
                          </div>

                        </div>
                        <div class="col-md-6">
                          <label for="photo" class="mx-2">Secondary ID (Optional)
                            <small>
                              <select class="form-control" name="secondary_id_name">
                                <option>Select Secondary ID</option>
                                <option
                                <?php 
                                   if($result["secondary_id_name"] == "NBI Clearance"){
                                     print("selected");
                                   }
                                ?>
                                >NBI Clearance</option>
                                <option
                                <?php 
                                   if($result["secondary_id_name"] == "Police Clearance"){
                                     print("selected");
                                   }
                                ?>
                                >Police Clearance</option>
                                <option
                                <?php 
                                   if($result["secondary_id_name"] == "Birth Certificate"){
                                     print("selected");
                                   }
                                ?>
                                >Birth Certificate</option>
                                <option
                                <?php 
                                   if($result["secondary_id_name"] == "Marriage Certificate"){
                                     print("selected");
                                   }
                                ?>
                                >Marriage Certificate</option>
                                <option
                                <?php 
                                   if($result["secondary_id_name"] == "Community Tax Certificate (Cedula)"){
                                     print("selected");
                                   }
                                ?>
                                >Community Tax Certificate (Cedula)</option>
                                <option
                                <?php 
                                   if($result["secondary_id_name"] == "GSIS ID"){
                                     print("selected");
                                   }
                                ?>
                                >GSIS ID</option>
                                <option
                                <?php 
                                   if($result["secondary_id_name"] == "IBP ID"){
                                     print("selected");
                                   }
                                ?>
                                >IBP ID</option>
                                <option
                                <?php 
                                   if($result["secondary_id_name"] == "Diplomat ID"){
                                     print("selected");
                                   }
                                ?>
                                >Diplomat ID</option>
                              </select>
                            </small>
                          </label>


                          <div class="form-group mt-3">
                              <label for="profile_photo" class="mt-2">Photo of your id</label>
                              <div class="d-flex">
                                  <?php if(!empty($result['secondary_id'])) :?>
                                    <img src="../uploads/documents/freelance/<?= $result['secondary_id']?>" 
                                    height="50px" width="50px"
                                    class="img-circle mr-2" alt="">
                                  <?php endif; ?>

                                <div style="border: 1px solid lightgrey;
                                border-radius: 10px"
                                class="p-2">
                                <input type="file"
                                  class="form-control-file" id="photo"
                                value="<?= $result['secondary_id']; ?>"
                                name="secondary">
                                  <style>
                                    ::-webkit-file-upload-button{
                                      border: 1px solid lightgrey;
                                      font-weight: bold;
                                      padding: 5px;
                                      border-radius: 8px;
                                    }
                                  </style>
                                </div>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-12">

                          <div class="form-group mt-3">
                                  <label for="profile_photo" class="mt-2">Diploma (Optional)</label>
                                <div class="d-flex">
                                  <?php if(!empty($result['diploma'])) :?>
                                    <img src="../uploads/documents/freelance/<?= $result['diploma']?>" 
                                    height="50px" width="50px"
                                    class="img-circle mr-2" alt="">
                                  <?php endif; ?>

                                  <div style="border: 1px solid lightgrey;
                                  border-radius: 10px"
                                  class="p-2">
                                  <input type="file"
                                    class="form-control-file" id="photo"
                                    value="<?= $result['diploma']; ?>"
                                    name="diploma">
                                    <style>
                                      ::-webkit-file-upload-button{
                                        border: 1px solid lightgrey;
                                        font-weight: bold;
                                        padding: 5px;
                                        border-radius: 8px;
                                      }
                                    </style>
                                  </div>
                                </div>
                            </div>

                            
                          <div class="form-group mt-3">
                                <label for="profile_photo" class="mt-2">Barangay Clearance ( Document must not expired )</label>
                                <div class="d-flex">
                                  <?php if(!empty($result['barangay_clearance'])) :?>
                                    <img src="../uploads/documents/freelance/<?= $result['barangay_clearance']?>" 
                                    height="50px" width="50px"
                                    class="img-circle mr-2" alt="">
                                  <?php endif; ?>
                                  <div style="border: 1px solid lightgrey;
                                  border-radius: 10px"
                                  class="p-2">
                                  <input type="file"
                                    class="form-control-file"  id="photo"
                                  value="<?= $result['barangay_clearance']; ?>"
                                  name="barangay_clearance">
                                    <style>
                                      ::-webkit-file-upload-button{
                                        border: 1px solid lightgrey;
                                        font-weight: bold;
                                        padding: 5px;
                                        border-radius: 8px;
                                      }
                                    </style>
                                  </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div> 
            </div>
        </div>
        <?php else: ?>
          <div class="card">
              <div class="card-header">
                <div class="card-title">
                  Certifications
                </div>
              </div>
              <div class="card-body">
                <?php 
                for ($i=0; $i < count($certs) ; $i++): ?>
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <img src="../uploads/certificates/<?=  $certs[$i]['certificate_photo']?>" 
                      height="150" width="200px"
                      style="border-radius: 10px"
                      alt="">
                    </div>
                    <div class="col-md-7">
                      <div class="d-flex flex-column">
                        <h5 class="text-bold text-success"><?= $certs[$i]['certificate_title'] ?></h5>
                        <p>
                          <?= $certs[$i]['certificate_description'] ?>
                        </p>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <button class="btn btn-light mt-5 ml-4"
                      type="submit"
                      value = "<?= $certs[$i]['id'] ?>"
                      name = "delete_certificates"
                      style="border-radius: 360px"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>
                <?php endfor; ?>
                
                <hr>
                  <div class="d-flex justify-content-center">
                    <div class="d-flex flex-column">
                        <span>Add certifications to highlight your best skills</span>
                        <center><span class="text-bold text-success"
                        style="cursor: pointer" data-toggle="modal" data-target="#certificate_modal">Add Certificates</span></center>
                    </div>
                  </div>
              </div>
          </div>


         
          
          
          <!--CERTIFICATIONS -->
          <div class="card">
              <div class="card-header">
                <div class="card-title">
                  Achievements
                </div>
              </div>
              <div class="card-body">
              <?php 
                for ($i=0; $i < count($achievement_data) ; $i++): ?>
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <img src="../uploads/achievements/<?=  $achievement_data[$i]['achievement_photo']?>" 
                      height="150" width="200px"
                      style="border-radius: 10px"
                      alt="">
                    </div>
                    <div class="col-md-7">
                      <div class="d-flex flex-column">
                        <h5 class="text-bold text-success"><?= $achievement_data[$i]['achievement_title'] ?></h5>
                        <p>
                          <?= $achievement_data[$i]['achievement_description'] ?>
                        </p>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <button class="btn btn-light mt-5 ml-4"
                      type="submit"
                      value = "<?= $achievement_data[$i]['id'] ?>"
                      name = "delete_achievement"
                      style="border-radius: 360px"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>
                <?php endfor; ?>

                <div class="d-flex justify-content-center">
                   <div class="d-flex flex-column">
                      <span>Add achievements to highlight your best skills</span>
                      <center><span class="text-bold text-success"
                      style="cursor: pointer" data-toggle="modal" data-target="#achievement_modal">Add Achievements</span></center>
                   </div>
                </div>
              </div>
          </div>


          <div class="card">
              <div class="card-header">
                <div class="card-title">
                Employment History
                </div>
              </div>
              <div class="card-body">
                  <?php for ($i=0; $i < count($exp_result) ; $i++): ?>
                    <div class="row mt-2">
                      <div class="col-md-10">
                        <div class="d-flex flex-column">
                          <h5 class="text-bold text-success"><?= $exp_result[$i]['work_experience'] ?> | <?= $exp_result[$i]['company_name'] ?></h5>
                          <p>
                            <?= Date("F-Y", strtotime($exp_result[$i]['start_date'])) ?> - 
                            <?php
                              if($exp_result[$i]['current'] == "1"):
                            ?>
                                Present
                            <?php else: ?>
                              <?= Date("F-Y", strtotime($exp_result[$i]['end_date'])) ?> 
                            <?php endif; ?>
                          </p>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-light float-right ml-5"
                        type="submit"
                        value = "<?= $exp_result[$i]['id'] ?>"
                        name = "delete_experience"
                        style="border-radius: 360px"><i class="fa fa-trash"></i></button>
                      </div>
                    </div>
                  <?php endfor; ?>
                 
                <div class="d-flex justify-content-center">
                   <div class="d-flex flex-column">
                      <span>Add any other experiences that help you stand out</span>
                      <center><span class="text-bold text-success"
                      style="cursor: pointer" data-toggle="modal" data-target="#experience_modal">Add Work Experience</span></center>
                   </div>
                </div>
              </div>
          </div>
        <?php endif; ?>
      </div>
      
      <!--END OF CARD 3 -->
          <div class="container">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">* Location *Longitude and Latitude can be identified from your map<small></small></h3>
                </div>
                <div class="card-body">
                        <div class="form-group row g-3">
                              <div class="col-md-4">
                                <label for="photo">Latitude</label>
                                <input type="text" name="latitude" class="form-control" placeholder="eg. 14.5995" required value="<?=$result['latitude']?>">
                              </div>
                              <div class="col-md-4">
                                <label for="photo">Longitude</label>
                                <input type="text" name="longitude" class="form-control" placeholder="eg. 120.9842 " required value="<?=$result['longitude']?>"> 
                              </div>
                        </div>
                        <div class="d-flex flex-column">
                              <a href="../cawork_map/map.php" target="_blank" class="text-sm text-success text-bold">Click here to open map guide</a>
                              <div class="d-flex mt-4">
                                <input type="submit" value="<?php $account_status != 2? print('Submit Profile'): print('Save'); ?>" name="submit" class="btn btn-primary mr-3"
                                onClick='return confirmSubmit()'/>
                                <a href="../freelance.php" class="btn btn-default">Cancel</a>
                              </div>
                        </div>
                 </div>
                </div>
              </div>
          </div>
    </form>
  </div>
</div>

<script>
function confirmSubmit(){
var agree= confirm("Are you sure you wish to continue?");
if (agree)
 return true ;
else
 return false ;
}
</script>


 <!--CERTIFICATION MODAL -->

          <div id="certificate_modal" style="margin-top:10%;" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                   <div class="modal-header">
                      <h5 class="text-bold">Add Certificate</h5>
                   </div>
                      <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" class="modal-body">
                                <input type="hidden" name="from_id" id="from_id">
                                <input type="hidden" name="user_id" id="user_id">
                                <div class="form-group">
                                    <input type="text" id="subject" class="form-control" name="subject" placeholder="Subject" required>
                                </div>
                                <div class="form-group">
                                    <textarea id="additional_comment" class="form-control" name="additional_comment" placeholder="Additional comment" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="certificate_photo" class="mt-2">Upload Photo</label>
                                    <div style="border: 1px solid lightgrey;
                                                  border-radius: 10px"
                                              class="p-2">
                                             <input type="file" id="certificate_photo" name="certificate_photo" class="form-control-file">
                                            <style>
                                                ::-webkit-file-upload-button{
                                                border: 1px solid lightgrey;
                                                font-weight: bold;
                                                padding: 5px;
                                                border-radius: 8px;
                                               }
                                            </style>
                                    </div>
                                </div>
                               <button type="submit" name="submit_certificate_btn" class="btn btn-primary text-center">Add</button>
                              <a class="btn btn-secondary text-center" data-dismiss="modal">Cancel</a>
                           </form>
                     </div>
                </div>
              </div>
          </div> 
  <!--ACHIEVMENT MODEL -->

  
        <div id="experience_modal" style="margin-top:10%;" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                   <div class="modal-header">
                      <h5 class="text-bold">Add Experience</h5>
                   </div>
                      <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" class="modal-body">
                                <div class="form-group">
                                    <input type="text" id="subject" class="form-control" name="subject" placeholder="Work" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="subject" class="form-control" name="company_name" placeholder="Company Name" required>
                                </div>

                                <div class="form-group">
                                    <textarea id="additional_comment" class="form-control" name="additional_comment" placeholder="Job Description" required></textarea>
                                </div>
                                          
                                <div class="row mb-3">
                                  <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">Start</label>
                                    <input type="date" name="start_date" class="form-control" id="inputEmail4" placeholder="Enter lastname" 
                                    value="<?= Date("Y-m-d")?>" required>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">End</label>
                                    <input type="date" name="end_date" class="form-control" id="inputEmail4" placeholder="Enter lastname" 
                                    value="<?= Date("Y-m-d")?>" required>
                                    

                                    <div class="form-check mt-3">
                                      <input class="form-check-input" type="checkbox" name="currently_work"
                                      id="work_here">
                                      <label class="form-check-label" for="work_here">
                                        I currently work here
                                      </label>
                                    </div>
                                  </div>
                                </div>
                               <button type="submit" name="submit_experience_btn" class="btn btn-primary text-center">Add</button>
                              <a class="btn btn-secondary text-center" data-dismiss="modal">Cancel</a>
                           </form>
                     </div>
                </div>
              </div>
          </div>                            

          <div id="achievement_modal" style="margin-top:10%;" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                   <div class="modal-header">
                      <h5 class="text-bold">Add Achievement</h5>
                   </div>
                      <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" class="modal-body">
                                <div class="form-group">
                                    <input type="text" id="subject" class="form-control" name="subject" placeholder="Subject" required>
                                </div>
                                <div class="form-group">
                                    <textarea id="additional_comment" class="form-control" name="additional_comment" placeholder="Additional comment" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="profile_photo" class="mt-2">Upload Photo</label>
                                    <div style="border: 1px solid lightgrey;
                                                  border-radius: 10px"
                                              class="p-2">
                                             <input type="file" id="achievement_photo" name="achievement_photo" class="form-control-file">
                                            <style>
                                                ::-webkit-file-upload-button{
                                                border: 1px solid lightgrey;
                                                font-weight: bold;
                                                padding: 5px;
                                                border-radius: 8px;
                                               }
                                            </style>
                                    </div>
                                </div>
                               <button type="submit" name="submit_achievement_btn" class="btn btn-primary text-center">Add</button>
                              <a class="btn btn-secondary text-center" data-dismiss="modal">Cancel</a>
                           </form>
                     </div>
                </div>
              </div>
          </div> 
          

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="../js/address.js"></script>
<!-- Page specific script -->

<script>
     $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
</script>
<script>
$(function () {
  $('#quickForm').validate({
    rules: {
      title: {
        required: true,
        minlength: 5
      },
      description: {
        required: true,
        minlength: 10
      },
      terms: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
  // $('input[type=checkbox]').click(function(){
  //   var count = $('input[type=checkbox]:checked').length
  //   if (count >= 4) {
  //     event.preventDefault();
  //     alert('You can only check 3');
  //   }
  // })
$('#submit_profile').click(function(){
  var count = $('input[type=checkbox]:checked').length
  if (count >= 1) {
  } else {
    event.preventDefault();
    alert('Please select skills');
  }
});

$("#region_select").change(function(){
    $.ajax({
      url: '../address_dir/district.php', 
      method: 'GET', 
      data: { 
        'regCode': $(this).val()
      }, 
      dataType: 'text', 
      success:function(response){
        var resp = JSON.parse(response);
        var selector = $('#province_element');
        var html; 
        for (let x = 0; x < resp.length; x++) {
          html += "<option value= "+ resp[x].provCode +">" + resp[x].provDesc + "</option>";
        }
        selector.html(html);
        $("#province_element").removeAttr('disabled');
      },error:function(err){
          alert("ERROR");
      }
    })
});


$("#province_element").change(function(){
    $.ajax({
      url: '../address_dir/municipal.php', 
      method: 'GET', 
      data: { 
        'provCode': $(this).val()
      }, 
      dataType: 'text', 
      success:function(response){
        var resp = JSON.parse(response);
        var selector = $('#city_select');
        var html; 
        for (let x = 0; x < resp.length; x++) {
          html += "<option value= "+ resp[x].citymunCode +">" + resp[x].citymunDesc + "</option>";
        }
        selector.html(html);
        $("#city_select").removeAttr('disabled');
      },error:function(err){
          alert("ERROR");
      }
    })
});


$("#city_select").change(function(){
    $.ajax({
      url: '../address_dir/baranggay.php', 
      method: 'GET', 
      data: { 
        'citymunCode': $(this).val()
      }, 
      dataType: 'text', 
      success:function(response){
        var resp = JSON.parse(response);
        var selector = $('#barangay_element');
        var html; 
        for (let x = 0; x < resp.length; x++) {
          html += "<option value= "+ resp[x].brgyCode +">" + resp[x].brgyDesc + "</option>";
        }
        selector.html(html);
        $("#barangay_element").removeAttr('disabled');
      },error:function(err){
          alert("ERROR");
      }
    })
});


//INITIAL DATA 
$("#province_element").html("<option selected><?= $result['province'] ?></option>");
$("#city_select").html("<option selected><?= $result['municipality'] ?></option>");
$("#barangay_element").html("<option selected><?= $result['barangay'] ?></option>");
</script>
</body>
</html>
