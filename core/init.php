<?php
    $db =  mysqli_connect('localhost', 'root', 'caworkdatabase', 'cawork');
    session_start();
    if(mysqli_connect_errno()){
        throw new Exception("Database connection is invalid. No database selected", 1);
    }else{
        
    }
?>