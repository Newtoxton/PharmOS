<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Password</title>
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
    var x = document.forms["form1"]["old_password"].value || document.forms["form1"]["password"].value|| document.forms["form1"]["password2"].value;
	
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
        alert("Make sure the new password is between 6-15 characters long");
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
        Change Password
        <small>Create new system password</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Change password</li>
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

			
			
			

           <form role="form" method="post"  name='form1'  action="updatepassword.php"  onsubmit="return validate()">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Old Password</label>
				  <input type="hidden" name="todo" value="change-password">
                  <input type="password"  name="old_password" class="form-control" id="skills" placeholder="Enter Old password"  required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">New Password</label>
                  <input type="password"  name="password"  class="form-control" id="checkleng" placeholder="Password must be 6 or more characters" required>
                </div>
				 <div class="form-group">
                  <label for="exampleInputEmail1">Re-Enter new Password</label>
                  <input type="password"  name="password2"  class="form-control" id="checkleng" placeholder="Repeat password" required>
                </div>
				
                 
                <div>
                <button type="submit" name="submit" class="btn btn-primary">Change Password</button>
				
              </div>
           </div>
			   
            </form>
			
			
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