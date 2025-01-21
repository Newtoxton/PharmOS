<?php
include_once "../connect.php"; // database connection details stored here

function saveRetailsSale($data)
{
  global $dbo;
 $now = date("Y-m-d H:i:s");
  if (!empty($data)) {


     $entrant =  $data['entrant'];
    $supplier =  $data['supplier'] ;
		$invoiceNo =  $data['invoiceNo'] ;
		$invoiceDate =  $data['invoiceDate'] ;
		$invoice_total =  $data['invoice_total'] ;
		$amount_paid =  $data['amount_paid'] ;
		$amount_due =  $data['amount_due'] ;
		$due_date =  $data['due_date'] ;
    $notes = $data['notes'];
    $comment=' ';
    $okey=' ';

    $uuid = uniqid();

    $query = "INSERT INTO purchases (`supplier`, `invoiceNo`, `invoiceDate`,`invoice_total`, `due_date`,
							`amount_paid`, `amount_due`, `notes`, `entrant`, `created`, `uuid`,`okey`,`comment`)
							VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $dbo->prepare($query);
    $stmt->bindParam(1, $supplier, PDO::PARAM_STR);
    $stmt->bindParam(2, $invoiceNo, PDO::PARAM_INT);
    $stmt->bindParam(3, $invoiceDate, PDO::PARAM_STR);
    $stmt->bindParam(4, $invoice_total, PDO::PARAM_INT);
    $stmt->bindParam(5, $due_date, PDO::PARAM_STR);
    $stmt->bindParam(6, $amount_paid, PDO::PARAM_INT);
    $stmt->bindParam(7, $amount_due, PDO::PARAM_INT);
    $stmt->bindParam(8, $notes, PDO::PARAM_STR);
    $stmt->bindParam(9, $entrant, PDO::PARAM_STR);
    $stmt->bindParam(10, $now, PDO::PARAM_STR);
    $stmt->bindParam(11, $uuid, PDO::PARAM_STR);
    $stmt->bindParam(12, $okey, PDO::PARAM_STR);
    $stmt->bindParam(13, $comment, PDO::PARAM_STR);

    if ($stmt->execute()) {
      $in_id=$dbo->lastInsertId();
      saveSalesList($data,$in_id);
			 header('Location: inventory.php?pass=1');die();
    } else {
			header('Location: inventory.php?fail=2');die();
    }

  } else {
    echo "Empty";
  }
}


function saveSalesList($data,$invoice){
global $dbo;
  if (!empty($data)) {
$in_query = "INSERT INTO inventory (`invoice_id`, `sno`, `batch`, `quantity`, `qty_sold`, `cost_price`, `expiry_date`)
                  VALUES (?,?,?,?,?,?,?)";
$in_stmt=$dbo->prepare($in_query);

foreach($data['data'] as $i => $invoice_detail){
  $sno =  $invoice_detail['sno'] ;
        $batch =  $invoice_detail['batch'] ;
		$price =  $invoice_detail['price'] ;
        $quantity =  $invoice_detail['quantity'] ;
        $expiry_date =  $invoice_detail['expiry_date'] ;
        $sold=0;
  $in_stmt->bindParam(1,$invoice);
  $in_stmt->bindParam(2,$sno);
  $in_stmt->bindParam(3,$batch);
  $in_stmt->bindParam(4,$quantity);
  $in_stmt->bindParam(5,$quantity);
  $in_stmt->bindParam(6,$price);
  $in_stmt->bindParam(7,$expiry_date);
  if($in_stmt->execute()){
  }
  else{
  //      echo "sales list F";
  }


}



  } else {
    echo "Empty";
  }
}



$data=$_POST;

//return print_r($data);
return saveRetailsSale($data);
