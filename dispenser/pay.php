<?php
// configuration
include_once('../connect.php');


				if (isset($_POST['register'])){
				$id=$_POST['id'];
				$total_bill=$_POST['total_bill'];
				$amount_paid=$_POST['amount_paid'];
				$date=$_POST['date'];
				$entrant=$_POST['entrant'];

				mysqli_query($con, "insert into supplier_payment (id,total_bill,amount_paid, date,entrant) values('$id','$total_bill','$amount_paid','$date','$entrant')")or die(mysqli_error());
				
				}
				header("location: inventory.php");
			
	
header("location: supplier_list.php");

?>