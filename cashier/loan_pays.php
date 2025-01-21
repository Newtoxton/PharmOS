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
  
   <style type="text/css">
select.models{
  display:none;
}
select.models.active{
  display:inline-block;
}
    </style>

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
       Loans
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
              <h3 class="box-title">Loans Selected</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
			
<div class="box">		 
 <div class="box-body">   

<form action="" method="post">
                        <table class="table table-bordered table-striped" id="example">
                           
                            <thead>
                                <tr>
                        <th style="width:150px;">Date</th>
					    <th style="width:200px;">Bank</th>
						<th style="width:100px;">Total</th>
						<th style="width:100px;">Paid</th>
						<th style="width:100px;">Balance</th>
						<th style="width:150px;">Pay</th>
						
                                </tr>
                            </thead>
                            <tbody>
								
								
								<?php

								$id=$_POST['selector'];
								$N = count($id);
								for($i=0; $i < $N; $i++)
								{
						$result = mysqli_query($con,"SELECT l.id,l.name,l.loan,l.installment,l.start_date, l.months, l.rate,
								SUM(p.paid) npaid FROM loans AS l LEFT JOIN loan_pay AS p ON  l.id = p.t_id  WHERE l.id='$id[$i]' Group by name ORDER BY l.id ASC  ");
								while($row = mysqli_fetch_array($result))
								{ 
								
								$tm = $row['loan'];
						     	$tp = $row['npaid'];
						    	$bal = $tm - $tp ;
								
								?>
			
						<td><input type="text"  name="invoiceDate[]" class="form-control" id="skills" value="<?php echo $row['start_date']; ?>" readonly></td>
						<input type="hidden"  name="id[]" class="form-control" id="skills" value="<?php echo $row['id']; ?>" >
						<td><input type="text"  name="supplier[]" class="form-control" id="skills"  value="<?php echo $row['name']; ?>" readonly> </td>
						<td> <input type="text"  name="total[]" class="form-control" id="skills" value="<?php echo $row['loan']; ?>" readonly></td>
						<td> <input type="text"  name="amount_paid[]" class="form-control" id="skills" value="<?php echo $row['npaid']; ?>" readonly></td>
						<td> <input type="text"  name="bal[]" class="form-control" id="skills" value="<?php echo $bal; ?>" readonly></td>
						
						<td><input name="pay[]" type="text"  class='input' value="<?php echo $row['installment']; ?>" onchange='updateTotal();'></td>
						

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
			<th colspan="5" style="border-top:1px solid #999999"> Total: </th>
			<th colspan="1" style="border-top:1px solid #999999">
			<input name="total" type="text" id="total" class="form-control" value="">
		</tr>
		<tr>
			<th colspan="3" style="border-top:1px solid #999999"> Source: </th>
			<th colspan="1" style="border-top:1px solid #999999">
			<td> 
						<select class='main' name="hand[]" style="width:150px; height:30px" >
  <option value='none'>Select Source</option>
  <option value='Yes'> Cash at Hand </option>
  <option value='Bank'>Cash in the Bank</option>

 
</select>

<!-- 

define each sublist as you wish,
 undefined ones wont show

-->
<select name="bank[]" class='models Bank' style="width:150px; height:30px">
 <option value=''>Select Bank</option>
					
					<?php

					$result3 = $dbo->prepare("SELECT* FROM bank order by ac_name  ASC");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?> | <?php echo $row['ac_no']; ?></option>
					<?php
					}
					?>

					
</select>
						
		</tr>
	</thead>
							
							
							
							
							
							
                        </table>
				<div class='row'>
	      		<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
	      			<button class="btn btn-success addmore" name="submit_mult" type="submit" formaction="loan_pay_save.php">+ Pay </button>
	      			
					</div>
				<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
					
	      		<button class="btn btn-danger delete" name="stop_mult" type="submit"  formaction="loan_pay.php">- Go back</button>
				</div>		
								
				</div>		

</form>
          
        </div>
        </div>
        </div>
    </div> 
<script src="app/app.js"></script>
<script src="js/jquery.min.js"></script>   


 <script language="javascript">
    $(function(){
  
  $("select.main").on("change", function(){
    //remove active
    $("select.models.active").removeClass("active");
    //check if select vlass exists..if it does show it
    var subList = $("select.models."+$(this).val());
    if (subList.length){
      //it does! show it by adding active class to it
      subList.addClass("active");
    }
  });
  
});
    </script>

 <?php include_once("footer.php"); ?>    
    </body>
</html>