.<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Balance Sheet</title>
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


<style>
table, td, th {
    border: 0px solid #ddd;
    text-align: left;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 5px;
	width:  300px;
}
</style>


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



<script>
function updateDue() {

    var total = parseInt(document.getElementById("income").value);
    var val2 = parseInt(document.getElementById("cost").value);


    // to make sure that they are numbers
    if (!total) { total = 0; }
    if (!val2) { val2 = 0; }

    var ansD = document.getElementById("gprofit");
    ansD.value = total - val2;
}
</script


</head>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Reports

      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Balance Sheet</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
		  </br>
		  </br>

	<form action="balance_sheet.php" method="get">
<center><strong>

<p>From: <input type="text"  id="from"  name="d1"/> <img src='img/cal.gif'>To: <input type="text" id="to" name="d2" /><img src='img/cal.gif'></p>
 		<button class="btn btn-success"submit">Search</button>
</strong></center>
</form>

<div class="box">
 <div class="box-header">
 <div id="printableArea">
  <h2><center><?php echo $name ?></h2></center>
 <h2><center>Balance Sheet Projection</h2></center>
 <h3><center>Period From&nbsp;<?php echo $_GET['d1'] ?>&nbsp;To&nbsp;<?php echo $_GET['d2'] ?></h3></center>

            <!-- /.box-header -->
            <div class="box-body">
			 <table>
			  <thead>
		<tr>
		<th>1. ASSETS</th>
		</tr>
		</thead>
							<?php
	$start_date =  $_GET['d1'];
	$end_date =    $_GET['d2'];

	$result = $dbo->prepare("select  SUM(s.amount) FROM `sales_list` AS s 
        INNER JOIN `sales_details` AS d ON d.id = s.invoice 
        WHERE `cash` = 'Yes' AND STR_TO_DATE(`date`, '%d/%m/%Y')
        BETWEEN '" . $start_date . "' AND '" . $end_date . "' ");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
		
		$tamount = $row['SUM(s.amount)']; 
		
?>

					<tr>
			
					<td><strong>Current Assets</strong></td>
					</tr>
					
					
					<tr>
			
					<td>Cash</td>
					<td><span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php echo number_format ($tamount); ?> </td>

					</tr>

			 

			 <?php
	   $query=mysqli_query($con, "SELECT l.id,  SUM(t.amount) amount FROM sales_details AS l INNER JOIN
	   sales_list AS t ON  l.id = t.invoice WHERE cash ='No'  AND STR_TO_DATE(`date`, '%d/%m/%Y')
       BETWEEN '" . $start_date . "' AND '" . $end_date . "' ")or die(mysqli_error());
	   while($row=mysqli_fetch_array($query)){
							
							$total = $row['amount'];				
						}

	   $query=mysqli_query($con, "SELECT l.cash,   SUM(m.paid) paid 
	   FROM credit_pay AS m LEFT JOIN sales_details AS l ON l.id = m.t_id  WHERE cash ='No' AND STR_TO_DATE(`date`, '%d/%m/%Y')
       BETWEEN '" . $start_date . "' AND '" . $end_date . "' ")or die(mysqli_error());
	   while($row=mysqli_fetch_array($query)){
							
							$paid = $row['paid'];
	
						}
						
						    $pending = $total - $paid ;
						
						
		$query=mysqli_query($con, "SELECT SUM(quantity * cost_price)  as 'total_inventory'
        FROM inventory WHERE quantity > 0 AND date_format(`expiry_date`, '%Y-%m-%d') > curdate() ")or die(mysqli_error());
	   while($row=mysqli_fetch_array($query)){
							
						$total_inventory =$row['total_inventory'];
	
						}				


			  
							
							
			
				
				?>

					<tr>
					<td>Accounts receivable</td>
					<td>
					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"   value="<?php echo number_format ($pending); ?>" />
					</tr>
					
					
					<tr>
					<td>Inventory</td>
					<td>
					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"   value="<?php echo number_format ($total_inventory); ?>" />
					</tr>
					
					
					
			<?php

			$tassets = $pending + $tamount + $total_inventory ;	
				
				
			?>
		
		
		
					<tr>
					<td>Total Current Assets </td>
		            <td>
					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"   value="<?php echo number_format ($tassets); ?>" />
					</tr>

		<?php
				}
			?>
		
		

			<tr><td></td></tr>
 <thead>
		<tr>
		<th>Fixed Assets </th>
		</tr>
		</thead>
							<?php
	$result = $dbo->prepare("SELECT description, SUM(total_amount)  FROM `bills`  
WHERE `name` = 'Assets' AND STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' GROUP BY description ORDER BY description ASC");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>

					<tr>
					<td><?php echo $row['description']; ?> </td>
					<td><span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php echo number_format ($row['SUM(total_amount)']); ?></td>

					</tr>

			 <?php
				}
			?>

			<?php
	$result = $dbo->prepare("SELECT SUM(total_amount)  FROM `bills`  
WHERE `name` = 'Assets' AND STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' ");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
		
			$tfassets = $row['SUM(total_amount)'];
?>

					<tr>
					<td>Total Fixed Assets </td>
					<td>
					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"  value="<?php echo number_format ($tfassets); ?>" />
                    
					</tr>
					
					
					<tr>
					<td></br><strong>Total Assets</strong> </td>
					<td><strong>
					
					
					<?php

			$total_assets = $tassets + $tfassets ;	
				
				
			?>
					

					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"  value="<?php echo number_format ($total_assets); ?>" />
                    
					</tr>
					
					

			 <?php
				}
			?>



			<tr><td></td></tr>

			


					<tr><td></td></tr>
 <thead>
		<tr>
		<th>2. LIABILITIES</th>
		</tr>
		</thead>
		
		
		<tr>
			
					<td><strong>Current Liabilities</strong></td>
					</tr>
					
							<?php
							
							$query=mysqli_query($con, "select SUM(i.cost_price * i.qty_sold) bought, p.invoiceDate  FROM `inventory` AS i
INNER JOIN `purchases` p ON i.invoice_id = p.id
WHERE STR_TO_DATE(`invoiceDate`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							
							$bought = $row['bought'];
							
							
						}
						
						
				$query=mysqli_query($con, "SELECT p.invoiceDate, SUM(s.paid) npaid FROM `purchases` AS p
INNER JOIN `supplier_pay` AS s ON p.id = s.t_id WHERE STR_TO_DATE(`invoiceDate`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
							
							$npaid = $row['npaid'];
							
			
			      $unpaid = $bought - $npaid ;
?>

					<tr>
					<td>Accounts payable  </td>
					<td><span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php echo number_format ($unpaid); ?></td>

	
			 <?php
				}
				
			
			?>
				
				<?php
	$result = $dbo->prepare("SELECT description, SUM(total_amount)  FROM `bills`  
WHERE `name` = 'Taxes' AND STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' GROUP BY description ORDER BY description ASC");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
		
		$tpayable =  $row['SUM(total_amount)'];
?>

					<tr>
					<td><?php echo $row['description']; ?> </td>
					<td><span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php echo number_format ($tpayable); ?></td>

					</tr>

			 <?php
				}
			?>
				
				
				
				
				
				
				
					</tr>


<?php
	$result = $dbo->prepare("SELECT SUM(total_amount)  FROM `bills`  
WHERE `name` = 'Taxes' AND STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' ");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
		
			$ttaxes = $row['SUM(total_amount)'];
			
			$tcl = $ttaxes + $unpaid ;
			
			
?>

					<tr>
					<td>Total Current Liabilities </td>
					<td>

					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"  value="<?php echo number_format ($tcl); ?>" />
                    
					</tr>

			 <?php
				}
			?>

	<tr><td></td></tr>
<thead>
		<tr>
		<th>Long Term Liabilities</th>
		</tr>
		</thead>
							<?php
	$result = $dbo->prepare("SELECT l.name,l.loan, SUM(p.paid) npaid FROM loans AS l LEFT JOIN loan_pay AS p ON l.id = p.t_id GROUP BY name");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
								$tm = $row['loan'];
							    $tp = $row['npaid'];
							    $bal = $tm - $tp ;
?>

					<tr>
					<td><?php echo $row['name']; ?> &nbsp Loan.</td>
					<td><span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php echo number_format ($bal); ?></td>

					</tr>

			 <?php
				}
			?>

			<?php
	$result = $dbo->prepare("SELECT r.tloan,
                    	   r.id,
                           f.t_id,
						   f.npaid

					FROM ( SELECT id, SUM(loan) tloan FROM loans) r
						 INNER JOIN 
					(SELECT t_id, SUM(paid) npaid FROM loan_pay) f
					ON  r.id = f.t_id");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
		                        $tm2 = $row['tloan'];
							    $tp2 = $row['npaid'];
							    $ltl = $tm2 - $tp2 ;
?>

					<tr>
					<td>Total Long Term Liabilities </td>
					<td>
					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"  value="<?php echo number_format ($ltl); ?>" />
                    
					</tr>
					
					
					<tr>
					<td></br><strong>Total Liabilities</strong> </td>
					<td><strong>
					
					
					<?php

		
				$liabilities = $ltl + $tcl ; 
				
			?>
					

					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"  value="<?php echo number_format ($liabilities); ?>" />
                    
					</tr>
					
					

			 <?php
				}
			?>

			
					<tr><td></td></tr>
 <thead>
		<tr>
		<th>3. STOCK HOLDERS EQUITY</th>
		</tr>
		</thead>
		
		
		<tr>
			
					<td><strong>Investment Capital</strong></td>
					</tr>
			
			
			<tr>
			
					<td><strong>Net Profit/Loss</strong></td>
					</tr>

<tr>
			
					<td><strong>Total Stock Holders Equity</strong></td>
					</tr>

			</table>
    </div>
<div class="clearfix"></div>
 </div>
<input type="button" class="btn btn-default "  onclick="printDiv('printableArea')" value="Print" />
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>


 <?php include_once("footer.php"); ?>


    </body>
</html>
