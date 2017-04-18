<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("Location: index.html");
	} else {
		require("./models/User.class.php");
		$user = new User($_SESSION['user_id']);
		$_SESSION['user'] = $user;
		
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
		<title>Homepage</title>
		<meta name="description" content="website description" />
		<meta name="keywords" content="website keywords, website keywords" />
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
		<link href="./css/navi2.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			function active(){
				var searchBar = document.getElementById('searchBar');
				
				if(searchBar.value == 'Search...'){
					searchBar.value = ''
					searchBar.placeholder = 'Search...'
				}
			}
			function inactive(){
				var searchBar = document.getElementById('searchBar');
				
				if(searchBar.value == ''){
					searchBar.value = 'Search...'
					searchBar.placeholder = ''
				}
			}
		</script>
	</head>
	
	<body>
		<div id="main">
			<div id="header">
				<h1><?php echo $_SESSION['user']->getF_name()." ".$_SESSION['user']->getS_name(); ?></h1>
				<div id="menubar">
				<ul id="menu">
				  <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
				  <li><a href="HomePage.php">Home</a></li>
				  <li><a href="my_tasks.php">View My Tasks</a></li>
				  <li><a href="task_creation.php">Create Task</a></li>
				  <li><a href="logout.php">LogOut</a></li>
				</ul>
			  </div>
			</div>
			<div id="content_header"></div>
				<div id="site_content">
				  <div id="sidebar_container">
					<div class="sidebar">
					  <div class="sidebar_top"></div>
					  <div class="sidebar_item">
						<!-- insert your sidebar items here -->
						<!--
							<form action="search.php" method="post">
								<input type="text" id="searchBar" placeholder="" value="Search..." maxlength="30" autocomplete="off" onmousedown="active();" onblur="inactive();"/><input type="submit" id="searchBtn" value="Go!" />
							</form>
						-->
						<?php if ($_SESSION['user']->getPoints() >= 40) : ?>
							<h3>Moderator Functions</h3>
							<ul>
								<li><a href="flagged_tasks.php">View Flagged Tasks</a></li>
								<li><a href="view_banned_users.php">View Banned Users</a></li>
							</ul>
						<?php endif; ?>
					  </div>
					  <div class="sidebar_base"></div>
					</div>
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
				  <div class="sidebar_base"></div>
				</div>
			  </div>

		<div id="content">
			<h3><u>University ID</u></h3>
			<p><?php echo $_SESSION['user']->getId(); ?><p>
			<h3><u>Email</u></h3>
			<p><?php echo $_SESSION['user']->getEmail(); ?></p>
			<h3><u>Subject</u></h3>
			<p>
				<?php 
					$courseID = $_SESSION['user']->getSubject(); 
					require("/connect.php");
					$result = $dbh->prepare("SELECT name FROM Courses WHERE Course_ID = :id");
					$result->bindParam(":id", $courseID);
					$result->execute();
					$row = $result->fetch(PDO::FETCH_ASSOC);
					echo $row['name'];
				?>
			</p>
			<h3><u>Reputation Points</u></h3>
			<p><?php echo $_SESSION['user']->getPoints(); ?></p>
		</div>

		<div class="claimed_tasks">
			<h2>Claimed Tasks</h2>
			<div class="tasks">
				<?php
					require("/connect.php");
					/* 
					Get the title and task id of each task 
					where the task has been claimed by you,
					while at the same time, the task deadline has not expired.
					*/
					$result = $dbh->prepare("SELECT t.Task_ID, t.Title, DATEDIFF(dead.Sub_D, NOW()) as DIFF
											 FROM (Tasks t JOIN Task_Status s ON t.Task_ID = s.Task_ID)
											 JOIN Deadlines dead ON t.Task_ID = dead.Task_ID
											 WHERE (Claimant = :id AND Status = 'CLAIMED') 
											 ORDER BY dead.Sub_D;");
					$result->bindParam(':id', $_SESSION['user_id']);
					$result->execute();
					while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
						// If there is a task that has been expired for submission
						// change its status and deduct 30 rep points
						if ($row['DIFF'] > 0) {
							echo "<p><a href='task_details.php?task_id=".$row['Task_ID']."&claimed=1&expired=0'>".$row['Title'].":</a><br><strong>".$row['DIFF']."</strong> days left!</p>";
							echo "<hr>";
						} else {
							echo "<p><a href='task_details.php?task_id=".$row['Task_ID']."&claimed=1&expired=1'>".$row['Title']."</a>:<br><strong>FAILED</strong> to submit!</p>";
							echo "<hr>";
						}
						
					}
					$dbh = null;
				?>
			</div>
					
	</div>

	<div class="task_stream">
		<h2>Tasks To Claim</h2>
		<div class="tasks">

			<?php
				require("/connect.php");
				/*
				Get the task id and task title of each task
				where the task does not belong to you and is available to be claimed.
				The deadline for claiming that task should not have been reached.
				*/
				$co = $_SESSION['user']->getSubject();
				$query = "SELECT t.Task_ID, t.Title, DATEDIFF(Claim_D, NOW()) as DIFF 
						  FROM (Tasks t JOIN Task_Status ts ON t.Task_ID = ts.Task_ID)
						  JOIN Deadlines d ON ts.Task_ID = d.Task_ID
						  WHERE ((t.Owner <> :id AND ts.Status = 'PENDING_CLAIM') AND d.Claim_D > CURDATE()) AND t.Task_ID IN 
						  (SELECT Task_Tags.Task_ID
						   FROM (Task_Tags JOIN Tags ON Task_Tags.Tag_ID = Tags.Tag_ID) JOIN Courses ON Tags.Course_ID = Courses.Course_ID 
						   WHERE Courses.Course_ID = :c_id)
						   ORDER BY d.Claim_D;";
				$result = $dbh->prepare($query);
				$result->bindParam(':id', $_SESSION['user_id']);
				$result->bindParam(':c_id', $co);
				$result->execute(); 
				
				while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
					echo "<p><a href='task_details.php?task_id=".$row['Task_ID']."&claim=1'>".$row['Title']."</a><br><strong>".$row['DIFF']."</strong> days left to claim!</p>";
					echo "<hr>";
				}
				$dbh = null;
			?>
			
		</div>
		
	</div>
	</div>
	<div id="content_footer"></div>
    <div id="footer">
      <p><a href="HomePage.php">Home</a> | <a href="task_creation.php">Task Creation</a> | <a href="my_tasks.php">My Tasks</a></p>
      <p>Copyright &copy; textured_orbs | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">Website templates</a></p>
    </div>
  </div>

	</body>
</html>