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
  
  <style type="text/css">
		.inlineTable {
            display: inline-block;
        }
		
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
   
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}


		
    </style>
	
	
	<script>
function updateDue() {

    var total = parseInt(document.getElementById("income").value);
    var val2 = parseInt(document.getElementById("cost").value);


    // to make sure that they are numbers
    if (!total) { total = 0; }
    if (!val2) { val2 = 0; }

    var ansD = document.getElementById("gprofit");
    ansD.value = total - val2;
}
</script

  
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
              
			  
			  
			
   <table class="inlineTable" id="customers">
					<thead>
						<tr>
                        <th>Supplier</th>
						<th>Invoice Total</th>

						</tr>
					</thead>
				
			
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT p.id, p.supplier, SUM(i.cost_price * i.qty_sold) total FROM purchases as p LEFT JOIN inventory as i ON i.invoice_id = p.id GROUP BY p.supplier ORDER BY p.supplier ASC")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							$tm = number_format ($row['total']); 
							  
						?>
						<tr>
						<td><?php echo $row['supplier']; ?></td>
						<td><?php echo $tm; ?>
						 <input type="hidden" id="income"  onchange="updateDue()" value="<?php echo $tm; ?>" />
						
						</td>
						
						
						</tr>
						<?php } ?>
					</tbody>
					<thead>
		<tr>
			<th colspan="1" style="border-top:1px solid #999999"> Total: </th>
			<th colspan="1" style="border-top:1px solid #999999">
			<?php
				 $query=mysqli_query($con, "SELECT SUM(cost_price *  qty_sold) total FROM inventory ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							
							$total = $row['total'];
							
							echo number_format ($total);
							
						}
			
				?>
				

				
			</th>
				
		</tr>
	</thead>
				</table>
    <table id="customers" class="inlineTable">
					<thead>
						<tr>
                      
						
						<th>Amount Paid</th>
						
						<th>Balance</th>
						</tr>
					</thead>
				
			
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT p.supplier, SUM(s.paid) paid FROM purchases as p LEFT JOIN supplier_pay s ON p.id = s.t_id GROUP BY p.supplier ORDER BY p.supplier ASC")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							
							    $tp =  number_format ($row['paid']);
							    
						?>
						<tr>
						<td><?php echo $tp ; ?>
						 <input type="hidden" id="cost" onchange="updateDue()" value="<?php echo $tp; ?>" />
						</td>
	
		               <td>
					    
						</td>
	
	
						</tr>
						<?php } ?>
					</tbody>
					<thead>
		<tr>
			
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
				$query=mysqli_query($con, "SELECT t_id, SUM(paid) paid FROM supplier_pay")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							
							$paid = $row['paid'];
							
							echo number_format ($paid);
							
						}
				?>

				</th>
				
				
				</th>
				<th colspan="1" style="border-top:1px solid #999999">
			
				
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