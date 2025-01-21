<?php

include_once "../connect.php"; // database connection details stored here


?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Loans</title>
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
function confirmDelete() 
{
	var msg = "Are you sure you want to delete?";       
    return confirm(msg);
}
</script>


</head>

<?php include("header.php"); ?>

  <!-- =============================================== -->

  
<?php include("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Loans
        <small>Register Loan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Loans</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body"
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">All Fields are required.</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
	
</br>
	
           
  <form role="form" method="post" name='form1'  action="loan_save.php" >
                <div class="container">
		 
	<div class="row">
        <div class="col-xs-5">
		
               <label>Bank Name</label>
				  </br>
				  <select name="name"  class="form-group"  style="width:420px; height:34px" >
				  
					<option value=''>Select Bank</option>
					
					<?php

					$result3 = $dbo->prepare("SELECT* FROM bank order by ac_name  ASC");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?>-<?php echo $row['ac_no']; ?>-<?php echo $row['ac_name']; ?></option>
					<?php
					}
					?>
					
					</select>
			    </div>
			  
               <div class="col-xs-5">
                  <label for="exampleInputEmail1">Loan Amount</label>
				  <input type="text"  name="loan"  class="form-control" >
                 
                </div>
				
			</div>
			</br>
			
           
			<div class="row">
        <div class="col-xs-5">
		
                   <label for="exampleInputEmail1">Interest Rate</label>
                  <input type="text"  name="rate" class="form-control" >
                </div>
				
				 <div class="col-xs-5">
				 <label for="exampleInputEmail1">Monthly Installment</label>
				
				<input type="text"  name="installment"  class="form-control"  >
		   
                </div>
				  </div>
				</br>
			
			<div class="row">
        <div class="col-xs-5">
		
                <label for="exampleInputEmail1">Loan Receipt Date</label>
                  <input type="text"  name="start_date"  class="form-control" value="<?php echo date("Y-m-d");  ?>" >
                </div>
				
				 <div class="col-xs-5">
		
                  <label for="exampleInputEmail1">Loan Period (Months)</label>
				
				<input type="text"  name="months"  class="form-control" >
                  
                </div>
			
			</div>
			</br>
			
		
			
                <div>
                <button type="submit" name="register" class="btn btn-primary">Register</button>
                </div>
			
         </br>
		 
         </br>
			   
            </form>
			</div>
			
	
        
</div>
  </div>
<script src="js/bootstrap.js"></script>

 <script src="js/jquery-1.10.2.min.js"></script>
 
 
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

    
   
</script>
 <?php include("footer.php"); ?>    
 
    </body>
</html>