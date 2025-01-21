<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['deposit'];
$b = $_POST['date'];
$c = $_POST['entrant'];




// query
$sql = "UPDATE bank_deposit
        SET deposit=?, date=?, entrant=?
		WHERE id=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$c,$id));
header("location: deposit.php");

?>