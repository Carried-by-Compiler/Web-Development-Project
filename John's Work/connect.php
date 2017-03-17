<?php


$servername = "localhost";
$dbname = "web project";
$username = "root";
$pass = "";
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception)  {

	header("Location: error.php?e=$exception->getMessage()");
}



?>