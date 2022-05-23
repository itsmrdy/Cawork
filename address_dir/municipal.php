<?php 
    require_once '../core/init.php';
    $db->query('SET NAMES utf8');
    $prov_code = $_GET['provCode'];
    $query = $db->query("SELECT * FROM refcitymun WHERE provCode = '{$prov_code}'");
    $resultArray = $query->fetch_all(MYSQLI_ASSOC);
   
    if(!empty($resultArray)){
        print(json_encode($resultArray));
    }
?>