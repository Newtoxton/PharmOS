<?php

include "../connect.php"; // database connection details stored here

 $id=$_GET['id'];

?>
<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | POS</title>
	<!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

   <link href="css/facebox.css" media="screen" rel="stylesheet" type="text/css" />

   <link href="css/chosen.min.css" rel="stylesheet" media="screen">


  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../plugins/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

      <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
	


  </head>

<?php include("header.php"); ?>

	<?php include("sidebar.php"); ?>
    <!-- Begin page content -->
	 <div class="content-wrapper">
	 <section class="content-header">
      <h1>
       Edit Invoice
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Admin</a></li>
        <li class="active">POS</li>
      </ol>
    </section>

	<section class="content">

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
		  <div class="box">
          
			             <!-- /.box-header -->
			 						 <div class="box-body">
			 			</div>
			 		</div>
           
					
				<div class='row' id="table_container">
	      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
				
				
<?php

$sql = "select i.customer, i.date, c.trade_name, c.generic_name, s.transaction_id, s.invoice, s.quantity, s.price, s.amount, s.profit,s.sno, s.product FROM `medicine_list` AS c INNER JOIN `sales_list` AS s ON c.sno = s.sno 
INNER JOIN `sales_details` AS i ON i.id = s.invoice WHERE  invoice='$id'  ORDER BY invoice ASC";

$result = mysqli_query($con, $sql) or die($sql."<br/><br/>".mysqli_error());

$i = 0;

echo '<table class="table table-bordered table-hover" id="invoice_table">';
echo '<thead>';
echo '<tr>';
echo '<td width="25%"><strong>Brand name</strong></td>';
echo '<td><strong>Price</strong></td>';
echo '<td><strong>Quantity</strong></td>';
echo '<td><strong>Total</strong></td>';
echo '<td><strong>Delete</strong></td>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

echo "<form name='form_update' method='post' action='update.php'>\n";
while ($students = mysqli_fetch_array($result)) {
	$tid = $students['transaction_id'] ;
	$customer = $students['customer'] ;
	$invoice = $students['invoice'] ;
	$q = $students['quantity'] ;
	$p = $students['product'] ;
	$j = $students['invoice'] ;
	
	echo '<tr>';
    echo "<td>{$students['trade_name']}</td>";
	echo "<input type='hidden' size='40' name='id[$i]' value='$tid' />";
	echo "<input type='hidden' size='40' name='sno[$i]' id='itemName_1' class='form-control autocomplete_txt' value='{$students['sno']}' />";
    echo "<td><input type='text' size='40' name='price[$i]' id='price_$tid' class='form-control changesNo' value='{$students['price']}' /></td>";
	echo "<input type='hidden' size='40' name='qty1[$i]'  value='{$students['quantity']}' />";
	echo "<td><input type='text' size='40' name='quantity[$i]' id='quantity_$tid' class='form-control changesNo' value='{$students['quantity']}' /></td>";
	echo "<td><input type='text' size='40' name='amount[$i]' id='total_$tid' class='form-control totalLinePrice' value='{$students['amount']}' /></td>";
	echo "<td><a href='delete_sale.php?id=$tid&quantity=$q&product=$p&invoice=$j' class='btn btn-danger delete'>  Delete </a></td>";
	echo '</tr>';
	++$i;
}
echo '<tr>';
echo '</tbody>';
echo "<td><input type='submit' value='Update Invoice' class='btn btn-success submit_btn invoice-save-top form-control'  /></td>";
echo '</tr>';
echo "</form>";
echo '</table>';

?>
		
	      		</div>
	      	</div>
	      	<div class='row'>
					<div class="col-xs-5">
					    
					</div>

					<div class="col-xs-2">
					<form  method="post" action="add_stock.php<?php echo '?id='.$invoice; ?>"><input type='submit'  class="btn btn-primary" value='Add'>	</form>
					</div>

					<div class="col-xs-5">
							<div class="form-group">
								<label>Total: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-addon"><?php echo $currency ?></div>
									<input type="number" class="form-control" name="totals" id="totalAftertax" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
								</div>
							</div>


							<div class="form-group">

								
							</div>

					</div>
				</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/auto3.js"></script>




	<?php include("footer.php"); ?>
  </body>
</html>
