<?php 
    include_once '../models/User.php';
    include_once '../core/init.php';
    $user = new User($db);
    $skey = "2021_caWorkWebSiteThesis";
    if(isset($_POST['login_token'])){
        $token = $_POST['login_token'];
        if($token === $skey){
            foreach ($_REQUEST as $key => $val) {
                $user->$key = $val;
            }
            if($user->login() != 0){
                switch ($user->login()) {
                    case '1': header("Location: ../client.php"); break;
                    case '2': header("Location: ../freelance.php"); break;
                    case '3': header("Location: ../trainor.php"); break;
                    case '4': header("Location: ../admin/index.php"); break;
                    default:  header("Location: ../index.php"); break;
                }
            }else{
                $err = array();
                array_push($err, "Invalid username or password");
                header("Location: ../login.php?errors=".$err[0]);
            }
        }
    }
?>