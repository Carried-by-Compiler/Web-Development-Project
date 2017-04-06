<?php

require("/models/User.class.php");
session_start();

require("/connect.php");
if (!isset($_GET['task_id'])) {
	header("Location: home_page.php");
} else {

	$task_id = $_GET['task_id'];

	if (isset($_GET['expired']) && $_GET['expired'] == 1) {
		
		$result = $dbh->prepare("UPDATE Task_Status SET Status = 'FAILED' WHERE Task_ID = :id");
		$result->bindParam(':id', $task_id);
		$result->execute();
		$_SESSION['user']->setPoints(-30);
		echo "<h1>FAILED TO SUBMIT TASK</h1>";
		echo "<p>You have lost 30 reputation points for failing to submit your task</p>";
	}

	$result = $dbh->prepare("SELECT * FROM Tasks NATURAL JOIN Deadlines WHERE Tasks.Task_ID = :id");
	$result->bindParam(':id', $task_id);
	$result->execute();

	$row = $result->fetch(PDO::FETCH_ASSOC);


	$result = $dbh->prepare("SELECT Status FROM Task_Status WHERE Task_ID = :id");
	$result->bindParam(':id', $task_id);
	$result->execute();
	$status_row = $result->fetch(PDO::FETCH_ASSOC);

	$dbh = null;
}



?>
<html>
	<head>
		<title><?php echo $row['Title']; ?></title>
	</head>
	<body>
		<h1><?php echo $row['Title']; ?></h1>
		<nav>
			<a href="HomePage.php">Home</a> |
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
			<li>Task Status: <?php  echo $status_row['Status']; ?></li>
			<li><a href="download_file.php?file=<?php echo $task_id; ?>.<?php echo $row['Format']; ?>">Download document preview</a></li>
		</ul>

		<?php  if (isset($_GET['claim'])): ?>
			<form action="claim_task.php" method="POST">
				<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
				<input type="submit" name="claim" value="Claim Task">
			</form>
		<?php  elseif(isset($_GET['claimed'])): ?>

			<!--IMPLEMENT THESE! IMPORTANT-->
			<?php if ($_GET['expired'] == 0) : ?>
				<form action="" method="POST">
					<input type="submit" name="request" value="Request for Document">
				</form>
				<form action="complete_task.php" method="POST">
					<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
					<input type="submit" name="complete" value="Mark as Complete">
				</form>
				<form action="cancel_task.php" method="POST">
					<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
					<input type="submit" name="cancel" value="Cancel task">
				</form>
			<?php else: ?>
				
				
			<?php endif; ?>
		<?php endif; ?>
	</body>
</html>