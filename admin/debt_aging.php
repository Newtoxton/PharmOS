<?php

include_once "../connect.php"; // database connection details stored here

$supplier=$_GET['supplier'];

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Debit Report</title>
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
        Debit report
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Aging Summary</li>
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

<div class="container">
		   </br>




           </div>

<section class="content">
<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Aging Summary for&nbsp;<?php echo $_GET['supplier'] ?>
</div>

<div id="printableArea">

<form action="actionpdf.php" method="post">
	<div class="row">
        <div class="col-xs-6">

                 <img src="../uploads/<?php echo $logo; ?>" class="img-rounded" width="100px" /> </br>

                </div>



                <h2><center>AGING STATEMENT</center></h2>




			</div>



			<div class="col-xs-6">
			<p>
		<strong> <?php echo $name ?> </strong><br>
		<?php echo $address ?>,<?php echo $address2 ?><br>
    Phone: <?php echo $phone ?> <br>
	E-mail: <font color = "blue"> <?php echo $email ?>   </font>
</p>
                </div>


                 <div class="col-xs-5">
				 <p align="right">
				 Date:  <?php echo date("d/m/Y");  ?>, <?php echo date("g:i a"); ?>  <br>
				 Supplier:  <?php echo $supplier ?> <br>

				</p>

                </div>


<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>

							<th>No.</th>
						  <th>Date</th>
							<th>Invoice No.</th>
							<th>Total Invoice</th>
							<th>Amount Paid.</th>
							<th>Balance</th>
              <th>Aging Period</th>

		</tr>
	</thead>
	<tbody>

			<?php

		    	$n= 1;


				$supplier =    $_GET['supplier'];



				$result = $dbo->prepare("SELECT
    p.id,
    p.aging,
    p.supplier,
    p.invoiceNo,
    p.invoiceDate,
    i.total,
    s.paid
FROM
    (
    SELECT
        id,
        supplier,
        invoiceNo,
        invoiceDate,
        DATEDIFF(CURRENT_TIMESTAMP, created) AS aging
    FROM
        purchases
    GROUP BY
        purchases.id
) p
INNER JOIN(
    SELECT
        invoice_id,
        SUM(cost_price * qty_sold) total
    FROM
        inventory
    GROUP BY
        invoice_id
) i
ON
    p.id = i.invoice_id
LEFT JOIN(
    SELECT
        t_id,
        SUM(paid) paid
    FROM
        supplier_pay
    GROUP BY
        t_id
) s
ON
    p.id = s.t_id
WHERE
    `supplier` = '$supplier' AND paid IS NULL OR paid < total AND paid != 0
AND total - paid != 0
ORDER BY aging DESC");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

				      $tm = $row['total'];
							$tp = $row['paid'];
							$bal = $tm - $tp ;
              $aging = $row['aging'];
if ($bal > 0){
			?>

			<tr class="record">

			 <td><?php echo $n++ ?></td>

								<td style="width:200px;"> <?php echo $row ['invoiceDate']; ?></td>
								<td style="width:100px;"> <?php echo $row ['invoiceNo']; ?></td>
								<td style="width:150px;"> <?php echo number_format ($row ['total']) ; ?></td>
								<td style="width:150px;"> <?php echo number_format ($row ['paid']) ; ?></td>
								<td style="width:150px;"> <?php echo number_format ($bal) ; ?></td>
                <td style="width:100px;"> <?php

                if ($aging >= 30 && $aging <= 360){
                  $age  = round($aging / 30, 0);
                  echo  "$age Months";
                }elseif ($aging > 360) {
                  $age  = round($aging / 360, 0);
                  echo  "$age Years";
    						}else {
                  echo "$aging Days";
                }
                ?>
                </td>

			</tr>
			<?php
				}

      }
			?>

				</strong>
					</tbody>
</table>

</div>
<div class="clearfix"></div>


    </div>


</form>
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










 <?php include_once("footer.php"); ?>
    </body>
</html>
