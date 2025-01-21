<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Expenses Report</title>
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
        Expenses report
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Expenses report</li>
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

<form action="expenses_report.php" method="get">
<center><strong>
<p>To: <input type="text"  id="from"  name="d1" autocomplete="off"/> <img src='img/cal.gif'>From: <input type="text" id="to" name="d2" autocomplete="off"/><img src='img/cal.gif'></p>
 		<button class="btn btn-success"submit">Search</button>
</strong></center>
</form>
<div class="content" id="content">
<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Expenses Report from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>
</div>
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
	    <th> Date </th>
			<th> Entrant </th>
			<th> Expense </th>
			<th> Description </th>
			<th> Source </th>
			<th> Total Amount </th>
			<th> Amount Paid</th>
		</tr>
	</thead>
	<tbody>

			<?php

				$start_date =  $_GET['d1'];

				$end_date   =    $_GET['d2'];

				$result     = $dbo->prepare("SELECT * FROM bills WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'
                                     ORDER by id DESC ");


				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
			?>
			<tr class="record">

			<td><?php echo $row['date']; ?></td>
			<td><?php echo $row['entrant']; ?></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['description']; ?></td>
			<td><?php echo $row['source']; ?></td>
			<td><?php
			$dsdsd=$row['total_amount'];
			echo formatMoney($dsdsd, true);
			?></td>
			<td><?php
			$zxc=$row['amount'];
			echo formatMoney($zxc, true);
			?></td>
			</tr>
			<?php
				}
			?>

	</tbody>
	<thead>
		<tr>
			<th colspan="5" style="border-top:1px solid #999999"> Total: </th>
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
				$results = $dbo->prepare("SELECT sum(total_amount) FROM bills WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'"  );
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['sum(total_amount)'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
				$resultia = $dbo->prepare("SELECT sum(amount) FROM bills WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'"  );
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
				$zxc=$cxz['sum(amount)'];
				echo formatMoney($zxc, true);
				}
				?>

				</th>
		</tr>
	</thead>
</table>
</div>
<div class="clearfix"></div>


<?php
require_once("excelwriter.class.php");

$excel=new ExcelWriter("expensesreport.xls");
if($excel==false)
echo $excel->error;
$myArr=array("");
$myArr=array("Sales Report");
$excel->writeLine($myArr);
$myArr=array("");
$excel->writeLine($myArr);
$myArr=array("Date","Entrant","Source","Description","Total bill","Amount paid");
$excel->writeLine($myArr);
$qry=mysqli_query($con, "select* FROM bills WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' ORDER by id DESC");

if($result!=false)
{
	$i=1;
	while($res=mysqli_fetch_array($qry))
	{
		$myArr=array($res['date'],$res['entrant'],$res['source'],$res['description'],$res['total_amount'],$res['amount']);
		$excel->writeLine($myArr);
		$i++;
	}
}
?>

</br>
				  <a href="expensesreport.xls"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Download Report
          </button></a>
    </div>
    </div>
</div>
</div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>
