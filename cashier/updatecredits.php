<?php
// configuration
include_once('../connect.php');

// new data

$a = $_POST['id'];
$b = $_POST['pay'];
$c = $_POST['entrant'];
$d = $_POST['hand'];
$e = $_POST['ck_no'];



mysqli_query($con, "insert into supplier_pay (t_id,paid,entrant,hand,ck_no) values('$a','$b','$c','$d','$e')")or die(mysql_error());
	
				
header("location: inventory.php");

?>
