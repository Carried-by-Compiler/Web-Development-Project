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
</head>
<body>
	<h1><?php echo $_SESSION['user']->getF_name()." ".$_SESSION['user']->getS_name(); ?></h1>
	<nav>
		<a href="logout.php">LogOut</a> |
		<a href="task_creation.php">Create a task</a> |
		<a href="my_task.php">View My Tasks</a>
	</nav>
	<h3>Email</h3>
	<p><?php echo $_SESSION['user']->getEmail(); ?></p>
	<h3>Subject</h3>
	<p><?php echo $_SESSION['user']->getSubject(); ?></p>
	<h3>Reputation Points</h3>
	<p><?php echo $_SESSION['user']->getPoints(); ?></p>
</body>
</html>