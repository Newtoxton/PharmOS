<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Credit</title>
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

<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Credit Statement

      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Credit</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Statement</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

<div class="box">
 <div class="box-body">
<div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example">

                            <thead>
                                <tr>
                    <th style="text-align:center;">Date</th>
				  <th style="text-align:center;">Invoice No.</th>
                
                  <th style="text-align:center;">Customer</th>
                  <th style="text-align:center;">Total</th>
				 <th style="text-align:center;">Paid</th>
				 <th style="text-align:center;">Due</th>
                 <th style="text-align:center;">Pay</th>

                  </tr>
                            </thead>
                            <tbody>
								<?php
								$customer=$_GET['customer'];
								
								$result= mysqli_query($con, "SELECT R.id,
						   R.customer,
						   R.cash,
						   M.paid,
						   R.date,
						   R.time,
						   F.amount

					FROM ( SELECT id, customer, date, time, cash FROM sales_details
					GROUP BY sales_details.id) r
						 INNER JOIN 
					(SELECT invoice, SUM(amount) amount FROM sales_list GROUP BY invoice) f
					ON r.id = f.invoice 

					LEFT JOIN 
					(SELECT t_id, SUM(paid) paid FROM credit_pay GROUP BY t_id) m
					ON r.id = m.t_id
					
					WHERE cash ='No' AND customer = '$customer'  ORDER BY r.id DESC " ) or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
								$id=$row['id'];
								
							$tm = $row['amount'];
							$tp = $row['paid'];
							$bal = $tm - $tp ;
								?>
								<tr>
								<td style="width:100px;"> <?php echo $row ['date']; ?></td>
								<td style="width:100px;"> <?php echo $row ['id']; ?></td>
                                <td style="width:200px;"> <?php echo $row ['customer']; ?></td>
							    <td style="width:150px;"> <?php echo number_format ($row ['amount']) ; ?></td>
							    <td style="width:150px;"> <?php echo number_format ($row ['paid']) ; ?></td>
								<td style="width:150px;"> <?php echo number_format ($bal) ; ?></td>
								<td><form  method="post" action="credit_pay.php<?php echo '?id='.$row['id']; ?>"><input type='submit'  class="btn btn-primary" value='Pay'>	</form></td>
								
                 </div>
								</div>
								</tr>

								<?php } ?>
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
