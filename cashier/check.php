
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
}elseif($level  != 3 ){
?>
<script>
		alert('You are not authorised to view this page');
		window.location.href='../login.php';
</script>

<?php
}

elseif (isset($_SESSION['userid'])) {

    $result = mysqli_query($con, "SELECT token FROM user_token where userid='".$_SESSION['userid']."'");

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);
        $token = $row['token'];

        if($_SESSION['token'] != $token){
            session_destroy();
            header('Location: index.php');
        }
    }

}

else{

echo "<center><font face='Verdana' size='3' color=white>Welcome $user |
 <a href=change-password.php>Change Password</a>
</font></center>";

}


echo '
<script type="text/javascript">
idleMax = 5;// Logout after 5 minutes of IDLE
idleTime = 0;
$(document).ready(function () {
    var idleInterval = setInterval("timerIncrement()", 50000);
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
