<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCname html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Sales Report</title>
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
<form action="sales_report_dispenser.php" method="get">
  <div class="container">
		   </br>
		  
		   </br>
             
              <div class="row">

               <div class="col-xs-3">
                  <select name="name"  class="form-group" id="select2" style="width:250px; height:34px" >
					<option>Select Dispenser name</option>
					
					<?php

					$result3 = $dbo->prepare("SELECT userid FROM users ");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option><?php echo $row['userid']; ?></option>
					<?php
					}
					?>
					
					</select>
                 
                </div>
				
		<div class="col-xs-3">
		<input name="d1"  id="from"  name="d1" placeholder="From"/>
                </div>
				
		<div class="col-xs-3">
		 <input name="d2" id="to" name="d2" placeholder="To" />
                </div>
				
				<div class="col-xs-1">
                 <button class="btn btn-success"submit">Search</button>
                
                </div>
				</form>
			</div>
			</br>
				
           </div>

<section class="content">
<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Sales Report from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>&nbsp;for&nbsp;<?php echo $_GET['name'] ?>
</div>

<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>

	         <th> Transaction Date and time </th>
			<th> Dispenser </th>
			<th> Invoice No. </th>
			<th> Customer </th>
			<th> Amount </th>
			<th> View</th>
			
		</tr>
	</thead>
	<tbody>

			<?php



				$start_date =  $_GET['d1'];


				$end_date =    $_GET['d2'];
				
				
				$name =  $_GET['name'];



				$result = $dbo->prepare("select s.invoice, SUM(s.amount) amount, d.date, d.time, d.entrant, d.customer
				FROM `medicine_list` AS c
				INNER JOIN `sales_list` AS s ON c.sno = s.sno
				INNER JOIN `sales_details` AS d ON d.id = s.invoice


				WHERE `entrant` = '$name'  AND  STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'


				GROUP BY invoice ORDER by transaction_id DESC ");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

			?>

			<tr class="record">

			<td><?php echo $row['date']; ?>, <?php echo $row['time']; ?></td>
			<td><?php echo $row['entrant']; ?></td>
			<td><?php echo $row['invoice']; ?></td>
			<td><?php echo $row['customer']; ?></td>
			<td><?php
			$dsdsd=$row['amount'];
			echo formatMoney($dsdsd, true);
			?></td>
			
			 <td><form  method="post" action="edit_invoices.php<?php echo '?id='.$row['invoice']; ?>"><input type='submit'  class="btn btn-success addmore" value='View'>	</form></td>
             
			</tr>
			<?php
				}
			?>

	</tbody>
	<thead>
		<tr>
			<th colspan="4" style="border-top:1px solid #999999"> Total: </th>
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

				$results = $dbo->prepare("SELECT sum(s.amount), d.date FROM sales_list AS s  INNER JOIN `sales_details` AS d ON d.id = s.invoice  WHERE `entrant` = '$name'  AND  STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' "  );
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['sum(s.amount)'];
				echo formatMoney($dsdsd, true);
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
<script src="js/angular.min.js"></script>

<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>

<script src="app/app.js"></script>   


 <script src="../bootstrap/js/select2.js"></script>
 
  <script>
    $(function(){
      // turn the element to select2 select style
      $('#select2').select2();
    });
  </script>

  








 <?php include_once("footer.php"); ?>    
    </body>
</html>