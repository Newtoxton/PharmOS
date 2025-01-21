<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Suppliers</title>
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
  
  <script type='text/javascript'>
	function validateForm() {
    var x = document.forms["form1"]["name"].value || document.forms["form1"]["address"].value|| document.forms["form1"]["phone"].value|| document.forms["form1"]["contact_person"].value|| document.forms["form1"]["notes"].value;
	
    if (x == null || x == "") {
        alert("Field must be filled out");
        return false;
    }
}
</script>



<script>
	function myFunction() {
    document.getElementById("students").reset();
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
        Suppliers
        <small>Pay suppliers</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Pay Suppliers</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            
	

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Suppliers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
					<thead>
						<tr>
                        <th>Supplier Name</th>
						
						
						
						<th>Total Bill</th>
						<th>Amount Paid</th>
						<th>Amount Due</th>
						<th>Update Payment</th>
						
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "Select  s.id, s.name, sum( p.total_bill) AS bill, sum(p.amount_paid) AS paid, sum(p.total_bill)-sum(p.amount_paid) AS Balance FROM `supplier` AS s INNER JOIN `supplier_payment` AS p  ON s.id = p.id  GROUP BY s.id")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						
						<td><?php echo $row[1]; ?></td>
						<td><?php echo number_format ($row[2]); ?></td>
						<td><?php echo number_format ($row[3]); ?></td>
						<td><?php echo number_format ($row[4]); ?></td>
					
					
						<td><a href="pay_supplier.php?id=<?php echo $row['id']; ?>"><input type='submit' class="btn btn-primary" value='Update'>	</></td>
						
						
		
						</tr>
						<?php } ?>
					</tbody>
					<thead>
		<tr>
			<th colspan="1" style="border-top:1px solid #999999"> Total: </th>
			
			<th colspan="1" style="border-top:1px solid #999999"> 
			<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span>
			
			<?php 
						
						$query=mysqli_query($con, "Select  sum(total_bill)  AS t_bill FROM supplier_payment ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						echo number_format($row['t_bill']); 
						}
						
						?>
			</th>
			
			<th colspan="1" style="border-top:1px solid #999999"> 
			<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span>
			<?php 
						
						$query=mysqli_query($con, "Select  sum(amount_paid)  AS total_pay FROM supplier_payment ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						echo number_format($row['total_pay']); 
						}
						
						?>
			</th>
			
			<th colspan="1" style="border-top:1px solid #999999"> 
			<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span>
			<?php 
						
						$query=mysqli_query($con, "Select sum(total_bill)-sum(amount_paid) AS a_balance FROM supplier_payment")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						echo number_format($row['a_balance']); 
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

 <?php include_once("footer.php"); ?>    
 
 <script type="text/javascript">
function confirmDelete() 
{
	var msg = "Are you sure you want to delete?";       
    return confirm(msg);
}
</script>
    </body>
</html>