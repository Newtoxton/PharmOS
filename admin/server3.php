<?php
	//include connection file 
	include_once("../connect.php");
	
	//define index of column
	$columns = array(
		
		1 =>'supplier',	
		2 =>'invoiceNo',		
		3 => 'invoiceDate',
		4 => 'entrant',
				
	);
	
	$error = false;
	$colVal = '';
	$colIndex = $rowId = 0;
	
	$msg = array('status' => !$error, 'msg' => 'Failed! updation in mysql');

	if(isset($_POST)){
    if(isset($_POST['val']) && !empty($_POST['val']) && !$error) {
      $colVal = $_POST['val'];
      $error = false;
      
    } else {
      $error = true;
    }
    if(isset($_POST['index']) && $_POST['index'] >= 0 &&  !$error) {
      $colIndex = $_POST['index'];
      $error = false;
    } else {
      $error = true;
    }
    if(isset($_POST['id']) && $_POST['id'] > 0 && !$error) {
      $rowId = $_POST['id'];
      $error = false;
    } else {
      $error = true;
    }
	
	if(!$error) {
			$sql = "UPDATE purchases SET ".$columns[$colIndex]." = '".$colVal."' WHERE id='".$rowId."'";
			$status = mysqli_query($con, $sql) or die("database error:". mysqli_error($conn));
			$msg = array('error' => $error, 'msg' => 'Success! Data updated successfully');
	} else {
		$msg = array('error' => $error, 'msg' => 'Failed! updation in mysql');
	}
	}
	// send data as json format
	echo json_encode($msg);
	
?>
	