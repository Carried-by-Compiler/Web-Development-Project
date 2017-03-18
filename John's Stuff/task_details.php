<?php

session_start();

require("/connect.php");
if (!isset($_GET['task_id'])) {
	header("Location: home_page.php");
} else {

	$task_id = $_GET['task_id'];

	$result = $dbh->prepare("SELECT * FROM Tasks NATURAL JOIN Deadlines WHERE Tasks.Task_ID = :id");
	$result->bindParam(':id', $task_id);
	$result->execute();

	$row = $result->fetch(PDO::FETCH_ASSOC);


	$result = null;

}



?>
<html>
	<head>
		<title><?php echo $row['Title']; ?></title>
	</head>
	<body>
		<h1><?php echo $row['Title']; ?></h1>
		<nav>
			<a href="logout.php">LogOut</a> |
			<a href="home_page.php">Home</a>
		</nav>
		<h2>Description</h2>
		<p> <?php echo $row['Description']; ?></p>
		<h2>Deadlines</h2>
		<h3>Task Stream Expiry Date</h3>
		<p> <?php echo $row['Claim_D'];  ?></p>
		<h3>Submission Expiry Date</h3>
		<p><?php echo $row['Sub_D'];  ?></p>
		<h2>Other Info</h2>
		<ul>
			<li>Type: <?php echo $row['Type'];  ?></li>
			<li>Words: <?php echo $row['Words'];  ?></li>
			<li>Words: <?php echo $row['Pages'];  ?></li>
			<li>Date created (YYYY-MM-DD TIME): <?php echo $row['Date_Created'];  ?></li>
		</ul>
	</body>
</html>