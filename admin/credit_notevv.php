<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Credits</title>
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
        Credit Notes

      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Credits</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
           
            <!-- /.box-header -->
            <!-- form start -->

<div class="box">
 <div class="box-body">
<div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example">
							
								</br>
								</br>
                            <thead>
                                <tr>
                  <th>Purchase No.</th>
                  <th>Date</th>
                  <th>Supplier</th>
                  <th>Entrant</th>
                  <th>Print</th>
                  </tr>
                            </thead>
                            <tbody>
								<?php
								$result= mysqli_query($con, "SELECT * FROM credit_details ORDER BY id DESC LIMIT 20" ) or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
								$id=$row['id'];
								?>
								<tr>
								<td> <?php echo $row ['tno']; ?></td>
                                <td> <?php echo $row ['date']; ?></td>
								<td> <?php echo $row ['supplier']; ?></td>
								<td> <?php echo $row ['entrant']; ?></td>
				 <td><form  method="post" action="preview_wsale.php?invoice=<?php echo $row['id']; ?>&customer=<?php echo $row['customer']; ?>&entrant=<?php echo $row['entrant']; ?>"><input type='submit'  class="btn btn-primary" value='Print'>	</form></td>
				
							
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

<script src="app/app.js"></script>
<script src="js/jquery.min.js"></script>
 <?php include_once("footer.php"); ?>
    </body>
</html>
