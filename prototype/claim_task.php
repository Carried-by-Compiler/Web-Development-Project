<?php

/*
claim_task.php:

- Insert user_id of task claimant to Task_Status table
- Set status of task to CLAIMED
- Add 10 reputation points to user.
*/
require("/models/User.class.php");
session_start();

// If the page is being accessed without being logged in
if (!isset($_SESSION['user'])) { 
	header("Location: login.html");
} else {
	if (!isset($_POST['claim'])) {
		header("Location: home_page.php");
	} else {

		// Add 10 rep points to user
		$_SESSION['user']->setPoints(10);

		require("/connect.php");

		// Update details of Task_Status table
		$update = $dbh->prepare("UPDATE Task_Status
								 SET Status = 'CLAIMED', Claimant = :u_id
								 WHERE Task_ID = :t_id");
		$update->bindParam(':u_id', $_SESSION['user_id']);
		$update->bindParam(':t_id', $_POST['t_id']);
		$update->execute();

		echo "<h1>Task Claim Successful!</h1>";
		echo "<p>10 reputation points has been awarded for claiming this task.</p>";
		echo "<a href='HomePage.php'>Home</a>";
	}
}


?>