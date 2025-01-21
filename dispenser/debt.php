<?php

include "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Debt</title>
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
  
  
  
</head>

<?php include("header.php"); ?>

  <!-- =============================================== -->

  
<?php include("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Debt report
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Debts</li>
      </ol>
    </section>

    <!-- Main content -->
      <!-- form start -->

<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All payments summary</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
					<thead>
						<tr>
                        <th>Supplier</th>
						<th>Invoice Total</th>
						<th>Amount Paid</th>
						<th>Amount Due</th>
						
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "Select supplier, SUM(invoice_total), SUM(amount_paid), SUM(invoice_total - amount_paid)  FROM purchases WHERE invoice_total - amount_paid > 0 GROUP BY supplier")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						<td><?php echo $row['supplier']; ?></td>
						<td><?php echo number_format ($row['SUM(invoice_total)']); ?></td>
						<td><?php echo number_format ($row['SUM(amount_paid)']); ?></td>
						<td><?php echo number_format ($row['SUM(invoice_total - amount_paid)']); ?></td>
						
						</tr>
						<?php } ?>
					</tbody>
					<thead>
		<tr>
			<th colspan="1" style="border-top:1px solid #999999"> Total: </th>
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

				$results = $dbo->prepare("SELECT sum(invoice_total) from purchases"  );
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['sum(invoice_total)'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
				$resultia = $dbo->prepare("SELECT SUM(amount_paid) from purchases" );
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
				$zxc=$cxz['SUM(amount_paid)'];
				echo formatMoney($zxc, true);
				}
				?>

				</th>
				
				
				</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
				$resultia = $dbo->prepare("SELECT SUM(invoice_total - amount_paid) from purchases" );
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
				$zxc=$cxz['SUM(invoice_total - amount_paid)'];
				echo formatMoney($zxc, true);
				}
				?>

				</th>
		</tr>
	</thead>
				</table>
    </div>
</div>
</div>
  </div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script> 

 

 <?php include("footer.php"); ?>    
    </body>
</html>