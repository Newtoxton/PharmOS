<?php
	include_once('../connect.php');
	$id=$_GET['id'];
	$result = $dbo->prepare("DELETE FROM credit_pay WHERE id= :sno");
	$result->bindParam(':sno', $id);
	$result->execute();
	header('location:payment_report.php?d1=0&d2=0&customer=0');
?>
