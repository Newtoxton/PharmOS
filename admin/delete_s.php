<?php
	include_once('../connect.php');
	$id=$_GET['invoice'];
	$result = $dbo->prepare("DELETE FROM sales_details WHERE id= :id");
	$result->bindParam(':id', $id);
	$result->execute();
	
	mysqli_query($con, "delete from sales_list where invoice='$id'")or die(mysqli_error());
	
	
	header('location:pos_list.php');
?>