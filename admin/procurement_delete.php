<?php

include_once ('../connect.php');


$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
	{ 
mysqli_query($con, "delete from procurement where id='$id[$i]'")or die(mysqli_error());
	}
	
	
header('location:procurement_report.php?d1=0&d2=0');



?>