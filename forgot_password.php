<?Php


include "connect.php";

if(!empty($_POST["forgot-password"])){
		
		
		$condition = "";
		if(!empty($_POST["user-login-name"])) 
			$condition = " userid = '" . $_POST["user-login-name"] . "'";
		if(!empty($_POST["user-email"])) {
			if(!empty($condition)) {
				$condition = " and ";
			}
			$condition = " mail = '" . $_POST["user-email"] . "'";
		}
		
		if(!empty($condition)) {
			$condition = " where " . $condition;
		}

		$sql = "Select * from users " . $condition;
		$result = mysqli_query($con,$sql);
		$user = mysqli_fetch_array($result);
		
		if(!empty($user)) {
			require_once("forgot-password-recovery-mail.php");
		} else {
			$error_message = 'No User Found';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Forgot Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="plugins/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <script>
function validate_forgot() {
	if((document.getElementById("user-login-name").value == "") && (document.getElementById("user-email").value == "")) {
		document.getElementById("validation-message").innerHTML = "Login name or Email is required!"
		return false;
	}
	return true
}
</script>
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.html"><b>Rx</b>Tera</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Forgot Password?</p>

    <form name="frmForgot" id="frmForgot" method="post" onSubmit="return validate_forgot();">

	<?php if(!empty($success_message)) { ?>
	<div class="success_message"><?php echo $success_message; ?></div>
	<?php } ?>

	<div id="validation-message">
		<?php if(!empty($error_message)) { ?>
	<?php echo $error_message; ?>
	<?php } ?>
	</div>

	</br>

		<label for="username">Username</label>
		<div class="form-group has-feedback">
		<input type="text" name="user-login-name" id="user-login-name" class="form-control">
		<span class="glyphicon glyphicon-user form-control-feedback"></span>
		</div>
		
		<p align = "center"> OR </p>
	
	
		<label for="email">Email</label>
		<div class="form-group has-feedback">
		<input type="email" name="user-email" id="user-email" class="form-control">
		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>

	<div class="col-xs-4">
	<input type="submit" name="forgot-password" id="forgot-password" value="Submit"class="btn btn-primary btn-block btn-flat">
    </div>	
	
</form>
    <!-- /.social-auth-links -->
</br>
   

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
