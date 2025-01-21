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

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    $('#example').dataTable( {
        "sPaginationType": "bootstrap",
        "oLanguage": {},
        "aaSorting": [],
        "bDestroy": true
    });
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
              <h3 class="box-title">Type medicine name to search</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

<div class="box">
 <div class="box-body">
<div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example">

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

								$result= mysqli_query($con, "select c.trade_name, c.generic_name, i.id, i.batch, i.cost_price,i.wsale, i.sell_price, i.quantity, i.qty_sold, date_format(i.datetime, '%d/%m/%y') AS DATE, i.expiry_date FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno  ORDER BY i.id Desc" ) or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
								$id=$row['id'];
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

								<td><form  method="post" action="edit_product.php<?php echo '?id='.$row['id']; ?>"><input type='submit'  class="btn btn-success addmore" value='Edit'>	</form></td>

			<td><form  method="post" action="delete_product.php<?php echo '?id='.$row['id']; ?>"><input type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete"  value='Delete'>	</form></td>





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
$myArr=array("Brand name","Generic Name","Batch No","Cost Price","Whole sale Price","Retail Price","Qty Available","Qty Stocked","Arrival Date","Expiry Date");
$excel->writeLine($myArr);
$qry=mysqli_query($con, "select c.trade_name, c.generic_name, i.id, i.batch, i.cost_price, i.sell_price, i.wsale, i.quantity, i.qty_sold, date_format(i.datetime, '%d/%m/%y') AS DATE, i.expiry_date FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno  ORDER BY i.id Desc");

if($result!=false)
{
	$i=1;
	while($res=mysqli_fetch_array($qry))
	{
	$myArr=array($res['trade_name'],$res['generic_name'],$res['batch'],$res['cost_price'],$res['wsale'],$res['sell_price'],$res['quantity'],$res['qty_sold'],$res['DATE'],$res['expiry_date']);
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
