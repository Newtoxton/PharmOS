<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Edit List</title>
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

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>

</head>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Medicine Master List
        <small>All Medicines</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Inventory</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Type medicine name to search</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

<div class="box">
 <div class="box-body">
<div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example">

                            <thead>
                                <tr>
                <th width="10%">No</th>
								<th width="12%">Trade Name</th>
								<th width="15%">Generic Name</th>
                <th width="15%">Type</th>
                <th width="15%">Retail Price</th>
                <th width="15%">Wholesale Price</th>
								<th> Edit</th>
								<th> Delete</th>
                                </tr>
                            </thead>
                            <tbody>
								<?php


				$result = $dbo->prepare("select * from medicine_list  order by sno DESC");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

			?>
		    <td>MED0<?php echo $row['sno']; ?></td>
			<td><?php echo $row['trade_name']; ?></td>
			<td><?php echo $row['generic_name']; ?></td>
			<td><?php echo $row['type']; ?></td>
      <td><?php echo $row['sell_price']; ?></td>
      <td><?php echo $row['wsell']; ?></td>


			<td><form  method="post" action="edit_medicine.php<?php echo '?id='.$row['sno']; ?>"><input type='submit'  class="btn btn-success addmore" value='Edit'>	</form></td>

			<td><form  method="post" action="delete_medicine.php<?php echo '?id='.$row['sno']; ?>"><input type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete"  value='Delete'>	</form></td>


			</tr>
			<?php
				}
			?>

							<!-- Modal -->

								</div>
								</div>
								</tr>

								<!-- Modal Bigger Image -->

                            </tbody>
                        </table>

        </div>
        </div>
        </div>
    </div>

<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>
