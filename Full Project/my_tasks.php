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
	
	require("checkUserExistence.php");
		
	$banned = checkIfBanned($_SESSION['user_id']);
	if ($banned == true) {
		header("Location: error.php?e=User is banned!");
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Tasks</title>
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link href="./css/MyTasks.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="main">
			<div id="header">
			
				<div class="sidebar">
					<div class="sidebar">
						<div class="sidebar_top"></div>
						<div class="sidebar_item">
						<h3>Search</h3>
						<form method="post" action="#" id="search_form">
							<p>
							<input class="search" type="text" name="search_field" value="Enter keywords....." />
							<input name="search" type="button" value="Search" <!--style="border: 0; margin: 0 0 -9px 5px;" src="style/search.png" alt="Search" title="Search"--> />
							</p>
						</form>
						</div>
					</div>
					<div class="sidebar_base"></div>
				</div>
				<div id="menubar">
				
				<ul id="menu">
				  <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
				  <li><a href="HomePage.php">Home</a></li>
				  <li><a href="task_creation.php">Create a task</a></li>
				</ul>
			  </div>
			  <h1>My Tasks</h1>
			</div>
			<!--
			<div class="sidebar">
					<div class="sidebar">
						<div class="sidebar_top"></div>
						<div class="sidebar_item">
						<h3>Search</h3>
						<form method="post" action="#" id="search_form">
							<p>
							<input class="search" type="text" name="search_field" value="Enter keywords....." />
							<input name="search" type="image" style="border: 0; margin: 0 0 -9px 5px;" src="style/search.png" alt="Search" title="Search" />
							</p>
						</form>
						</div>
					</div>
					<div class="sidebar_base"></div>
				</div>
				-->
	
	

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

					<?php elseif ($row['Status'] == "UNCLAIMED" || $row['Status'] == "FAILED" || $row['Status'] == "CANCELLED") : ?>

						<?php $_SESSION['t_id'] = $row['Task_ID']; ?>
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
						<?php if ($row['Status'] == 'COMPLETE') : ?>
						<div class="claimant_review">
							<h1>Claimant's Review</h1>
							<p>Below is the claimant's review of your task.</p>
							<textarea readonly disabled rows="5" cols="35"><?php  echo $row['Claimant_Review']; ?></textarea>
							<?php  if ($row['Rating'] != 'HAPPY' && $row['Rating'] != 'UNHAPPY'):  ?>
								<form action="review_rating.php" method="POST">
								<input type="hidden" name="t_id" value="<?php  echo $row['Task_ID']; ?>">
								<input type="hidden" name="u_id" value="<?php  echo $user_row['User_ID']; ?>">
								<br>Rate Claimant's Review
								<select name="review">
									<option value="HAPPY">Happy</option>
									<option value="UNHAPPY">Unhappy</option>
								</select><br><br>
								<input type="submit" name="submit" value="Rate Review">
								</form>
							<?php else: ?>
								<p>Thank you for the review!</p>
							<?php endif; ?>
						</div>
						<?php endif; ?>
						<!--
						 <div class="claimant_review">
							<h1>Claimant's Review</h1>
							<p>Below is the claimant's review of your task.</p>
							<p><?php  echo $row['Claimant_Review']; ?></p>
						</div> --> 
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
			</div><br><br>
			<hr>
		<?php  endwhile; ?>
	</div>
	<div id="content_footer"></div>
    <div id="footer">
      <p><a href="HomePage.html">Home</a> | <a href="TaskCreate.html">Task Creation</a> | <a href="MyTasks.html">My Tasks</a> | <a href="contact.html">Contact Us</a></p>
      <p>Copyright &copy; textured_orbs | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">Website templates</a></p>
    </div>
  </div>
</body>
</html>