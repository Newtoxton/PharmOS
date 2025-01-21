<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['name'];
$b = $_POST['userid'];
$c = $_POST['mail'];
$d = $_POST['level'];

// query
$sql = "UPDATE users
        SET name=?, userid=?, mail=?, level=?
		WHERE id=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$c,$d,$id));
header("location: signup.php");

?>