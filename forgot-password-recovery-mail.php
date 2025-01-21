<?php

include "connect.php";


function generate_password($length = 100, $complex=3) {
$min = "abcdefghijklmnopqrstuvwxyz";
$num = "0123456789";
$maj = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

$chars = $min;
if ($complex >= 2) { $chars .= $num; }
if ($complex >= 3) { $chars .= $maj; }

$password = substr( str_shuffle( $chars ), 0, $length );
return $password;
}

 $pass = generate_password(100);
 
 
 
 function generate($length = 100, $complex=3) {
$min = "abcdefghijklmnopqrstuvwxyz";
$num = "0123456789";
$maj = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

$chars = $min;
if ($complex >= 2) { $chars .= $num; }
if ($complex >= 3) { $chars .= $maj; }

$password2 = substr( str_shuffle( $chars ), 0, $length );
return $password2;
}

 $pass2 = generate(100);




$url = "http://" . $_SERVER['SERVER_NAME'] ;

if(!class_exists('PHPMailer')) {
    require('admin/phpmailer/class.phpmailer.php');
	require('admin/phpmailer/class.smtp.php');
}



				$mail = new PHPMailer();
				
				
				$emailBody = "Hello " . $user["userid"] . ", <br><br>Click <a href=' ".$url."/reset_password.php?id=".$pass."&name=" . $user["userid"] . "&sno=".pass2."'    target='_blank'>THIS LINK</a> to reset your password.";
		     	

//From email address and name
				$mail->From = ' '.$email.' ';
				$mail->FromName = ' '.$name.' ';
				$mail->Subject = 'Password Reset';
				$mail->AddAddress($user["mail"]); 
				$mail->MsgHTML($emailBody);
				$mail->IsHTML(true);				

if(!$mail->Send()) {
	$error_message = 'Problem in Sending Password Recovery Email';
} else {
	$success_message = 'Please check your email to reset your password!, It may take a few minutes';
}

?>
