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
			<a href="home_page.php">Home</a> |
			<a href="task_creation.php">Create a task</a>
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

		<?php  if (isset($_GET['claim'])): ?>
			<form action="claim_task.php" method="POST">
				<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
				<input type="submit" name="claim" value="Claim Task">
			</form>
		<?php  elseif(isset($_GET['claimed'])): ?>

			<!--IMPLEMENT THESE! IMPORTANT-->
			<form action="" method="POST">
				<input type="submit" name="request" value="Request for Document">
			</form>
			<form action="" method="POST">
				<input type="submit" name="complete" value="Mark as Complete">
			</form>
		<?php endif; ?>
	</body>
</html>