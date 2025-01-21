<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | View Invoice</title>
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
        Invoices
    
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">View all Invoices</li>
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
		
             
			  
			  <a href="invoice.php?id=cash&invoice=<?php echo $finalcode ?>"><button class="btn btn-success addmore"> Create new Invoices</button></a></br>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
					<thead>
						<tr>
                        <th>Invoice No.</th>
						<th>Client Name</th>
						
						<th>Date</th>
						
						<th>Prepared by</th>
						
					
						<th>View</th>
						<th>Delete</th>
						
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT *  FROM `invoices` GROUP BY invoice ORDER BY transaction_id DESC  ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						
						<td><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
						<td><?php echo $row[10]; ?></td>
					
						<td><?php echo $row[12]; ?></td>
					
						
						<td><a href="invoice_preview.php?pt=cash&invoice=<?php echo $row['invoice']; ?>"><input type='submit' class="btn btn-primary" value='View'>	</a></td>
						<td><a href="delete_invoice.php?invoice=<?php echo $row['invoice']; ?>"><input type='submit'  type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete" value='Delete'>	<a/></td>
                 
					
						
		
						</tr>
						<?php } ?>
					</tbody>
				</table>
    </div>
</div>
</br>
		 
         </br>
 
         
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