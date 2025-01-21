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
    


    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<?php include("header.php"); ?>
  
	<?php 
		if(!empty($_POST)){
			echo "<pre>";print_r($_POST); echo "</pre>";
			exit;
		}
	?>
	
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

      <!-- Default box -->
	  
      
        <div class="box-body">
		
		<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">All Fields are required</h3>
            </div>
   
    	<form name='form1' method="post" action="data.php">
	    	
	      	<div class='row' id="table_container">
	      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
	      			<table class="table table-bordered table-hover" id="invoice_table">
						<thead>
							<tr>
								<th width="4%"> <input id="check_all" class="formcontrol" type="checkbox"/></th>
								<th width="12%">Trade Name</th>
								<th width="15%">Generic Name</th>
                                <th width="10%">Batch</th>
								<th width="8%">Sale Price</th>
								<th width="8%">Cost Price</th>
								<th width="10%">Supplier</th>
								<th width="7%">Quantity</th>
								<th width="9%">Expiry (yy-m-d)</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <input class="case" type="checkbox"/></td>
								<td><input type="text" data-type="trade_name" name="itemNo[]" id="itemNo_1" class="form-control autocomplete_txt" autocomplete="off"></td>
								<td><input type="text" data-type="generic_name" name="itemName[]" id="itemName_1" class="form-control autocomplete_txt" autocomplete="off"></td>
								<input type="hidden" step="any" name="sno[]" id="price_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"  >
								<td><input type="text" step="any" name="batch[]" id="batch" class="form-control autocomplete_txt" autocomplete="off" required></td>
								<td><input type="text" step="any" name="sell_price[]" id="sell_price"  onchange="updateDue()" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"  ></td>
								 <td><input type="text" step="any" name="cost_price[]" id="cost_price"  onchange="updateDue()" class="form-control changesNo"   ></td>
								<td><input type="text" step="any" name="supplier[]" id="baby" class="form-control autocomplete_txt" autocomplete="off"   ></td>
								<td><input type="number" step="any" name="quantity[]" id="quantity_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required></td>
							   <td><input type="text" step="any" name="expiry_date[]" id="expiry_date" value="<?php echo date("Y-m-d"); ?>" class="form-control autocomplete_txt" autocomplete="off"></td>
							</tr>
						</tbody>
						
					</table>
	      		</div>
	      	</div>
	      	<div class='row'>
	      		<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
	      			<button class="btn btn-danger delete" type="button">- Delete</button>
	      			<button class="btn btn-success addmore" type="button">* Add Row</button>
					</div>
					
				<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
					<button class="btn btn-success addmore" type="submit">+ Save</button>
	      		</div>
      	</form>	
		 </div>
		  </div>
		  
        </div>
				  </div>
		  
        </div>

</div>
<script type='text/javascript'>
	function validateForm() {
    var x = document.forms["form1"]["arrival_date"].value || document.forms["form1"]["quantity"].value;
	
    if (x == null || x == "") {
        alert("Field must be filled out");
        return false;
    }
}
</script>

		
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/auto.js"></script>
	
		<script src="js/jquery-1.10.2.min.js"></script>	
		<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
	
	
		
	<?php include("footer.php"); ?>  
  </body>
</html>




