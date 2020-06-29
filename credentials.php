<?php
// default values for Xampp when accessing your MySQL database:
$dbhost  = 'localhost';
$dbuser  = 'root';
$dbpass  = '';
$dbname  = 'phoneWebsite';

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// if the connection fails, we need to know, so allow this exit:
if (!$connection)
{
die("Connection failed: " . $mysqli_connect_error);
}
?>