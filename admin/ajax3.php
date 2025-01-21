<?php

require_once '../connect.php';
if(!empty($_POST['type'])){
	$type = $_POST['type'];
	$name = $_POST['name_startsWith'];
	$query = "
select c.trade_name, c.sno, c.wsell, i.pid,i.batch, i.quantity  FROM `medicine_list` AS c
INNER JOIN `inventory` AS i ON c.sno = i.sno  WHERE quantity > 0 AND  UPPER($type) LIKE '".strtoupper($name)."%'";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['trade_name'].'|'.$row['pid'].'|'.$row['quantity'].'|'.$row['wsell'].'|'.$row['batch'];
		array_push($data, $name);
	}
	echo json_encode($data);exit;
}

?>
