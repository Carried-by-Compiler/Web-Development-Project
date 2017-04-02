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
		<style>
			.task_details {
				position: relative;
			}

			.task_details .flagging {
				position: absolute;
				right: 100px;
				top: 50px;
				width: 350px;
			}
		</style>
		<script>
			function showDiv() {
				document.getElementById('flag_div').style.display = "block";
			}
		</script>
	</head>
	<body>
		<div class="task_container">
			
			<div class="task_details">
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
					<li>Date created: <?php echo $row['Date_Created'];  ?></li>
					<li>Task Status: <strong><?php  echo $status_row['Status']; ?></strong></li>
					<li><a href="download_file.php?file=<?php echo $task_id; ?>.<?php echo $row['Format']; ?>">Download document preview</a></li>
				</ul>

				<?php  if (isset($_GET['claim'])): ?>
					<form action="claim_task.php" method="POST">
						<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
						<input type="submit" name="claim" value="Claim Task">
					</form>
					<input type="button" name="flag" value="Flag Task" onclick="showDiv()"/>
					
				<?php  elseif(isset($_GET['claimed'])): ?>

					<!--IMPLEMENT THESE! IMPORTANT-->
					<?php if ($_GET['expired'] == 0) : ?>
						<form action="email_request.php" method="POST">
							<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
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
						<form action="flag_task.php" method="POST">
							<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
							<input type="submit" name="flag" value="Flag Task">
						</form>
					<?php else: ?>
						
						
					<?php endif; ?>
				<?php endif; ?>

				<div id="flag_div" class="flagging" style="display: none">
					<h2>Flagging Task</h2>
					<p>Thank you very much for letting us know about this!<br><br> Please select an appropriate description of the problem and a moderator will come to it as fast as possible.</p>
					<form action="flag_task.php" method="POST">
						<select name="flag_desc">
							<option value="SPAM">Spam</option>
							<option value="INAPPROPRIATE">Inappropriate</option>
							<option value="WRONG_SUBJECT">Task in wrong subject</option>
						</select>
						<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
						<input type="submit" name="submit" value="Submit">
					</form>
				</div>
			</div>
			
		</div>
		
	</body>
</html>