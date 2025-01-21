<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['name'];
$b = $_POST['address'];
$c = $_POST['phone'];
$d = $_POST['contact_person'];
$e = $_POST['notes'];
// query
$sql = "UPDATE supplier
        SET name=?, address=?, phone=?, contact_person=?, notes=?
		WHERE id=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$c,$d,$e,$id));
header("location: supplier.php");

?>