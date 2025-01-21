<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Payment</title>
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

?>


		 

<?php include_once("header.php"); ?>

  <!-- =============================================== -->

  
<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Invoice
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
		
       
			 <div class="box box-primary">
			 
			  <div class="box">
            <div class="box-header">

	<a href="expenses"><button class="btn btn-success addmore"> Back to Expenses</button></a>
</div>
</br>
</br>

<div id="printableArea">
	
	
	<div class="container">
	
	<form action="actionpdf.php" method="post">
	<div class="row">
        <div class="col-xs-6">
		
                 <img src="../uploads/<?php echo $logo; ?>" class="img-rounded" width="100px" /> </br>
				
                </div>
				
                 
              			
                <h2><center>PAYMENT</center></h2>
                
                
               
				
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
				 Date:  <?php echo $date; <br>			
				 Payment No. <font color = "red"> <?php echo $invoice ?></font> <br>
				 				 Prepared by: <?Php echo $entrant ?><br>
				</p>
				 
                </div>
				  </div>
    </br>
Payment Name:  <?php echo $names ?>
           			
</br>
Payment Type:  <?php echo $desc ?>
</br>
Amount Paid <?php echo $total ?>
</br>

      	<div class='row'>
      		   <div class="col-xs-12">






				
				<center>Invoice is due on demand.</center>
      		</div>
      	</div>
      	
				
			</div>
	

    
</div>
</div>
          
<input type="button" class="btn btn-default "  onclick="printDiv('printableArea')" value="Print" />
<script>
	
		$(document).ready(function () {
			$(".find-duplicates").duplifer();
		});

	</script> 
        

 <?php include_once("footer.php"); ?>    
    </body>
</html>