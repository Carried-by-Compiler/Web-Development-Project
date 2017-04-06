<?php  

/*
cancel_task.php:

- Update status of task as "CANCELLED"
- Deduct 15 rep points

*/
require("/models/User.class.php");
session_start();


require("/connect.php");

if (isset($_POST['t_id'])) {
	$_SESSION['user']->setPoints(-15);
	$result = $dbh->prepare("UPDATE Task_Status SET Status = 'CANCELLED' WHERE Task_ID = ".$_POST['t_id']);
	$result->execute();

	echo "<h1>Cancelled task</h1>";
	echo "<p>You have lost 15 rep points for cancelling this task.</p>";
   echo "<a href='HomePage.php'>Return Home</a>;
} else {
	header("Location: home_page.php");
}





?>