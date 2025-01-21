<?php
include_once "../connect.php"; // database connection details stored here

function saveMed( array $data){
		if( !empty( $data ) ){
			global $con;

			$count = 0;
			if( isset($data['data'] )){
				foreach ($data['data'] as $value) {
					if(!empty($value['price'] ))$count++;
				}
			}

			if($count == 0)throw new Exception( "Please add atleast one product to the list" );

			// escape variables for security
			if( !empty( $data)){
				$customer = mysqli_real_escape_string( $con, trim( $data['customer'] ) );
				$date     = mysqli_real_escape_string( $con, trim( $data['date'] ) );
				$time     = mysqli_real_escape_string( $con, trim( $data['time'] ) );
				$userid   = mysqli_real_escape_string( $con, trim( $data['userid'] ) );
				$wsale    = mysqli_real_escape_string( $con, trim( $data['wsale'] ) );
				$cash     = mysqli_real_escape_string( $con, trim( $data['cash'] ) );
				$notes    = mysqli_real_escape_string( $con, trim( $data['notes'] ) );


				if(empty($id)){
					$uuid = uniqid();
					$query = "INSERT INTO sales_details (`customer`,`date`, `time`, `entrant`, `wsale`, `cash` , `uuid`, `notes`)
							VALUES ('$customer',  '$date', '$time', '$userid', '$wsale', '$cash', '$uuid', '$notes')";

				}else{
					$uuid = $data['uuid'];
					$query = "UPDATE `sales_details` SET `customer` = '$customer', `amount` = '$totals',`date` ='$date',
							`time` = '$time', `entrant` = '$userid',  `updated` = CURRENT_TIMESTAMP
							WHERE `id` = $id";
				}
				if(!mysqli_query($con, $query)){
					throw new Exception(  mysqli_error($con) );
				}else{
					if(empty($id))$id = mysqli_insert_id($con);
				}

				if( isset( $data['data']) && !empty( $data['data'] )){
					saveInvoiceDetail( $data['data'], $id );
				}
				return [
					'success' => true,
					'uuid' => $uuid,
					'message' => 'Data Saved Successfully.'
				];
			}else{
				throw new Exception( "Please check, some of the required fileds missing" );
			}
		} else{
			throw new Exception( "Please check, some of the required fileds missing" );
		}
	}


    function saveInvoiceDetail(array $sales_list, $invoice = ''){
	  global $con;
    $deleteQuery = "DELETE FROM sales_list WHERE invoice = $invoice";
    mysqli_query($con, $deleteQuery);

    foreach ($sales_list as $invoice_detail){
        $b        = mysqli_real_escape_string( $con, trim( $invoice_detail['sno'] ) );
		    $price    = mysqli_real_escape_string( $con, trim( $invoice_detail['price'] ) );
        $quantity = mysqli_real_escape_string( $con, trim( $invoice_detail['quantity'] ) );
				$qty      = mysqli_real_escape_string( $con, trim( $invoice_detail['qty'] ) );
        $total    = mysqli_real_escape_string( $con, trim( $invoice_detail['total'] ) );

				if ($quantity > $qty){
					$quantity = $qty ;
				}

				$query    = mysqli_query($con, "SELECT sno, cost_price FROM inventory WHERE `pid`= '$b'")or die(mysqli_error());
				while($row = mysqli_fetch_assoc($query)) {
				$sno=$row['sno'];
				$cost=$row['cost_price'];
				}

				$p = $price - $cost ;
				$profit = $p*$quantity;

				$query = mysqli_query($con, "UPDATE inventory SET quantity=quantity-'$quantity'  WHERE `pid`= '$b' ");

        $query = "INSERT INTO sales_list
				               (`invoice`, `product`, `quantity`, `amount`, `sno`, `price`, `profit`)
                VALUES ('$invoice', '$b', '$quantity', '$total', '$sno', '$price', '$profit')";
        mysqli_query($con, $query);
    }

}


function getpurchases(){
	global $con;
	$data = [];
	$query = "SELECT * FROM sales_details";
	if ( $result = mysqli_query($con, $query) ){
		while($row = mysqli_fetch_assoc($result)) {
			array_push($data, $row);
		}
	}
	return $data;
}
