<?Php

include "connect.php"; // database connection details stored here


//////////////////////////////

$userid=$_POST['userid'];
$password=$_POST['password'];

$query=mysqli_query($con, "select * FROM users WHERE userid='$userid' ")or die(mysqli_error());

while($row=mysqli_fetch_array($query)){

$level = $row['level'];

}



//$password=md5($password); // Encrypt the password before comparing
//// Checking userid and password //////
$msg='';
$status='OK';
if(!isset($userid) or strlen($userid) <6){
$msg=$msg."User id should be 6 or more characters in length<BR>";
$status= "NOTOK";}
if ( strlen($password) < 6 ){
$msg=$msg."Password must be more than 6 char legth<BR>";
$status= "NOTOK";}

if($status<>"OK"){
echo "<font face='Verdana' size='2' color=red>$msg</font><br><input type='button' value='Retry' onClick='history.go(-1)'>";
exit;
}


$count=$dbo->prepare("select id,password,userid from users where userid=:userid");
$count->bindParam(":userid",$userid,PDO::PARAM_STR);
if($count->execute()){
$no=$count->rowCount();
if($no <> 1 ) {
$msg=" Make sure you login with valid username or password";
}else {
$row = $count->fetch(PDO::FETCH_OBJ);
if($row->password==md5($password)){
//echo " Inside ";
// Start session n redirect to last page
$_SESSION['id']=session_id();
$_SESSION['userid']=$row->userid;
$_SESSION['id']=$row->id;

$sql_query = "select count(*) as cntUser from users where userid='".$userid."' ";
$result    = mysqli_query($con,$sql_query);
$rod       = mysqli_fetch_array($result);
$count     = $rod['cntUser'];

if($count > 0){
            $token 								= getToken(10);
            $_SESSION['token']    = $token;

            // Update user token
            $result_token = mysqli_query($con, "select count(*) as allcount from user_token where userid='".$userid."' ");
            $row_token = mysqli_fetch_assoc($result_token);
            if($row_token['allcount'] > 0){
                mysqli_query($con,"update user_token set token='".$token."' where userid='".$userid."'");
            }else{
                mysqli_query($con,"insert into user_token(userid,token) values('".$userid."','".$token."')");
            }

					}


//echo " Inside session  ". $_SESSION['userid'];
						if ($level == 1)
						{
							header('location:admin/index.php');
							write_mysql_log($userid, $con);
						}

					if ($level == 2)
						{
							header('location:dispenser/index.php');
							write_mysql_log($userid, $con);
						}

					if ($level == 3)
						{
							header('location:cashier/index.php?d1=0');
							write_mysql_log($userid, $con);
						}

				        if ($level == 4)
						{
							header('location:superdis/index.php');
							write_mysql_log($userid, $con);
						}
}
else
{
$msg = " Login failed, try again ... <br><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);'>";
} // end of if else for matching password
} // end of if elase for matching number of records <>1
}else{
$msg = " Login failed, try again ... <br><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);'>";
} //
echo $msg;
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Log in</title>
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


</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Rx</b>Tera</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">


<center>


<br><br><a href="login.php">Try again</a> </center>



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

</body>
</html>
