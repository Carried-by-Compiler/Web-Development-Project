<?php


$servername = "testweb3";
$dbname = "group4";
$username = "group4";
$pass = "various-also-material-ears";
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception)  {

	header("Location: error.php?e=$exception->getMessage()");
}



?>