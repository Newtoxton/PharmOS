<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['batch'];
$b = $_POST['cost_price'];
$c = $_POST['quantity'];
$d = $_POST['expiry_date'];



// query
$sql = "UPDATE inventory
        SET batch=?, cost_price=?, quantity=?, expiry_date=?
		WHERE pid=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$c,$d,$id));
header("location: inventory_edit.php");

?>
