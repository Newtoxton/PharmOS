<?php
	include_once('../connect.php');
	$id=$_GET['id'];
	$quantyty=$_GET['quantity'];
	
$result = $db->prepare("SELECT * FROM inventory WHERE id= :userid");
$result->bindParam(':userid', $b);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
$qty=$row['quantity'];
}

	$sql = "UPDATE inventory 
        SET quantity=quantity+?
		WHERE id=?";

	
	$result = $db->prepare("DELETE FROM sales_list WHERE transaction_id= :id");
	$result->bindParam(':id', $id);
	$result->execute();
		header("location: sales_records.php");
?>