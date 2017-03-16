<?php


$servername = "localhost";
$dbname = "web project";
$username = "root";
$pass = "";
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
} catch (PDOException $exception)  {
    printf("Connection error: %s", $exception->getMessage());
}



?>