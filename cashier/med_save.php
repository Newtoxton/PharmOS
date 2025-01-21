<?php
include_once "../connect.php"; // database connection details stored here

function saveMed( array $data){
		if( !empty( $data ) ){
			global $con;

			$count = 0;
			if( isset($data['data'] )){
				foreach ($data['data'] as $value) {
					if(!empty($value['batch'] ))$count++;
				}
			}

			if($count == 0)throw new Exception( "Please add atleast one product to the list" );

			// escape variables for security
			if( !empty( $data)){
				$supplier = mysqli_real_escape_string( $con, trim( $data['supplier'] ) );
				$invoiceNo = mysqli_real_escape_string( $con, trim( $data['invoiceNo'] ) );
				$invoiceDate = mysqli_real_escape_string( $con, trim( $data['invoiceDate'] ) );
				$invoice_total = mysqli_real_escape_string( $con, trim( $data['invoice_total'] ) );
				$amount_paid = mysqli_real_escape_string( $con, trim( $data['amount_paid'] ) );
				$amount_due = mysqli_real_escape_string( $con, trim( $data['amount_due'] ) );
				$due_date = mysqli_real_escape_string( $con, trim( $data['due_date'] ) );
				$notes = mysqli_real_escape_string( $con, trim( $data['notes'] ) );

				$id = mysqli_real_escape_string( $con, trim( $data['id'] ) );

				if(empty($id)){
					$uuid = uniqid();
					$query = "INSERT INTO purchases (`supplier`, `invoiceNo`, `invoiceDate`,`invoice_total`, `due_date`,
							`amount_paid`, `amount_due`, `notes`, `created`, `uuid`)
							VALUES ('$supplier', '$invoiceNo', '$invoiceDate',  '$invoice_total', '$due_date', '$amount_paid', '$amount_due', '$notes',
							CURRENT_TIMESTAMP, '$uuid')";

				}else{
					$uuid = $data['uuid'];
					$query = "UPDATE `purchases` SET `supplier` = '$supplier', `invoiceNo` = '$invoiceNo', `invoiceDate` = '$invoiceDate',`invoice_total` ='$invoice_total',
							`due_date` = '$due_date', `amount_paid` = '$amount_paid', `amount_due` = '$amount_due', `notes` = '$notes', `updated` = CURRENT_TIMESTAMP
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
					'message' => 'Invoice Saved Successfully.'
				];
			}else{
				throw new Exception( "Please check, some of the required fileds missing" );
			}
		} else{
			throw new Exception( "Please check, some of the required fileds missing" );
		}
	}


    function saveInvoiceDetail(array $inventory, $invoice_id = ''){
	global $con;
    $deleteQuery = "DELETE FROM inventory WHERE invoice_id = $invoice_id";
    mysqli_query($con, $deleteQuery);

    foreach ($inventory as $invoice_detail){
        $sno = mysqli_real_escape_string( $con, trim( $invoice_detail['sno'] ) );
        $batch = mysqli_real_escape_string( $con, trim( $invoice_detail['batch'] ) );
		$price = mysqli_real_escape_string( $con, trim( $invoice_detail['price'] ) );
        $quantity = mysqli_real_escape_string( $con, trim( $invoice_detail['quantity'] ) );
        $expiry_date = mysqli_real_escape_string( $con, trim( $invoice_detail['expiry_date'] ) );

        $query = "INSERT INTO inventory (`invoice_id`, `sno`, `batch`, `quantity`, `qty_sold`, `cost_price`, `expiry_date`)
                  VALUES ('$invoice_id', '$sno', '$batch', '$quantity', '$quantity', '$price', '$expiry_date')";
        mysqli_query($con, $query);
    }

}


function getpurchases(){
	global $con;
	$data = [];
	$query = "SELECT * FROM purchases";
	if ( $result = mysqli_query($con, $query) ){
		while($row = mysqli_fetch_assoc($result)) {
			array_push($data, $row);
		}
	}
	return $data;
}
