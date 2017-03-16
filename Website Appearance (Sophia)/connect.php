<?php
$servername = "localhost";
$username = "root";
$pass = "";
try {
    $dbh = new PDO("mysql:host=$servername;dbname=group4", $username, $pass);
} catch (PDOException $exception)  {
    printf("Connection error: %s", $exception->getMessage());
}



?>