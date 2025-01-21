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

  <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">


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
            <div class="box-header with-border">
              <h3 class="box-title">Type medicine name to search and press enter</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

<div class="box">
 <div class="box-body">
<div class="table-responsive">
 <form method="POST" action="inventory_search.php" class="navbar-search pull-left">
                                    <input type="text" name="search" class="search-query" placeholder="Search">
                                </form>
								</br>
								</br>
								</br>
                        <table class="table table-bordered table-striped" id="example">

                            <thead>
                                <tr>
                                    <th style="text-align:center;">Trade name</th>
                                    <th style="text-align:center;">Generic name</th>
                                    <th style="text-align:center;">Batch</th>
                                    <th style="text-align:center;">Cost</th>
                                    <th style="text-align:center;">Qty Available</th>
									<th style="text-align:center;">Qty Stocked</th>
									<th style="text-align:center;">Expiry</th>
									<th style="text-align:center;">Supplier</th>
									<th style="text-align:center;">Arrival</th>
								    <th style="text-align:center;">Edit</th>
									<th style="text-align:center;">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
								<?php

								$result= mysqli_query($con, "select p.supplier, p.invoiceDate, c.trade_name, c.generic_name,c.sell_price, c.wsell, i.pid, i.batch, i.quantity, i.cost_price, i.qty_sold, i.expiry_date FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno   INNER JOIN purchases AS p ON p.id = i.invoice_id
								ORDER BY i.pid Desc LIMIT 15" ) or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
								$id=$row['pid'];
								?>
								<tr>

								<td style="width:300px;"> <?php echo $row ['trade_name']; ?></td>
								<td style="width:300px;"> <?php echo $row ['generic_name']; ?></td>
								<td style="width:100px;"> <?php echo $row ['batch']; ?></td>
								<td style="width:150px;"> <?php echo $row ['cost_price']; ?></td>
								<td style="width:100px;"> <?php echo $row ['quantity']; ?></td>
								<td style="width:100px;"> <?php echo $row ['qty_sold']; ?></td>
								<td style="width:200px;"> <?php echo $row ['expiry_date']; ?></td>
								<td style="width:120px;"> <?php echo $row ['supplier']; ?></td>
								<td style="width:120px;"> <?php echo $row ['invoiceDate']; ?></td>
								

								<td><form  method="post" action="edit_product.php<?php echo '?id='.$row['pid']; ?>"><input type='submit'  class="btn btn-success addmore" value='Edit'>	</form></td>
                                <td><form  method="post" action="delete_product.php<?php echo '?id='.$row['pid']; ?>"><input type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete"  value='Delete'>	</form></td>

							<!-- Modal -->

								</div>
								</div>
								</tr>

								<!-- Modal Bigger Image -->


								<?php } ?>
                            </tbody>
                        </table>
             </div>
        </br>
        
        <?php
require_once("excelwriter.class.php");

$excel=new ExcelWriter("inventory.xls");
if($excel==false)	
echo $excel->error;
$myArr=array("");
$myArr=array("Stock Report");
$excel->writeLine($myArr);
$myArr=array("");
$excel->writeLine($myArr);
$myArr=array("Sno","Brand name","Generic Name","Type","Batch No","Cost Price","Whole sale Price","Retail Price","Qty Available","Qty Stocked","Arrival Date","Expiry Date");
$excel->writeLine($myArr);
$qry=mysqli_query($con, "select c.sno, c.trade_name, c.generic_name, c.type, c.sell_price, c.wsell, i.pid, i.batch, i.cost_price, i.quantity, i.qty_sold, date_format(i.datetime, '%d/%m/%y') AS DATE, i.expiry_date FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno  ORDER BY i.pid Desc");

if($result!=false)
{
	$i=1;
	while($res=mysqli_fetch_array($qry))
	{
	$myArr=array($res['sno'],$res['trade_name'],$res['generic_name'],$res['type'],$res['batch'],$res['cost_price'],$res['wsell'],$res['sell_price'],$res['quantity'],$res['qty_sold'],$res['DATE'],$res['expiry_date']);
		$excel->writeLine($myArr);
		$i++;
	}
}
?>
				  
				  <a href="inventory.xls"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Download Report  
          </button></a>
        </div>
        </div>
    </div>





<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>
