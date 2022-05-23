<?php
require_once 'core/init.php';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
      $username = test_input($_POST['username']);
      $password = test_input($_POST['password']);
      $role = test_input($_POST['role']);
       
      if (empty($username)){
        header("location: login.php?error=USERNAME is required");
    }
    else if (empty($password)){
        header("location: login.php?error=PASSWORD is required");
    }
    else{
        
        //$password = md5($password);
        $sql= "SELECT * FROM reg_db WHERE username='$username' AND password='$password'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) ==1){
            $row = mysqli_fetch_assoc($result);
           if ($row['password']==$password && $row['role']==$role){
            
            $_SESSION['name'] = $row['name'];
            $_SESSION['age'] = $row['age'];
            $_SESSION['address'] = $row['address'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['role'] = $row['role'];

            if($_SESSION['role'] == 'admin'){
                header("location: admin/index.php");}
            

            if ($_SESSION['role'] == 'client'){
            header("location: profile2.php");
            }

            if($_SESSION['role'] == 'freelance'){
                header("location: profile.php");
            }
           
            
        }
           
        }
        else {
            header("location: login.php?error=incorrect username or password");
        }

    } 
    }
    else{
        header("location: login.php");
    }
