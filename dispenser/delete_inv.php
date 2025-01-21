<?php
	include_once('../connect.php');
	$invoiceNo=$_GET['invoiceNo'];
	$result = $dbo->prepare("DELETE FROM purchases WHERE invoiceNo= :invoiceNo");
	$result->bindParam(':invoiceNo', $invoiceNo);
	$result->execute();
	
	mysqli_query($con, "delete from inventory where invoice_id='$invoiceNo'")or die(mysqli_error());
	
	
	header('location:inventory.php');
?>