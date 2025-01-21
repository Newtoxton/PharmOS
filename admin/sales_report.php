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
<form action="sales_report.php" method="get">

<div class="container">
		   </br>

		   </br>
              <div class="row">
              <div class="col-xs-3">
					<select name="type"  class="form-control">
					<option value="No">Retail</option>
					<option value="Yes">Wholesale</option>
					
					</select>
                </div>

				<div class="col-xs-2">
		<input type="text"  id="from"  name="d1" placeholder="From"  style="height:34px" autocomplete="off"/> 
                </div>
				
		<div class="col-xs-2">
		 <input type="text" id="to" name="d2" placeholder="To"  style="height:34px" autocomplete="off"/>
                </div>
				
			</div>
			</br>
 
  
  <button class="btn btn-primary" submit">Search</button>
          
</div>

            </form>
				</br>
          

<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Sales Report from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>
</div>




<div class="table-responsive">
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>

	    <th> Transaction Date and time </th>
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



				$start_date =  $_GET['d1'];


				$end_date =    $_GET['d2'];
				
				
				$type =  $_GET['type'];



				$result = $dbo->prepare("select c.trade_name, c.generic_name,s.profit,s.transaction_id,
        s.invoice, s.product, s.price, s.quantity, s.amount, d.date, d.time, d.entrant, d.wsale, d.cash
        FROM `medicine_list` AS c
        INNER JOIN `sales_list` AS s ON c.sno = s.sno
        INNER JOIN `sales_details` AS d ON d.id = s.invoice


				WHERE `wsale` = '$type'  AND  STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'


				ORDER by transaction_id DESC ");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

			?>

			<tr class="record">

			<td><?php echo $row['date']; ?>, <?php echo $row['time']; ?></td>

			<td><?php echo $row['entrant']; ?></td>

			<td><?php echo $row['invoice']; ?></td>
			<td><?php echo $row['trade_name']; ?></td>
			<td><?php echo $row['generic_name']; ?></td>
			<td><?php echo $row['quantity']; ?></td>
			<td><?php
			$dsdsd=$row['amount'];
			echo formatMoney($dsdsd, true);
			?></td>
			<td><?php
			$zxc=$row['profit'];
			echo formatMoney($zxc, true);
			?></td>
			</tr>
			<?php
				}
			?>

	</tbody>
	<thead>
		<tr>
			<th colspan="6" style="border-top:1px solid #999999"> Total: </th>
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

				$results = $dbo->prepare("SELECT sum(s.amount), d.date FROM sales_list AS s  INNER JOIN `sales_details` AS d ON d.id = s.invoice  WHERE `wsale` = '$type'  AND  STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' "  );
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['sum(s.amount)'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
				$resultia = $dbo->prepare("SELECT sum(s.profit), d.date FROM sales_list AS s INNER JOIN `sales_details` AS d ON d.id = s.invoice WHERE `wsale` = '$type' AND  STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'"   );
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
				$zxc=$cxz['sum(s.profit)'];
				echo formatMoney($zxc, true);
				}
				?>

				</th>
		</tr>
	</thead>
</table>
</div>
</div>
<div class="clearfix"></div>







    </div>
    </div>
</div>
</div>

<script src="app/app.js"></script>




 <?php include_once("footer.php"); ?>
    </body>
</html>
