<?php

session_start();

if (!isset($_SESSION['user'])) {
	header("Location: index.html");
} else {
	require("/connect.php");
	$task_info = $dbh->prepare("SELECT * 
								FROM (Tasks t JOIN Task_Status s ON t.Task_ID = s.Task_ID) JOIN
								Deadlines d ON s.Task_ID = d.Task_ID
								WHERE Owner=".$_SESSION['user_id'].";");
	$task_info->execute();
}


?>
<html>
<head>
	<title>My Tasks</title>
</head>
<body>
	<h1>My Tasks</h1>
	<nav>
		<a href="home_page.php">Home</a> |
		<a href="task_creation.php">Create a task</a>
	</nav>
	<?php while ($row = $task_info->fetch(PDO::FETCH_ASSOC)) : ?>
		<h2><?php echo $row['Title'];  ?></h2>
		<h3><u>Description</u></h3>
		<p> <?php echo $row['Description']; ?></p>
		<h3><u>Deadlines</u></h3>
		<h4>Task Stream Expiry Date</h4>
		<p> <?php echo $row['Claim_D'];  ?></p>
		<h4>Submission Expiry Date</h4>
		<p><?php echo $row['Sub_D'];  ?></p>
		<h3><u>Other Info</u></h3>
		<ul>
			<li>Type: <?php echo $row['Type'];  ?></li>
			<li>Words: <?php echo $row['Words'];  ?></li>
			<li>Words: <?php echo $row['Pages'];  ?></li>
			<li>Date created (YYYY-MM-DD TIME): <?php echo $row['Date_Created'];  ?></li>
		</ul>
		<h3><u>Task Status</u></h3>
		<p><em><?php  echo $row['Status']; ?></em></p>
		<?php if ($row['Status'] = "PENDING_CLAIM") : ?>
			<form action="delete_task.php" method="POST">
				<input type="hidden" name="t_id" value="<?php  echo $row['Task_ID']; ?>">
				<input type="submit" name="delete" value="Delete Task">
			</form>
		<?php endif; ?>
		<hr>
	<?php  endwhile; ?>
</body>
</html>