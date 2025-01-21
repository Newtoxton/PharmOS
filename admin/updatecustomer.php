<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['name'];
$b = $_POST['address'];
$c = $_POST['phone'];
$d = $_POST['medicine'];
$e = $_POST['notes'];
// query
$sql = "UPDATE customer
        SET name=?, address=?, phone=?, medicine=?, notes=?
		WHERE id=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$c,$d,$e,$id));
header("location: customer.php");

?>