<?php

session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: index.html");
} else {
	require("./models/User.class.php");
	$user = new User($_SESSION['user_id']);
	$_SESSION['user'] = $user;

	// Check if there are any tasks that you have claimed that are expired
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
	<style type="text/css" media="screen">

		.profile_details {
			float: left;
			width: 450px;
			height: 250px;
		}

		.claimed_tasks {
			width: 300px;
			height: 250px;
			float: left;
			margin-left: 120px;
			overflow-y: auto;
		}

		.task_stream {
			float: right;
			width: 300px;
			height: 250px;
			overflow-y: auto;
		}
	</style>
</head>
<body>
	<h1><?php echo $_SESSION['user']->getF_name()." ".$_SESSION['user']->getS_name(); ?></h1>
	<nav>
		<a href="logout.php">LogOut</a> |
		<a href="task_creation.php">Create a task</a> |
		<a href="my_tasks.php">View My Tasks</a>
	</nav>

	<div class="profile_details">
		<h3>Email</h3>
		<p><?php echo $_SESSION['user']->getEmail(); ?></p>
		<h3>Subject</h3>
		<p><?php echo $_SESSION['user']->getSubject(); ?></p>
		<h3>Reputation Points</h3>
		<p><?php echo $_SESSION['user']->getPoints(); ?></p>
	</div>
	
	<div class="claimed_tasks">
		<h2>Claimed Tasks</h2>
		<?php
			require("/connect.php");

			/* 
			Get the title and task id of each task 
			where the task has been claimed by you,
			while at the same time, the task deadline has not expired.
			*/

			$result = $dbh->prepare("SELECT t.Task_ID, t.Title, DATEDIFF(dead.Sub_D, NOW()) as DIFF
									 FROM (Tasks t JOIN Task_Status s ON t.Task_ID = s.Task_ID)
									      JOIN Deadlines dead ON t.Task_ID = dead.Task_ID
									 WHERE (Claimant = :id AND Status = 'CLAIMED') AND dead.Sub_D >= CURDATE()
									 ORDER BY dead.Sub_D;");
			$result->bindParam(':id', $_SESSION['user_id']);
			$result->execute();

			echo "<hr>";
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

				// TEST
				// If there is a task that has been expired for submission
				// change its status and deduct 30 rep points
				if ($row['DIFF'] > 0) {
					echo "<p><a href='task_details.php?task_id=".$row['Task_ID']."&claimed=1&expired=0'>".$row['Title']."</a>: ".$row['DIFF']." days left!</p>";
					echo "<hr>";
				} else {
					echo "<p><a href='task_details.php?task_id=".$row['Task_ID']."&claimed=1&expired=1'>".$row['Title']."</a>: ".$row['DIFF']." days left!</p>";
					echo "<hr>";
				}
				
			}

			$dbh = null;

		?>
	</div>

	<div class="task_stream">
		<h2>Tasks To Claim</h2>
		<?php
			require("/connect.php");
			/*
			Get the task id and task title of each task
			where the task does not belong to you and is available to be claimed.
			The deadline for claiming that task should not have been reached.
			*/
			$result = $dbh->prepare("SELECT Tasks.Task_ID, Tasks.Title, DATEDIFF(Claim_D, NOW()) as DIFF
									 FROM (Tasks JOIN Task_Status ON Tasks.Task_ID = Task_Status.Task_ID)
									 	JOIN Deadlines ON Tasks.Task_ID = Deadlines.Task_ID
									 WHERE (Owner <> :id AND Status = 'PENDING_CLAIM') AND Claim_D > CURDATE();");
			$result->bindParam(':id', $_SESSION['user_id']);
			$result->execute();

			echo "<hr>";
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				echo "<p><a href='task_details.php?task_id=".$row['Task_ID']."&claim=1'>".$row['Title']."</a>: ".$row['DIFF']." days left to claim!</p>";
				echo "<hr>";
			}

			$dbh = null;

		?>
	</div>

	
</body>
</html>