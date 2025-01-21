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
                <?php

                $result3 = $dbo->prepare("SELECT * from `v_inventory_sales`
GROUP BY `trade_name`");
						$result3->bindParam(':userid', $res);
						$result3->execute();

                ?>

               <div class="col-xs-3">
                  <select name="sno"  class="form-group" id="select2" style="width:250px; height:34px" >
					<option>Select Trade name</option>

					<?php
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option value="<?php echo $row['sno']; ?>"><?php echo $row['trade_name']; ?></option>
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
  <?php

				$sno =    $_GET['sno'];
				$results = $dbo->prepare("SELECT * from v_inventory_sales  where sno=? ");
        $results->bindParam(1,$sno,PDO::PARAM_INT);
				$results->execute();
        $res=$results->fetch();

				$batched_results = $dbo->prepare("SELECT * from v_batched_inventory  where sno=$sno ");
				$batched_results->execute();
        ?>
<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
STOCK CARD FOR::<?php echo $res['trade_name']; ?>
  <small style="color:#555555">
    (<?php echo $res['generic_name']; ?>)
  </small>

</div>


<div class="table-responsive">
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
				<th colspan="1" style="border-top:1px solid #999999"> </th>




					<strong>

				</th>
				<th colspan="1" style="border-top:1px solid #999999">
				Item Code: MED0<?php


						?>

				</th>


				<th colspan="1" style="border-top:1px solid #999999">  Total Stock In:
						<?php
                      $rm=((int)$res['total_available']+(int)$res['total_sales_quantity']);
            echo $rm;
						?>

				</th>




				<th colspan="1" style="border-top:1px solid #999999">Total Stock Out:


						<?php
      echo $res['total_sales_quantity'];
						?>

				</th>





				<th colspan="1" style="border-top:1px solid #999999"> Closing Stock: <?php
      echo $res['total_available'];
						?></th>




				<th colspan="1" style="border-top:1px solid #999999"> </th>
				<th colspan="1" style="border-top:1px solid #999999"> </th>

				</tr>


				</strong>
	<tr>

	        <th> Date</th>
		    <th> From/To</th>
			<th> Invoice/Receipt No. </th>
			<th> Qty In/Out</th>

			<th> Expiry Date</th>
			<th> Batch No.</th>
		    <th> Entrant </th>
		</tr>
	</thead>
	<tbody>

			<?php


				for($i=0; $row = $batched_results->fetch(); $i++){

			?>
			<tr class="record">

			<td><?php echo $row['date']; ?></td>



			<td><?php echo $row['customer']; ?></td>
			<td><?php echo $row['id']; ?></td>

			<td>

			<?php
						if ($row['cash'] == "Yes"){
							echo "-";
						}
						?>

			<?php echo $row['quantity']; ?></td>

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
