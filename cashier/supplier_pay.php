<?php

include_once "../connect.php"; // database connection details stored here

?>
<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Supplier</title>
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

</head>


<?php include_once("header.php"); ?>
  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Supplier
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
              <h3 class="box-title">All Fields are required</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->


    			<?php
    	$id=$_GET['id'];
    	$query=mysqli_query($con, "SELECT 
						p.id,p.supplier, p.invoiceNo,p.notes, p.due_date, p.invoiceDate,
						i.total,
						s.paid
					FROM ( SELECT id, supplier, invoiceNo, notes, due_date, invoiceDate FROM purchases
					GROUP BY purchases.id) p
						 INNER JOIN 
					(SELECT invoice_id, SUM(cost_price *  qty_sold) total FROM inventory GROUP BY invoice_id) i
					ON p.id = i.invoice_id 
					LEFT JOIN 
					(SELECT t_id, SUM(paid) paid FROM supplier_pay GROUP BY t_id) s
					ON p.id = s.t_id WHERE id = '$id'")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
    ?>


           <form role="form" method="post"  action="updatecredits.php" >
              <div class="box-body">
                <div class="container">

                  <div class="row">
                  <div class="col-xs-5">
                  <label for="exampleInputEmail1">Supplier Name</label>
               
                  <input type="text"  name="supplier" class="form-control" id="skills"  value="<?php echo $row['supplier']; ?>" readonly>
                </div>

                <div class="col-xs-5">
                     <label for="exampleInputEmail1">Invoice Total</label>
                     <input type="text"  name="total" class="form-control" id="skills" value="<?php echo number_format ($row ['total']) ;  ?>" readonly>
   				       </div>
              </div>
             <br>
             <div class="row">
             <div class="col-xs-5">
                  <label for="exampleInputEmail1">Invoice No.</label>
                  <input type="text"  name="id" class="form-control" id="skills" value="<?php echo $row['id']; ?>" readonly>
				       </div>
               <div class="col-xs-5">
                    <label for="exampleInputEmail1">Amount Paid</label>
                    <input type="text"  name="amount_paid" class="form-control" id="skills" value="<?php echo $row['paid']; ?>" readonly>
                </div>
             </div>
             <br>
               <div class="row">
               <div class="col-xs-5">
                 <label for="exampleInputEmail1">Invoice Date.</label>
                 <input type="text"  name="invoiceDate" class="form-control" id="skills" value="<?php echo $row['invoiceDate']; ?>" readonly>
              </div>
              <div class="col-xs-5">
                   <label for="exampleInputEmail1">Amount to Pay</label>
                   <input type="text"  name="pay" class="form-control" id="skills" ">
				   <input type="hidden" name="entrant" value="<?php echo "$_SESSION[userid]"; ?>" />
               </div>
            </div>
			      <br>
			
			<div class="row">
               <div class="col-xs-5">
                  <label>Paid From</label>
                  <select name="hand" class="form-control">
                    <option value="Yes">Cash at Hand</option>
                    <option value="No">Cash in Bank</option>
                    
                  required</select>
                </div>
				
				<div class="col-xs-5">
                 <label for="exampleInputEmail1">Cheque No.</label>
                 <input type="text"  name="ck_no" class="form-control" id="skills" >
              </div>
			  </div>
			
			
            <br>
			

                <button type="submit" name="register" class="btn btn-primary">Pay</button>
                </div>

         </br>

         </br>

            </form>
 <?php
  }
  ?>



</div>
  </div>
<script src="app/app.js"></script>
<script src="js/jquery.min.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>
