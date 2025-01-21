<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Debit Summary</title>
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


  <script>
   $(function(){
        $("#to").datepicker({ dateFormat: 'yy-mm-dd' });
        $("#from").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate());
            $("#to").datepicker( "option", "minDate", minValue );
        })
    });
  </script>

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

            </div>
            <!-- /.box-header -->
            <div class="box-body">
<form action="debt.php" method="get">
<div class="container">

<section class="content">
<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Debit Summary Report
</div>

<div id="printableArea">

<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
					<thead>
						<tr>
            <th>Supplier</th>
						<th>Invoice Total</th>
						<th>Amount Paid</th>
						<th>Balance</th>
            <th>Aging Summary</th>

						</tr>
					</thead>


					<tbody>
						<?php

						$start_date =  $_GET['d1'];


				        $end_date =    $_GET['d2'];



						$query=mysqli_query($con, "SELECT
	m.supplier,
    m.invoiceDate,
	m.total,
	s.paid
	FROM (SELECT p.invoiceDate, p.supplier, SUM(i.cost_price *  i.qty_sold) total FROM purchases AS p INNER JOIN inventory AS i
	ON p.id = i.invoice_id GROUP BY supplier) m
	LEFT JOIN
	(SELECT supp, SUM(paid) paid FROM supplier_pay GROUP BY supp) s
	ON m.supplier = s.supp
GROUP BY supplier ORDER BY supplier ASC")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							$tm = number_format ($row['total']);
							$tp = number_format ($row['paid']);

							$bal = $row['total'] - $row['paid'];

              	$supp = $row['supplier'];
						?>
						<tr>
						<td><?php echo $row['supplier']; ?></td>
						<td><?php echo $tm; ?>
						<td><?php echo $tp; ?>
						<td><?php echo number_format ($bal); ?>


						</td>


						</tr>
						<?php } ?>
					</tbody>
					<thead>
		<tr>
			<th colspan="1" style="border-top:1px solid #999999"> Total: </th>
			<th colspan="1" style="border-top:1px solid #999999">
			<?php
				 $query=mysqli_query($con, "SELECT SUM(i.cost_price *  i.qty_sold) total  FROM purchases AS p INNER JOIN
                    inventory AS i ON p.id = i.invoice_id ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){

							$total = $row['total'];

							echo number_format ($total);



				?>

			</th>

			<th colspan="1" style="border-top:1px solid #999999">
			<?php
				 $query=mysqli_query($con, "SELECT p.supplier, SUM(s.paid) paid FROM purchases AS p
                                            LEFT JOIN supplier_pay AS s ON p.id = s.t_id
					")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){

							$paid = $row['paid'];

							echo number_format ($paid);



				?>

			</th>

				<th colspan="1" style="border-top:1px solid #999999">
			<?php
			      $pending = $total - $paid ;

							echo number_format ($pending);
			}
				}
				?>
				</th>


      </th>

				<th colspan="1" style="border-top:1px solid #999999">
          <td><form  method="post" action="debt_aging.php?supplier=<?php echo $supp ?>"><input type='submit'  class="btn btn-success addmore" value='View'>	</form></td>

				</th>
		</tr>
	</thead>
				</table>





    </div>
</div>
</div>
  </div>
<input type="button" class="btn btn-default "  onclick="printDiv('printableArea')" value="Print" />
<script src="js/angular.min.js"></script>

<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>

<script src="app/app.js"></script>


 <script src="../bootstrap/js/select2.js"></script>

  <script>
    $(function(){
      // turn the element to select2 select style
      $('#select2').select2();
    });
  </script>



 <?php include("footer.php"); ?>
    </body>
</html>
