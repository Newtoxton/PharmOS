<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Customers</title>
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
    var x = document.forms["form1"]["name"].value || document.forms["form1"]["address"].value|| document.forms["form1"]["phone"].value|| document.forms["form1"]["medicine"].value|| document.forms["form1"]["notes"].value;
	
    if (x == null || x == "") {
        alert("Field must be filled out");
        return false;
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
        Add Customers
        <small>Create new Customers</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Add Customers</li>
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
			

           <form role="form" method="post" name='form1'  action="customer.php" >
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Customer's Name</label>
                  <input type="text"  name="name" class="form-control" id="skills" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <textarea class="form-control" name="address" rows="3" placeholder="Enter Address" required></textarea>  </div>
				 <div class="form-group">
                  <label for="exampleInputEmail1">Phone Number</label>
                  <input type="text"  name="phone"  class="form-control" id="exampleInputEmail1"  placeholder="Enter Phone No." required>
                </div>
                <div class="form-group">
				<label for="exampleInputEmail1">E-mail Address</label>
                  <input type="text"  name="medicine" class="form-control" id="skills" placeholder="Enter E-mail" required>
                </div>
				
                <div class="form-group">
                  <label for="exampleInputEmail1">Notes</label>
                  <textarea class="form-control" name="notes" rows="3" placeholder="Enter ..." required></textarea>  </div>
                  </div>
                <div>
                <button type="submit" name="register" class="btn btn-primary">Register</button>
                </div>
			
         </br>
		 
         </br>
			   
            </form>
			
			<?php
				if (isset($_POST['register'])){
				$name=$_POST['name'];
				$address=$_POST['address'];
				$phone=$_POST['phone'];
				$medicine=$_POST['medicine'];
				$notes=$_POST['notes'];
				
				
				mysqli_query($con, "insert into customer (name,address,phone,medicine, notes) values('$name','$address','$phone','$medicine','$notes')")or die(mysqli_error());
				
				}
				?>
       
	

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Customers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
					<thead>
						<tr>
                        <th>Supplier Name</th>
						<th>Address</th>
						
						<th>Phone No.</th>
						<th>Medicine</th>
						<th>Notes</th>
						<th>Edit</th>
						
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT *  FROM `customer` ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						
						<td><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
						<td><?php echo $row[3]; ?></td>
						<td><?php echo $row[4]; ?></td>
						<td><?php echo $row[5]; ?></td>
						
						
						<td><a href="edit_customer.php?id=<?php echo $row['id']; ?>"><input type='submit' class="btn btn-success addmore" value='Edit'>	</a></td>
						
						</tr>
						<?php } ?>
					</tbody>
				</table>
    </div>
</div>
</div>
  </div>
  
  
  
 
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script>  

 <?php include("footer.php"); ?>    
 
 <script type="text/javascript">
function confirmDelete() 
{
	var msg = "Are you sure you want to delete?";       
    return confirm(msg);
}
</script>
    </body>
</html>