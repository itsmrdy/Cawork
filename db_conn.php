<?php

$sname="localhost";
$uname="root";
$password="caworkdatabase";
$db_name = "cawork";
$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn){
    throw new Exception("Database connection is invalid. No database selected", 1);
    exit();
}