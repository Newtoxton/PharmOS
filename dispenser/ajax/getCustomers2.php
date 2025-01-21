<?php

include_once('../../connect.php');


$query="select c.trade_name, c.generic_name, i.id, i.batch, i.cost_price, i.sell_price, i.supplier, i.quantity, i.qty_sold, date_format(i.datetime, '%d/%m/%y') AS DATE, i.expiry_date FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno  ORDER BY i.id Desc";

$result = $con->query($query) or die($con->error.__LINE__);

$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;	
	}
}
# JSON-encode the response
$json_response = json_encode($arr);

// # Return the response
echo $json_response;
?>



				