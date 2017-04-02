<?php

session_start();

if (!isset($_SESSION['user'])) {
	header("Location: index.php");
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
	<style>
		.task_detail {
			position: relative;
		}

		.task_detail .claimant_detail {
			position: absolute;
			right: 50px;
			top: 0;
		}

		.contents {
			overflow-y: auto;
			height: 85%;
			margin-top: 15px;
		}

		.task_detail .claimant_review {
			position: absolute;
			right: 35%;
			top: 0;
			height: 500px;
			width: 350px;
			overflow-y: auto;
		}
	</style>
</head>
<body>
	<h1>My Tasks</h1>
	<nav>
		<a href="HomePage.php">Home</a> |
		<a href="task_creation.php">Create a task</a> 
	</nav>

	<div class="contents">
		<?php while ($row = $task_info->fetch(PDO::FETCH_ASSOC)) : ?>

			<div class="task_container">

				<div class="task_detail">
					
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
						<li>Date created: <?php echo $row['Date_Created'];  ?></li>
					</ul>
					<h3><u>Task Status</u></h3>
					<p><em><?php  echo $row['Status']; ?></em></p>
					<?php if ($row['Status'] == "PENDING_CLAIM") : ?>
						<form action="mod_features.php" method="POST">
							<input type="hidden" name="t_id" value="<?php  echo $row['Task_ID']; ?>">
							<input type="submit" name="delete" value="Delete Task">
						</form>

					<?php elseif ($row['Status'] == "UNCLAIMED" || $row['Status'] == "FAILED") : ?>

						<?php $_SESSION['t_id'] = $row['Task_ID']; ?>

						<form action="mod_features.php" method="POST">
							<input type="hidden" name="t_id" value="<?php  echo $row['Task_ID']; ?>">
							<input type="submit" name="delete" value="Delete Task">
						</form>
						<form action="republish_task.php" method="POST">
							<input type="hidden" name="t_id" value="<?php  echo $row['Task_ID']; ?>">
							<input type="submit" name="republish" value="Republish Task">
						</form>

					<?php endif; ?>
					
					<?php if ($row['Status'] == 'CLAIMED' || $row['Status'] == 'FAILED' || $row['Status'] == 'COMPLETE'||
								$row['Status'] == 'CANCELLED'): ?>
						<form action="mod_features.php" method="POST">
							<input type="hidden" name="t_id" value="<?php  echo $row['Task_ID']; ?>">
							<input type="submit" name="delete" value="Remove Task">
						</form>
						<?php  
						$result = $dbh->prepare("SELECT * FROM Users WHERE User_ID = ".$row['Claimant']);
						$result->execute();
						$user_row = $result->fetch(PDO::FETCH_ASSOC);
						?>
						<div class="claimant_review">
							<h1>Claimant's Review</h1>
							<p>Below is the claimant's review of your task.</p>
							<p><?php  echo $row['Claimant_Review']; ?></p>
						</div>
						<div class="claimant_detail">
							<h2>Claimant's Details</h2>
							<h3>Firstname</h3>
							<p><?php echo $user_row['FirstName'] ?></p>
							<h3>Lastname</h3>
							<p><?php echo $user_row['LastName'] ?></p>
							<h3>E-mail Address</h3>
							<p><?php echo $user_row['Email'] ?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<hr>
		<?php  endwhile; ?>
	</div>
</body>
</html>