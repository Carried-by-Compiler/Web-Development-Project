<?php 

/*
flagged_tasks.php:
- Display all tasks (with details) of flagged tasks
- Do not include tasks that you have flagged (to avoid abuse of system)
*/
require("/models/User.class.php");
session_start();
if (!isset($_SESSION['user'])) {
	header("Location: index.php");
} else {
	require("/connect.php");
	$result = $dbh->prepare("SELECT * 
							 FROM ((Flagged_Tasks ft JOIN Tasks t ON ft.Task_ID = t.Task_ID) 
							 JOIN Deadlines d ON d.Task_ID = t.Task_ID)
							 WHERE Flagger <> ".$_SESSION['user_id']." AND Review_Status = 'UNCHECKED'
							 AND (d.Claim_D > CURDATE() OR d.Sub_D > CURDATE());");
	$result->execute();
}


?>
<html>
<head>
	<title>Flagged Tasks</title>
	<style>
		.contents {
			overflow-y: auto;
			height: 85%;
			margin-top: 15px;
		}

		.task_detail {
			position: relative;
		}

		.task_detail .flagger_detail {
			position: absolute;
			right: 100px;
			top: 0;
		}

		#ban_details {
			position: absolute;
			right: 500px;
			top: 0;
		}

		
	</style>
	<script>
		function showDiv() {
			document.getElementById('ban_details').style.display = "block";
		}
	</script>
</head>
<body>
	<h1>Flagged Tasks</h1>
	<nav>
		<a href="HomePage.php">Home</a> |
		<a href="task_creation.php">Create a task</a> |
		<a href="my_tasks.php">View My Tasks</a>
	</nav>

	<div class="contents">
		<?php 

		if ($result->rowCount() <= 0) {
				echo "<h2><strong>People have been good today. xD</strong></h2>";
		}  ?>

		<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>


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
						<li><a href="download_file.php?file=<?php echo $row['Task_ID']; ?>.<?php echo $row['Format']; ?>">Download document preview</a></li>
						<li>Flag Description:<strong><?php  echo $row['Flag_Desc'];  ?></strong></li>
					</ul>

					<form action="mod_features.php" method="POST" accept-charset="utf-8">
						<input type="hidden" name="t_id" value="<?php  echo $row['Task_ID'] ?>">
						<input type="hidden" name="f_id" value="<?php  echo $row['Flagger'] ?>">
						<input type="submit" name="delete" value="Unpublish Task">
						<input type="submit" name="seen" value="Mark as Checked">
						
					</form>
					<input type="button" name="ban" value="Ban Task Owner" onclick="showDiv()">



					<?php  
					$results = $dbh->prepare("SELECT * FROM Users WHERE User_ID = ".$row['Flagger']);
					$results->execute();
					$user_row = $results->fetch(PDO::FETCH_ASSOC);
					?>
					<div class="flagger_detail">
						<h2>Flagger's Details</h2>
						<h3>Firstname</h3>
						<p><?php echo $user_row['FirstName'] ?></p>
						<h3>Lastname</h3>
						<p><?php echo $user_row['LastName'] ?></p>
						<h3>E-mail Address</h3>
						<p><?php echo $user_row['Email'] ?></p>
					</div>

					<div id="ban_details" style="display: none">
						<h2>Ban User</h2>
						<p>Please add a description/reason for banning this user</p>
						<form action="mod_features.php" method="POST">
							<input type="hidden" name="t_id" value="<?php  echo $row['Task_ID'] ?>">
							<input type="hidden" name="f_id" value="<?php  echo $row['Flagger'] ?>">
							<textarea name="desc" rows="5" cols="40"></textarea><br>
							<input type="submit" name="ban" value="Ban User">
						</form>
					</div>
				</div>
			</div>
			<hr>
		<?php  endwhile; ?>
	</div>
</body>
</html>