<?php

include_once "../connect.php"; // database connection details stored here

require_once 'med_save_wsale.php';

if( !empty( $_POST ) ){
	try{
		$data = saveMed( $_POST );

		if( isset($data['success']) && $data['success']){
			$_SESSION['success'] = 'Medicine Saved Successfully!';
			header('Location: invoice_list.php');exit;
		} else {
			$_SESSION['success'] = 'Medicine Save failed, try again.';
		}
	} catch (Exception $e) {
		$_SESSION['error'] = $e->getMessage();
	}
}

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
			 						<form action="" method="post" >
			 						<select name="product" style="width:950px; "class="chzn-select" required>
			 						<option></option>
			 						<?php
			 						$result = $dbo->prepare("select c.trade_name, c.generic_name,c.wsell, i.pid, i.cost_price, i.quantity, i.qty_sold, i.expiry_date FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno  WHERE quantity > 0;");
			 						$result->bindParam(':userid', $res);
			 						$result->execute();
			 						for($i=0; $row = $result->fetch(); $i++){
			 						?>
			 						<option value="<?php echo $row['pid'];?>"> <?php echo $row['trade_name']; ?>  | <?php echo $row['generic_name']; ?> | Cost @ <?php echo $row['cost_price']; ?> | Price @ <?php echo $row['wsell']; ?> | Expires on: <?php echo $row['expiry_date']; ?> | Qty Left: <?php echo $row['quantity']; ?></option>
			 						<?php
			 						 }
			 						?>
			 						</select>

			 					</form>
			 				</br>
			 			</div>
			 		</div>
            <div class="box-body">

<form name='form1' action="<?php echo $_SERVER['PHP_SELF']; ?>" id="invoice-form" method="post" role="form" >
			<div class="row">
				<div class="col-xs-6">
						</br>
						</br>
					<select name="customer"  class="chzn-select" style="width:350px; height:15px" required>
						<option value="" >Select Customer</option>

					<?php

					$result3 = $dbo->prepare("SELECT  name FROM customer");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option><?php echo $row['name']; ?> </option>
					<?php
					}
					?>

					</select>

                                                <input type="hidden" name="wsale" value="Yes" />
												<input type="hidden" name="cash" value="No" />
						<input type="hidden" value="1" name="uuid">
					</div>
					<div class="col-xs-6">	<h4>&nbsp;</h4>
						<div class="input-group">
							<div class="input-group-addon">Date</div>
							<input type="text" class="form-control" name="date"  value="<?php echo date("d/m/Y");  ?>">
							<input type="hidden" name="time" value="<?php echo date("g:i a"); ?>" />
							<?Php
							if(isset($_SESSION['userid'])){
							}
							?>

							<input type="hidden" name="userid" value="<?php echo "$_SESSION[userid]"; ?>" />
</div>
					</div>
				</div>
				</br>
				<div class='row' id="table_container">
	      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
	      			<table class="table table-bordered table-hover" id="invoice_table">
						<thead>
							<tr>
								<th width="4%"> <input id="check_all" class="formcontrol" type="checkbox"/></th>
								<th width="15%">Brand Name</th>
								<th width="8%">Qty Avail</th>
								<th width="8%">Sale Price</th>
								<th width="7%">Quantity</th>
								<th width="8%">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <input class="case" type="checkbox"/></td>
								<td><input type="text" data-type="trade_name" name="itemNo[]" id="itemNo_1" class="form-control autocomplete_txt" autocomplete="off"></td>
                <input type="hidden" data-type="generic_name" name="data[0][sno]" id="itemName_1" class="form-control autocomplete_txt" autocomplete="off">
               <td><input type="text" data-type="qty" name="qty[]" id="qty_1" class="form-control autocomplete_txt" autocomplete="off" readonly></td>
              <td><input type="text" name="data[0][price]" id="price_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
							  <td><input type="number" name="data[0][quantity]" id="quantity_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
							  <td><input type="text" name="data[0][total]" id="total_1" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>



							  </tr>
						</tbody>

					</table>
	      		</div>
	      	</div>
	      	<div class='row'>
					<div class="col-xs-5">
						<button id="addmore" class="btn btn-success addmore" type="button">+ Add More</button>
						<button id="delete" class="btn btn-danger delete" type="button">- Delete</button>
					
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



			</form>
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
