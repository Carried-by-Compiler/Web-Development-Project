<?php

try {
    $dbh = new PDO("mysql:host=localhost;dbname=web project", "root", "");
} catch (PDOException $exception)  {
    printf("Connection error: %s", $exception->getMessage());
}



?>