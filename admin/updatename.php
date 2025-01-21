<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['supplier'];
$b = $_POST['date'];
$c = $_POST['num'];

// query
$sql = "UPDATE purchases
        SET supplier=?, invoiceDate=?, invoiceNo=?
		WHERE id=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$c,$id));
header("location: edit_receipt.php?id=".$id);

?>
