<?php

// DATABASE INFORMATION


$dbhost_name = "localhost"; // Change your database host
$database = "newtoxton_fpdb"; // Change your database name
$username = "newtoxton_fabian";          // Your database user id
$password = "_!T@[~ujq(4y";          // Your password

error_reporting(1);
ini_set('display_errors', 1);

//////// Connecting to the Database /////////
try {
$dbo = new PDO("mysql:host=$dbhost_name;dbname=$database", $username, $password);
  $dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}

$con=mysqli_connect("$dbhost_name","$username","$password","$database");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  // PHARMACY INFORMATION


$query=mysqli_query($con, "SELECT *  FROM `settings` WHERE `id` = 1 ")or die(mysqli_error());
while($row = mysqli_fetch_assoc($query)) {
$id = $row['id'];
$name = $row['name'];
$address = $row['address'];
$address2 = $row['address2'];
$email = $row['email'];
$phone = $row['phone'];
$country = $row['country'];
$currency = $row['currency'];
$tag = $row['level'];
$logo = $row['logo'];
$timezone = $row['timezone'];

	}

// Set the default timezone to use.

if (!defined('ZONE')) define('ZONE', "$timezone");

date_default_timezone_set(ZONE);


// Set the user log.

function write_mysql_log($message, $con)
{
  // Check database connection
  if( ($con instanceof MySQLi) == false) {
    return array(status => false, message => 'MySQL connection is invalid');
  }

  // Check message
  if($message == '') {
    return array(status => false, message => 'Message is empty');
  }

  // Get IP address
  if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
    $remote_addr = "REMOTE_ADDR_UNKNOWN";
  }

  // Get requested script
  if( ($request_uri = $_SERVER['REQUEST_URI']) == '') {
    $request_uri = "REQUEST_URI_UNKNOWN";
  }


  $mytime = date("g:i a");
  // Escape values
  $mytime      = $con->escape_string($mytime);
  $message     = $con->escape_string($message);
  $remote_addr = $con->escape_string($remote_addr);
  $request_uri = $con->escape_string($request_uri);

  // Construct query
  $sql = "INSERT INTO my_log (remote_addr, request_uri, message, mytime) VALUES('$remote_addr', '$request_uri','$message','$mytime')";

  // Execute query and save data
  $result = $con->query($sql);

  if($result) {
    return array(status => true);
  }
  else {
    return array(status => false, message => 'Unable to write to the database');
  }
}


function getToken($length){
     $token = "";
     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet.= "0123456789";
     $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max-1)];
    }

    return $token;
}


//////// Starting PHP Sessions /////////

    if(!isset($_SESSION))
    {
        session_start();
    }
?>
