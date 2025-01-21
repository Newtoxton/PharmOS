<?php
// DATABASE INFORMATION

$dbhost_name = "localhost"; 
$database = "rxtera.com"; 
$username = "root";         
$password = "";   




//////// Connecting to the Database /////////
try {
$dbo = new PDO("mysql:host=$dbhost_name;dbname=$database", $username, $password);

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
$level = $row['level'];  
$logo = $row['logo']; 
$timezone = $row['timezone']; 
	
	}  

// Set the default timezone to use.	
	
define('ZONE', "$timezone");

date_default_timezone_set(ZONE);	
	

//////// Generating random Invoice Number /////////
	
function RandomInvoiceNumber() {
	$chars = "003232303232023232023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 7) {

		$num = rand() % 33;

		$tmp = substr($chars, $num, 1);

		$pass = $pass . $tmp;

		$i++;

	}
	return $pass;
}
$finalcode='Rx'.RandomInvoiceNumber();





//////// Starting PHP Sessions /////////
  
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>