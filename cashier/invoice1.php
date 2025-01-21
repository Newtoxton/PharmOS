<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Invoices </title>
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
  
  <link href="css/facebox.css" media="screen" rel="stylesheet" type="text/css" />

<link href="css/chosen.min.css" rel="stylesheet" media="screen">


  
</head>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->

  
<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Invoice
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Create Invoice</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
             
			  
		<br>	  
			 <form action="invoice_load.php" method="post" >
			 
			  <div class="form-group">
                  <label>Customer name:</label>
				  <select name="customer"  id="select2" style="width:300px">
<option></option>
	<?php

	$result3 = $dbo->prepare("SELECT * FROM customer");
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
											
<input type="hidden" name="pt" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" name="invoice" value="<?php echo $_GET['invoice']; ?>" />
<select name="product" style="width:771px; "class="chzn-select" required>
<option></option>
	<?php
	include_once('../connect.php');
	$result = $dbo->prepare("select c.trade_name, c.generic_name, i.id, i.cost_price, i.sell_price, i.quantity, i.qty_sold, i.expiry_date FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno  WHERE quantity > 0;");
		$result->bindParam(':userid', $res);
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
	?>
		<option value="<?php echo $row['id'];?>"> <?php echo $row['trade_name']; ?>  | <?php echo $row['generic_name']; ?>| Price @ <?php echo $row['sell_price']; ?> | Expires on: <?php echo $row['expiry_date']; ?> | Qty Left: <?php echo $row['quantity']; ?></option>
	<?php
				}
			?>
</select>
<input type="number" name="quantity" value="1" min="1" placeholder="Qty" autocomplete="off" style="width: 60px; height:40px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" / required>
<input type="number" name="discount" value="" autocomplete="off" style="width: 50px; height:40px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" />
<Button type="submit" class="btn btn-success addmore"> Add</button> <br><br>
<input type="hidden" name="date" value="<?php echo date("m/d/y"); ?>" />
<input type="hidden" name="time" value="<?php echo date("g:i a"); ?>" />

<?Php
if(isset($_SESSION['userid'])){
}
?>

<input type="hidden" name="userid" value="<?php echo "$_SESSION[userid]"; ?>" />


</form>
<br>
<table class="table table-bordered" id="resultTable" data-responsive="table">
	<thead>
		<tr>
			<th> Trade Name </th>
			<th> Generic Name </th>
			<th> Price </th>
			<th> Qty </th>
			<th> Amount </th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
		
			<?php
				$id=$_GET['invoice'];
				$result = $dbo->prepare("select c.trade_name, c.generic_name, s.transaction_id, s.product, s.invoice, s.product, s.price, s.quantity, s.amount, s.profit FROM `medicine_list` AS c INNER JOIN `invoices` AS s ON c.sno = s.sno WHERE invoice= :userid");
				$result->bindParam(':userid', $id);
				$result->execute();
				for($i=1; $row = $result->fetch(); $i++){
			?>
			<tr class="record">
			<td hidden><?php echo $row['product']; ?></td>
			<td><?php echo $row['trade_name']; ?></td>
			<td><?php echo $row['generic_name']; ?></td>
			<td>
			<?php
			$ppp=$row['price'];
			echo formatMoney($ppp, true);
			?>
			</td>
			<td><?php echo $row['quantity']; ?></td>
			<td>
			<?php
			$dfdf=$row['amount'];
			echo formatMoney($dfdf, true);
			?>
			</td>
			
			<?php
			$profit=$row['profit'];
			?>
			<td width="90"><a href="delete2.php?id=<?php echo $row['transaction_id']; ?>&invoice=<?php echo $_GET['invoice']; ?>&dle=<?php echo $_GET['id']; ?>&quantity=<?php echo $row['quantity'];?>&code=<?php echo $row['product'];?>"><button class="btn btn-mini btn-warning"><i class="icon icon-remove"></i> Cancel </button></a></td>
			
			
			
			</tr>
			<?php
				}
			?>
			<tr>
			<th> </th>
			<th>  </th>
		
			<th>  </th>
			<th>  </th>
			<td> Total Amount: </td>
			<th>  </th>
		</tr>
			<tr>
				<th colspan="4"><strong style="font-size: 12px; color: #222222;">Total:</strong></th>
				<td colspan="1"><strong style="font-size: 12px; color: #222222;">
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
				$sdsd=$_GET['invoice'];
				$resultas = $dbo->prepare("SELECT sum(amount) FROM invoices WHERE invoice= :a");
				$resultas->bindParam(':a', $sdsd);
				$resultas->execute();
				for($i=0; $rowas = $resultas->fetch(); $i++){
				$fgfg=$rowas['sum(amount)'];
				echo formatMoney($fgfg, true);
				}
				?>
				</strong></td>
				
			<?php 
				$resulta = $dbo->prepare("SELECT sum(profit) FROM invoices WHERE invoice= :b");
				$resulta->bindParam(':b', $sdsd);
				$resulta->execute();
				for($i=0; $qwe = $resulta->fetch(); $i++){
				$asd=$qwe['sum(profit)'];
				}
				?>
		
				
				<th></th>
			</tr>
		
	</tbody>
</table>
<a href="invoice_preview.php?pt=<?php echo $_GET['id']?>&invoice=<?php echo $_GET['invoice']?>&total=<?php echo $fgfg ?>&totalprof=<?php echo $asd ?>&cashier=<?php echo $_SESSION['SESS_FIRST_NAME']?>"><button class="btn btn-default"><i class="fa fa-print"></i> Print</button></a>

</div>
</div>

			  
			  
			  
			  
			  
			  
            </div>
            <!-- /.box-header -->
            <!-- form start -->

			
			
			

          
			
			
  </div>


<script src="js/facebox.js" type="text/javascript"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

 <script src="../bootstrap/js/select2.js"></script>

  <script>
    $(function(){
      // turn the element to select2 select style
      $('#select2').select2();
    });
  </script>

<script src="js/chosen.jquery.min.js"></script>


        <script>
        $(function() {
<!--             $(".datepicker").datepicker(); -->
<!--             $(".uniform_on").uniform() -->;
            $(".chzn-select").chosen();
   <!--          $('.textarea').wysihtml5(); -->

        });
        </script>
		
	




 <?php include_once("footer.php"); ?>    
    </body>
</html>