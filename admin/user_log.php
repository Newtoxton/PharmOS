<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rx Tera | User Log</title>
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
        User Log
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
<form action="user_log.php" method="get">
<center><strong>

<p>From: <input type="text"  id="from"  name="d1" autocomplete="off"/> <img src='img/cal.gif'>To: <input type="text" id="to" name="d2" autocomplete="off"/><img src='img/cal.gif'></p>
 		<button class="btn btn-success"submit">Search</button>
</strong></center>
</form>
<div class="content" id="content">


<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
User Log from&nbsp;<?php echo $_GET['d1'] ?>&nbsp;to&nbsp;<?php echo $_GET['d2'] ?>
</div>


<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
	    <th> Date </th>
      <th> Time </th>
			<th> User </th>
			<th> IP Address </th>
			<th> Details </th>

		</tr>
	</thead>
	<tbody>

			<?php



				$start_date =  $_GET['d1'];


				$end_date =    $_GET['d2'];

        $result = $dbo->prepare("select mytime,DATE(log_date) AS mydate, message, remote_addr FROM `my_log` WHERE DATE(log_date) BETWEEN '" . $start_date . "' AND '" . $end_date . "' ORDER BY log_id DESC ");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

			?>

			<tr class="record">

			      <td><?php echo $row['mydate']; ?></td>
            <td><?php echo $row['mytime']; ?></td>
						<td><?php echo $row['message']; ?></td>
						<td><?php echo $row['remote_addr']; ?></td>
						<td><?php
$ip = $row['remote_addr'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
echo $details->city;
echo "</br>";
echo $details->country;
echo "</br>";
echo $details->loc;
echo "</br>";
echo $details->org;
echo "</br>";
$cod = $details->loc;
echo "<a href=\"https://www.google.com/maps/@$cod\" >Google Map</a>";
             ?>

           </td>

			</tr>
			<?php
				}
			?>

	</tbody>

</table>

 </br>
    </div>
    </div>
</div>
</div>

<script src="app/app.js"></script>




 <?php include_once("footer.php"); ?>
    </body>
</html>
