<?php

include_once "../connect.php"; // database connection details stored here

///////Collect the form data /////
$todo=$_POST['todo'];
$password=$_POST['password'];
$password2=$_POST['password2'];
$old_password=$_POST['old_password'];
/////////////////////////

if(isset($todo) and $todo=="change-password"){
$status = "OK";
$msg="";

			
$count=$dbo->prepare("select password from users where userid=:userid");
$count->bindParam(":userid",$_SESSION['userid'],PDO::PARAM_STR, 20);
$count->execute();
$row = $count->fetch(PDO::FETCH_OBJ);


if($row->password<>md5($old_password)){
$msg=$msg."Your old password  is not matching as per our records.<BR>";
$status= "NOTOK";
}					

if ( strlen($password) < 6 or strlen($password) > 15 ){
$msg=$msg."Password must be between 6 and 15 characters in length<BR>";
$status= "NOTOK";}					

if ( $password <> $password2 ){
$msg=$msg."Both passwords are not matching<BR>";
$status= "NOTOK";}					



if($status<>"OK"){ 
echo "<font face='Verdana' size='2' color=red>$msg</font><br><center><input type='button' value='Retry' onClick='history.go(-1)'></center>";
}else{ // if all validations are passed.
$password=md5($password); // Encrypt the password before storing
//if(mysql_query("update plus_signup set password='$password' where userid='$_SESSION[userid]'")){
$sql=$dbo->prepare("update users set password=:password where userid='$_SESSION[userid]'");
$sql->bindParam(':password',$password,PDO::PARAM_STR, 32);
if($sql->execute()){
echo "<font face='Verdana' size='2' ><center>Thanks <br> Your password was changed successfully. Please keep changing your password for better security</font></center>";
header("refresh:5;../logout.php"); // redirects image view page after 5 seconds.
}else{echo "<font face='Verdana' size='2' color=red><center>Sorry <br> Failed to change password Contact Site Admin</font></center>";
} // end of if else if updation of password is successful
} // end of if else if status <>OK
} // end of if else todo

?>
           