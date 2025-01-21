<?php

include_once "../connect.php"; // database connection details stored here

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
        Sales report
        <small>Reports</small>
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
<form action="sales_report_product.php" method="get">
<center><strong>

<p>From: <input type="text"  id="from"  name="d1" autocomplete="off"/> <img src='img/cal.gif'>To: <input type="text" id="to" name="d2" autocomplete="off"/><img src='img/cal.gif'></p>
 		<button class="btn btn-success"submit">Search</button>
</strong></center>
</form>
<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Sales Report from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>
</div>





<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
            <th>No</th>
	        <th> Date</th>
			<th> Trade Name </th>
			<th> Generic Name </th>
			<th> Cost Price </th>
			<th> Qty Sold</th>
			<th> Qty Available</th>
			<th> Amount </th>
			<th> Profit </th>
		</tr>
	</thead>
	<tbody>

			<?php

				$n = 0;

				$start_date =  $_GET['d1'];


				$end_date =    $_GET['d2'];

		$result = $dbo->prepare("select c.trade_name, c.generic_name,i.cost_price,SUM(i.quantity) AS qty, s.price, SUM(s.quantity) AS quantity, SUM(s.amount) AS amount, d.date
        FROM `medicine_list` AS c
        INNER JOIN `sales_list` AS s ON c.sno = s.sno
        INNER JOIN `sales_details` AS d ON d.id = s.invoice
		INNER JOIN `inventory` AS i ON s.product =   i.pid	

				WHERE STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'
				
				GROUP BY  trade_name

				ORDER by amount DESC");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
					
					$cost = $row['quantity'] * $row['cost_price'];
					$sell = $row['quantity'] * $row['price'];
					$profit = $sell - $cost;

			?>

			<tr class="record">
            <td><?php echo ++$n ;  ?> </td>
			<td><?php echo $row['date']; ?></td>
            <td><?php echo $row['trade_name']; ?></td>
			<td><?php echo $row['generic_name']; ?></td>
			<td><?php echo $row['cost_price']; ?></td>
			<td><?php echo $row['quantity']; ?></td>
			<td><?php echo $row['qty']; ?></td>
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

				$results = $dbo->prepare("SELECT sum(s.amount), d.date FROM sales_list AS s  INNER JOIN `sales_details` AS d ON d.id = s.invoice  WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' "  );
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
                WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'"   );
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

  <a href="salesreport.xls"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Download Report
          </button></a>
</br>
</div>
<div class="clearfix"></div>

</br>
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
$myArr=array("Date","Trade Name","Generic Name" ,"Cost Price","Qty Sold","Qty Available","Sale Price","Amount","Profit");
$excel->writeLine($myArr);
$qry=mysqli_query($con, "select c.trade_name, c.generic_name,i.cost_price,s.price,SUM(i.quantity) AS qty, SUM(s.quantity) AS quantity, SUM(s.amount) AS amount, d.date
        FROM `medicine_list` AS c
        INNER JOIN `sales_list` AS s ON c.sno = s.sno
        INNER JOIN `sales_details` AS d ON d.id = s.invoice
		INNER JOIN `inventory` AS i ON s.product =   i.pid	

				WHERE STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'
				
				GROUP BY  trade_name

				ORDER by amount DESC");

if($result!=false)
{
	$i=1;
	while($res=mysqli_fetch_array($qry))
	{
		$myArr=array($res['date'],$res['trade_name'],$res['generic_name'],$res['cost_price'],$res['quantity'],$res['qty'], $res['price'], $res['quantity'] * $res['price'],
		
		($res['quantity'] * $res['price']) -  $res['quantity'] * $res['cost_price']);
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
