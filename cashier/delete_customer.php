<?php

include_once ('../connect.php');
$id=$_GET['id'];

mysqli_query($con, "delete from customer where id='$id'")or die(mysqli_error());
header('location:customer.php');



?>