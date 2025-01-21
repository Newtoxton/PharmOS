<?php

include_once('../../connect.php');

$query="select c.trade_name, c.generic_name,  sum(i.quantity) AS qty1 , sum(i.qty_sold) AS qty2 FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno GROUP BY i.sno ORDER BY i.id Desc";

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
