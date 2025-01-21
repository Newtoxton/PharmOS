<?php

include_once "../connect.php"; // database connection details stored here


foreach($_GET['brand'] as $state) {
  $query=mysqli_query($con, "SELECT  *  FROM `medicine_list` WHERE type  = '$state' ")or die(mysqli_error());
  while($row=mysqli_fetch_array($query)){

     echo $row['type'];
  }
  }

?>
