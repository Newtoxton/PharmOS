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

         
			
			<?php
				if (isset($_POST['register'])){
				$name=$_POST['name'];
				$userid=$_POST['userid'];
				$password1=$_POST['password'];
				$level=$_POST['level'];
				$mail=$_POST['mail'];
				$code=$_POST['code'];
				$password=md5($password1);
				$url = "http://" . $_SERVER['SERVER_NAME'] ;
				

				
				// Mail 
				
				require_once("phpmailer/class.phpmailer.php");

				$mailer = new PHPMailer();
				
				//From email address and name
				$mailer->From = ' '.$email.' ';
				$mailer->FromName = 'Rx Tera';
		     	$mailer->Body = 'Hello '.$name.', Your username: '.$userid.'  | Your password is: '.$password1.'. Please login here '.$url.' and change your password';
				$mailer->Subject = 'New System Account created';
				$mailer->AddAddress($_POST['mail']); 

				
				if(!$mailer->Send())
				{
				   echo "<script>alert('Registration failed.')</script>";

				}
				else
				{
				echo "<script>alert('Registration Success! Login details have been sent to user's E-mail.')</script>"; 
				
				mysqli_query($con, "insert into users (name,userid,password,level,mail,code) values('$name','$userid','$password','$level','$mail','$code')")or die(mysql_error());
								
				}
				
				}
				?>
       
	

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
						<th>User Level</th>
						<th>Code</th>
						<th>Edit</th>
						<th>Delete</th>
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT * FROM `users` ORDER BY id DESC  LIMIT 10")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['mail']; ?></td>
						<td><?php echo $row['userid']; ?></td>
						<td><?php echo $row['level']; ?></td>
						<td><?php echo $row['code']; ?></td>
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