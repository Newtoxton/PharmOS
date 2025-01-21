<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Statementt</title>
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
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
        Account Statement
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Report</li>
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

<form action="bank_report.php" method="get">
<div class="container">
		   </br>
		  
		   </br>
             
              <div class="row">

               <div class="col-xs-3">
                  <select name="name"  class="form-group" >
					<option>Select Account Name</option>
					
					<?php

					$result3 = $dbo->prepare("SELECT name FROM bank ");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option><?php echo $row['name']; ?></option>
					<?php
					}
					?>
					
					</select>
                 
                </div>
				
		<div class="col-xs-3">
		<input name="d1"  id="from"  name="d1" placeholder="From" autocomplete="off" />
                </div>
				
		<div class="col-xs-3">
		 <input name="d2" id="to" name="d2" placeholder="To" autocomplete="off" />
                </div>
				
				<div class="col-xs-1">
                 <button class="btn btn-success"submit">Search</button>
                
                </div>
				</form>
			</div>
			</br>
				
           </div>
<div class="content" id="content">
<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Statement  from <?php echo $_GET['name'] ?>&nbsp;Betweem&nbsp;<?php echo $_GET['d1'] ?>&nbsp;and&nbsp;<?php echo $_GET['d2'] ?>
</div>
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
		
	        <th> Date </th>
			<th> Entrant </th>
			<th> Expense </th>
			<th> Description </th>
			<th> Cash Source </th>
			<th> Total Amount </th>
			<th> Amount Paid</th>
			
			
		</tr>
	</thead>
	<tbody>
		
			<?php
				
				
				$start_date =  $_GET['d1'];
			

				$end_date =    $_GET['d2'];
				
				$name = $_GET['name'];
				
				
				$result = $dbo->prepare("select * FROM bills 
				
				WHERE bank = '$name' AND STR_TO_DATE(`date`, '%d/%m/%Y')
				
				
				BETWEEN '" . $start_date . "' AND '" . $end_date . "'
				
				
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
				$results = $dbo->prepare("SELECT sum(total_amount) FROM bills WHERE bank = '$name' AND STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'"  );
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['sum(total_amount)'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php 
				$resultia = $dbo->prepare("SELECT sum(amount) FROM bills WHERE bank = '$name' AND STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'"  );
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
				$zxc=$cxz['sum(amount)'];
				echo formatMoney($zxc, true);
				}
				?>
		
				</th>
		</tr>
	</thead>
	<thead>
		<tr>
			<th colspan="4" style="border-top:1px solid #999999"> Balance: </th>
			
			<th colspan="1" style="border-top:1px solid #999999">
			<?php 
				$resultia = $dbo->prepare("SELECT      b.name,
													   b.deposits,
													   e.bank,
													   e.expenses,
													   e.date,
													  (b.deposits - e.expenses) AS balance


					FROM ( SELECT name, SUM(deposit) deposits FROM bank_deposit
					GROUP BY name) b
					INNER JOIN
					(SELECT bank,date, SUM(amount) expenses FROM bills GROUP BY bank) e
					ON b.name = e.bank
 WHERE bank = '$name' "  );
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
				$zxc1=$cxz['balance'];
				echo formatMoney($zxc1, true);
				}
				?>
		
				</th>
	</tr>
	</thead>
</table>
</div>
<div class="clearfix"></div>
            
       
		
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