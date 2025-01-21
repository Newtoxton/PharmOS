<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Bank</title>
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
  
   <script type='text/javascript'>
	function validateForm() {
    var x = document.forms["form1"]["name"].value || document.forms["form1"]["ac_no"].value|| document.forms["form1"]["branch"].value;
	
    if (x == null || x == "") {
        alert("Field must be filled out");
        return false;
    }
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
        Add Bank
        <small>Create new Banks</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Add Banks</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body">
		
		
         <!-- general form elements -->
          <div class="box box-primary"></br>
		  
            <div class="box-header with-border">
			<a href="deposit.php"><input type='submit' class="btn btn-primary" value='Make Bank Deposit'> </a> </br></br>
              <h3 class="box-title">All Fields are required</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

           <form role="form" method="post"  name='form1'  action="bank.php"  onsubmit="return validate()">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Bank Name</label>
                  <input type="text"  name="name" class="form-control"    required>
                </div>
				
				 <div class="form-group">
                  <label for="exampleInputEmail1">Account Name</label>
                  <input type="text"  name="ac_name" class="form-control"    required>
                </div>
	
                <div class="form-group">
                  <label for="exampleInputEmail1">Account Number</label>
                  <input type="text"  name="ac_no"  class="form-control"  required>
                </div>
				 <div class="form-group">
                  <label for="exampleInputEmail1">Branch</label>
                  <input type="text"  name="branch"  class="form-control" id="exampleInputEmail1" value="" >
                </div>

                <div>
                <button type="submit" name="register" class="btn btn-primary">Register</button>
				
              </div>
           </div>
			   
            </form>
			
			<?php
				if (isset($_POST['register'])){
				$name=$_POST['name'];
				$ac_no=$_POST['ac_no'];
				$branch=$_POST['branch'];
				$ac_name=$_POST['ac_name'];

				mysqli_query($con, "insert into bank (name,ac_no, branch, ac_name) values('$name','$ac_no','$branch','$ac_name')")or die(mysqli_error());
				
				}
				?>
       
	
<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Banks</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
					<thead>
						<tr>
                        <th>Bank Name</th>
						<th>Account Name</th>
						<th>Account Number</th>
						<th>Branch</th>
						<th>Account Balance</th>
						
						
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT b.name,b.ac_name, b.ac_no, b.branch, b.id , sum(d.deposit) AS Total FROM `bank` AS b INNER JOIN `bank_deposit` AS d ON b.id=d.name GROUP BY b.id")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['ac_name']; ?></td>
						<td><?php echo $row['ac_no']; ?></td>
						<td><?php echo $row['branch']; ?></td>
						<td><?php echo number_format ($row['Total']); ?></td>
						
						
						</tr>
						<?php } ?>
					</tbody>
					
					<thead>
		<tr>
			<th colspan="4" style="border-top:1px solid #999999"> Total Cash in Bank </th>
			
			<th colspan="1" style="border-top:1px solid #999999"> 
			<span class="white-text" style="margin-right: 0.1em;"><?php echo $currency  ?></span><?php 
						
						$query=mysqli_query($con, "Select  sum(deposit)  AS sum FROM bank_deposit ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						echo number_format($row['sum']); 
						}
						
						?>
			</th>
			
		</tr>
	</thead>
					
				</table>
    </div>
</div>
</div>
  </div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script> 


 <script type="text/javascript">
function confirmDelete() 
{
	var msg = "Are you sure you want to delete?";       
    return confirm(msg);
}
</script>  

 <?php include("footer.php"); ?>    
    </body>
</html>