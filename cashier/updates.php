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

	$price= $_POST['price'][$i];
	$expiry_date= $_POST['expiry_date'][$i];
	$quantity= $_POST['quantity'][$i];
	$batch= $_POST['batch'][$i];
	$id = $_POST['id'][$i];
	
	 $query = "UPDATE inventory SET cost_price = '$price', qty_sold = '$quantity' , expiry_date = '$expiry_date', batch = '$batch'  WHERE pid = '$id' LIMIT 1";
	mysqli_query($con, $query) or die ("Error in query: $query");
	echo " Invoice Updated!<br />";
	header("location: inventory.php");
	++$i;
}
?>
</body>
</html>
