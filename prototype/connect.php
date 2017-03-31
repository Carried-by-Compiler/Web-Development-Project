<?php


$servername = "localhost";
$dbname = "web project";
$username = "root";
$pass = "";
// server password: various-also-material-ears 
// link to website: http://testweb3.csisad.ul.campus/modules/cs4014/group4/pro
// link tp phpmyadmin on server: http://testweb3.csisad.ul.campus/phpmyadmin/
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception)  {

	header("Location: error.php?e=$exception->getMessage()");
}



?>