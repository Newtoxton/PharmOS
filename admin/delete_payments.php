<?php
	include_once('../connect.php');
	$id=$_GET['id'];
	$result = $dbo->prepare("DELETE FROM supplier_pay WHERE id= :sno");
	$result->bindParam(':sno', $id);
	$result->execute();
	header('location:supply_report.php?d1=0&d2=0&supplier=0');
?>