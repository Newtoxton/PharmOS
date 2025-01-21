<?php

include_once "../connect.php"; // database connection details stored here




?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Payment Report</title>
	<!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

  <link rel="stylesheet" href="../bootstrap/css/select2.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../plugins/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
 <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">


  <link rel="stylesheet" href="../plugins/css/jquery-ui.css">

  <script src="js/jquery-1.12.4.js"></script>
  <script src="js/jquery-ui.js"></script>

  <style type="text/css">
  #printable { display: none; }

  @media print
  {
    #non-printable { display: none; }
    #printable { display: block; }
  }
  </style>

  <script language="javascript">
  function printDiv(divName)
  {
  var printContents = document.getElementById(divName).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents; window.print();
  document.body.innerHTML = originalContents;
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
        Payment report
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Payment report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">

            </div>
            <!-- /.box-header -->
            <!-- form start -->


<section class="content">
<div class="content" id="content">
<div id="printableArea">
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>

	        <th width="5%">No.</th>
			<th width="10%">Invoice Date</th>
			<th width="20%">Customer</th>
			<th width="10%">Invoice No.</th>
			 <th width="15%">Amount Paid</th>
        <th width="20%">Check/Receipt No</th>
			 <th width="20%">Payment Date</th>
			 <th>Delete</th>
		</tr>
	</thead>
	<tbody>

			<?php

			    $n= 1;

			$customers =  $_GET['customer'] ;

            $daten =    $_GET['date'] ;

				$result = $dbo->prepare("SELECT l.id, l.customer, l.date,(m.id) mid, m.paid, DATE(m.datetime) tdate, m.hand FROM sales_details AS l INNER JOIN
				credit_pay AS m ON l.id = m.t_id
				WHERE `customer` = '$customers'  AND DATE(m.datetime) = '$daten'  ORDER by t_id DESC");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

					$mid = $row['mid'] ;

			?>

			<tr class="record">
		    <td><?php echo $n++ ?></td>
			<td><?php echo $row['date']; ?></td>

			<td><?php echo $row['customer']; ?></td>

			<td><?php echo $row['id']; ?></td>
			<td><?php
			$dsdsd=$row['paid'];
			echo formatMoney($dsdsd, true);
			?></td>

      		<td><?php echo $row['hand']; ?></td>


			<td><?php echo $row['tdate']; ?></td>

      <td><form  method="post" action="delete_payment.php?id=<?php echo $mid; ?>"><input type='submit'  class='btn btn-danger delete' value='Delete'>	</form></td>


			</tr>
			<?php
				}
			?>

	</tbody>
	<thead>
		<tr>
			<th colspan="4" style="border-top:1px solid #999999"> Total: </th>
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

				$results = $dbo->prepare("SELECT l.date, SUM(m.paid) FROM sales_details AS l INNER JOIN
				credit_pay AS m ON l.id = m.t_id
				WHERE `customer` = '$customers'  AND DATE(m.datetime) = '$daten' ");
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['SUM(m.paid)'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>


		</tr>
	</thead>
</table>

</div>
<div class="clearfix"></div>
<input type="button" class="btn btn-default "  onclick="printDiv('printableArea')" value="Print" />
    </div>
    </div>
</div>
</div>


<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>

<script src="app/app.js"></script>



 <?php include_once("footer.php"); ?>
    </body>
</html>
