<?php
	include_once ('../connect.php');
	$id=$_GET['id'];
	$result = $db->prepare("DELETE FROM bank WHERE id= :id");
	$result->bindParam(':id', $id);
	$result->execute();
	header('location:bank.php');
?>