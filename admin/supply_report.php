<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Payment Report</title>
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



</head>


<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Supplier Payment
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Supplier Payment</li>
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
<form action="supply_report.php" method="get">
  <div class="container">
		   </br>

		   </br>

              <div class="row">

               <div class="col-xs-3">
                  <select name="supplier"  class="form-group" id="select2" style="width:250px; height:34px" >
					<option>Select Supplier</option>

					<?php

					$result3 = $dbo->prepare("SELECT name FROM supplier");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option><?php echo $row['name']; ?></option>
					<?php
					}
					?>

					</select>

                </div>

		<div class="col-xs-3">
		<input type="text"  id="from"  name="d1" placeholder="From" autocomplete='off'/>
                </div>

		<div class="col-xs-3">
		 <input type="text" id="to" name="d2" placeholder="To" autocomplete='off'/>
                </div>

				<div class="col-xs-1">
                 <button class="btn btn-success"submit">Search</button>

                </div>
				</form>
			</div>
			</br>

           </div>

<section class="content">
<div class="content" id="content">

<div id="printableArea">
<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Sales Report from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>&nbsp;for&nbsp;<?php echo $_GET['supplier'] ?>
</div>


<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>

	        <th width="5%">No.</th>
			<th width="20%">Supplier</th>
			<th width="20%">Payment Date</th>
			<th width="15%">Amount Paid</th>
      	<th width="15%">Cheque No.</th>
			<th width="20%">View Details</th>
		</tr>
	</thead>
	<tbody>

			<?php

			    $n= 1;

				$start_date =  $_GET['d1'];

				$end_date =    $_GET['d2'];

				$supplier =    $_GET['supplier'];

				$result = $dbo->prepare("SELECT p.supplier,(p.id) pid,  p.invoiceDate, p.invoiceNo,(m.id) mid,SUM(m.paid) paid,m.ck_no, DATE(m.datetime) tdate FROM purchases AS p INNER JOIN
				supplier_pay AS m ON p.id = m.t_id
				WHERE `supplier` = '$supplier' AND DATE(m.datetime)
                BETWEEN '" . $start_date . "' AND '" . $end_date . "'
                GROUP BY tdate, supplier ORDER by t_id DESC");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

					$mid = $row['mid'] ;

			?>

			<tr class="record">
		    <td><?php echo $n++ ?></td>
			<td><?php echo $row['supplier']; ?></td>
		    <td><?php echo $row['tdate']; ?></td>
			<td><?php echo $row['ck_no']; ?></td>
			<td><?php
			$dsdsd=$row['paid'];
			echo formatMoney($dsdsd, true);
			?></td>

			<td><form  method="post" action="payment_views.php<?php echo '?supplier='.$row['supplier']; ?>&<?php echo 'date='.$row['tdate']; ?>"><input type='submit'  class="btn btn-success addmore" value='View'>	</form></td>

			</tr>
			<?php
				}
			?>

	</tbody>
	<thead>
		<tr>
			<th colspan="3" style="border-top:1px solid #999999"> Total: </th>
			<th colspan="1" style="border-top:1px solid #999999">
			<?php
				function formatMoney($number, $fractional=false) {
					if ($fractional) {
						$number = sprintf('%.2f', $number);
					}
					while (true) {
						$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
						if ($replaced != $number) {
							$number = $replaced;
						} else {
							break;
						}
					}
					return $number;
				}

				$results = $dbo->prepare("SELECT p.invoiceDate, SUM(m.paid) FROM purchases AS p INNER JOIN
				supplier_pay AS m ON p.id = m.t_id
				WHERE `supplier` = '$supplier'  AND DATE(m.datetime) BETWEEN '" . $start_date . "' AND '" . $end_date . "' ");
				$results->execute();
				for($i=0; $rows = $results->fetch(); $i++){
				$dsdsd=$rows['SUM(m.paid)'];
				echo formatMoney($dsdsd, true);
				}
				?>
			</th>


		</tr>
	</thead>
</table>

</div>
<div class="clearfix"></div>
<input type="button" class="btn btn-default "  onclick="printDiv('printableArea')" value="Print" />
    </div>
    </div>
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
