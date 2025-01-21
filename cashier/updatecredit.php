<?php
// configuration
include_once('../connect.php');

// new data

$a = $_POST['id'];
$b = $_POST['pay'];
$c = $_POST['entrant'];
$d = $_POST['hand'];



mysqli_query($con, "insert into credit_pay (t_id,paid,entrant,hand) values('$a','$b','$c','$d')")or die(mysql_error());
	
				
header("location: credit_payments.php?d1=0&d2=0&customer=0");

?>
