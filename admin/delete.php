<?php
  require_once '../core/init.php';
  $title = '';
  $description = '';
   
  $moduleid=$_GET['mi'];
    $query = $db->query("DELETE FROM module WHERE moduleid = '$mi'");
    if ($data)
    {
        echo '<script>
        alert("DELETED!");
        window.location="table.php";
      </script>';
    }
    else
    {
        echo '<script>
        alert("FAILED!");
        window.location="table.php";
      </script>';
    }

  ?>