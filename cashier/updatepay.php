<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['supplier'];
$b = $_POST['invoice_total'];
$c = $_POST['invoiceNo'];
$d = $_POST['invoiceDate'];
$e = $_POST['amount_paid'];
$f = $_POST['amount_due'];
// query
$sql = "UPDATE purchases
        SET supplier=?, invoice_total=?, invoiceNo=?, invoiceDate=?, amount_paid=? , amount_due=?
		WHERE id=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$c,$d,$e,$f,$id));
header("location: inventory.php");

?>
