<?php

include_once "../connect.php"; // database connection details stored here

 $id=$_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Edit</title>
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

      <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">


	<script type="text/javascript">
function updateTotal() {
    var total = 0;//
    var list = document.getElementsByClassName("input");
    var values = [];
    for(var i = 0; i < list.length; ++i) {
        values.push(parseFloat(list[i].value));
    }
    total = values.reduce(function(previousValue, currentValue, index, array){
        return previousValue + currentValue;
    });
    document.getElementById("total").value = total;
}

</script>


  </head>

<?php include("header.php"); ?>

	<?php include("sidebar.php"); ?>
    <!-- Begin page content -->
	 <div class="content-wrapper">
	 <section class="content-header">
      <h1>
        Edit Purchases
        <small>Receipts</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Admin</a></li>
        <li class="active"> Edit Purchases</li>
      </ol>
    </section>

	<section class="content">

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
		  <div class="box">
            <div class="box-header">
			 <h3 class="box-title">Invoice Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <table id="example2" class="table table-bordered table-hover">
            <thead>
            <tr>
            <th>Date</th>
            <th>Supplier Name</th>
            <th>Invoice No.</th>
            <th>Entrant</th>
            <th>Edit</th>
            </tr>
            </thead>

            <tbody>
            <?php

            $query=mysqli_query($con, "SELECT *  FROM `purchases` WHERE id = '$id' ")or die(mysqli_error());
            while($row=mysqli_fetch_array($query)){
				
				$supplier = $row['supplier'];
            ?>
            <tr>

            <td><?php echo $row[3]; ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php echo $row[2]; ?></td>
            <td><?php echo $row[11]; ?></td>

            <td><a href="edit_name.php?id=<?php echo $row['id']; ?>"><input type='submit' class="btn btn-success addmore" value='Edit'>	</a></td>

            </tr>
            <?php } ?>
            </tbody>
            </table>

</br>

				<div class='row' id="table_container">
	      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>

				<?php

$sql = "select c.sno, c.trade_name, i.pid, i.invoice_id, i.batch, i.cost_price, i.qty_sold, i.expiry_date FROM `medicine_list` AS c
INNER JOIN `inventory` AS i ON c.sno = i.sno
WHERE  invoice_id = '$id'  ORDER BY pid ASC";

$result = mysqli_query($con, $sql) or die($sql."<br/><br/>".mysqli_error());

$i = 0;

echo '<table class="table table-bordered table-hover" id="invoice_table">';
echo '<thead>';
echo '<tr>';
echo '<td width="25%"><strong>Trade Name</strong></td>';
echo '<td><strong>Batch</strong></td>';
echo '<td><strong>Expiry</strong></td>';
echo '<td><strong>Cost</strong></td>';
echo '<td><strong>Quantity</strong></td>';
echo '<td><strong>Total</strong></td>';
echo '<td><strong>Delete</strong></td>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

echo "<form name='form_update' method='post' action='updates.php'>\n";
while ($students = mysqli_fetch_array($result)) {
	$tid = $students['pid'] ;
	$invoice = $students['invoice_id'] ;
	$q = $students['qty_sold'] ;
	$p = $students['cost_price'] ;
	$amount = $q * $p;
	$pid = $students['pid'] ;
echo '<tr>';
    echo "<td>{$students['trade_name']}</td>";
	echo "<input type='hidden' size='40' name='id[$i]' value='$tid' />";
    echo "<td><input type='text' size='40' name='batch[$i]' id='batch_$tid' class='form-control changesNo' value='{$students['batch']}' /></td>";
	echo "<td><input type='text' size='40' name='expiry_date[$i]' id='expiry_date_$tid' class='form-control changesNo' value='{$students['expiry_date']}' /></td>";
	echo "<td><input type='text' size='40' name='price[$i]' id='price_$tid' class='form-control totalLinePrice' value='$p' /></td>";
	echo "<td><input type='text' size='40' name='quantity[$i]' id='quantity_$tid' class='form-control changesNo' value='$q' /></td>";
	echo "<input type='hidden' size='40' name='qty1[$i]' id='quantity_$tid' class='form-control changesNo' value='$q' />";
	echo "<input type='hidden' size='40' name='sno[$i]' id='sno_$tid' class='form-control changesNo' value='{$students['sno']}' />";
	echo "<input type='hidden' name='mid' value='$invoice' />";
	echo "<input type='hidden' name='supplier' value='$supplier' />";
	echo "<td><input type='text' size='40' name='total[$i]' id='total_$tid' class='input' onchange='updateTotal();'  value='$amount' /></td>";
	echo "<td><a href='delete_inv.php?id=$pid&invoice=$invoice' class='btn btn-danger delete'>  Delete </a></td>";
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
					<form  method="post" action="add_stocks.php<?php echo '?invoice_id='.$id; ?>"><input type='submit'  class="btn btn-success addmore" value='Add'>	</form></div>

					<div class="col-xs-5">
							<div class="form-group">
								<label>Total: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-addon"><?php echo $currency ?></div>
									<input name="total" type="text" id="total" class="form-control" value="">

								</div>
							</div>

              </div>
                </div>

					</div>
				</div>




        </div>
				  </div>

        </div>

</div>



    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/auto.js"></script>

		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/jquery-ui-1.10.3.custom.min.js"></script>

<script src="js/facebox.js" type="text/javascript"></script>

<script src="js/chosen.jquery.min.js"></script>


        <script>
        $(function() {
<!--             $(".datepicker").datepicker(); -->
<!--             $(".uniform_on").uniform() -->;
            $(".chzn-select").chosen();
   <!--          $('.textarea').wysihtml5(); -->

        });
        </script>

<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>



	<?php include("footer.php"); ?>
  </body>
</html>
