<?php

session_start();
require_once("./models/User.class.php");
if (!isset($_SESSION['userID'])) {
    header("Location: index.html");

}
$user = new User($_SESSION['userID']);
$_SESSION['user'] = $user;

 ?>

 <!DOCTYPE html>
 <html>
     <head>
         <meta charset="utf-8">
         <title><?php echo $_SESSION['user']->getFirstName()." ".$_SESSION['user']->getLastName(); ?></title>
         <link rel="stylesheet" href="./css/styles.css">
     </head>
     <body>
        <h1>Welcome <?php  echo $_SESSION['user']->getFirstName()." ".$_SESSION['user']->getLastName(); ?></h1>
        <nav class="userFeatures">
            <a href="createTask.php">Create a task</a>
            <a href="myTasks.php">My Tasks</a>
            <a href="logout.php">Log Out</a>
        </nav>
     </body>
 </html>
