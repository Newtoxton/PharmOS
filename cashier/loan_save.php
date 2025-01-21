<?php
// configuration
include_once('../connect.php');

				if (isset($_POST['register'])){
				$a=$_POST['name'];
				$b=$_POST['loan'];
				$d=$_POST['installment'];
				$e=$_POST['start_date'];
                $f=$_POST['months'];
				$g=$_POST['rate'];
				
				mysqli_query($con, "insert into loans (name,loan,installment,start_date,months,rate) 
				values('$a','$b','$d','$e','$f','$g')")or die(mysqli_error());
				
				}
				

header("location: loan_pay.php");

?>