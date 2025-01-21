<?php include_once('../connect.php');

?>
<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Expiry</title>
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

  
<?php include_once("header.php"); ?>
  <!-- =============================================== -->

  
<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Soon expiring
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Inventory</li>
      </ol>
    </section>

    <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
 <div id="printableArea">      
<div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Medicine Expiring in 3 months</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

<div ng-controller="customersCrtl">


    
	
	
    <div class="row">
        <div class="col-md-12" ng-show="filteredItems > 0">
            <table id="example1" class="table table-striped table-bordered">
            <thead>
           
            <tr>
						<th>Brand Name</th>
						<th>Generic Name</th>
						<th>Batch No</th>
						<th>Expiry Date</th>
						<th>Quantity Left</th>
						<th>Cost</th>
						<th>Loss</th>
						
						</tr>
            </thead>
            <tbody>
                
                   
                 		
			<?php 
						$query=mysqli_query($con, "select c.trade_name, c.generic_name, i.quantity, i.expiry_date , i.batch , i.cost_price, (i.quantity * i.cost_price) AS loss   FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno WHERE date_format(`expiry_date`, '%Y-%m-%d') < NOW() + INTERVAL 3 MONTH  AND  `quantity` > 0 AND date_format(`expiry_date`, '%Y-%m-%d') > curdate() ORDER BY expiry_date ASC")or die(mysql_error());
						while($row=mysqli_fetch_array($query)){
						?>	
						<tr>
						<td><?php echo $row['trade_name']; ?></td>
						<td><?php echo $row['generic_name']; ?></td>
						<td><?php echo $row['batch']; ?></td>
						<td><?php echo $row['expiry_date']; ?></td>
						<td><?php echo $row['quantity']; ?></td>
						<td><?php echo $row['cost_price']; ?></td>
						<td><?php echo number_format($row['loss']); ?></td>

	
						<?php } ?>
                </tr>
            </tbody>
			<thead>
		<tr>
			<th colspan="6" style="border-top:1px solid #999999"> Total Loss:</th>
			<th colspan="1" style="border-top:1px solid #999999"> 
			<?php
				function formatMoney($number, $fractional=false) {
					if ($fractional) {
						$number = sprintf('%.2f', $number);
					}
					while (true) {
						$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
						if ($replaced != $number) {
							$number = $replaced;
						} else {
							break;
						}
					}
					return $number;
				}
				
				$results = $dbo->prepare("select c.trade_name, c.generic_name, i.quantity, i.expiry_date , i.batch , i.cost_price, sum(i.quantity * i.cost_price) AS tloss FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno WHERE date_format(`expiry_date`, '%Y-%m-%d') < NOW() + INTERVAL 3 MONTH  AND  `quantity` > 0 AND date_format(`expiry_date`, '%Y-%m-%d') > curdate()");
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['tloss'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>
			</tr>
	</thead>
            </table>
            </table>
        </div>
       
		
    </div>
    </div>
</div>
</div>
</div>
<input type="button" class="btn btn-default" onclick="printDiv('printableArea')" value="Print" />
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app2.js"></script>     
<script src="js/jquery.min.js"></script>

 <?php include_once("footer.php"); ?>    
    </body>
</html>