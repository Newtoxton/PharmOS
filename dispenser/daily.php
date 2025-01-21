<?php

include_once "../connect.php"; // database connection details stored here


?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Daily Report</title>
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


<?php include_once("header.php"); ?>

  <!-- =============================================== -->

  
<?php include_once("sidebar.php"); ?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daily report
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Report</li>
      </ol>
    </section>

    <!-- Main content -->

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
            
            </div>	
	
	
    <section class="content">

<div class="content" id="content">

<form action="daily.php" method="get">
<center><strong>

<p>Select Date <input type="text"  id="from"  name="d1" autocomplete="off"/> <img src='img/cal.gif'></p>
 		<button class="btn btn-success"submit">Search</button>
</strong></center>
</form>


<div id="printableArea">

<form action="actionpdf.php" method="post">
	<div class="row">
     
              			
                <h2><center>DAILY REPORT: <?php echo $_GET['d1'] ?> </center></h2>
                
                
               
				
			</div>
			
			
			  <div class="box-body table-responsive no-padding">
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
		
							<th>No.</th>
						    <th>Date</th>
							<th>Time</th>
							<th>Transaction No.</th>
							<th>Transaction Name</th>
							<th>Amount</th>
							<th>Entered By</th>
		</tr>
	</thead>
	<tbody>
		
			<?php
			
		    	$n= 1;
			
				
			   $today =  $_GET['d1'];
				
				$result = $dbo->prepare("SELECT t.invoice, l.customer,l.cash, l.date, l.time, SUM(t.amount) total , l.entrant 
				FROM sales_details AS l INNER JOIN sales_list AS t ON l.id = t.invoice WHERE STR_TO_DATE(`date`, '%d/%m/%Y') = '$today' GROUP BY invoice 
				UNION SELECT id, name,source, date,time, amount, entrant FROM `bills` 
				
				WHERE STR_TO_DATE(`date`, '%d/%m/%Y') = '$today'
				
	            ORDER BY invoice DESC");
				
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
					
			?>
			
			<tr class="record">
			
			                    <td style="width:10px;"><?php echo $n++ ?></td>
								<td style="width:100px;"> <?php echo $row ['date']; ?></td>
								<td style="width:200px;"> <?php echo $row ['time']; ?></td>
								<td style="width:200px;"> <?php echo $row ['invoice']; ?></td>
								<td style="width:200px;"> <?php echo $row ['customer']; ?></td>
								<td style="width:100px;"> 
								<?php 
						if ($row['cash'] == "Yes"){
							echo ""; 
						}else { 
							echo "-" ;
						}
						?>
								
								
								<?php echo number_format ($row ['total']) ; ?></td>
								<td style="width:100px;"> <?php echo $row ['entrant']; ?></td>
								
			</tr>
			<?php
				}
			?>
	<tr>
				<th colspan="2" style="border-top:1px solid #999999"> </th>
				<?php
			    
				$resultia = $dbo->prepare("SELECT sum(amount) FROM bills WHERE STR_TO_DATE(`date`, '%d/%m/%Y') = '$today' "  );
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){
				$zxc=$cxz['sum(amount)'];
				
				}
				
				
				$results = $dbo->prepare("SELECT sum(s.quantity * s.price) , d.date FROM sales_list AS s  INNER JOIN `sales_details` AS d ON d.id = s.invoice  WHERE STR_TO_DATE(`date`, '%d/%m/%Y') = '$today' ");
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['sum(s.quantity * s.price)'];
			
				}
				
				
				$bal = $dsdsd - $zxc ;
			
				?>
					<strong>
				
				</th>
				
							
					
				<th colspan="1" style="border-top:1px solid #999999">  Total Sales:
						<?php 
						
						echo number_format ($dsdsd);
						
						?>
		
				</th>
				
				
				
					
				<th colspan="1" style="border-top:1px solid #999999">Total Expenses:
						<?php 
						
						echo number_format ($zxc);
						
						?>
		
				</th>
				
				
				
				
		
				<th>Balance:</th>
					
				<th colspan="1" style="border-top:1px solid #999999">  
						<?php 
						
						echo number_format ($bal);
						
						?>
		
				</th>
				
				
				<th></th>
				
				
				</tr>
				</strong>
					</tbody>
</table>
 
</div>
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