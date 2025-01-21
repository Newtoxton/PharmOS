<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Sells</title>
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
  
  <link href="css/facebox.css" media="screen" rel="stylesheet" type="text/css" />

<link href="css/chosen.min.css" rel="stylesheet" media="screen">


  
</head>

<?php
function createRandomPassword() {
	$chars = "003232303232023232023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 7) {

		$num = rand() % 33;

		$tmp = substr($chars, $num, 1);

		$pass = $pass . $tmp;

		$i++;

	}
	return $pass;
}
$finalcode='Rx'.createRandomPassword();
?>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->

  
<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sale Medicine
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Sell Medicine</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
             
			  
			  
			  <form action="incoming.php" method="post" >
											
<input type="hidden" name="pt" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" name="invoice" value="<?php echo $_GET['invoice']; ?>" />

 <div class="form-group">
<select name="product" style="width:795px; " class="chzn-select" required>
<option ></option>
	<?php
	$result = $db->prepare("SELECT * FROM inventory WHERE quantity > 0");
	$result->bindParam(':userid', $res);
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
	?>
		<option value="<?php echo $row['sno'];?>"> <?php echo $row['sno']; ?>| Price @ <?php echo $row['sell_price']; ?> | Expires on: <?php echo $row['expiry_date']; ?> | Qty Left: <?php echo $row['quantity']; ?> </option>
	<?php
				}
			?>
</select>

<input type="number" name="quantity" value="1" min="1" placeholder="Qty" style="width: 60px; height:40px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" / required>
<input type="number" name="discount" value="" autocomplete="off" style="width: 50px; height:40px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" />
<button type="submit" class="btn btn-success addmore" type="button">Add </button> </br></br>
<input type="text" name="date" class="form-short" value="<?php echo date("m/d/y"); ?>" /> <input type="hidden" name="time" value="<?php echo date("g:i a"); ?>" />



<?Php
if(isset($_SESSION['userid'])){
}
?>

<input type="hidden" name="userid" value="<?php echo "$_SESSION[userid]"; ?>" />



</form>
</div>
<div class='row' id="table_container">
	      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
	      			<table class="table table-bordered table-hover" id="invoice_table">
	<thead>
		<tr>
			<th> Generic Name </th>
			<th> Trade Name </th>
			
			<th> Price </th>
			<th> Qty </th>
			<th> Amount </th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
		
			<?php
				$id=$_GET['invoice'];
				$result = $db->prepare("SELECT * FROM sales WHERE invoice= :userid");
				$result->bindParam(':userid', $id);
				$result->execute();
				for($i=1; $row = $result->fetch(); $i++){
			?>
			<tr class="record">
		
			<td><?php echo $row['sno']; ?></td>
			<td><?php echo $row['sno']; ?></td>
			<td>
			<?php
			$ppp=$row['price'];
			echo formatMoney($ppp, true);
			?>
			</td>
			<td><?php echo $row['qty_sold']; ?></td>
			<td>
			<?php
			$dfdf=$row['amount'];
			echo formatMoney($dfdf, true);
			?>
			</td>
			
			<?php
			$profit=$row['profit'];
			?>
			<td width="90"><a href="delete.php?id=<?php echo $row['sell_id']; ?>&invoice=<?php echo $_GET['invoice']; ?>&dle=<?php echo $_GET['id']; ?>&qty=<?php echo $row['qty_sold'];?>&code=<?php echo $row['sno'];?>"><button class="btn btn-mini btn-warning"><i class="icon icon-remove"></i> Cancel </button></a></td>
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
				$resultas = $db->prepare("SELECT sum(amount) FROM sales WHERE invoice= :a");
				$resultas->bindParam(':a', $sdsd);
				$resultas->execute();
				for($i=0; $rowas = $resultas->fetch(); $i++){
				$fgfg=$rowas['sum(amount)'];
				echo formatMoney($fgfg, true);
				}
				?>
				</strong></td>
				
			<?php 
				$resulta = $db->prepare("SELECT sum(profit) FROM sales WHERE invoice= :b");
				$resulta->bindParam(':b', $sdsd);
				$resulta->execute();
				for($i=0; $qwe = $resulta->fetch(); $i++){
				$asd=$qwe['sum(profit)'];
				}
				?>
		
				
				<th></th>
			</tr>
		
	</tbody>
</table><br>
<a rel="facebox" href="checkout.php?pt=<?php echo $_GET['id']?>&invoice=<?php echo $_GET['invoice']?>&total=<?php echo $fgfg ?>&totalprof=<?php echo $asd ?>&cashier=<?php echo $_SESSION['SESS_FIRST_NAME']?>"><button class="button round blue image-right ic-print text-upper"> Receipt</button></a>


    </div>
    </div>
			  
			  
			  
			  
			  
			  
			  
			  
			  
            </div>
            <!-- /.box-header -->
            <!-- form start -->

			
			
			

          
			
			
  </div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script> 


<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/facebox.js" type="text/javascript"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app2.js"></script>     
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>  
<script src="js/jquery.min.js"></script>
<script src="js/chosen.jquery.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
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