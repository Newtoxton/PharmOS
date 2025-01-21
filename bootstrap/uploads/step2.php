        <?php
         
		include_once "../connect.php"; // database connection details stored here

		if (isset($_POST['register'])){
		 
		mysqli_query($con, "DROP TABLE `bank`, `bank_deposit`, `bills`, `credit_pay`, `customer`, `expense_category`, `inventory`, `medicine_list`, `purchases`, `sales_details`, `sales_list`, `settings`, `supplier`, `supplier_pay`, `users`")or die(mysqli_error());
		
		header('Location: step3.php');exit;
		}
		 
      ?>