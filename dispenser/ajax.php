<?php

require_once '../connect.php';
if(!empty($_POST['type'])){
	$type = $_POST['type'];
	$name = $_POST['name_startsWith'];
	$query = "SELECT trade_name, sno, sell_price, wsell FROM medicine_list where  UPPER($type) LIKE '".strtoupper($name)."%'";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['trade_name'].'|'.$row['sno'].'|'.$row['sell_price'].'|'.$row['wsell'];
		array_push($data, $name);
	}	
	echo json_encode($data);exit;
}




?>

