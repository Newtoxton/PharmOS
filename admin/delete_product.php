<?php
	include_once('../connect.php');
	$id=$_GET['id'];
	$result = $dbo->prepare("DELETE FROM inventory WHERE pid= :sno");
	$result->bindParam(':sno', $id);
	$result->execute();
	header('location:inventory_edit.php');
?>