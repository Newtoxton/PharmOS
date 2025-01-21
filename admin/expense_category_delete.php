<?php

include_once ('../connect.php');
$id=$_GET['id'];

mysqli_query($con, "delete from expense_category where id='$id'")or die(mysqli_error());
header('location:expense_category.php');



?>