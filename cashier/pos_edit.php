<?php

include_once "../connect.php"; // database connection details stored here

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
        Point of Sale -Wholesale
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
            <div class="box-header">
							<h3 class="box-title">Quick Search</h3>
			             </div>
			             <!-- /.box-header -->
			 						 <div class="box-body">
			 			</div>
			 		</div>
           
					
				<div class='row' id="table_container">
	      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
				
				
				<?php

include_once "../connect.php"; // database connection details stored here

$id=$_GET['id'];


$sql = "select c.trade_name, s.transaction_id, s.invoice, s.quantity, s.price, s.amount, s.profit, s.product FROM `medicine_list` 
AS c INNER JOIN `sales_list` AS s ON c.sno = s.sno  WHERE  invoice='$id'  ORDER BY invoice ASC";

$result = mysqli_query($con, $sql) or die($sql."<br/><br/>".mysqli_error());

$i = 0;
				
	      			echo '<table class="table table-bordered table-hover" id="invoice_table">';
						echo '<thead>';
							echo '<tr>';
								echo '<th width="15%">Brand Name</th>';
								echo '<th width="8%">Sale Price</th>';
								echo '<th width="7%">Quantity</th>';
								echo '<th width="8%">Total</th>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
							echo '<tr>';
							echo "<form name='form_update' method='post' action='update.php'>\n";
							while ($res = mysqli_fetch_array($result)) {
							
								echo "<td>{$res['trade_name']}</td>";
                                echo "<td>{$res['price']}<input name='price[$i]' id='price_1' class='form-control changesNo' value='{$res['price']}'></td>";
							    echo "<td>{$res['quantity']}<input  name='quantity[$i]' id='quantity_1' class='form-control changesNo' value='{$res['quantity']}'></td>";
							    echo "<td>{$res['amount']}<input name='amount[$i]' id='total_1' class='form-control totalLinePrice' value='{$res['amount']}'></td>";
	++$i;
}


							  echo '</tr>';
					
							  

						echo '</tbody>';
						
						echo "</form>";

					echo '</table>';
					
					?>
					
	      		</div>
	      	</div>
	      	<div class='row'>
					<div class="col-xs-5">
					    
					</div>

					<div class="col-xs-2">
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

								<div class="input-group">
								<button data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" class="btn btn-success submit_btn invoice-save-top form-control"> <i class="fa fa-floppy-o"></i>  Save </button>

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
    <script src="js/auto3.js"></script>

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
