<?php
include_once "../connect.php"; // database connection details stored here

function saveRetailsSale($data)
{
  global $dbo;
 $now = date("Y-m-d H:i:s");
  if (!empty($data)) {

    $customer = $data['customer'];
    $date = $data['date'];
    $time = $data['time'];
    $entrant = $data['userid'];
    $wsale = $data['wsale'];
    $cash = $data['cash'];
    $phone = $data['phone'];
    $doc = $data['doc'];
    $notes = $data['notes'];
    $total = $data['totals'];

    $uuid = uniqid();
    $query = "INSERT INTO sales_details (`customer`,`date`, `time`, `entrant`, `wsale`, `cash` , `uuid`,`total`,`phone`,`doc`,`notes`,`created`,`updated`)
							VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $dbo->prepare($query);
    $stmt->bindParam(1, $customer, PDO::PARAM_STR);
    $stmt->bindParam(2, $date, PDO::PARAM_STR);
    $stmt->bindParam(3, $time, PDO::PARAM_STR);
    $stmt->bindParam(4, $entrant, PDO::PARAM_STR);
    $stmt->bindParam(5, $wsale, PDO::PARAM_STR);
    $stmt->bindParam(6, $cash, PDO::PARAM_STR);
    $stmt->bindParam(7, $uuid, PDO::PARAM_STR);
    $stmt->bindParam(8, $total, PDO::PARAM_INT);
    $stmt->bindParam(9, $phone, PDO::PARAM_STR);
    $stmt->bindParam(10, $doc, PDO::PARAM_STR);
    $stmt->bindParam(11, $notes, PDO::PARAM_STR);
    $stmt->bindParam(12, $now, PDO::PARAM_STR);
    $stmt->bindParam(13, $now, PDO::PARAM_STR);

    if ($stmt->execute()) {
      $in_id=$dbo->lastInsertId();
      saveSalesList($data,$in_id);
			header('Location: pos.php?pass=1');die();

    } else {
			header('Location: pos.php?fail=2');die();
    }

  } else {
    echo "Empty";
  }
}


function saveSalesList($data,$invoice){
global $dbo;
  if (!empty($data)) {

    $query="SELECT sno,cost_price,quantity FROM inventory WHERE pid = ? limit 1";
 $inv_update_q= "UPDATE inventory SET quantity=?  WHERE pid= ? ";

$in_query = "INSERT INTO sales_list (`invoice`, `product`, `quantity`, `amount`, `sno`, `price`, `profit`)
                VALUES (?,?,?,?,?,?,?)";

$in_stmt=$dbo->prepare($in_query);
$inv_update_stmt=$dbo->prepare($inv_update_q);
$inv=$dbo->prepare($query);

foreach($data['data'] as $i => $invoice_detail){
  $product=   $invoice_detail['sno'];
  $inv->bindParam(1,$product);
  $inv->execute();
  $inventory=$inv->fetch();


  $price =   $invoice_detail['price'];
  $quantity =   $invoice_detail['quantity'];
  $total =   $invoice_detail['total'];

  $sno=$inventory['sno'];
  $cost=$inventory['cost_price'];
  $unit_profit = $price - $cost ;
	$profit=$unit_profit*$quantity;

  $in_stmt->bindParam(1,$invoice);
  $in_stmt->bindParam(2,$product);
  $in_stmt->bindParam(3,$quantity);
  $in_stmt->bindParam(4,$total);
  $in_stmt->bindParam(5,$sno);
  $in_stmt->bindParam(6,$price);
  $in_stmt->bindParam(7,$profit);
  if($in_stmt->execute()){
    $new_quantity= $inventory['quantity']-$quantity;
    $inv_update_stmt->bindParam(1,$new_quantity);
    $inv_update_stmt->bindParam(2,$product);
    $inv_update_stmt->execute();
  }
  else{
  //      echo "sales list F";
  }


}



  } else {
    echo "Empty";
  }
}



function checkQuantityAvailable($data)
{
  global $dbo;
  $query="SELECT inv.quantity,ml.generic_name FROM inventory as inv  left join medicine_list as ml on inv.sno=ml.sno WHERE pid = ? limit 1";
  $inv=$dbo->prepare($query);
  $not_available=[];
  if (!empty($data)) {
    foreach($data['data'] as $i => $invoice_detail){
        $product=  $invoice_detail['sno'];
        $quantity =   $invoice_detail['quantity'];

        $inv->bindParam(1,$product);
        $inv->execute();
        $inventory=$inv->fetch();
          if($inventory['quantity']<$quantity){
            $not_available[]=$inventory['generic_name'];
          }


    }

  }
  return $not_available;
}


$data=$_POST;
$av=checkQuantityAvailable($data);
$_SESSION['Insufficient']=null;
if(count($av)>0){
  $_SESSION['Insufficient']=$av;
header('Location: pos.php');die();

}else{
return saveRetailsSale($data);
}
