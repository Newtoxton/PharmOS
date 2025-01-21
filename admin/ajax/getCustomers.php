<?php

include_once('../../connect.php');


$query="select distinct c.sno, c.trade_name, c.generic_name, c.type, c.sell_price,c.wsell from medicine_list c order by c.sno DESC";

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
