<?php
// configuration
include_once('../connect.php');

// new data
$qua = $_POST['quantity'];
$id = $_POST['pid'];
$batch = $_POST['batch'];



// query
$sql = "UPDATE inventory
        SET  quantity=?
		WHERE pid=? AND batch=? ";
$q = $dbo->prepare($sql);
$q->execute(array($qua,$id,$batch));
header("location: products.php");

?>
