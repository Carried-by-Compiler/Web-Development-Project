<?php

session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: index.html");
} else {
	require("./models/User.class.php");
	$user = new User($_SESSION['user_id']);
	$_SESSION['user'] = $user;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
	<style type="text/css" media="screen">

		.profile_details {
			float: left;
			width: 500px;
		}

		.task_stream {
			float: right;
			width: 350px;
			height: 300px;
			overflow-y: auto;
		}
	</style>
</head>
<body>
	<h1><?php echo $_SESSION['user']->getF_name()." ".$_SESSION['user']->getS_name(); ?></h1>
	<nav>
		<a href="logout.php">LogOut</a> |
		<a href="task_creation.php">Create a task</a> |
		<a href="my_task.php">View My Tasks</a>
	</nav>

	<div class="profile_details">
		<h3>Email</h3>
		<p><?php echo $_SESSION['user']->getEmail(); ?></p>
		<h3>Subject</h3>
		<p><?php echo $_SESSION['user']->getSubject(); ?></p>
		<h3>Reputation Points</h3>
		<p><?php echo $_SESSION['user']->getPoints(); ?></p>
	</div>
	

	<div class="task_stream">
		<h2>Tasks To Claim</h2>
		<?php
			require("/connect.php");

			$result = $dbh->prepare("SELECT Task_ID, Title 
									 FROM Tasks NATURAL JOIN Task_Status 
									 WHERE Owner <> :id AND Status = 'PENDING_CLAIM';");
			$result->bindParam(':id', $_SESSION['user_id']);
			$result->execute();

			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				echo "<a href='task_details.php?task_id=".$row['Task_ID']."'>".$row['Title']."</a><br>";
			}

			$dbh = null;

		?>
	</div>
</body>
</html>