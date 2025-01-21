<?php
	include_once('../connect.php');
	$id=$_GET['id'];
	$result = $dbo->prepare("DELETE FROM users WHERE id= :id");
	$result->bindParam(':id', $id);
	$result->execute();
	header('location:signup.php');
?>