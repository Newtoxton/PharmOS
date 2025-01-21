<?Php

include_once "../connect.php"; // database connection details stored here

$user = $_SESSION['userid'] ;

$query=mysqli_query($con, "SELECT *  FROM `users` WHERE `userid` = '$user' ")or die(mysqli_error());
while($row = mysqli_fetch_assoc($query)) {
$level = $row['level'];
}


if(!isset($user)){
	?>
	<script>
		alert('Please Login to use this page');
		window.location.href='../login.php';
	</script>
<?php
}elseif($level  != 2 ){
?>
<script>
		alert('You are not authorised to view this page');
		window.location.href='../login.php';
</script>

<?php
}else{

echo "<center style='padding-top:5px; padding-right:12px; font-size:15px; color:#8DC63F;'>Welcome $user |
 <a href=change-password.php>Change Password</a>
</center>";

}


echo '
<script type="text/javascript">
idleMax = 5;// Logout after 5 minutes of IDLE
idleTime = 0;
$(document).ready(function () {
    var idleInterval = setInterval("timerIncrement()", 500000);
    $(this).mousemove(function (e) {idleTime = 0;});
    $(this).keypress(function (e) {idleTime = 0;});
})
function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > idleMax) {
        window.location="../login.php";
    }
}
</script>';


?>
