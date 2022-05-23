<?php 
    require_once '../core/init.php';
    $citymunCode = $_GET['citymunCode'];
    $db->query('SET NAMES utf8');
    $query = $db->query("SELECT * FROM refbrgy WHERE citymunCode = '{$citymunCode}'");
    $rslt = $query->fetch_all(MYSQLI_ASSOC);
    if(!empty($rslt)){
        print(json_encode($rslt));
    }
?>