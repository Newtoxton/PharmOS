<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Select Query</title>
</head>

<body>
<?php

include_once "../connect.php"; 


$sql = "select c.trade_name, s.transaction_id, s.invoice, s.quantity, s.price, s.amount, s.sno FROM `medicine_list` 
AS c INNER JOIN `sales_list` AS s ON c.sno = s.sno  WHERE  invoice='5'  ORDER BY invoice ASC";

$result = mysqli_query($con, $sql) or die($sql."<br/><br/>".mysqli_error());

$i = 0;

echo '<table>';
echo '<tr>';
echo '<td>Brand name</td>';
echo '<td>Price</td>';
echo '<td>Quantity</td>';
echo '<td>Total</td>';
echo '</tr>';

echo "<form name='form_update' method='post' action='update.php'>\n";
while ($students = mysqli_fetch_array($result)) {
	echo '<tr>';
    echo "<td>{$students['trade_name']}</td>";
	echo "<td><input type='hidden' size='40' name='id[$i]' value='{$students['transaction_id']}' /></td>";
	echo "<td><input type='hidden' size='40' name='sno[$i]' value='{$students['sno']}' /></td>";
    echo "<td><input type='text' size='40' name='price[$i]' value='{$students['price']}' /></td>";
	echo "<td><input type='hidden' size='40' name='qty1[$i]' value='{$students['quantity']}' /></td>";
	echo "<td><input type='text' size='40' name='quantity[$i]' value='{$students['quantity']}' /></td>";
	echo "<td><input type='text' size='40' name='amount[$i]' value='{$students['amount']}' /></td>";
	echo '</tr>';
	++$i;
}
echo '<tr>';
echo "<td><input type='submit' value='submit' /></td>";
echo '</tr>';
echo "</form>";
echo '</table>';
?>


</body>
</html>
