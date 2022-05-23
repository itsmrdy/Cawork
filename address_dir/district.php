<?php 
    require_once '../core/init.php';
    $region_code = $_GET['regCode'];
    $db->query('SET NAMES utf8');
    $query = $db->query("SELECT * FROM refprovince WHERE regCode = '{$region_code}'");
    $rslt = $query->fetch_all(MYSQLI_ASSOC);
    if(!empty($rslt)){
        print(json_encode($rslt));
    }
?>