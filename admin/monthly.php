<?php

include_once "../connect.php"; // database connection details stored here


?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Monthly Report</title>
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
        Cumulative report
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


<div id="printableArea">


<div class="box-body table-responsive no-padding">
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
							<th>No.</th>
              <th>Item Name</th>
						  <th>Insurance</th>
							<th>Cash</th>
						  <th>Qty Stocked</th>
              <th>Cost Price</th>
							<th>Amount</th>
							<th>Qty Available</th>
							<th>Amount</th>
              <th>Qty Sold</th>
              <th>Amount Sold</th>
              <th>Profit</th>
		</tr>
	</thead>
	<tbody>

			<?php

		    	$n= 1;



				$result = $dbo->prepare("SELECT
	m.trade_name,
    m.insurance,
	m.cash,
    i.cost_price,
	i.qty_avail,
	i.qty_stocked,
    s.qty_sold,
	s.tamt,
	s.tp

	FROM (SELECT sno, trade_name, wsell AS cash, sell_price AS insurance FROM medicine_list GROUP BY medicine_list.sno) m
	INNER JOIN
	(SELECT sno, SUM(profit) AS tp, SUM(amount) AS tamt, SUM(quantity) AS qty_sold FROM sales_list GROUP BY sno) s
	ON m.sno = s.sno
	LEFT JOIN
	(SELECT sno,cost_price, quantity AS qty_avail, qty_sold AS qty_stocked FROM inventory GROUP BY sno) i
	ON s.sno = i.sno

    ORDER BY trade_name ASC");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){


          $cost_avail   = $row ['cost_price'] * $row ['qty_avail'];
          $cost_stock   = $row ['cost_price'] * $row ['qty_stocked'];

			?>

			<tr class="record">

			          <td><?php echo $n++ ?></td>
								<td> <?php echo $row ['trade_name']; ?></td>
								<td> <?php echo $row ['insurance']; ?></td>
								<td> <?php echo $row ['cash']; ?></td>
                <td> <?php echo $row ['qty_stocked']; ?></td>
                <td> <?php echo number_format($row ['cost_price']); ?></td>
                <td> <?php echo number_format($cost_stock); ?></td>
								<td> <?php echo $row ['qty_avail']; ?></td>
			          <td> <?php echo number_format($cost_avail); ?></td>
                <td> <?php echo number_format($row ['qty_sold']); ?></td>
                <td> <?php echo number_format($row ['tamt']); ?></td>
                <td> <?php echo number_format($row ['tp']); ?></td>


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


				$results = $dbo->prepare("SELECT m.trade_name, m.insurance, m.cash, i.cost_price, i.qty_avail, i.qty_stocked, s.qty_sold, s.samt, s.sprofit FROM ( SELECT sno, trade_name, wsell AS cash, sell_price AS insurance FROM medicine_list ) m INNER JOIN ( SELECT sno, SUM(profit) AS sprofit, SUM(amount) AS samt, SUM(quantity) AS qty_sold FROM sales_list ) s ON m.sno = s.sno LEFT JOIN ( SELECT sno, cost_price, quantity AS qty_avail, qty_sold AS qty_stocked FROM inventory GROUP BY sno ) i ON s.sno = i.sno");
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['samt'];
				echo number_format ($dsdsd) ;

				?>
			</th>
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
      $prof=$rows['sprofit'];
      echo number_format ($prof) ;
      }

				?>

				</th>
		</tr>
	</thead>
</table>

</div>
</div>
<div class="clearfix"></div>
</br>
<?php
require_once("excelwriter.class.php");

$excel=new ExcelWriter("sales_report.xls");
if($excel==false)
echo $excel->error;
$myArr=array("");
$myArr=array("Sales Report");
$excel->writeLine($myArr);
$myArr=array("");
$excel->writeLine($myArr);
$myArr=array("Item name","Insurance","Cash","Qty Stocked","Cost Price","Amount","Qty Available","Amount","Qty Sold","Amount Sold","Profit");
$excel->writeLine($myArr);
$qry=mysqli_query($con, "select
c.trade_name,
c.sell_price AS insurance,
c.wsell AS cash,
i.cost_price,
i.quantity AS qty_avail,
i.qty_sold AS qty_stocked,
SUM(s.quantity) AS qty_sold,
SUM(s.amount) AS tamt,
SUM(s.profit) AS tp
FROM
`medicine_list` AS c
INNER JOIN `inventory` AS i ON c.sno = i.sno
INNER JOIN `sales_list` AS s ON s.sno = i.sno
GROUP BY
trade_name
ORDER BY
trade_name ASC");

if($result!=false)
{
$i=1;
while($res=mysqli_fetch_array($qry))
{
$myArr=array($res['trade_name'],$res['insurance'],$res['cash'],$res['qty_stocked'],$res['cost_price'], ($res['cost_price'] * $res['qty_stocked']),$res['qty_avail'],($res['cost_price'] * $res['qty_avail']),$res['qty_sold'],$res['tamt'],$res['tp']);
$excel->writeLine($myArr);
$i++;
}
}
?>


     <a href="sales_report.xls"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
   <i class="fa fa-download"></i> Download Report
 </button></a>

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
