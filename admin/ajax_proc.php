<?php

require_once '../connect.php';
if(!empty($_POST['type'])){
	$type = $_POST['type'];
	$name = $_POST['name_startsWith'];
	$query = "select c.trade_name,c.sno, i.cost_price, i.pid , i.quantity FROM `medicine_list` AS c
    LEFT JOIN `inventory` AS i ON c.sno = i.sno  WHERE UPPER($type) LIKE '".strtoupper($name)."%' GROUP BY trade_name";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['trade_name'].'|'.$row['sno'].'|'.$row['quantity'].'|'.$row['cost_price'];
		array_push($data, $name);
	}
	echo json_encode($data);exit;
}


?>
