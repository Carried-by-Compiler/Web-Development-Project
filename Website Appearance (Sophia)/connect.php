<?php
$servername = "localhost";
$username = "group4";
$pass = "various-also-material-ears";
try {
    $dbh = new PDO("mysql:host=testweb3;dbname=group4", "group4", "various-also-material-ears");
} catch (PDOException $exception)  {
    printf("Connection error: %s", $exception->getMessage());
}



?>