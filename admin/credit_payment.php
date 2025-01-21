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
<div class="box">
 <div class="box-body">
<form action="receive_multi_edit.php" method="post">	
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
	<tr>
	                    	<th><input id="check_all" class="formcontrol" type="checkbox"/></th>
							<th>No.</th>
						    <th>Date</th>
							<th>Time</th>
							<th>Invoice No.</th>
							<th>Total Invoice</th>
							<th>Amount Paid.</th>
							<th>Balance</th>
							
		</tr>
	</thead>
	<tbody>
		
			<?php
			
		    	$n= 1;
			
				$start_date =  $_GET['d1'];
			

				$end_date =    $_GET['d2'];
				
				$customer =    $_GET['customer'];
				
			
				
				$result = $dbo->prepare("SELECT r.id,
						   r.customer,
						   r.cash,
						   m.paid,
						   r.date,
						   r.time,
						   f.amount

					FROM ( SELECT id, customer, date, time, cash FROM sales_details
					GROUP BY sales_details.id) r
						 INNER JOIN 
					(SELECT invoice, SUM(amount) amount FROM sales_list GROUP BY invoice) f
					ON r.id = f.invoice 

					LEFT JOIN 
					(SELECT t_id, SUM(paid) paid FROM credit_pay GROUP BY t_id) m
					ON r.id = m.t_id
					
					WHERE cash ='No' AND `customer` = '$customer'  AND STR_TO_DATE(`date`, '%d/%m/%Y')


				BETWEEN '" . $start_date . "' AND '" . $end_date . "'


				ORDER BY r.id ASC");
				
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
					        $id=$row['id'];
				        	$tm = $row['amount'];
							$tp = $row['paid'];
							$bal = $tm - $tp ;
					
			?>
			
			<tr class="record">
			<td><input name="selector[]" class="case" type="checkbox" value="<?php echo $id; ?>"></td>
			 <td><?php echo $n++ ?></td>
								<td style="width:100px;"> <?php echo $row ['date']; ?></td>
								<td style="width:100px;"> <?php echo $row ['time']; ?></td>
								<td style="width:200px;"> <?php echo $row ['id']; ?></td>
								<td style="width:150px;"> <?php echo number_format ($row ['amount']) ; ?></td>
								<td style="width:150px;"> <?php echo number_format ($row ['paid']) ; ?></td>
								<td style="width:150px;"> <?php echo number_format ($bal) ; ?></td>
							
			</tr>
			<?php
				}
			?>
	<tr>
				<th colspan="5" style="border-top:1px solid #999999"> </th>
				
					<strong>
				
				</th>
					
				<th colspan="1" style="border-top:1px solid #999999">
			<?php
			     $query=mysqli_query($con, "SELECT l.id,  SUM(t.amount) amount 
	   FROM sales_details AS l INNER JOIN
		sales_list AS t ON  l.id = t.invoice WHERE cash ='No' AND customer = '$customer' AND STR_TO_DATE(`date`, '%d/%m/%Y')


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
				
				</tr>
				</strong>
					</tbody>
</table>
 <button class="btn btn-success pull-right" name="submit_mult" type="submit">
		Receive Selected
	</button>
</form>
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