<?php

session_start();
if (!isset($_SESSION['user']) || !isset($_POST['submit'])) {

	header("Location: index.php");

} else {

	require("connect.php");

	$query = "INSERT INTO Tasks (Owner, Date_Created, Title, Type, Description, Pages, Words, Format)
	   	 	  VALUES
	   	      (:owner, NOW(), :title, :type, :d, :p, :w, :f);";
	$result = $dbh->prepare($query);

	$result->bindParam(':owner', $_SESSION['user_id']);
	$result->bindParam(':title', $_POST['title']);
	$result->bindParam(':type', $_POST['type']);
	$result->bindParam(':d', $_POST['desc']);
	$result->bindParam(':p', $_POST['pages']);
	$result->bindParam(':w', $_POST['words']);
	$result->bindParam(':f', $_POST['format']);
	
	$result->execute();
	
	$last = $dbh->lastInsertID();

	$query = "INSERT INTO Deadlines (Task_ID, Claim_D, Sub_D)
			  VALUES (:id, :c, :s)";
	$deadlinesInput = $dbh->prepare($query);
	$deadlinesInput->bindParam('id', $last);
	$deadlinesInput->bindParam(':c', $_POST['d_stream']);
	$deadlinesInput->bindParam(':s', $_POST['d_submission']);
	$deadlinesInput->execute();

	$query = "INSERT INTO Task_Status (Task_ID)
		      VALUES (:i)";
	$task_status = $dbh->prepare($query);
	$task_status->bindParam(':i', $last);
	$task_status->execute();

	echo "<h1>Task Added Successfully</h1>";
	echo "<a href='HomePage.php'>Return to Home</a>";

	$dbh = null;

}




?>