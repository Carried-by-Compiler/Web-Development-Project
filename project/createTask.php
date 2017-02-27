<?php

session_start();
require_once("./models/User.class.php");
if (!isset($_SESSION['userID'])) {
    header("Location: index.html");

}

 ?>

 <!DOCTYPE html>
 <html>
     <head>
         <meta charset="utf-8">
         <title>Task Creation</title>
     </head>
     <body>
        <h1>Create A Task</h1>
        <?php if (isset($_POST['d'])) :?>
            <p><?php echo $_POST['d']; ?></p>
        <?php else: ?>
            <p>Fill in the details to create a task.</p>
        <?php endif; ?>
        <br>
        <form action="createTask.php" method="post">
            <input type="date" name="d" value=""> <br>
            <input type="submit" name="submit">
        </form>
     </body>
 </html>
