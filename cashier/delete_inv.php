<?php
	include_once('../connect.php');
	$id=$_GET['id'];
	$invoice=$_GET['invoice'];

	
	mysqli_query($con, "delete from inventory where pid='$id'")or die(mysqli_error());

	
	header('location: edit_receipt.php?id='.$invoice);
?>