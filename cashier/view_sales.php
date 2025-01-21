<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Sales</title>
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

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>


</head>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales History

      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Sales</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">

            <!-- /.box-header -->
            <!-- form start -->
			</br>
<a href="sales.php" class="btn btn-success">Sales History</a>	
</br>
</br>
<div class="box">
 <div class="box-body">
<div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example">

                            <thead>
                                <tr>
                                    <th> No.</th>
                                    <th style="text-align:center;">Invoice No.</th>
                                    <th style="text-align:center;">Trade name</th>
                                    <th style="text-align:center;">Generic name</th>
                                    <th style="text-align:center;">Qty</th>
                                    <th style="text-align:center;">Price</th>
                                    <th style="text-align:center;">Total</th>
                  									<th style="text-align:center;">Delete</th>

                                </tr>
                            </thead>
                            <tbody>
								<?php
                $id=$_GET['id'];
                $i = 0;
								$result= mysqli_query($con, "select c.trade_name, c.generic_name, s.transaction_id, s.invoice, s.quantity, s.price, s.amount, s.profit, s.product FROM `medicine_list` AS c INNER JOIN `sales_list` AS s ON c.sno = s.sno  WHERE  invoice='$id'  ORDER BY invoice ASC" ) or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
									
									$invoice =  $row ['invoice'];

								?>
								<tr>
                <td><?php echo ++$i ;  ?> </td>
                <td style="width:150px;"> <?php echo $row ['invoice']; ?></td>
								<td style="width:300px;"> <?php echo $row ['trade_name']; ?></td>
								<td style="width:300px;"> <?php echo $row ['generic_name']; ?></td>
								<td style="width:50px;"> <?php echo $row ['quantity']; ?></td>
								<td style="width:150px;"> <?php echo $row ['price']; ?></td>
                <td style="width:150px;"> <?php echo $row ['amount']; ?></td>

			          <td><form  method="post" action="delete_sales.php?id=<?php echo $row['transaction_id']; ?>&quantity=<?php echo $row['quantity']; ?>&invoice=<?php echo $row['invoice']; ?>&product=<?php echo $row['product']; ?>"><input type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete"  value='Delete'>	</form></td>

							<!-- Modal -->

								</div>
								</div>
								</tr>

								<!-- Modal Bigger Image -->


								<?php } ?>
                            </tbody>
							
							<thead>
		<tr>
			<th colspan="6" style="border-top:1px solid #999999"> Total: </th>
			<th colspan="1" style="border-top:1px solid #999999">
			<?php
            
								$result= mysqli_query($con, "select SUM(amount) total FROM `sales_list`  WHERE  invoice='$id'  " ) or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
									
									$tot =  $row ['total'];
									
									echo number_format ($tot);
								}

								?>
			</th>
							
							
			</thead>				
							
                        </table>
        </div>
		<div class='row'>
					<div class="col-xs-5">
					    
					</div>

					<div class="col-xs-2">
					<form  method="post" action="add_stock2.php<?php echo '?id='.$invoice; ?>"><input type='submit'  class="btn btn-primary" value='Add'>	</form>
					
					</div>

					
		
        </div>
    </div>


<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>
