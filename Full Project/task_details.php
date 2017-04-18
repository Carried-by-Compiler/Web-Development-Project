<?php
require("/models/User.class.php");
session_start();
require("/connect.php");
if (!isset($_GET['task_id'])) {
	header("Location: home_page.php");
} else {
	
	require("checkUserExistence.php");
		
	$banned = checkIfBanned($_SESSION['user_id']);
	if ($banned == true) {
		header("Location: error.php?e=User is banned!");
	}
	
	$task_id = $_GET['task_id'];
	if (isset($_GET['expired']) && $_GET['expired'] == 1) {
		
		$result = $dbh->prepare("UPDATE Task_Status SET Status = 'FAILED' WHERE Task_ID = :id");
		$result->bindParam(':id', $task_id);
		$result->execute();
		$_SESSION['user']->setPoints(-30);
		/*echo "<h1>FAILED TO SUBMIT TASK</h1>";
		echo "<p>You have lost 30 reputation points for failing to submit your task</p>";*/
	}
	$result = $dbh->prepare("SELECT * FROM Tasks NATURAL JOIN Deadlines WHERE Tasks.Task_ID = :id");
	$result->bindParam(':id', $task_id);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$result = $dbh->prepare("SELECT Status FROM Task_Status WHERE Task_ID = :id");
	$result->bindParam(':id', $task_id);
	$result->execute();
	$status_row = $result->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $row['Title']; ?></title>
		<meta name="description" content="website description" />
		<meta name="keywords" content="website keywords, website keywords" />
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
		<link href="./css/taskdetails.css" rel="stylesheet" type="text/css" />
		<script>
			function showDivFlag() {
				document.getElementById('flag_div').style.display = "block";
				document.getElementById('complete_div').style.display = "none";
			}
			function showDivComplete() {
				document.getElementById('flag_div').style.display = "none";
				document.getElementById('complete_div').style.display = "block";
			}
		</script>
	</head>
	<body>
	<div id="main">
			<div id="header">
				<h1><?php echo $row['Title']; ?></h1>
				<div id="menubar">
				<ul id="menu">
				  <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
				  <li><a href="HomePage.php">Home</a></li>
				  <li><a href="task_creation.php">Create a task</a></li>
				</ul>
			  </div>
			</div>
		<div class="task_container">
			
			<div class="task_details">
			<?php if (isset($_GET['expired']) && $_GET['expired'] == 1): ?>
				<h1>FAILED TO SUBMIT TASK</h1>
				<p>You have lost 30 reputation points for failing to submit your task</p>
			<?php endif; ?>
				
				<h2>Description</h2>
				<p> <?php echo $row['Description']; ?></p>
				<h2>Deadlines</h2>
				<h3>Task Stream Expiry Date</h3>
				<p> <?php echo $row['Claim_D'];  ?></p>
				<h3>Submission Expiry Date</h3>
				<p><?php echo $row['Sub_D'];  ?></p>
				<h2>Tags</h2>
				<ul>
					<?php
					$tag_result = $dbh->prepare("SELECT Title 
												 FROM Task_Tags tt JOIN Tags t ON tt.Tag_ID = t.Tag_ID
												 WHERE tt.Task_ID = ".$row['Task_ID']);
					 
					$tag_result->execute();
					?>
					<?php while($tag_row = $tag_result->fetch(PDO::FETCH_ASSOC)): ?>
						<li><?php echo $tag_row['Title']; ?></li>
					<?php endwhile; ?>
				</ul>
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
					<br>
					<input type="button" name="flag" value="Flag Task" onclick="showDivFlag()"/>
					
				<?php  elseif(isset($_GET['claimed'])): ?>

					<!--IMPLEMENT THESE! IMPORTANT-->
					<?php if ($_GET['expired'] == 0) : ?>
						<form action="email_request.php" method="POST">
							<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
							<input type="submit" name="request" value="Request for Document">
						</form>
						<br>
						<form action="cancel_task.php" method="POST">
							<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
							<input type="submit" name="cancel" value="Cancel task">
						</form>
						<br>
						<input type="submit" name="flag" value="Flag Task" onclick="showDivFlag()"><br><br>
						<input type="submit" name="complete" value="Mark as Complete" onclick="showDivComplete()">
						<br>
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
							<option value="EXPLICIT">Contains explicit material</option>
						</select>
						<input type="hidden" name="t_id" value="<?php echo $task_id; ?>">
						<input type="submit" name="submit" value="Submit">
					</form>
				</div>
				<div id="complete_div" style="display: none">
					<h1>Complete Task</h1>
					<p>Enter your review for the task.</p>
					<form action="complete_task.php" method="POST" accept-charset="utf-8">
						<input type="hidden" name="t_id" value="<?php echo $task_id; ?>" required>
						<textarea name="task_review" rows="5" cols="50"></textarea>
						<br /><input type="submit" name="submit_complete" value="Complete Task">
					</form>
				</div>
			</div>
			
		</div>
		<br>
		<div id="content_footer"></div>
    <div id="footer">
      <p><a href="HomePage.html">Home</a> | <a href="TaskCreate.html">Task Creation</a> | <a href="MyTasks.html">My Tasks</a> | <a href="contact.html">Contact Us</a></p>
      <p>Copyright &copy; textured_orbs | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">Website templates</a></p>
    </div>
  </div>
	</body>
</html>