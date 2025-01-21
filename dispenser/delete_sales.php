<?php

include_once ('../connect.php');
$id=$_GET['id'];
$quantity=$_GET['quantity'];
$product=$_GET['product'];
$invoice=$_GET['invoice'];


$sql = "UPDATE inventory
    SET quantity=quantity+?
    WHERE id=?";
$q = $dbo->prepare($sql);
$q->execute(array($quantity,$product));


mysqli_query($con, "delete from sales_list where transaction_id='$id'")or die(mysqli_error());


header("location: edit_invoice.php?id=$invoice");



?>
