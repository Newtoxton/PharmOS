<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | History</title>
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

 
</head>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Medicine Purchase History
        <small>All Medicines</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Inventory</li>
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

<div class="box">
 <div class="box-body">
<div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example">
						
						 <a href="inventory_edit.php" class="btn btn-success">Back</a>
						 
						 </br>
						 </br>

                            <thead>
                                <tr>
                                    <th style="text-align:center;" >Trade name</th>
                                    <th style="text-align:center;">Generic name</th>
                                    <th style="text-align:center;">Batch</th>
                                    <th style="text-align:center;">Cost</th>
                                    <th style="text-align:center;">W/sale</th>
                                    <th style="text-align:center;">Retail</th>
									<th style="text-align:center;">Qty Available</th>
									<th style="text-align:center;">Qty Stocked</th>
									<th style="text-align:center;">Arrival</th>
									<th style="text-align:center;">Expiry</th>
									<th style="text-align:center;">Edit</th>
									<th style="text-align:center;">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
							
							
							
							 <?php
                                 if (isset($_POST['search'])){
                                    
                                $search=$_POST['search'];

								$result= mysqli_query($con, "select c.trade_name, c.generic_name, i.pid, i.batch, i.cost_price,i.wsale, i.sell_price, i.quantity, i.qty_sold, date_format(i.datetime, '%d/%m/%y') AS DATE, i.expiry_date FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno  
								WHERE  trade_name LIKE '%$search%' OR generic_name LIKE '%$search%' OR batch LIKE '%$search%' 
								ORDER BY i.pid Desc" ) or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
							
								?>
								<tr>

								<td style="width:300px;"> <?php echo $row ['trade_name']; ?></td>
								<td style="width:300px;"> <?php echo $row ['generic_name']; ?></td>
								<td style="width:100px;"> <?php echo $row ['batch']; ?></td>
								<td style="width:150px;"> <?php echo $row ['cost_price']; ?></td>
								<td style="width:150px;"> <?php echo $row ['wsale']; ?></td>
								<td style="width:150px;"> <?php echo $row ['sell_price']; ?></td>
								<td style="width:100px;"> <?php echo $row ['quantity']; ?></td>
								<td style="width:100px;"> <?php echo $row ['qty_sold']; ?></td>
								<td style="width:120px;"> <?php echo $row ['DATE']; ?></td>
								<td style="width:200px;"> <?php echo $row ['expiry_date']; ?></td>

								<td><form  method="post" action="edit_product.php<?php echo '?id='.$row['pid']; ?>"><input type='submit'  class="btn btn-success addmore" value='Edit'>	</form></td>

			<td><form  method="post" action="delete_product.php<?php echo '?id='.$row['pid']; ?>"><input type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete"  value='Delete'>	</form></td>





							<!-- Modal -->

								</div>
								</div>
								</tr>

								<!-- Modal Bigger Image -->


								<?php } 
								 }
								?>
                            </tbody>
                        </table>



        </div>
        </br>

<script src="app/app.js"></script>

  <script src="js/jquery-1.12.4.js"></script>
  <script src="js/jquery-ui.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>
