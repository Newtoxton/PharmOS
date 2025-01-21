<?php

include_once "../connect.php"; // database connection details stored here


$customer=$_GET['customer'];

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | Credit Report</title>
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
        Credit report
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Credit report</li>
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
<form action="credit_payment.php?customer=<?php echo $customer ?>&d1=<?php echo $start_date ?>&d2=<?php echo $end_date ?>" method="get">



  <div class="container">
		   </br>

		   </br>
              <div class="row">

               <div class="col-xs-3">
                  <select name="customer"  class="form-group" id="select2" style="width:250px; height:34px" >
					<option>Select customer name</option>

					<?php

					$result3 = $dbo->prepare("SELECT customer FROM sales_details WHERE cash = 'No' GROUP BY customer ");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option><?php echo $row['customer']; ?></option>
					<?php
					}
					?>

					</select>

                </div>


		<div class="col-xs-3">
		<input type="text"  id="from"  name="d1" placeholder="From" autocomplete="off"/>
                </div>

		<div class="col-xs-3">
		 <input type="text" id="to" name="d2" placeholder="To" autocomplete="off"/>
                </div>

				<div class="col-xs-1">
                 <button class="btn btn-success"submit">Search</button>

                </div>

			</div>
			</br>

           </div>

<section class="content">
<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Credit Statement from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>&nbsp;for&nbsp;<?php echo $_GET['customer'] ?>
</div>

<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>

							<th>No.</th>
						    <th>Date</th>
							<th>Time</th>
							<th>Invoice No.</th>
							<th>Total Invoice</th>
							<th>Amount Paid.</th>
							<th>Balance</th>
							<th>Pay</th>
		</tr>
	</thead>
	<tbody>

			<?php

		    	$n= 1;

				$start_date =  $_GET['d1'];


				$end_date =    $_GET['d2'];

				$customer =    $_GET['customer'];



				$result = $dbo->prepare("SELECT
				           r.id,
						   r.customer,
						   r.cash,
						   m.paid,
						   r.date,
						   r.time,
						   f.amount


					FROM ( SELECT id, customer, date, time, cash FROM sales_details
					GROUP BY sales_details.id) r
						 INNER JOIN
					(select  s.invoice, SUM(s. price * s.quantity) AS amount FROM `medicine_list` AS c INNER JOIN `sales_list` AS s
					ON c.sno = s.sno   GROUP BY invoice) f
					ON r.id = f.invoice

                    LEFT JOIN
					(SELECT t_id, SUM(paid) paid FROM credit_pay GROUP BY t_id) m
					ON r.id = m.t_id

					WHERE cash ='No' AND `customer` = '$customer'  AND STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'


				ORDER BY date ASC");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

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
								<td style="width:150px;"> <?php echo number_format(round($bal, 0), 0);  ?></td>
								<td><form  method="post" action="credit_pay.php<?php echo '?id='.$row['id']; ?>"><input type='submit'  class="btn btn-primary" value='Pay'>	</form></td>

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
			     $query=mysqli_query($con, "SELECT  SUM(s. price * s.quantity) AS amount
 FROM medicine_list AS c

 INNER JOIN sales_list AS s ON c.sno = s.sno

 INNER JOIN  sales_details AS l ON l.id = s.invoice WHERE cash ='No' AND customer = '$customer' AND STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "' ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){

							$total = $row['amount'];

							echo number_format ($total);

						}


				?>

				</th>

				<th colspan="1" style="border-top:1px solid #999999">
			<?php
			     $query=mysqli_query($con, "SELECT l.cash,   SUM(m.paid) paid
	   FROM credit_pay AS m LEFT JOIN sales_details AS l ON l.id = m.t_id  WHERE cash ='No' AND customer = '$customer' AND STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "' ")or die(mysqli_error());
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
				</th>
				<th></th>
				</tr>
				</strong>
					</tbody>
</table>

</div>



</form>

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
