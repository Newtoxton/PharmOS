<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Statement</title>
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

$entrant = $_SESSION[userid] ;

$customer=$_GET['customer'];



?>


		 

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

	<a href="credit.php"><button class="btn btn-success addmore"> Back</button></a>
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
				
                 
              			
                <h2><center>CREDIT STATEMENT</center></h2>
                
                
               
				
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
				 Customer:  <?php echo $customer ?> <br>				 
				 Prepared by: <?Php echo $entrant ?><br>
				</p>
				 
                </div>
				  </div>
               			

			
      	<div class='row'>
      		   <div class="col-xs-12">
      			<table class="table table-bordered table-hover">
					<thead>
						<tr>
						    <th width="5%">No.</th>
						    <th width="5%">Date</th>
							<th width="10%">Time</th>
							<th width="10%">Invoice No.</th>
							<th width="20%">Total Invoice</th>
							<th width="20%">Amount Paid.</th>
							<th width="20%">Balance</th>
							
						</tr>
					</thead>
					<tbody>
						<?php
					$n= 1;
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
					
					WHERE cash ='No' AND customer = '$customer' ORDER BY date ASC " ) or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
									
							$tm = $row['amount'];
							$tp = $row['paid'];
							$bal = $tm - $tp ;
				?>
				<tr class="record">
				                <td><?php echo $n++ ?></td>
								<td style="width:100px;"> <?php echo $row ['date']; ?></td>
								<td style="width:100px;"> <?php echo $row ['time']; ?></td>
								<td style="width:200px;"> <?php echo $row ['id']; ?></td>
								<td style="width:150px;"> <?php echo number_format ($row ['amount']) ; ?></td>
								<td style="width:150px;"> <?php echo number_format ($row ['paid']) ; ?></td>
								<td style="width:150px;"> <?php echo number_format ($bal) ; ?></td>
				
				</tr>
				<?php
					}
				?>
				
				<tr>
				<th colspan="4" style="border-top:1px solid #999999"> </th>
				
					<strong>
				
				</th>
					
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
			     $query=mysqli_query($con, "SELECT l.id,  SUM(t.amount) amount 
	   FROM sales_details AS l INNER JOIN
		sales_list AS t ON  l.id = t.invoice WHERE cash ='No' AND customer = '$customer' ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							
							$total = $row['amount'];
							
							echo number_format ($total);
							
						}
			
			
				?>

				</th>
				
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
			     $query=mysqli_query($con, "SELECT l.cash,   SUM(m.paid) paid 
	   FROM credit_pay AS m LEFT JOIN sales_details AS l ON l.id = m.t_id  WHERE cash ='No' AND customer = '$customer' ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							
							$paid = $row['paid'];
							
							echo number_format ($paid);
							
						}
			
				
				?>
				
				</th>
				
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
			      $pending = $total - $paid ;
							
							echo number_format ($pending);
			
				
				?>
				</tr>
				</strong>
					</tbody>
				</table>
      		</div>
      	</div>
      	
				
			</div>
	

    
</div>
</div>
          
</form>
<input type="button" class="btn btn-default "  onclick="printDiv('printableArea')" value="Print" />
<script src="js/jquery.min.js"></script>  
        

 <?php include_once("footer.php"); ?>    
    </body>
</html>