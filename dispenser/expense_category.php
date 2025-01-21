<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title ?> | Expense</title>
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
function confirmDelete() 
{
	var msg = "Are you sure you want to delete?";       
    return confirm(msg);
}
</script>

<script type="text/javascript">
document.getElementById("form1").onkeypress = function(e) {
  var key = e.charname || e.keyname || 0;     
  if (key == 13) {
    alert("Enter Does not Save");
    e.preventDefault();
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
        Category Category
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Add Category</li>
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
			

           <form role="form" method="post" name='form1'  action="expense_category.php" >
                 <div class="container">
				  </br>
			   <div class="row">
				<div class="col-xs-5">
                  <label for="exampleInputEmail1">Category Name</label>
                  <input type="text"  name="name" class="form-control" id="skills" placeholder="Enter name" required>
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
			
			<?php
				if (isset($_POST['register'])){
				$name=$_POST['name'];
				
				mysqli_query($con, "insert into expense_category (name) values('$name')")or die(mysqli_error());
				
				}
				?>
       
	

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Categories</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
					<thead>
						<tr>
                        <th>Name</th>
						<th>Delete</th>
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT *  FROM `expense_category` ORDER BY id DESC")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						
						<td><?php echo $row[1]; ?></td>
					
						
						
						<td><a href="expense_category_delete.php?id=<?php echo $row['id']; ?>"><input type='submit'  type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete" value='Delete'>	</a></td>
                 
						
						
						
		
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
 

    </body>
</html>