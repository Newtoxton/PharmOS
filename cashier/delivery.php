<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Delivery Note</title>
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
$customer=$_GET['customer'];
$date=$_GET['date'];
$time=$_GET['time'];
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
       Delivery Note
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

	<a href="invoice_list.php"><button class="btn btn-success addmore"> Back to Invoices</button></a>
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
				
                 
              			
                <h2><center>Delivery Note</center></h2>
                
                
               
				
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
				 Date:  <?php echo $date; ?>, <?php echo $time; ?>  <br>			
				 Invoice No. <font color = "red"> <?php echo $invoice ?></font> <br>
				 Customer:  <?php echo $customer ?> <br>
				 Prepared by: <?Php echo $entrant ?><br>
				</p>
				 
                </div>
				  </div>
               			

			
      	<div class='row'>
      		   <div class="col-xs-12">
      			<table class="table table-bordered table-hover find-duplicates">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="35%"class="duplifer-highlightdups">Trade Name</th>
							<th width="35%">Generic Name</th>
							<th width="10%">Quantity</th>
							
							
						</tr>
					</thead>
					<tbody>
						<?php
					$n= 1;
					$id=$_GET['invoice'];
					$result = $dbo->prepare("select  c.trade_name,c.generic_name,  s.amount, s. price, s.quantity FROM `medicine_list` AS c INNER JOIN `sales_list` AS s ON c.sno = s.sno  WHERE invoice= :userid");
					$result->bindParam(':userid', $id);
					$result->execute();
					for($i=0; $row = $result->fetch(); $i++){
				?>
				<tr class="record">
				<td><?php echo $n++ ?></td>
				<td><?php echo $row['trade_name']; ?></td>
				<td><?php echo $row['generic_name']; ?></td>
				<td><?php echo $row['quantity']; ?></td>
				
				</tr>
				<?php
					}
				?>
				
				
					</tbody>
				</table>
      		</div>
      	</div>
      	
				
			</div>
	

    
</div>
</div>
          
</form>
<input type="button" class="btn btn-default "  onclick="printDiv('printableArea')" value="Print" />
<script>
	
		$(document).ready(function () {
			$(".find-duplicates").duplifer();
		});

	</script> 
 <?php include_once("footer.php"); ?>    
    </body>
</html>