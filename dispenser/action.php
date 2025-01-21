<?php
// configuration
include_once('../connect.php');


				if (isset($_POST['register'])){
				$name=$_POST['name'];
				$userid=$_POST['userid'];
				$password=$_POST['password'];
				$level=$_POST['level'];
				$password=md5($password);
				
				
				mysql_query("insert into users (name,userid,password,level) values('$name','$userid','$password','$level')")or die(mysql_error());
				
				}
				
?>