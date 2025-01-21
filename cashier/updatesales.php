<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['name'];
$b = $_POST['date'];

// query
$sql = "UPDATE sales_details
        SET customer=?, date=?
		WHERE id=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$id));
header("location: sales_search.php");

?>