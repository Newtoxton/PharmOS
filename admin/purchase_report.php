<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Purchase Report</title>
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
        Purchase Report All
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Purchases</li>
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
<form action="purchase_report.php" method="get">
  <div class="container">
		   </br>
		  
		   </br>
             
              <div class="row">


				
		<div class="col-xs-5">
		<input type="text"  id="from"  name="d1" placeholder="From" autocomplete="off"/>
                </div>
				
		<div class="col-xs-5">
		 <input type="text" id="to" name="d2" placeholder="To" autocomplete="off"/>
                </div>
				
				<div class="col-xs-2">
                 <button class="btn btn-success"submit">Search</button>
                
                </div>
				
			</div>
			</br>
				
           </div>

<section class="content">
<div class="content" id="content">

 <div id="printableArea"> 
<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Purchase Report from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>
</div>


<div class="table-responsive">
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
	
	                                <th style="text-align:center;">Arrival</th>
									<th style="text-align:center;">Invoice No</th>
									<th style="text-align:center;">Supplier</th>
									<th style="text-align:center;">Trade name</th>
                                    <th style="text-align:center;">Generic name</th>
									<th style="text-align:center;">Type</th>
                                    <th style="text-align:center;">Batch</th>
									<th style="text-align:center;">Expiry</th>
									  <th style="text-align:center;">Qty Purchased</th>
                                    <th style="text-align:center;">Cost</th>
                                  <th style="text-align:center;">Total Cost</th>
								  <th style="text-align:center;">Qty Remaining</th>
									<th style="text-align:center;">Stock Value</th>
								  <th style="text-align:center;">Entrant</th>
									

		</tr>
	</thead>
	<tbody>
		
			<?php
			
			
			
				$start_date =  $_GET['d1'];
			

				$end_date =    $_GET['d2'];
				
			
				
				$result = $dbo->prepare("SELECT 
	p.supplier, 
	p.entrant, 
	p.invoiceNo, 
	p.invoiceDate, 
	c.trade_name, 
	c.generic_name, 
	c.type,
	c.sell_price, 
	c.wsell, 
	i.pid, 
	i.batch, 
	i.quantity, 
	i.cost_price, 
	i.qty_sold, 
	i.expiry_date 
FROM 
	`medicine_list` AS c 
	INNER JOIN `inventory` AS i ON c.sno = i.sno 
	INNER JOIN purchases AS p ON p.id = i.invoice_id 
WHERE 
	STR_TO_DATE(`invoiceDate`, '%d/%m/%Y') BETWEEN '" . $start_date . "' 
	AND '" . $end_date . "' 
	AND supplier != 'Adjustment' 
ORDER by 
	id DESC");
				
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
					
			?>
			
			<tr class="record">
			<td style="width:120px;"> <?php echo $row ['invoiceDate']; ?></td>
			<td style="width:120px;"> <?php echo $row ['invoiceNo']; ?></td>
			<td style="width:120px;"> <?php echo $row ['supplier']; ?></td>
			<td style="width:200px;"> <?php echo $row ['trade_name']; ?></td>
								<td style="width:200px;"> <?php echo $row ['generic_name']; ?></td>
								<td style="width:200px;"> <?php echo $row ['type']; ?></td>
								<td style="width:100px;"> <?php echo $row ['batch']; ?></td>	
								<td style="width:200px;"> <?php echo $row ['expiry_date']; ?></td>
								<td style="width:100px;"> <?php echo $row ['qty_sold']; ?></td>
								<td style="width:150px;"> <?php echo number_format($row ['cost_price']); ?></td>
								<td style="width:100px;"> <?php echo number_format($row ['cost_price'] * $row ['qty_sold']); ?></td>
								<td style="width:100px;"> <?php echo $row ['quantity']; ?></td>
								<td style="width:100px;"> <?php echo number_format($row ['cost_price'] * $row ['quantity']); ?></td>
								<td style="width:100px;"> <?php echo $row ['entrant']; ?></td>
								
								

			</tr>
			<?php
				}
			?>
		
	</tbody>
	<thead>
		<tr>
			<th colspan="10" style="border-top:1px solid #999999"> Total: </th>
			<th colspan="1" style="border-top:1px solid #999999"> 
			<?php
				
				$results = $dbo->prepare("SELECT 
	SUM(i.cost_price * i.qty_sold) AS tt 
FROM 
	`medicine_list` AS c 
	INNER JOIN `inventory` AS i ON c.sno = i.sno 
	INNER JOIN purchases AS p ON p.id = i.invoice_id 
WHERE 
	STR_TO_DATE(`invoiceDate`, '%d/%m/%Y') BETWEEN '" . $start_date . "' 
	AND '" . $end_date . "' 
	AND supplier != 'Adjustment'");
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['tt'];
				echo number_format($dsdsd, true);
				}
				?>
			</th>
			<th colspan="1" style="border-top:1px solid #999999">  </th>
	<th colspan="1" style="border-top:1px solid #999999"> 
			<?php
				
				$results = $dbo->prepare("SELECT 
	SUM(i.cost_price * i.quantity) AS tm 
FROM 
	`medicine_list` AS c 
	INNER JOIN `inventory` AS i ON c.sno = i.sno 
	INNER JOIN purchases AS p ON p.id = i.invoice_id 
WHERE 
	STR_TO_DATE(`invoiceDate`, '%d/%m/%Y') BETWEEN '" . $start_date . "' 
	AND '" . $end_date . "' 
	AND supplier != 'Adjustment'");
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['tm'];
				echo number_format($dsdsd, true);
				}
				?>
			</th>
		</tr>
	</thead>
</table>
 
</div>
<div class="clearfix"></div>


<?php
require_once("excelwriter.class.php");

$excel=new ExcelWriter("purchases_report.xls");
if($excel==false)
echo $excel->error;
$myArr=array("");
$myArr=array("Purchase Report");
$excel->writeLine($myArr);
$myArr=array("");
$excel->writeLine($myArr);
$myArr=array("Arrival","Supplier","Invoice No","Trade Name","Generic Name","Type","Batch","Expiry","Quantity Purchased","Cost","Total Cost","Quantity Remaining","Entrant");
$excel->writeLine($myArr);
$from=$_GET['d1'];
$to=$_GET['d2'];
$qry=mysqli_query($con, "SELECT p.supplier,p.entrant, p.invoiceNo, p.invoiceDate, c.trade_name, c.generic_name,c.type, c.sell_price, c.wsell, i.pid, i.batch, i.quantity, i.cost_price, i.qty_sold, i.expiry_date FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno   INNER JOIN purchases AS p ON p.id = i.invoice_id
								
								WHERE STR_TO_DATE(`invoiceDate`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'

AND supplier != 'Adjustment'

				ORDER by id DESC");

if($result!=false)
{
	$i=1;
	while($res=mysqli_fetch_array($qry))
	{
		$myArr=array($res['invoiceDate'],$res['supplier'],$res['invoiceNo'],$res['trade_name'],$res['generic_name'],$res['type'],$res['batch'],$res['expiry_date'],$res['qty_sold'],$res['cost_price'],$res['qty_sold'] * $res['cost_price'],$res['quantity'],$res['entrant']);
		$excel->writeLine($myArr);
		$i++;
	}
}
?>


				 

            
       
		
    </div>
    </div>
	<input type="button" class="btn btn-default" onclick="printDiv('printableArea')" value="Print" />
	
	
	<a href="purchases_report.xls"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Download Report
          </button></a>
</div>
 

</div>
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