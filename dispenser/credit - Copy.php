<?php

include "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Creditors</title>
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
      Credit report
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Credit</li>
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
                        <th>Customer</th>
						<th>Invoice Total</th>
						<th>Amount Paid</th>
						<th>Amount Due</th>
						<th>Statement</th>
						<th>Pay</th>
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "
						SELECT R.id,
						   R.customer,
						   R.cash,
						   R.paid,
						   F.amount

					FROM ( SELECT id, customer, cash, SUM(paid) paid FROM sales_details
					GROUP BY sales_details.customer) r
						 LEFT JOIN 
					(SELECT invoice, SUM(amount) amount FROM sales_list GROUP BY invoice) f
					ON r.id = f.invoice  WHERE cash = 'No' ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							
							$tm = $row['amount'];
							$tp = $row['paid'];
							$bal = $tm - $tp ;
						?>
						<tr>
						<td><?php echo $row['customer']; ?></td>
						<td><?php echo number_format($row['amount']); ?></td>
						<td><?php echo number_format ($row['paid']); ?></td>
						<td><?php echo number_format ($bal); ?></td>
						<td><a href="credit_statement.php?customer=<?php echo $row['customer']; ?>"><input type='submit' class="btn btn-success addmore" value='View'>	</a></td>	
						<td><a href="credit_view.php?customer=<?php echo $row['customer']; ?>"><input type='submit' class="btn btn-primary" value='Pay'>	</a></td>	
						
						</tr>
						<?php } ?>
					</tbody>
					<tr>
		
			<th colspan="1" style="border-top:1px solid #999999">
			<?php
				
				$query=mysqli_query($con, "SELECT SUM(d.paid), SUM(l.amount) FROM  sales_details AS d INNER JOIN 
sales_list AS l ON l.invoice = d.id WHERE d.cash ='No' ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							
							$am = $row['SUM(l.amount)'];
							$pa = $row['SUM(d.paid)'] / 2;
							$ba =  $am - $pa ;
				
				
						
				
				?>
			</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
			 echo number_format ($am )  ;
				
				?>

				</th>
				
				
				</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
			
			 echo number_format ($pa )  ;
			
				
				?>

				</th>
				<?php
			      echo number_format ($ba )  ;
			
				}
				?>
				<th>
				</th>
				
				<th>
				</th>
				
				<th>
				</th>
				
				
		</tr>
	</thead>
				</table>
    </div>
</div>
</div>
  </div>
  
<script src="js/jquery.min.js"></script> 

 

 <?php include("footer.php"); ?>    
    </body>
</html>