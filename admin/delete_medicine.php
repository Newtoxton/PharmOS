<?php
	include_once('../connect.php');
	$id=$_GET['id'];
	$result = $dbo->prepare("DELETE FROM medicine_list WHERE sno= :sno");
	$result->bindParam(':sno', $id);
	$result->execute();
	header('location:medicine_edit.php');
?>