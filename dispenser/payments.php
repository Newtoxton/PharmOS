<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Payments</title>
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
  
 
	<script src="js/jquery-1.12.1.min.js"></script>
	<script src="js/jquery-duplifer.js"></script>

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
<?php
$invoice=$_GET['invoice'];
$date=$_GET['date'];
$names=$_GET['name'];
$desc=$_GET['description'];
$total=$_GET['total'];

$entrant=$_GET['entrant'];

 include_once("header.php");
  ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Rayment Preview

      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Preveiw</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">

<div class="box">

            <!-- /.box-header -->
            <div class="box-body">

<div class="col-xs-12">
<div ng-controller="customersCrtl">
<div class="container">


	<a href="expenses.php"><button class="btn btn-success addmore"> Back to Expenses</button></a>



<div id="printableArea">

	<div style="float: center;">
	<div style="font:bold 15px 'Aleo'; padding-left: 20px;"><?php echo $name ?></div>
	<div style="font:bold 14px 'Aleo'; padding-left: 70px;">Payment Voucher<br></div>
	
	<div>
	</div>
	</div>

	<div >
	<table >

		<tr>
			<td>Voucher No. </td>
            <td><?php echo $invoice ?> </td>

		</tr>
		<tr>
			<td>Date :</td>
			<td><?php echo date("F j, Y, g:i a"); ?> </td>
		</tr>
		

		
	</table>

				  </div>

</br>
<p style="padding-left: 1px;"><b>Payment Name:</b>&nbsp;  <?php echo $names ?></p>

<p style="padding-left: 1px;"><b>Payment Type:</b>&nbsp;  <?php echo $desc ?></p>

<p style="padding-left: 1px;"><b>Amount Paid:</b>&nbsp;  <?php echo number_format($total); ?></p>

<p style="padding-left: 1px;"><b>Prepared By:</b>&nbsp;  <?php echo $entrant ?></p>

<p style="padding-left: 1px;"><b>Received By:</b>&nbsp;  ___________________________</p>

    </div>
    </div>

</div>
</div>
<input type="button" class="btn btn-default" onclick="printDiv('printableArea')" value="Print" />

<script src="app/app.js"></script>

<script>
	
		$(document).ready(function () {
			$(".find-duplicates").duplifer();
		});

	</script>

 <?php include_once("footer.php"); ?>
    </body>
</html>
