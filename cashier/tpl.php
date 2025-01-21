<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | TPL</title>
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
        <li class="active">TPL</li>
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

	<form action="tpl.php" method="get">
<center><strong>
<p>From: <input type="text"  id="from"  name="d1"/> <img src='img/cal.gif'>To: <input type="text" id="to" name="d2" /><img src='img/cal.gif'></p>
 		<button class="btn btn-success"submit">Search</button>
</strong></center>
</form>
<div class="content" id="content">
<div class="box">
 <div class="box-header">
 <h2><center>Trading Profit and Loss Accounts</h2></center>
 <h3><center>From&nbsp;<?php echo $_GET['d1'] ?>&nbsp;To&nbsp;<?php echo $_GET['d2'] ?></h3></center>
</div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			 <table>
			  <thead>
		<tr>
		<th> Income </th>
		</tr>
		</thead>
							<?php
	$start_date =  $_GET['d1'];
	$end_date =    $_GET['d2'];

	$result = $dbo->prepare("Select  c.type, d.date, SUM(s.amount) AS Total 
		 FROM `medicine_list` AS c
        INNER JOIN `sales_list` AS s ON c.sno = s.sno
        INNER JOIN `sales_details` AS d ON d.id = s.invoice
	WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
	GROUP BY type ORDER BY type ASC");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>

					<tr>
					<td>Sale of <?php echo $row['type']; ?> </td>
					<td><span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php echo number_format ($row['Total']); ?> </td>

					</tr>

			 <?php
				}
			?>

			<?php
	$result = $dbo->prepare("Select  d.date, SUM(s.amount) AS new
		 FROM `sales_list` AS s
        
        INNER JOIN `sales_details` AS d ON d.id = s.invoice
	WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
	");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>

					<tr>
					<td><strong>Total Income</strong> </td>
					<td><strong>
					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"   value="<?php echo number_format ($row['new']); ?>" />
					 <input type="hidden" id="income"  onchange="updateDue()" value="<?php echo $row['new']; ?>" />
					</strong> </td>

					</tr>

			 <?php
				}
			?>

			<tr><td></td></tr>
 <thead>
		<tr>
		<th> Cost of Goods </th>
		</tr>
		</thead>
							<?php
	$result = $dbo->prepare("select c.type,  SUM(i.cost_price * i.qty_sold) paid, p.invoiceDate FROM `medicine_list` AS c 
INNER JOIN `inventory` AS i ON c.sno = i.sno 
INNER JOIN `purchases` p ON i.sno = p.id
WHERE STR_TO_DATE(`invoiceDate`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND  invoice_id != '2' GROUP BY type ORDER BY type ASC");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>

					<tr>
					<td>Purchase of <?php echo $row['type']; ?> </td>
					<td><span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php echo number_format ($row['paid']); ?></td>

					</tr>

			 <?php
				}
			?>

			<?php
	$result = $dbo->prepare("SELECT SUM(i.cost_price * i.qty_sold) paid, p.invoiceDate FROM `inventory` AS i  
INNER JOIN `purchases` p ON i.sno = p.id  WHERE STR_TO_DATE(`invoiceDate`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND  invoice_id != '2' ");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>

					<tr>
					<td><strong>Total Cost of Goods</strong> </td>
					<td><strong>

					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"  value="<?php echo number_format ($row['paid']); ?>" />
                    <input type="hidden" id="cost" onchange="updateDue()" value="<?php echo $row['paid']; ?>" />
					</tr>

			 <?php
				}
			?>



			<tr><td></td></tr>

			<tr>
					<td><strong> <input type="button" name="Sumbit" value="Gross Profit" onclick="javascript:updateDue()"/></strong> </td>
					<td><strong>

<input style="border:none" type="text" id="gprofit" onchange="updateDue()" />


					</strong> </td>

					</tr>


					<tr><td></td></tr>
 <thead>
		<tr>
		<th> Expenses </th>
		</tr>
		</thead>
							<?php
	$result = $dbo->prepare("SELECT name, SUM(amount)AS expense FROM bills WHERE STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "'  AND name !='Assets' AND name !='Loan' GROUP BY name ORDER BY name  ASC");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>

					<tr>
					<td><?php echo $row['name']; ?> </td>
					<td><span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php echo number_format ($row['expense']); ?></td>

					</tr>

			 <?php
				}
			?>

			<?php
	$result = $dbo->prepare("Select  SUM(amount) AS t_bill FROM bills WHERE STR_TO_DATE(`date`, '%m/%d/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND name !='Assets' AND name !='Loan'");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>

					<tr>
					<td><strong>Total Expenses</strong> </td>
					<td><strong>

					<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><input style="border:none" type="text"  value="<?php echo number_format ($row['t_bill']); ?>" />
                    <input type="hidden" id="expense" onchange="calnet()" value="<?php echo $row['t_bill']; ?>" />


					</tr>

			 <?php
				}
			?>

	<tr><td></td></tr>

			<tr>
					<td><strong> <input type="button" name="Sumbit" value="Net Profit" onclick="javascript:calnet()"/></strong> </td>
					<td><strong>


					<input style="border:none" type="text" id="nprofit" onchange="calnet()" />


					</strong> </td>

					</tr>




			</table>
    </div>
</div>
</div>
  </div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>


 <?php include_once("footer.php"); ?>

<script>
function calnet() {

    var gp = parseInt(document.getElementById("gprofit").value);
    var exp = parseInt(document.getElementById("expense").value);


    // to make sure that they are numbers
    if (!gp) { gp = 0; }
    if (!exp) { exp = 0; }

    var ansQ = document.getElementById("nprofit");
    ansQ.value = gp - exp;
}
</script


    </body>
</html>
