<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Sales</title>
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
  
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">

 

</head>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales History

      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Sales</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recent Sales</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

<div class="box">
 <div class="box-body">
<div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example">
						
						 <a href="sales_search.php" class="btn btn-success">Back</a>
								</br>
								</br>
							

                            <thead>
                                <tr>
                  <th style="text-align:center;">Receipt No.</th>
                  <th style="text-align:center;">Date</th>
                  <th style="text-align:center;">Time</th>
                  <th style="text-align:center;">Customer</th>
                  <th style="text-align:center;">Total</th>
                  <th style="text-align:center;">Entrant</th>
                  <th style="text-align:center;">Name</th>
                  <th style="text-align:center;">Print</th>
                  </tr>
                            </thead>
                            <tbody>
								<?php
								
								
								 if (isset($_POST['search'])){
                                    
                                $search=$_POST['search'];
								
								
								$result= mysqli_query($con, "SELECT l.id, l.customer, l.date, l.time, l.entrant, SUM(t.amount) total 
								FROM sales_details AS l INNER JOIN
								sales_list AS t ON  l.id = t.invoice
								WHERE  wsale ='No' AND customer LIKE '%$search%' OR date LIKE '%$search%' OR entrant LIKE '%$search%' OR id LIKE '%$search%' 
								
								GROUP BY invoice ORDER BY id DESC LIMIT 100  " ) or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
								$id=$row['id'];
								?>
								<tr>
								<td style="width:100px;"> <?php echo $row ['id']; ?></td>
                <td style="width:100px;"> <?php echo $row ['date']; ?></td>
								<td style="width:100px;"> <?php echo $row ['time']; ?></td>
								<td style="width:200px;"> <?php echo $row ['customer']; ?></td>
								<td style="width:150px;"> <?php echo number_format ($row ['total']) ; ?></td>
								<td style="width:100px;"> <?php echo $row ['entrant']; ?></td>
								
								
			<td><form  method="post" action="edit_sales.php<?php echo '?id='.$row['id']; ?>"><input type='submit'  class="btn btn-success addmore" value='Edit'>	</form></td>
                
			<td><form  method="post" action="preview.php?invoice=<?php echo $row['id']; ?>&total=<?php echo $row['total']; ?>&customer=<?php echo $row['customer']; ?>&date=<?php echo $row['date']; ?>&time=<?php echo $row['time']; ?>&entrant=<?php echo $row['entrant']; ?>"><input type='submit'  class="btn btn-primary" value='Print'>	</form></td>
              </div>
								</div>
								</tr>

								<?php } 
								 }
								?>
                            </tbody>
                        </table>
        </div>
        </div>
        </div>
    </div>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script> 

 <?php include_once("footer.php"); ?>
    </body>
</html>
