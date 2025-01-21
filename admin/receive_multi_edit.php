<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <title>Rx Tera | Customer</title>
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



<script type="text/javascript">
document.getElementById("form1").onkeypress = function(e) {
  var key = e.charCode || e.keyCode || 0;
  if (key == 13) {
    alert("Enter Does not Save");
    e.preventDefault();
  }
}
</script>

 <script type="text/javascript">
function updateTotal() {
    var total = 0;//
    var list = document.getElementsByClassName("input");
    var values = [];
    for(var i = 0; i < list.length; ++i) {
        values.push(parseFloat(list[i].value));
    }
    total = values.reduce(function(previousValue, currentValue, index, array){
        return previousValue + currentValue;
    });
    document.getElementById("total").value = total;
}

</script>


</head>

<?php include("header.php"); ?>

  <!-- =============================================== -->



<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Customer
 </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Payments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Invoices Selected</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

<div class="box">
 <div class="box-body">

<form action="" method="post">
                        <table class="table table-bordered table-striped" id="example">

                            <thead>
                                <tr>
                        <th>Date</th>
						<th>Inv.No.</th>
						<th>Customer</th>
						<th>Total</th>
						<th>Paid</th>
						<th>Balance</th>
						<th>Pay</th>
						<th>Payment No.</th>
                                </tr>
                            </thead>
                            <tbody>


								<?php

								$id=$_POST['selector'];
								$N = count($id);
								for($i=0; $i < $N; $i++)
								{
						$result = mysqli_query($con,"SELECT r.id,
						   r.customer,
						   r.cash,
						   m.paid,
						   r.date,
						   r.time,
						   f.total

					FROM ( SELECT id, customer, date, time, cash FROM sales_details
					GROUP BY sales_details.id) r
						 INNER JOIN
					(SELECT invoice, SUM(amount) total FROM sales_list GROUP BY invoice) f
					ON r.id = f.invoice

					LEFT JOIN
					(SELECT t_id, SUM(paid) paid FROM credit_pay GROUP BY t_id) m
					ON r.id = m.t_id  WHERE cash ='No' AND id='$id[$i]' ");
								while($row = mysqli_fetch_array($result))
								{

								$tm = $row['total'];
						     	$tp = $row['paid'];
						    	$bal = $tm - $tp ;

								?>

						<td><input type="text"  name="invoiceDate[]" class="form-control" id="skills" value="<?php echo $row['date']; ?>" readonly></td>
						<td> <input type="text"  name="id[]" class="form-control" id="skills" value="<?php echo $row['id']; ?>" readonly></td>
						<td><input type="text"  name="customer[]" class="form-control" id="skills"  value="<?php echo $row['customer']; ?>" readonly> </td>
						<td> <input type="text"  name="total[]" class="form-control" id="skills" value="<?php echo $row['total']; ?>" readonly></td>
						<td> <input type="text"  name="amount_paid[]" class="form-control" id="skills" value="<?php echo $row['paid']; ?>" readonly></td>
						<td> <input type="text"  name="bal[]" class="form-control" id="skills" value="<?php echo $bal; ?>" readonly></td>

						<td><input name="pay[]" type="text"  class='input' value="0" onchange='updateTotal();'></td>
						<td> <input type="text"  name="hand[]"  class="form-control" id="skills" >


			 <input type="hidden" name="entrant[]" value="<?php echo "$_SESSION[userid]"; ?>" />


			</tr>
			<?php
}
}
?>

							<!-- Modal -->

								</div>
								</div>
								</tr>

								<!-- Modal Bigger Image -->



                            </tbody>
							<thead>
		<tr>
			<th colspan="6" style="border-top:1px solid #999999"> Total: </th>
			<th colspan="1" style="border-top:1px solid #999999">
			<input name="total" type="text" id="total" class="form-control" value="">

		</tr>
	</thead>






                        </table>
				<div class='row'>
	      		<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
	      			<button class="btn btn-success addmore" name="submit_mult" type="submit" formaction="receive_multi_save.php">+ Pay </button>

					</div>
				<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>

	      		<button class="btn btn-danger delete" name="stop_mult" type="submit"  formaction="credit_payment_multi.php">- Go back</button>
				</div>

				</div>

</form>

        </div>
        </div>
        </div>
    </div>
<script src="app/app.js"></script>
<script src="js/jquery.min.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>
