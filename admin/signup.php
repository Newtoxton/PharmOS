<?php

include "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Users</title>
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
    var x = document.forms["form1"]["name"].value || document.forms["form1"]["userid"].value|| document.forms["form1"]["level"].value;
	
    if (x == null || x == "") {
        alert("Field must be filled out");
        return false;
    }
}
</script>

 <script type='text/javascript'>
	function validate(){
    var checkleng = document.getElementById("checkleng");
    if(checkleng.value.length <= 15 && checkleng.value.length >= 6){
    }
    else{
        alert("Make sure the system username is between 6-15 characters long");
		this.focus();
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
        Add Users
        <small>Create new system users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Add Users</li>
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

           <form role="form" method="post"  name='form1'  action="signupload.php"  onsubmit="return validate()">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Full Name</label>
                  <input type="text"  name="name" class="form-control" id="skills" placeholder="Enter Full Name"  required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">System username</label>
                  <input type="text"  name="userid"  class="form-control" id="checkleng" placeholder="Username must be 6 or more characters" required>
                </div>
				
				<div class="form-group">
                  <label for="exampleInputEmail1">E-mail</label>
                  <input type="text"  name="mail"  class="form-control" id="checkleng" placeholder="Enter your E-mail" required>
                </div>
				
			
                  <input type="hidden"  name="code"  class="form-control" id="checkleng" value="12773" required>
              
				
				 <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="text"  name="password"  class="form-control" id="exampleInputEmail1" value="pass123" readonly>
                </div>
				
                   <div class="form-group">
                  <label>Select user level</label>
                  <select name="level" class="form-control">
                    <option value="1">Administrator</option>
                    <option value="2">Dispenser</option>
                    <option value="3">Cashier</option>
                  
                    
                  required</select>
                </div>
                <div>
                <button type="submit" name="register" class="btn btn-primary">Register</button>
				
              </div>
           </div>
			   
            </form>
			
			
       
	
<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All system users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
					<thead>
						<tr>
                        <th>Full Name</th>
						<th>E-mail</th>
						<th>Username</th>
						<th>User Group</th>
						
						<th>Edit</th>
						<th>Delete</th>
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT *  FROM `users` ORDER BY id DESC ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['mail']; ?></td>
						<td><?php echo $row['userid']; ?></td>
						<td>
						<?php 
						if ($row['level'] == 1){
							echo "Administrator"; 
						} elseif ($row['level'] == 2) {
							echo "Dispenser"; 
						}elseif ($row['level'] == 3) {
							echo "Cashier"; 
						}else {
							echo "Manager"; 
						}
						?></td>
						
						<td><a href="edit_user.php?id=<?php echo $row['id']; ?>"><input type='submit' class="btn btn-success addmore" value='Edit'>	</a></td>
						<td><a href="delete_user.php?id=<?php echo $row['id']; ?>"><input type='submit'  type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete" value='Delete'>	</a></td>
                 
						
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