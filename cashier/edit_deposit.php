<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Deposits</title>
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
        Edit Bank Deposits
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Edit Deposits</li>
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
	$result = $dbo->prepare("SELECT b.name, d.id, d.deposit, d.date, d.entrant FROM `bank` AS b INNER JOIN `bank_deposit` AS d ON b.id=d.name WHERE d.id= :userid");
	$result->bindParam(':userid', $id);
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>

           <form role="form" method="post"  action="updatedeposit.php"   onsubmit="return validate()">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Bank</label>
				  <input type="hidden" name="memi" value="<?php echo $id; ?>" />
                  <input type="text"  name="name" class="form-control" id="skills"  value="<?php echo $row['name']; ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Deposit</label>
                  <input type="text"  name="deposit" class="form-control" id="checkleng"  value="<?php echo $row['deposit']; ?>">
				   </div>
				   
				     <input type="hidden"  name="date"  class="form-control" value="<?php echo date("m/d/y"); ?>" required>
                
				  
				  <?Php
					if(isset($_SESSION['userid'])){
									}
						?>
                  <input type="hidden"  name="entrant"  class="form-control" value="<?php echo "$_SESSION[userid]"; ?>"  readonly>
				 <div class="form-group">
       
                
                <button type="submit" name="register" class="btn btn-primary">Update</button>
                </div>
			
         </br>
		 
         </br>
		   
            </form>		   
          <?php
}
?> 
</div>
  </div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script>  

 <?php include_once("footer.php"); ?>    
    </body>
</html>