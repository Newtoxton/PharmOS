<?Php


include "connect.php";


if(isset($_POST["reset-password"])) {
		
		$sql = "UPDATE `users` SET `password` = '" . md5($_POST["member_password"]). "' WHERE `users`.`userid` = '" . $_GET["name"] . "'";
		$result = mysqli_query($con,$sql);
		$success_message = "Password is reset successfully.....Redirecting to Login";
		header("refresh:3;login.php"); // redirects image view page after 5 seconds.
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
function validate_password_reset() {
	if((document.getElementById("member_password").value == "") && (document.getElementById("confirm_password").value == "")) {
		document.getElementById("validation-message").innerHTML = "Please enter new password!"
		return false;
	}
	if(document.getElementById("member_password").value  != document.getElementById("confirm_password").value) {
		document.getElementById("validation-message").innerHTML = "Both password should be same!"
		return false;
	}
	
	return true;
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
    <p class="login-box-msg">Reset Password</p>
<form name="frmReset" id="frmReset" method="post" onSubmit="return validate_password_reset();">

	<?php if(!empty($success_message)) { ?>
	<div class="success_message"><?php echo $success_message; ?></div>
	<?php } ?>

	<div id="validation-message">
		<?php if(!empty($error_message)) { ?>
	<?php echo $error_message; ?>
	<?php } ?>
	</div>


		<label for="username">Password</label>
		<div class="form-group has-feedback">
		<input type="password" name="member_password" id="member_password" class="form-control">
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		
		
		<label for="email">Confirm Password</label>
		<div class="form-group has-feedback">
		<input type="password" name="confirm_password" id="confirm_password" class="form-control">
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>

	<div class="col-xs-4">
	<input type="submit" name="reset-password" id="reset-password" value="Submit" class="btn btn-primary btn-block btn-flat">
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
