<?php
	include_once ('../connect.php');
	$id=$_GET['id'];
	$c=$_GET['invoice'];
	$sdsd=$_GET['dle'];
	$quantity=$_GET['quantity'];
	$wapak=$_GET['code'];
	//edit qty
	$sql = "UPDATE inventory 
			SET quantity=quantity+?
			WHERE id=?";
	$q = $dbo->prepare($sql);
	$q->execute(array($quantity,$wapak));

	$result = $dbo->prepare("DELETE FROM sales_list WHERE transaction_id= :memid");
	$result->bindParam(':memid', $id);
	$result->execute();
	header("location: sales.php?id=$sdsd&invoice=$c");
?>