<?php
 
 
// new data
$file=$_FILES['image']['tmp_name'];
                $image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
                $image_name= addslashes($_FILES['image']['name']);
                $image_size= getimagesize($_FILES['image']['tmp_name']);
 
               
                                move_uploaded_file($_FILES["image"]["tmp_name"],"" . $_FILES["image"]["name"]);
 
$filename=$_FILES["image"]["name"];
 
$mysql_host = 'localhost';
$mysql_username = 'malaikam_chruser';
$mysql_password = 'dKhIha%n5pRH';
$mysql_database = 'malaikam_christa';
 
// Connect to MySQL server
mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());
mysql_query("SET NAMES 'utf8'");
// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
if (substr($line, 0, 2) == '--' || $line == '')
continue;
 
// Add this line to the current segment
$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';')
{
    // Perform the query
mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
    // Reset temp variable to empty
    $templine = '';
}
}
echo '<div style="text-align: center; margin-top: 50px;">';
echo "Database imported successfully<br>";
 $dir = dirname(__FILE__);
echo 'form'.$dir.'/' .$filename .'To '.$mysql_database.'<br>';
echo '<a href="../admin/index.php">Back</a>';
echo '</div>';
 
 
?>