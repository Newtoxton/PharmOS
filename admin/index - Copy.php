<?php include_once ('../connect.php');

//<td><?php echo number_format($row[3]); //

$userid = $_SESSION['userid'];
$login = mysqli_query($con, "select * from users where userid='$userid'")or die(mysqli_error());
$row=mysqli_fetch_row($login);
$level = $row[4];

if ($level == 2)
	{
		header('location:../dispenser/index.php');
	}

if ($level == 3)
	{
		header('location:../cashier/index.php');
	}

if ($level == '')
	{
		header('location:../index.php');
	}

$today =  date('Y-m-d');

?>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Dashboard</title>
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
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="../https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="../https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<?php include("header.php"); ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php include("sidebar.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>


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


	$result = $dbo->prepare("SELECT * FROM users ");
				$result->execute();
				$rowcount = $result->rowcount();



						$query = mysqli_query($con, "SELECT sum(s.quantity * s.price) , d.date FROM sales_list AS s  INNER JOIN `sales_details` AS d ON d.id = s.invoice WHERE STR_TO_DATE(`date`, '%d/%m/%Y') = '$today' AND customer != 'Adjustment'
")or die(mysqli_error());
						while($row = mysqli_fetch_array($query)){

						?>


    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $currency  ?> <?php echo formatMoney($row['sum(s.quantity * s.price)']); ?></h3>
  <?php } ?>
              <p>Today's Total Sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="sales_report.php?d1=0&d2=0" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">

			<?php $query=mysqli_query($con, "SELECT sum(amount) AS tbill FROM `bills` WHERE  DATE(datetime) = '$today' ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
              <h3><?php echo $currency  ?><?php echo formatMoney ($row['tbill']); ?></h3>

              <p>Today's Total Expenses</p>
			    <?php } ?>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="expenses_report.php?d1=0&d2=0" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php $result = $dbo->prepare("select c.trade_name, c.generic_name, i.quantity, i.expiry_date , i.batch  FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno WHERE date_format(`expiry_date`, '%Y-%m-%d') < NOW() + INTERVAL 3 MONTH  AND  `quantity` > 0 AND date_format(`expiry_date`, '%Y-%m-%d') > curdate() ORDER BY expiry_date ASC")or die(mysql_error());
				$result->execute();
				$rowcount12345 = $result->rowcount();
						?>
              <h3><?php echo $rowcount12345;?></h3>

              <p>Soon Expiring</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="expiry.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $rowcount;?></h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="signup.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
           <!-- ./col -->
      </div>


      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="../#revenue-chart" data-toggle="tab">Summary</a></li>

              <li class="pull-left header"><i class="fa fa-inbox"></i> Total Monthly Sales</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
    <table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
		<tr>
		<th> Year  </th>
		<th> Month </th>
		<th> Total Sales</th>

		</tr>
	</thead>
	<tbody>




			<?php


			$start_date =  date('Y-01-01');

			$end_date =  date('Y-12-31');

				$query=mysqli_query($con, "SELECT YEAR(s.datetime) AS `Year`, MONTHNAME(s.datetime) AS `Month`, SUM(s.amount) AS `Total` FROM `sales_details` AS c INNER JOIN `sales_list` AS s ON c.id = s.invoice WHERE datetime BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND customer != 'Adjustment'
 GROUP BY YEAR(s.datetime), MONTH(s.datetime)")or die(mysqli_error());

						while($row=mysqli_fetch_array($query)){


			?>

			<td><?php echo $row['Year']; ?></td>
			<td><?php echo $row['Month']; ?></td>
			<td><span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php echo number_format ($row['Total']); ?></td>


			</tr>
			<?php
				}
			?>

	</tbody>

</table>

            </div>
          </div>
          <!-- /.nav-tabs-custom -->

          <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">QUICK FACTS</h3>

              <div class="box-tools pull-right" data-toggle="tooltip" title="Status">


			  <?php

				$result = $dbo->prepare("SELECT * FROM inventory WHERE quantity > 0 ");
				$result->execute();
				$rowcount = $result->rowcount();

				$result = $dbo->prepare("SELECT * FROM inventory where quantity < 3 ");
				$result->execute();
				$rowcount123 = $result->rowcount();

			?>








              </div>
              <!-- /.item -->
			  <div class="inner">
              <h3>

				<div style="text-align:center;">
			Total Number of Products:  <font color="green" style="font:bold 22px 'Aleo';"><a href="products.php">[<?php echo $rowcount;?>]</a></font><br><br>
			</div>

	
			


			Total Amount in Inventory:  <span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span>


			<?php

$sql = "SELECT SUM(quantity * cost_price)  as 'total_inventory' FROM inventory WHERE quantity > 0 AND date_format(`expiry_date`, '%Y-%m-%d') > curdate() ";

$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
            $total_inventory =$row['total_inventory'];
			echo number_format($total_inventory, true);

	 }

?>

</h3>
</div>  <!-- /.chat -->
            <div class="box-footer">
              <div class="input-group">
                <input class="form-control" placeholder="Type message...">

                <div class="input-group-btn">
                  <button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box (chat box) -->







        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">


          <!-- /.box -->

          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Top 5 Users All time Sales</h3>


            </div>

            <!-- /.box-body -->
            <div class="box-footer no-border">


              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
			<h3 class="box-title">
			 <canvas id="user_graph" width="300" height="520">
                                        Your web-browser does not support the HTML 5 canvas element.
                                    </canvas>

									</h3>
          </div>
          <!-- /.box -->


            <!-- /.box-header -->

            <!-- /.box-body -->

              <!-- /.row -->
            </div>
          </div>
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>


  <!-- /.content-wrapper -->
   <?php include("footer.php"); ?>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->

<script src="js/jquery.js" type="text/javascript"></script>
 <script type="application/javascript" src="js/awesomechart.js"> </script>
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="../plugins/jQuery/raphael-min.js"></script>
<script src="../plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="../plugins/jQuery/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script type="application/javascript">
    var user_chart = new AwesomeChart('user_graph');
    user_chart.data = [
    <?php
    $query = mysqli_query($con, "select c.entrant, SUM(s.amount) AS Total FROM `sales_details` AS c INNER JOIN `sales_list` AS s ON c.id = s.invoice WHERE datetime BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND customer != 'Adjustment'
 GROUP BY entrant ORDER BY Total DESC LIMIT 5") or die(mysqli_error());
    while ($row = mysqli_fetch_array($query)) {
        ?>
        <?php echo  $row['Total'] . ','; ?>
    <?php }; ?>
    ];

    user_chart.labels = [
    <?php
    $query = mysqli_query($con, "select c.entrant, SUM(s.amount) AS Total FROM `sales_details` AS c INNER JOIN `sales_list` AS s ON c.id = s.invoice WHERE datetime BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND customer != 'Adjustment'
 GROUP BY entrant ORDER BY Total DESC LIMIT 5") or die(mysqli_error());
    while ($row = mysqli_fetch_array($query)) {
        ?>
        <?php echo "'" . $row['entrant'] . "'" . ','; ?>
    <?php }; ?>
    ];
    user_chart.colors = ['green', 'skyblue', '#FF6600', 'black', 'darkblue', 'lightpink', 'green'];
    user_chart.randomColors = true;
    user_chart.animate = true;
    user_chart.animationFrames = 30;
    user_chart.draw();
</script>

</body>
</html>
