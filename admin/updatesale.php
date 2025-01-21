<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['supplier'];
$b = $_POST['invoice'];
$c = $_POST['date'];

// query
$sql = "UPDATE purchases
        SET supplier=?, invoiceNo=?, invoiceDate=?
		WHERE id=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$c,$id));
header("location: inventory.php");

?>