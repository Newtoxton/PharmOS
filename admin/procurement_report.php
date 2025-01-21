<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | USER LOG</title>
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

  <script type="text/javascript">
$(document).on('change','#check_all',function(){
	$('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
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
        Procurement Requests
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Report</li>
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
<form action="procurement_report.php" method="get">
<center><strong>

<p>From: <input type="text"  id="from"  name="d1" autocomplete="off"/> <img src='img/cal.gif'>To: <input type="text" id="to" name="d2" autocomplete="off"/><img src='img/cal.gif'></p>
 		<button class="btn btn-success"submit">Search</button>
</strong></center>
</form>
<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Procurement Report from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>
</div>




<form action="procurement_delete.php" method="post">
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
        <th><input id="check_all" class="formcontrol" type="checkbox"/></th>
	    <th> Date </th>
			<th> Dispenser </th>

			<th> Trade Name </th>
			<th> Generic Name </th>
			<th> Qty </th>
			<th> Amount </th>
			<th> Total </th>
		</tr>
	</thead>
	<tbody>

			<?php



				$start_date =  $_GET['d1'];


				$end_date =    $_GET['d2'];

		$result = $dbo->prepare("select c.trade_name, c.generic_name, s.id, s.qty, s.cost, s.date,s.entrant FROM `medicine_list` AS c INNER JOIN `procurement` AS s ON c.sno = s.sno
WHERE
		STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'


				ORDER BY id DESC ");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

					$id=$row['id'];


			?>

			<tr class="record">
            <td><input name="selector[]" class="case" type="checkbox" value="<?php echo $id; ?>"></td>
			<td><?php echo $row['date']; ?></td>
						<td><?php echo $row['entrant']; ?></td>
						<td><?php echo $row['trade_name']; ?></td>
						<td><?php echo $row['generic_name']; ?></td>
						<td><?php echo $row['qty']; ?></td>
						<td><?php echo $row['cost']; ?></td>
						<td><?php echo number_format($row['qty'] * $row['cost']); ?></td>

			</tr>
			<?php
				}
			?>

	</tbody>
	<thead>
		<tr>
			<th colspan="6" style="border-top:1px solid #999999"> Total: </th>
			<th colspan="1" style="border-top:1px solid #999999">

				<th colspan="1" style="border-top:1px solid #999999">
			<?php
			$resultia = $dbo->prepare("select SUM(qty * cost) AS tt FROM`procurement` WHERE
		STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN '" . $start_date . "' AND '" . $end_date . "' ");
				$resultia->execute();
				for($i=0; $cxz = $resultia->fetch(); $i++){

					$tc =$cxz['tt'];

				echo number_format($tc, true);
				}
				?>

				</th>
		</tr>
	</thead>

  <tr>
    <td><button class="btn btn-danger delete pull-right" name="submit_mult" type="submit">
    		Delete Selected  </button> </td>

    <td><a href="reports.xls"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
              <i class="fa fa-download"></i> Download Report </button></a> </td>

  </tr>
</table>

	 </br>
</form>
 </br>




    </div>

    <?php
    require_once("excelwriter.class.php");

    $excel=new ExcelWriter("reports.xls");
    if($excel==false)
    echo $excel->error;
    $myArr=array("");
    $myArr=array("Report");
    $excel->writeLine($myArr);
    $myArr=array("");
    $excel->writeLine($myArr);
    $myArr=array("Trade Name","Generic Name","Quantity");
    $excel->writeLine($myArr);
    $qry=mysqli_query($con, "select c.trade_name, c.generic_name, s.id, s.qty, s.cost, s.date,s.entrant FROM `medicine_list` AS c INNER JOIN `procurement` AS s ON c.sno = s.sno
WHERE
		STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'


				ORDER BY id DESC");

    if($result!=false)
    {
      $i=1;
      while($res=mysqli_fetch_array($qry))
      {
        $myArr=array($res['trade_name'],$res['generic_name'],$res['qty']);
        $excel->writeLine($myArr);
        $i++;
      }
    }
    ?>



    </div>
</div>


</div>

<script src="app/app.js"></script>




 <?php include_once("footer.php"); ?>
    </body>
</html>
