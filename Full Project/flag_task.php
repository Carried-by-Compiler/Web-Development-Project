<?php 

require("/models/User.class.php");
session_start();
if (!isset($_SESSION['user']) || !isset($_POST['submit'])) {
	header("Location: index.html");
} else {
	
	$task_id = $_POST['t_id'];
	$desc = $_POST['flag_desc'];
	$flagger = $_SESSION['user']->getId();

	require("/connect.php");

	$result = $dbh->prepare("INSERT INTO Flagged_Tasks (Task_ID, Flagger, Flag_Desc, Date_Flagged) VALUES 
							 (:t, :f, :d, NOW());");
	$result->bindParam(':t', $task_id);
	$result->bindParam(':f', $flagger);
	$result->bindParam(':d', $desc);
	$result->execute();
	$_SESSION['user']->setPoints(2);

	echo "<h1>Task Flagged!</h1>";
	echo "<p>Thank you for this report! You have obtained 2 reputation points for flagging this task.</p>";
	echo "<a href='HomePage.php'>Return to home</a>";
}


?>