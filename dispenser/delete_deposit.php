<?php
	include_once ('../connect.php');
	$id=$_GET['id'];
	$result = $dbo->prepare("DELETE FROM bank_deposit WHERE id= :id");
	$result->bindParam(':id', $id);
	$result->execute();
	header('location:deposit.php');
?>