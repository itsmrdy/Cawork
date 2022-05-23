<?php 
    require_once 'core/init.php';

    $user_id = $_GET['log'];
    $logId = $_SESSION['userId'];

    //GET MY USER TYPE
    $sql_type = "SELECT user_type_id FROM reg_db WHERE id = '{$logId}'";
    $log_result = mysqli_fetch_assoc($db->query($sql_type));


    //GET USER DATA 
    $sql = "SELECT reg_db.*, profile_db.birthday as date_birth,profile_db.gender,
    profile_db.street_no, profile_db.rate as rate, profile_db.time_availability as rate_time, 
    profile_db.experience as experience FROM reg_db
    INNER JOIN profile_db ON reg_db.id = profile_db.id
    WHERE reg_db.id = $user_id";
    $result = mysqli_fetch_assoc($db->query($sql));
    
    if($result["user_type_id"] == 1){
        $user_type = "client";
    }else if($result["user_type_id"] == 2){
        $user_type = "freelance";
    }else if($result["user_type_id"] == 3){
        $user_type = "trainor";
    }
    $sql = "SELECT t_user_experience.* FROM t_user_experience
    WHERE create_user = $user_id";
    $work = $db->query($sql)->fetch_all(MYSQLI_ASSOC);
    $curr = null;
    if(empty($work)){
        $current_work = "No work experience";
        $current_company = "No company name";
        $current_description = "No description";
    }
    for ($i=0; $i < count($work) ; $i++) { 
        if($work[$i]["current"] == 1){
            $curr = 1;
            $current_work = $work[$i]["work_experience"];
            $current_company = $work[$i]["company_name"];
            $current_description = $work[$i]["work_description"];
        }
    }

    if($curr == null && !empty($work)){
        $i = 0;
        $current_work = $work[$i]["work_experience"];
        $current_company = $work[$i]["company_name"];
        $current_description = $work[$i]["work_description"];
    }


    $sql = "SELECT * FROM t_user_certificates WHERE create_user = $user_id";
    $certificates = $db->query($sql)->fetch_all(MYSQLI_ASSOC);

    
    $sql = "SELECT * FROM t_user_achievements WHERE create_user = $user_id";
    $achievements = $db->query($sql)->fetch_all(MYSQLI_ASSOC);


    if($user_type == "client"){
        $sql = "SELECT * FROM t_user_employment WHERE create_user = $user_id";
        $employment = $db->query($sql)->fetch_all(MYSQLI_ASSOC);
        $company_name = empty($employment[0]["company_name"])? "No company name to show": $employment[0]["company_name"];
        $company_address = empty($employment[0]["company_address"])? "No address to show": $employment[0]["company_address"];
        $phone_number = empty($employment[0]["phone_number"])? "No phone number": $employment[0]["phone_number"];
        $tel_number = empty($employment[0]["tel_number"])? "No telephone number": $employment[0]["tel_number"];
    }else{
        $company_name = "No company name to show";
        $company_address = "No address to show";
        $phone_number = "No phone number";
        $tel_number = "No telephone number";
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body style="background: #f0f2f5">
   
    <nav class="main-header navbar navbar-expand-md navbar-light bg-white">
        <div class="container">
          <a href="#" class="navbar-brand">
            <span class="brand-text fw-bold text-success"
            style="font-family: Comic Sans MS, Comic Sans, cursive">Cawork</span>
          </a>

          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse order-5" id="navbarCollapse">
            <ul class="nav nav-tabs ml-3 p-3">
              <li class="nav-item">
                <a href="#" class="nav-link text-secondary active" data-toggle="tab">Profile</a>
              </li>
              <li class="nav-item">
                <a href="#" id="home" class="nav-link text-secondary">Home</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
  

    <div class="container mt-5 bg-white p-0 mb-3"
    height="100vh"
    width="100%"
    style="border: 2px solid #e4e4eb;
    border-radius: 10px;">
        <div class="profile-header"
        width="100%"
        height="300px"
        style="border-bottom: 1px solid #f0f2f5">
            <div class="row mt-4 mx-5 mb-3 g-0">
                <div class="col-md-2">
                      <?php if(file_exists("uploads/profile/$user_type/".$result["profile_picture"])): ?>
                        <img src="uploads/profile/<?= $user_type ?>/<?=$result["profile_picture"]?>" alt="User profile picture"
                            height="150px"
                            width="150px"
                            class="rounded-circle bg-light">
                      <?php else: ?>
                          <img src="https://media.istockphoto.com/vectors/default-gray-placeholder-man-vector-id871752462?k=20&m=871752462&s=612x612&w=0&h=BTrZB8slanBvVw-1hwwf8mew5HkpDOyHIJAWDdBwIr8=" alt="User profile picture"
                            height="150px"
                            width="150px"
                            class="rounded-circle bg-light">
                      <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <h3 class="text-bold mt-3"><?= $result["firstname"]." ".$result["lastname"] ?></h3>
                        <h6 class="fw-light text-capitalize"><?= $result["street_no"] ?> <?= $result["barangay"]." ".$result["municipality"]." ".$result["province"]?></h6>
                        <h5><?= $result["region"] ?></h5>
                        <h5><?= $result["number"] ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-body">
            <div class="row g-0">
                <div class="col-md-5 p-5">
                    <div class="d-flex flex-column">
                        <h4>Profile Information</h4>
                        <h5>Age</h5>
                        <h6 class="fw-light"><?= $result["age"] ?> years old</h6>
                        <h5 class="mt-3">Birth Place</h5>
                        <h6 class="fw-light"><?= $result["place_birth"] ?></h6>

                        <h5 class="mt-3">Education</h5>
                        <h6 class="fw-light"><?= $result["education"] ?></h6>

                        <h5 class="mt-3">Email Address</h5>
                        <h6 class="fw-light"><?= $result["email"] ?></h6>
                        <!-- <h6 class="fw-light">Bachelor of Science in Information Technology</h6>
                        <h6 class="fw-bold">2019-2020</h6> -->
                    </div>
                </div>
                <?php if($user_type != "client"): ?> 
                    <div class="col-md-7"
                    style="border-left: 1px solid #f0f2f5;">
                        <div class="p-4">
                            <h4 class="fw-bold text-success"><?= $current_work ?> | <?= $current_company ?></h4>
                            <!-- <h5>Php. <?= $result['rate'] ?> / <?= $result['rate_time'] ?></h5> -->
                            <p><?= $current_description ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                 <?php 
                            if($user_type == "client"):
                        ?>
                        <div class="col-md-7 p-5"
                            style="border-left: 1px solid #f0f2f5;">
                            <h4>Employment Background</h4>
                            <div class="d-flex flex-column">
                                <small class="text-secondary">Company Name</small>
                                <h5 class="text-success fw-bold"><?= $company_name ?></h5>
                                
                                <small class="text-secondary">Company Address</small>
                                <h5 class="text-success fw-bold"><?= $company_address ?></h5>
                                
                                <small class="text-secondary">Mobile Number</small>
                                <h5 class="text-success fw-bold"><?= $phone_number ?></h5>

                                <small class="text-secondary">Telephone Number</small>
                                <h5 class="text-success fw-bold"><?= $tel_number ?></h5>
                            </div>
                        </div>
                <?php endif; ?>
            </div>

            <div class="row g-0">
                <div class="col-md-5 p-5">
                    <h5 class="mt-3">Birthday</h5>
                    <h6 class="fw-light"><?= Date("F m, Y", strtotime($result["date_birth"])) ?></h6>
                    <h5 class="mt-3">Gender</h5>
                    <h6 class="fw-light text-capitalize"><?= $result["gender"] ?></h6>
                    
                </div>
                <?php if($user_type != "client"): ?>
                    <div class="col-md-7"
                    style="border-top: 1px solid #f0f2f5;border-left: 1px solid #f0f2f5;">
                        <div class="p-4">
                            <h4 class="mt-2">Work History</h4>
                            <div class="p">
                                <ul>
                                    <?php for ($i=0; $i < count($work) ; $i++): ?>
                                        <li class="fs-5"><?= $work[$i]["work_experience"] ?> at 
                                        <span class="text-success fw-bold"><?= $work[$i]["company_name"] ?></span> | <span class="fw-bold"><?= Date("Y",strtotime($work[$i]["start_date"])) ?> - 
                                        <?= Date("Y",strtotime($work[$i]["end_date"])) ?></span></li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                            
                            <?php if(empty($work)): ?>
                                <h5 class="p-3 fw-light d-flex justify-content-center">No work history</h5>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <div class="row g-0">
                <div class="col-md-5 px-5 d-none">
                    <?php if($log_result['user_type_id'] == "4"):?>
                        <h5>Others</h5>
                        <h6 class="fw-light mt-2">
                        <a href="http://54.89.219.104/uploads/documents/<?= $user_type."/".$result['primary_id']?>"
                        target="_blank"><i class="fas fa-eye"></i></a>
                        <?php empty($result['primary_id_name'])? print("Attachment"): $result['primary_id_name']; ?></h6>
                        <h6 class="fw-light mt-2">
                        <a href="http://54.89.219.104/uploads/documents/<?= $user_type."/".$result['secondary_id']?>"
                        target="_blank"><i class="fas fa-eye"></i></a>
                        <?php empty($result['secondary_id_name']) ? print("Attachment"): $result['secondary_id_name'] ?></h6>
                        <h6 class="fw-light mt-2">
                        <a href="http://54.89.219.104/uploads/documents/<?= $user_type."/".$result['diploma']?>"
                        target="_blank"><i class="fas fa-eye"></i></a>
                        Diploma</h6>
                        <h6 class="fw-light mt-2">
                        <a href="http://54.89.219.104/uploads/documents/<?= $user_type."/".$result['barangay_clearance']?>"
                        target="_blank"><i class="fas fa-eye"></i></a>
                        Barangay Clearance</h6>
                    <?php endif; ?>
                </div>
                <?php if($user_type != "client"): ?>
                    <div class="col-md-7"
                    style="border-top: 1px solid #f0f2f5;border-left: 1px solid #f0f2f5;">
                        <div class="p-4">
                            <h4>Skills</h4>
                            <div class="p-2">
                                <?php 
                                    $cats = explode(",", $result['skills']); 
                                    for ($i=0; $i < count($cats) ; $i++):
                                ?>
                                    <span class="badge rounded-pill bg-light text-dark fs-6 mt-1"><?= $cats[$i] ?></span>
                                <?php endfor; ?>
                            </div>

                            <?php if(empty($result['skills']) || $result['skills'] == null): ?>
                                <h5 class="p-3 fw-light d-flex justify-content-center">No skills</h5>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($user_type != "client"): ?>
    <div class="container mt-3 bg-white mx-auto p-0"
    height="100vh"
    style="border: 2px solid #e4e4eb;
    border-radius: 10px;">
        <div class="p-4"
        style="border-bottom: 1px solid #f0f2f5">
            <h5>Certifications</h5>
        </div>

        <div class="certication-body">
            <?php for ($i=0; $i < count($certificates) ; $i++): ?>
                <div class="row p-5">
                    <div class="col-md-2 p-2">
                        <img src="uploads/certificates/<?= $certificates[$i]["certificate_photo"]?>" 
                        height="100%"
                        width="100%"
                        alt="">
                    </div>
                    <div class="col-md-7 p-3">
                        <h5 class="text-success fw-bold"><?= $certificates[$i]["certificate_title"] ?></h5>
                        <h6 class="fw-light"><?= $certificates[$i]["certificate_description"] ?></h6>
                        <h6><?= Date("F Y", strtotime($certificates[$i]["create_date"])) ?></h6>
                    </div>
                </div>   
            <?php endfor; ?>

            <?php if(empty($certificates)): ?>
                <h5 class="p-3 fw-light d-flex justify-content-center">No certifications</h5>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>


    <?php if($user_type != "client"): ?>
    <div class="container mt-3 bg-white mx-auto p-0 mb-4"
    height="100vh"
    style="border: 2px solid #e4e4eb;
    border-radius: 10px;">
        <div class="p-4"
        style="border-bottom: 1px solid #f0f2f5">
            <h5>Achievements</h5>
        </div>

        <div class="certication-body">
            <?php for ($i=0; $i < count($achievements) ; $i++): ?>
                <div class="row p-5">
                    <div class="col-md-2 p-2">
                        <img src="uploads/achievements/<?= $achievements[$i]["achievement_photo"]?>" 
                        height="100%"
                        width="100%"
                        alt="">
                    </div>
                    <div class="col-md-7 p-3">
                        <h5 class="text-success fw-bold"><?= $achievements[$i]["achievement_title"] ?></h5>
                        <h6 class="fw-light"><?= $achievements[$i]["achievement_description"] ?></h6>
                        <h6><?= Date("F Y", strtotime($achievements[$i]["create_date"])) ?></h6>
                    </div>
                </div>   
            <?php endfor; ?>
            <?php if(empty($certificates)): ?>
                <h5 class="p-3 fw-light d-flex justify-content-center">No Achievements</h5>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</body>
<script>
    var home = document.getElementById("home");
    home.addEventListener("click", function(){
        window.history.back();
    });
</script>
</html>