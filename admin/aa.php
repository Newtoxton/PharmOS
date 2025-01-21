<?php

include_once "../connect.php"; // database connection details stored here


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Add Medicine</title>
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
   


  </head>

<?php include("header.php"); ?>

	<?php include("sidebar.php"); ?>
    <!-- Begin page content -->
	 <div class="content-wrapper">
	 <section class="content-header">
      <h1>
        Add Medicine
        <small>Add New Medicines</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Admin</a></li>
        <li class="active">Add Medicine</li>
      </ol>
    </section>

	<section class="content">

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
		  <div class="box">
            <div class="box-header">
			 <h3 class="box-title">All Fields are required</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

<form name='form1' action="<?php echo $_SERVER['PHP_SELF']; ?>" id="invoice-form" method="post" role="form" >
			<div class="row">
				<div class="col-xs-6">
						</br>
						</br>
					<select name="supplier"  class="chzn-select" style="width:350px; height:15px" required>
					<option value="">Select Supplier</option>

					<?php

					$result3 = $dbo->prepare("SELECT  name FROM supplier");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option><?php echo $row['name']; ?> </option>
					<?php
					}
					?>

					</select>


						<input type="hidden" value="1" name="uuid">
<input type="hidden" name="entrant" value="<?php echo "$_SESSION[userid]"; ?>" />
					</div>
					<div class="col-xs-6">	<h4>&nbsp;</h4>

							<input type="text" class="form-control" name="invoiceNo" id="invoiceNo" placeholder="Invoice No">

						</br>
							<input type="text" class="form-control" name="invoiceDate"  value="<?php echo date("d/m/Y");  ?>">


					</div>
				</div>
				</br>
				<div class='row' id="table_container">
	      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
	      			<table class="table table-bordered table-hover" id="invoice_table">
						<thead>
							<tr>
								<th> <input id="check_all" class="formcontrol" type="checkbox"/></th>
								<th>Item</th>
								<th>Rate</th>
								<th>Quantity</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <input class="case" type="checkbox"/></td>
							  <td><input type="text" data-type="trade_name" name="itemNo[]" id="itemNo_1" class="form-control autocomplete_txt" autocomplete="off"></td>
                                <input type="hidden" data-type="generic_name" name="data[0][sno]" id="itemName_1" class="form-control autocomplete_txt" autocomplete="off">
                               
						   	  <td><input type="text" name="data[0][price]" id="price_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
							  <td><input type="text" name="data[0][quantity]" id="quantity_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
							  <td><input type="text" name="data[0][total]" id="total_1" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>




							  </tr>
						</tbody>

					</table>
	      		</div>
	      	</div>
	      	<div class='row'>
					<div class="col-xs-5">
						<button id="delete" class="btn btn-danger delete" type="button">- Delete</button>
						<button id="addmore" class="btn btn-success addmore" type="button">+ Add More</button>
						<h2>Notes: </h2>
						<div class="form-group">
							<textarea class="form-control" rows='5' name="notes" id="notes" placeholder="Your Notes"></textarea>
						</div>
					</div>

					<div class="col-xs-2">
					</div>

					<div class="col-xs-5">
							<div class="form-group">
								<label>Total: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-addon"><?php echo $currency ?></div>
									<input type="number" class="form-control" name="invoice_total" id="totalAftertax" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
								</div>
							</div>
							


							<div class="form-group">

								<div class="input-group">
								<button data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" class="btn btn-success submit_btn invoice-save-top form-control"> <i class="fa fa-floppy-o"></i>  Save Invoice </button>

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
    <script src="js/auto.js"></script>




	<?php include("footer.php"); ?>
  </body>
</html>
