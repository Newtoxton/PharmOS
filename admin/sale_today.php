<?php

include_once "../connect.php"; // database connection details stored here
	
	
	$start_date =  date('Y-m-d');

	$end_date =  date('Y-m-d');

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Sales Report</title>
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

 <link rel="stylesheet" href="../plugins/css/jquery-ui.css">

  <script src="js/jquery-1.12.4.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script>
   $(function(){
        $("#to").datepicker({ dateFormat: 'yy-mm-dd' });
        $("#from").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate());
            $("#to").datepicker( "option", "minDate", minValue );
        })
    });
  </script>



</head>


<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales report - Today
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">sales report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">

            </div>
            <!-- /.box-header -->
            <!-- form start -->



<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Sales Report from&nbsp;<?php echo $start_date ?>&nbsp;to&nbsp;<?php echo $end_date ?>
</div>




<div class="table-responsive">
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>

	    <th> Transaction Date and time </th>
		
			<th> Customer </th>
			<th> Dispenser </th>
			<th> Invoice No. </th>
			<th> Trade Name </th>
			<th> Generic Name </th>
			<th> Qty </th>
			<th> Amount </th>
			<th> Profit </th>
		</tr>
	</thead>
	<tbody>

			<?php


		$result = $dbo->prepare("select c.trade_name, c.generic_name,i.cost_price,s.transaction_id,
        s.invoice,d.customer, s.product, s.price, s.quantity, s.amount, d.date, d.time, d.entrant
        FROM `medicine_list` AS c
        INNER JOIN `sales_list` AS s ON c.sno = s.sno
        INNER JOIN `sales_details` AS d ON d.id = s.invoice
		INNER JOIN `inventory` AS i ON s.product =   i.pid	


				WHERE STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'

AND customer != 'Adjustment'

				ORDER by transaction_id DESC ");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
					
					
					$cost = $row['quantity'] * $row['cost_price'];
					$sell = $row['quantity'] * $row['price'];
					$profit = $sell - $cost;

			?>

			<tr class="record">


			<td><?php echo $row['date']; ?>, <?php echo $row['time']; ?></td>
			
			<td><?php echo $row['customer']; ?></td>

			<td><?php echo $row['entrant']; ?></td>

			<td><?php echo $row['invoice']; ?></td>
			<td><?php echo $row['trade_name']; ?></td>
			<td><?php echo $row['generic_name']; ?></td>
			<td><?php echo $row['quantity']; ?></td>
			<td><?php
			
			echo formatMoney($sell, true);
			?></td>
			<td><?php
			
			echo formatMoney($profit, true);
			?></td>
			</tr>
			<?php
				}
			?>

	</tbody>
	<thead>
		<tr>
			<th colspan="7" style="border-top:1px solid #999999"> Total: </th>
			<th colspan="1" style="border-top:1px solid #999999">
			<?php
				function formatMoney($number, $fractional=false) {
					if ($fractional) {
						$number = sprintf('%.2f', $number);
					}
					while (true) {
						$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
						if ($replaced != $number) {
							$number = $replaced;
						} else {
							break;
						}
					}
					return $number;
				}

				$results = $dbo->prepare("SELECT sum(s.amount), d.date FROM sales_list AS s  INNER JOIN `sales_details` AS d ON d.id = s.invoice  WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND customer != 'Adjustment'
 "  );
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['sum(s.amount)'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
				$resultia = $dbo->prepare("select SUM(i.cost_price * s.quantity) AS tc , SUM(s.price * s.quantity) AS ts
				FROM `sales_list` AS s 
				INNER JOIN `sales_details` AS d ON d.id = s.invoice
				INNER JOIN `inventory` AS i ON s.product =   i.pid	
                WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND customer != 'Adjustment' ");
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
					
					$tc =$cxz['tc'];
					$ts =$cxz['ts'];
					$zxc = $ts - $tc;
				echo formatMoney($zxc, true);
				}
				?>

				</th>
		</tr>
	</thead>
</table>
</div>

  <a href="salesreport.xls"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Download Report
          </button></a>

</div>
<div class="clearfix"></div>


<?php
require_once("excelwriter.class.php");

$excel=new ExcelWriter("salesreport.xls");
if($excel==false)
echo $excel->error;
$myArr=array("");
$myArr=array("Sales Report");
$excel->writeLine($myArr);
$myArr=array("");
$excel->writeLine($myArr);
$myArr=array("Date","Time","Trade Name","Generic Name" ,"Quantity","Sale Price","Amount","Profit","Dispenser");
$excel->writeLine($myArr);
$qry=mysqli_query($con, "select c.trade_name, c.generic_name,i.cost_price,s.transaction_id,
        s.invoice, s.product, s.price, s.quantity, s.amount, d.date, d.time, d.entrant
        FROM `medicine_list` AS c
        INNER JOIN `sales_list` AS s ON c.sno = s.sno
        INNER JOIN `sales_details` AS d ON d.id = s.invoice
		INNER JOIN `inventory` AS i ON s.product =   i.pid	
				WHERE STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'  AND customer != 'Adjustment'



				ORDER by transaction_id DESC ");

if($result!=false)
{
	$i=1;
	while($res=mysqli_fetch_array($qry))
	{
		$myArr=array($res['date'],$res['time'],$res['trade_name'],$res['generic_name'],$res['quantity'], $res['price'], $res['quantity'] * $res['price'],
		
		($res['quantity'] * $res['price']) -  $res['quantity'] * $res['cost_price'],
		
		$res['entrant']);
		$excel->writeLine($myArr);
		$i++;
	}
}
?>


				



    </div>
    </div>
</div>
</div>

<script src="app/app.js"></script>




 <?php include_once("footer.php"); ?>
    </body>
</html>
