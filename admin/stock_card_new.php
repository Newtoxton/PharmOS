<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Stock Card</title>
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
        Stock Card
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Individual</li>
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
<form action="stock_card.php" method="get">
  <div class="container">
		   </br>

		   </br>

              <div class="row">

               <div class="col-xs-3">
                  <select name="brand"  class="form-group" id="select2" style="width:250px; height:34px" >
					<option>Select Trade name</option>

					<?php

					$result3 = $dbo->prepare("SELECT c.trade_name
FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno
GROUP BY `trade_name`");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option><?php echo $row['trade_name']; ?></option>
					<?php
					}
					?>

					</select>

                </div>



				<div class="col-xs-1">
                 <button class="btn btn-success"submit">Search</button>

                </div>

			</div>
			</br>

           </div>

<section class="content">
<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
STOCK CARD FOR&nbsp;<?php echo $_GET['brand'] ?>
</div>


<div class="table-responsive">
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
				<th colspan="1" style="border-top:1px solid #999999"> </th>
				<?php


				$brand =    $_GET['brand'];


				$resultia = $dbo->prepare("SELECT c.trade_name, c.sno, SUM(i.qty_sold)
FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno
WHERE `trade_name` = '$brand' ");
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
				$stock=$cxz['SUM(i.qty_sold)'];
        $snoi=$cxz['sno'];
				}


				$results = $dbo->prepare("SELECT c.trade_name, SUM(GREATEST(i.quantity, 0)) AS qty1
        FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno
        WHERE `trade_name` = '$brand'
        GROUP BY i.sno ");
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
			    $bal = $rows['qty1'];
				}


				$sold = $stock - $bal ;

				?>
					<strong>

				</th>
				<th colspan="1" style="border-top:1px solid #999999">
				Item Code: MED0<?php

						echo $snoi;

						?>

				</th>


				<th colspan="1" style="border-top:1px solid #999999">  Total Stock In:
						<?php

						echo number_format ($stock);

						?>


				</th>




				<th colspan="1" style="border-top:1px solid #999999">Total Stock Out:


						<?php

						echo number_format ($sold);

						?>

				</th>





				<th colspan="1" style="border-top:1px solid #999999"> Closing Stock: <?php

						echo number_format ($bal);

						?></th>




				<th colspan="1" style="border-top:1px solid #999999"> </th>
				<th colspan="1" style="border-top:1px solid #999999"> </th>
				<th colspan="1" style="border-top:1px solid #999999"> </th>

				</tr>
				</strong>
	<tr>

	        <th> Date</th>
		    <th> From/To</th>
			<th> Note</th>
			<th> Invoice/Receipt No. </th>
			<th> Qty In/Out</th>
			<th> Expiry Date</th>
			<th> Batch No.</th>
		    <th> Entrant </th>
		</tr>
	</thead>
	<tbody>

			<?php







				$result = $dbo->prepare("SELECT c.trade_name, c.generic_name,d.id,d.customer,d.cash,d.date, d.entrant,d.notes,s.quantity,i.expiry_date, i.batch
        FROM `medicine_list` AS c
        INNER JOIN `sales_list` AS s ON c.sno = s.sno
        INNER JOIN `sales_details` AS d ON d.id = s.invoice
		INNER JOIN `inventory` AS i ON i.pid = s.product WHERE `trade_name` = '$brand'
UNION
SELECT c.trade_name, c.generic_name,p.invoiceNo,p.supplier,c.wsell,p.invoiceDate, p.entrant,p.notes,i.qty_sold, i.expiry_date, i.batch
FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno   INNER JOIN purchases AS p ON p.id = i.invoice_id
WHERE `trade_name` = '$brand'

				ORDER BY STR_TO_DATE(`date`, '%d/%m/%Y') DESC");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

			?>

			<tr class="record">

			<td><?php echo $row['date']; ?></td>



			<td><?php echo $row['customer']; ?></td>
			<td><?php echo $row['notes']; ?></td>
			<td><?php echo $row['id']; ?></td>

			<td>

			<?php
						if ($row['cash'] == "Yes"){
							echo "-";
						}
						?>

			<?php echo number_format($row['quantity']); ?></td>

			<td><?php echo $row['expiry_date']; ?></td>
			<td><?php echo $row['batch']; ?></td>

				<td><?php echo $row['entrant']; ?></td>
			</tr>
			<?php
				}
			?>

	</tbody>

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
