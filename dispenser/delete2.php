<?php
	include_once ('../connect.php');
	$id=$_GET['id'];
	$c=$_GET['invoice'];
	$sdsd=$_GET['dle'];
	$quantity=$_GET['quantity'];
	$wapak=$_GET['code'];
	//edit qty
	
	$q = $dbo->prepare($sql);
	$q->execute(array($quantity,$wapak));

	$result = $dbo->prepare("DELETE FROM invoices WHERE transaction_id= :memid");
	$result->bindParam(':memid', $id);
	$result->execute();
	header("location: invoice.php?id=$sdsd&invoice=$c");
?>