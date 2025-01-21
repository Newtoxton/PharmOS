<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Periodic Report</title>
<!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="../bootstrap/css/select2.css">
  
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


<?php include("header.php"); ?>

  <!-- =============================================== -->

  
<?php include("sidebar.php"); ?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Periodic report
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Periodic report</li>
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

<form action="daily_report.php" method="get">
<center><strong> 
<p>To: <input type="text"  id="from"  name="d1"/> <img src='img/cal.gif'>From: <input type="text" id="to" name="d2" /><img src='img/cal.gif'></p>
 		<button class="btn btn-success"submit">Search</button>
</strong></center>
</form>
<div class="content" id="content">
<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Periodic Report from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>
</div>
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >

<thead>
	<tr>
		
	        <th></th>
			<th> Total Sales </th>
			<th> Total profit</th>
		</tr>
	</thead>
	
	<thead>
		<tr>
			<th colspan="1" style="border-top:1px solid #999999"> Sales: </th>
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
				$start_date =  $_GET['d1'];
			

				$end_date =    $_GET['d2'];
				
				$results = $dbo->prepare("SELECT sum(s.amount), d.date FROM sales_list AS s  INNER JOIN `sales_details` AS d ON d.id = s.invoice  WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' " );

				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['s.sum(amount)'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php 
				$resultia = $dbo->prepare("SELECT sum(s.profit), d.date FROM sales_list AS s  INNER JOIN `sales_details` AS d ON d.id = s.invoice  WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' "  );
				
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
				$zxc=$cxz['sum(s.profit)'];
				echo formatMoney($zxc, true);
				}
				?>
		
				</th>
		</tr>
	</thead>

<thead>
	<tr>
		
	        <th></th>
			<th> Total Bill </th>
			<th> Amount Paid </th>
		</tr>
	</thead>
	<thead>
		<tr>
			<th colspan="1" style="border-top:1px solid #999999"> Expenses: </th>
			<th colspan="1" style="border-top:1px solid #999999"> 
			<?php
				
				
				$results = $dbo->prepare("SELECT sum(total_amount) FROM bills WHERE STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'"  );
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['sum(total_amount)'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php 
				$resultia = $dbo->prepare("SELECT sum(amount) FROM bills WHERE STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'"  );
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


            
       
		
    </div>
    </div>
</div>
</div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   

 <?php include("footer.php"); ?>    
    </body>
</html>