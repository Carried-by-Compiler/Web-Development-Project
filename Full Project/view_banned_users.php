<?php  

require("/models/User.class.php");
require("checkUserExistence.php");

session_start();
	
$banned = checkIfBanned($_SESSION['user_id']);
if ($banned == true) {
	header("Location: error.php?e=101");
}

require("/connect.php");
$result = $dbh->prepare("SELECT * FROM Users u JOIN Banned_Users b ON u.User_ID = b.Banned_User;");
$result->execute();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Banned Users</title>
	<title><?php echo $row['Title']; ?></title>
		<meta name="description" content="website description" />
		<meta name="keywords" content="website keywords, website keywords" />
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
		<link href="./css/MyTasks.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="main">
			<div id="header">
			<h1>Banned Users</h1>
				<div id="menubar">
				<ul id="menu">
				  <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
				  <li><a href="HomePage.php">Home</a></li>
				  <li><a href="my_tasks.php">View My Tasks</a></li>
				  <li><a href="task_creation.php">Create a task</a></li>
				  <li><a href="flagged_tasks.php">View Flagged Tasks</a></li>
				</ul>
			  </div>
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
		</div>
		<div class="sidebar_base"></div> -->
	
	

	<div class="contents">
		<?php
			if ($result->rowCount() <= 0) {
				echo "<h2><em>Website users have been good at the moment <3.</em></h2>";
			}
		?>
		<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
			<div class="user_details">
				<h2><?php echo $row['FirstName']." ".$row['LastName']; ?></h2>
				<h3><u>User ID Number</u></h3>
				<p><?php echo $row['User_ID'] ?></p>
				<h3><u>Email</u></h3>
				<p><?php echo $row['Email'] ?></p>
				<h3><u>Course Of Study</u></h3>
				<?php 
					$s = $dbh->prepare("SELECT Name FROM Courses WHERE Course_ID = ".$row['Subject']);
					$s->execute();
					$r = $s->fetch(PDO::FETCH_ASSOC);
				?>
				<p><?php echo $r['Name']; ?></p>
				<h3><u>Date_Banned</u></h3>
				<p><?php echo $row['Date_Banned'] ?></p>
				<h3><u>Banning Description</u></h3>
				<p><?php echo $row['Ban_Desc'];  ?></p>

				<form action="mod_features.php" method="POST">
					<input type="hidden" name="uid", value="<?php echo $row['User_ID'];?>">
					<input type="submit" name="unban" value="Unban User">
				</form>
			</div>
			<hr>
		<?php endwhile; ?>

	</div>
	<div id="content_footer"></div>
    <div id="footer">
      <p><a href="HomePage.html">Home</a> | <a href="TaskCreate.html">Task Creation</a> | <a href="MyTasks.html">My Tasks</a> | <a href="contact.html">Contact Us</a></p>
      <p>Copyright &copy; textured_orbs | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">Website templates</a></p>
    </div>
  </div>
</body>
</html>