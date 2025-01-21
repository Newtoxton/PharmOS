<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Preview</title>
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
  
	<style type="text/css">
  #printable { display: none; }

    @media print
    {
    	#non-printable { display: none; }
    	#printable { display: block; }
    }
    </style>
    
    <script language="javascript">
    function printDiv(divName) 
    { 
    var printContents = document.getElementById(divName).innerHTML; 
    var originalContents = document.body.innerHTML; 
    document.body.innerHTML = printContents; window.print(); 
    document.body.innerHTML = originalContents; 
    }
    </script>
	
  
</head>
<?php
$invoice=$_GET['invoice'];
$result = $dbo->prepare("SELECT * FROM invoices WHERE invoice= :userid");
$result->bindParam(':userid', $invoice);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){

$invoice=$row['invoice'];
$date=$row['date'];
$am=$row['amount'];

}
?>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->

  
<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proforma Preview
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Preveiw</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body">
       
			 <div class="box box-primary">



	<a href="invoice.php?id=cash&invoice=<?php echo $finalcode ?>"><button class="btn btn-success addmore"> Back to Invoices</button></a>

</br>
</br>
</br>
</br>

<div id="printableArea">
	
	
	<div class="container">
	
	
	<div class="row">
        <div class="col-xs-5">
		
                <img src="<?php echo LOGO ?>" width = "200px"> </br>
				
                </div>
				
                 
              			<div class="col-xs-5">
                <h2>PROFORMA INVOICE</h2>
                </div>
				
			</div>
			
			
			
			<div class="col-xs-5">
			<p>
		 <?php echo $name ?><br>
		<?php echo $address ?>,<?php echo $address2 ?><br>
    Phone: <?php echo $phone ?> E-mail: <font color = "blue"> <?php echo $email ?>   </font>
</p>		
                </div>
				
				
                 
               			<div class='col-xs-8 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-sm-4 col-md-4 col-lg-4'>
                 DATE:  <?php echo date("d/m/Y"); ?> <br>
				 Invoice No. <font color = "red"> <?php echo $invoice ?></font> <br>
				 Prepared by: <?Php if(isset($_SESSION['userid'])){} echo "$_SESSION[userid]"; ?>
				
			</div>
	
	
	  
			
			
			
      	<div class='row'>
      		   <div class="col-xs-10">
      			<table class="table table-bordered table-hover">
					<thead>
						<tr>
							
							<th width="35%">Trade Name</th>
							<th width="35%">Generic Name</th>
							<th width="10%">Quantity</th>
							<th width="10%">Unit Price</th>
							<th width="10%">Amount</th>
							
						</tr>
					</thead>
					<tbody>
						<?php
					$id=$_GET['invoice'];
					$result = $dbo->prepare("select  c.trade_name, c.generic_name,  s.amount, s. price, s.quantity FROM `medicine_list` AS c INNER JOIN `invoices` AS s ON c.sno = s.sno  WHERE invoice= :userid");
					$result->bindParam(':userid', $id);
					$result->execute();
					for($i=0; $row = $result->fetch(); $i++){
				?>
				<tr class="record">
				<td><?php echo $row['trade_name']; ?></td>
				<td><?php echo $row['generic_name']; ?></td>
				<td><?php echo $row['quantity']; ?></td>
				<td>
				<?php
				$ppp=$row['price'];
				echo number_format($ppp, true);
				?>
				</td>
				
				<td>
				<?php
				$dfdf=$row['amount'];
				echo number_format($dfdf, true);
				?>
				</td>
				</tr>
				<?php
					}
				?>
				
				<tr>
					<td colspan="4" style=" text-align:right;"><strong>Total: &nbsp;<?php echo $currency  ?></strong></td>
					<td colspan="4">
					<?php
					$sdsd=$_GET['invoice'];
					$resultas = $dbo->prepare("SELECT sum(amount) FROM invoices WHERE invoice= :a");
					$resultas->bindParam(':a', $sdsd);
					$resultas->execute();
					for($i=0; $rowas = $resultas->fetch(); $i++){
					$fgfg=$rowas['sum(amount)'];
					echo number_format($fgfg, true);
					}
					?>
					</td>
				</tr>
					</tbody>
				</table>
      		</div>
      	</div>
      	
				</form>
			</div>
	

    
</div>
</div>
<input type="button" class="btn btn-default" onclick="printDiv('printableArea')" value="Print" />
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script>  
        

 <?php include_once("footer.php"); ?>    
    </body>
</html>