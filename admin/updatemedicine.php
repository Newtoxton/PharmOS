<?php
// configuration
include_once('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['trade_name'];
$b = $_POST['generic_name'];
$c = $_POST['type'];
$d = $_POST['retail'];
$e = $_POST['wsell'];


// query
$sql = "UPDATE medicine_list
        SET trade_name=?, generic_name=?, type=?, sell_price=?, wsell=?
		WHERE sno=?";
$q = $dbo->prepare($sql);
$q->execute(array($a,$b,$c,$d,$e,$id));
header("location: medicine_edit.php");

?>
