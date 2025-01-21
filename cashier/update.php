<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Table</title>
</head>

<body>
<?php


include_once "../connect.php"; 

$size = count($_POST['price']);


$i = 0;
while ($i < $size) {
	$b= $_POST['sno'][$i];
	$price= $_POST['price'][$i];
	$qty1= $_POST['qty1'][$i];
	$quantity= $_POST['quantity'][$i];
	$amount= $_POST['amount'][$i];
	$id = $_POST['id'][$i];
	
	            $query= mysqli_query($con, "SELECT sno, cost_price FROM inventory WHERE `pid`= '$b'")or die(mysqli_error());
				while($row = mysqli_fetch_assoc($query)) {
				$sno=$row['sno'];
				$cost=$row['cost_price'];
				}
				
				$p = $price - $cost ;
	
				$profit=$p*$quantity;

				$query= mysqli_query($con, "UPDATE inventory SET quantity=quantity-'$quantity'  WHERE `pid`= '$b' LIMIT 1");


				
	$query = "UPDATE sales_list SET price = '$price', quantity = '$quantity', amount = '$amount', profit = '$price'  WHERE transaction_id = '$id' LIMIT 1";
	mysqli_query($con, $query) or die ("Error in query: $query");
	echo " Invoice Updated!<br />";
	header("location: invoice_list.php");
	++$i;
}
?>
</body>
</html>
