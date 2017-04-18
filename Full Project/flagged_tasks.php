<?php 
/*
flagged_tasks.php:
- Display all tasks (with details) of flagged tasks
- Do not include tasks that you have flagged and the owner of the flagged task is not yours (to avoid abuse of system)
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
							 WHERE Flagger <> ".$_SESSION['user_id']." AND t.Owner != ".$_SESSION['user_id']." AND Review_Status = 'UNCHECKED'
							 AND (d.Claim_D > CURDATE() OR d.Sub_D > CURDATE());");
	$result->execute();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Flagged Tasks</title>
	<meta name="description" content="website description" />
		<meta name="keywords" content="website keywords, website keywords" />
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
		<link href="./css/Flagged.css" rel="stylesheet" type="text/css" />
	<script>
		function showDiv() {
			document.getElementById('ban_details').style.display = "block";
		}
	</script>
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
				  <li><a href="my_tasks.php">View My Tasks</a></li>
				</ul>
				
			  </div>
			  <h1>Flagged Tasks</h1>
			  
				
			</div>
	
	

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
						<input type="submit" name="delete" value="Unpublish Task"><br><br>
						<input type="submit" name="seen" value="Mark as Checked"><br><br>
						
					</form>
					<input type="button" name="ban" value="Ban Task Owner" onclick="showDiv()">
					
					<br><br>



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
	<div id="content_footer"></div>
    <div id="footer">
      <p><a href="HomePage.html">Home</a> | <a href="TaskCreate.html">Task Creation</a> | <a href="MyTasks.html">My Tasks</a> | <a href="contact.html">Contact Us</a></p>
      <p>Copyright &copy; textured_orbs | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">Website templates</a></p>
    </div>
  </div>
</body>
</html>