<?php include_once ('../connect.php');


$userid = $_SESSION['userid'];
$login = mysqli_query($con, "select * from users where userid='$userid'")or die(mysqli_error());
$row=mysqli_fetch_row($login);
$level = $row[4];

if ($level == 2)
	{
		header('location:../dispenser/index.php');
	}

if ($level == 1)
	{
		header('location:../admin/index.php');
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



						$query = mysqli_query($con, "SELECT sum(s.quantity * s.price) , d.date FROM sales_list AS s  INNER JOIN `sales_details` AS d ON d.id = s.invoice WHERE STR_TO_DATE(`date`, '%d/%m/%Y') = '$today' AND customer != 'Adjustment' ")or die(mysqli_error());
						while($row = mysqli_fetch_array($query)){

							$sales = $row['sum(s.quantity * s.price)'];

						?>


    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
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

          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">

			<?php $query=mysqli_query($con, "SELECT sum(amount) AS tbill FROM `bills` WHERE  DATE(datetime) = '$today' ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){

							$bills  = $row['tbill'];
						?>
              <h3><?php echo $currency  ?><?php echo formatMoney ($row['tbill']); ?></h3>

              <p>Today's Total Expenses</p>
			    <?php } ?>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>

          </div>
        </div>




        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo formatMoney($sales - $bills) ;?></h3>

              <p>Cash Balance</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           </div>
        </div>
        <!-- ./col -->
           <!-- ./col -->
      </div>


   <div class="box">
 <div class="box-body">
<div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example">

								</br>
                            <thead>
                                <tr>
                  <th style="text-align:center;">Receipt No.</th>
                  <th style="text-align:center;">Date</th>
                  <th style="text-align:center;">Time</th>
                  <th style="text-align:center;">Customer</th>
				   <th style="text-align:center;">Total</th>
                  <th style="text-align:center;">Entrant</th>
                  <th style="text-align:center;">Cash Tendered</th>
                  <th style="text-align:center;">Print</th>

                  </tr>
                            </thead>
                            <tbody>
								<?php
								$result= mysqli_query($con, "SELECT l.id, l.customer, l.date, l.time, l.entrant, SUM(t.amount) total
								FROM sales_details AS l INNER JOIN
								sales_list AS t ON  l.id = t.invoice WHERE wsale ='No' AND customer != 'Adjustment'  GROUP BY invoice ORDER BY id DESC LIMIT 20 ") or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
								$id=$row['id'];
								?>
								<tr>
								<td style="width:100px;"> <?php echo $row ['id']; ?></td>
                <td style="width:100px;"> <?php echo $row ['date']; ?></td>
								<td style="width:100px;"> <?php echo $row ['time']; ?></td>
								<td style="width:200px;"> <?php echo $row ['customer']; ?></td>
								<td style="width:100px;"> <?php echo number_format($row ['total']); ?></td>
								<td style="width:100px;"> <?php echo $row ['entrant']; ?></td>
			 <td><form  method="post" action="preview.php?invoice=<?php echo $row['id']; ?>&total=<?php echo $row['total']; ?>&customer=<?php echo $row['customer']; ?>&date=<?php echo $row['date']; ?>&time=<?php echo $row['time']; ?>&entrant=<?php echo $row['entrant']; ?>">
			 <input type="number" name="cash"  />
			 </td>

			 <td>

			 <input type='submit' name="register" class="btn btn-primary" value='Print'>
			 </form></td>
			   </div>
								</div>
								</tr>

								<?php } ?>
                            </tbody>


                        </table>
        </div>
        </div>
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

<script src="../plugins/jQuery/moment.min.js"></script>

<!-- Slimscroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>

<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>


</body>
</html>
