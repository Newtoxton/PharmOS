<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Below Min</title>
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
        Medicine Below Re-order Level

      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Below Re-order</li>
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

		<div class="box-body">

    <table class="table table-bordered table-hover" id="example">

        <thead>
            <tr>
                <th style="text-align:center; background: #0080ff;" ><span class="glyphicon glyphicon-sort-by-alphabet"></span> Trade Name</th>
                <th style="text-align:center; background: #0080ff;"><span class="glyphicon glyphicon-sort-by-alphabet"></span> Formulation</th>
                <th style="text-align:center; background: #0080ff;"><span class="glyphicon glyphicon-sort"></span>Min Stock</th>
                <th style="text-align:center; background: #0080ff;"><span class="glyphicon glyphicon-sort"></span>Quantity Available</th>
                <th style="text-align:center; background: #0080ff;"><span class="glyphicon glyphicon-sort"></span>Qty to Order</th>
		</tr>
	</thead>
	<tbody>

			<?php


				$result = $dbo->prepare("select
	c.trade_name,c.type,
    c.bin,
	SUM(
		GREATEST(i.quantity, 0)
	) AS Qty
FROM
	`medicine_list` AS c
	INNER JOIN `inventory` AS i ON c.sno = i.sno
GROUP BY
	i.sno
HAVING
	Qty < bin");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

			?>

			<td><?php echo $row['trade_name']; ?></td>
			<td><?php echo $row['type']; ?></td>
		    <td><?php echo $row['bin']; ?></td>

			<td><?php echo $row['Qty']; ?></td>
			<td><?php echo ($row['bin'] - $row['Qty']); ?></td>



			</tr>
			<?php
				}
			?>

	</tbody>

</table>
<a href="reports.xls"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
          <i class="fa fa-download"></i> Download Report
        </button></a>


          </div>
          <?php
          require_once("excelwriter.class.php");

          $excel=new ExcelWriter("reports.xls");
          if($excel==false)
          echo $excel->error;
          $myArr=array("");
          $myArr=array("Report");
          $excel->writeLine($myArr);
          $myArr=array("");
          $excel->writeLine($myArr);
          $myArr=array("Trade Name","Formulation","Bin","Quantity Available","Quantity to Order");
          $excel->writeLine($myArr);
          $qry=mysqli_query($con, "select
  	c.trade_name,c.type,
      c.bin,
  	SUM(
  		GREATEST(i.quantity, 0)
  	) AS Qty
  FROM
  	`medicine_list` AS c
  	INNER JOIN `inventory` AS i ON c.sno = i.sno
  GROUP BY
  	i.sno
  HAVING
  	Qty < bin");

          if($result!=false)
          {
            $i=1;
            while($res=mysqli_fetch_array($qry))
            {
              $myArr=array($res['trade_name'],$res['type'],$res['bin'],$res['Qty'], ($res['bin'] - $res['Qty']));
              $excel->writeLine($myArr);
              $i++;
            }
          }
          ?>
        </div>

</div>
<script type="text/javascript">
$(document).ready( function(){
    $('#example').dataTable({
    "iDisplayLength": 25,
    "aLengthMenu": [[25, 50, -1], [25, 50, "All"]],
     "bDestroy": true
    });
});
</script>


<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>
