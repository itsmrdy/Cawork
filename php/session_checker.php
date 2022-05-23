<?php
  include_once 'models/User.php';
  $db =  mysqli_connect('localhost', 'root', 'caworkdatabase', 'cawork');
  if(mysqli_connect_errno()){
    throw new Exception("Database connection is invalid. No database selected", 1);
  }else{
    session_start();
    try {
      $user = new User($db);
      if(isset($_SESSION['user_type'])){
        switch ($user->get_session('user_type')) {
          case '1': header("Location: ../client.php"); break;
          case '2': header("Location: ../freelance.php"); break;
          case '3': header("Location: ../trainor.php"); break;
          case '4': header("Location: ../admin/index.php"); break;
          default:  header("Location: ../index.php"); break;
        }
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  
?>