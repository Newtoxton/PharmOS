<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Table</title>
</head>

<body>
<?php


include_once "../connect.php"; 


$supplier = $_POST['supplier'];
$date     = date("d/m/Y");
if(isset($_SESSION['userid'])){
	
	$entrant  = $_SESSION['userid'];
							}
							
$mid      = $_POST['mid'];


$queryn   = mysqli_query($con, "INSERT INTO credit_details (`tno`,`supplier`,`date`, `entrant`)
							VALUES ('$mid','$supplier','$date', '$entrant') ")or die(mysqli_error());

$g        = mysqli_query($con, "select max(id) from `credit_details`")or die('Error: ' . mysqli_error($con));
$row      = mysqli_fetch_row($g);
$invoice  = $row[0];


$size = count($_POST['price']);
$i = 0;
while ($i < $size) {

	$price			= $_POST['price'][$i];
	$expiry_date	= $_POST['expiry_date'][$i];
	$qty1     		= $_POST['qty1'][$i];
	$quantity		= $_POST['quantity'][$i];
	$batch			= $_POST['batch'][$i];
	$id 			= $_POST['id'][$i];
	$sno 			= $_POST['sno'][$i];
	$var            = $qty1 - $quantity;
	
	$query = "UPDATE inventory SET cost_price = '$price', qty_sold = '$quantity' , expiry_date = '$expiry_date', batch = '$batch'  WHERE pid = '$id' LIMIT 1";
	mysqli_query($con, $query) or die ("Error in query: $query");
	
	
	IF ($var > 0){
				$query   = "INSERT INTO credit_list (`invoice`, `product`, `quantity`, `sno`, `price`)
	                                    VALUES ('$invoice', '$id', '$var', '$sno', '$price')";  mysqli_query($con, $query);
																			}
	echo " Invoice Updated!<br />";
	header("location: inventory.php");
	++$i;
}
?>
</body>
</html>
