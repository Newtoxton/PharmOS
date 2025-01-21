<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Add Medicine</title>
	<!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../plugins/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  
</head>

<?php include("header.php"); ?>

  <!-- =============================================== -->

  
<?php include("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Medicine
        <small>Add New Medicines</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Admin</a></li>
        <li class="active">Add Medicine</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Medicine Added</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start --> 

           <?php
include 'config.php';


foreach (array('sno', 'quantity', 'batch','cost_price', 'sell_price', 'supplier', 'expiry_date') as $pos) {
    foreach ($_POST[$pos] as $id => $row) {
        $_POST[$pos][$id] = mysqli_real_escape_string($con, $row);
    }
}

$ids = $_POST['sno'];
$quantities = $_POST['quantity'];
$batch=  $_POST['batch'];
$cost_prices = $_POST['cost_price'];
$sell_prices =  $_POST['sell_price'];
$suppliers =  $_POST['supplier'];
$expiry_dates =  $_POST['expiry_date'];

$items = array();

$size = count($ids);

for($i = 0 ; $i < $size ; $i++){
    // Check for part id
    if (empty($ids[$i]) || empty($quantities[$i]) || empty($suppliers[$i])) {
        continue;
    }
    $items[] = array(
        "sno"     => $ids[$i], 
        "quantity"    => $quantities[$i],
		"batch"       => $batch[$i],
		 "cost_price"     => $cost_prices[$i], 
        "sell_price"    => $sell_prices[$i],
		"supplier"       => $suppliers[$i],
	    "expiry_date"     => $expiry_dates[$i]
    );
}

if (!empty($items)) {
    $values = array();
    foreach($items as $item){
        $values[] = "('{$item['sno']}', '{$item['quantity']}', '{$item['quantity']}', '{$item['batch']}' , '{$item['cost_price']}', '{$item['sell_price']}', '{$item['supplier']}', '{$item['expiry_date']}')";
    }

    $values = implode(", ", $values);

    $sql = "INSERT INTO inventory (sno, quantity, qty_sold, batch, cost_price, sell_price, supplier, expiry_date) VALUES  {$values}    ;
    " ;
    $result = mysqli_query($con, $sql );
    if ($result) {
        echo '<h3>Records Successful Inserted: </h3' . mysqli_affected_rows($con);
		
	   echo '</br></br><h2><a href="add_medicine.php">Add More Medicine</a></h2>';
		
    } else {
        echo 'query failed: ' . mysqli_error($con);
    }
}

?>

				
              </div>
           
			   
            </form>
			
			
          </div>
		  
        </div>
<div class="box">
            <div class="box-header">
              <h3 class="box-title">Type to search Medicine</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

<div class="col-xs-12">
<div ng-controller="customersCrtl">
<div class="container">

    <div class="row">
        
        </div>
    </div>
</div>
</div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script>     

 <?php include("footer.php"); ?>    
    </body>
</html>