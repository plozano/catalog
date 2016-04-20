<?php

$servername = "localhost";
$username = "glozano";
$password = "abc123";
$dbname = "dev_coursecatalog";
$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
    die('Could not connect: ' . mysql_error());
}

//echo 'Connected successfully';  
 
mysqli_select_db($conn, $dbname); 

mysqli_set_charset($conn,"utf8");

?>
