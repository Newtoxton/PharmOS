<?php

include_once ('../connect.php');
$id=$_GET['invoice'];

mysqli_query($con, "delete from invoices where invoice='$id'")or die(mysqli_error());
header('location:invoice_view.php');



?>