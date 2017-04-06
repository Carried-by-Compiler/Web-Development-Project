<?php
/*
FOR TAGS:
- Get a list of tags related to course of study
- User should also have an option to add a tag for their course (optional)
- display list of tags to them for their choice.
- can choose max 4 tags
*/
require("/models/User.class.php");
session_start();
if (!isset($_SESSION['user'])) {
	header("Location: index.php");
} else {
	$courseID = $_SESSION['user']->getSubject();
	require("/connect.php");
	$result = $dbh->prepare("SELECT Tag_ID, Title FROM Tags WHERE Course_ID = :id"); // Get list of tag names associated with their course
	$result->bindParam(":id", $courseID);
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Task Creation</title>
		<meta name="description" content="website description" />
		<meta name="keywords" content="website keywords, website keywords" />
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
		<link href="./css/navi2.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="main">
			<div id="header">
				<div id="menubar">
				<ul id="menu">
				  <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
				  <li><a href="HomePage.php">Home</a></li>
				  <li><a href="my_task.php">View My Tasks</a></li>
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
						<ul>
						<h3><?php echo $_SESSION['user']->getF_name()." ".$_SESSION['user']->getS_name(); ?></h3>
								<li><a href="logout.php">LogOut</a></li>
							<?php 
								if ($_SESSION['user']->getPoints() >= 40) {
									echo "<li><a href='flagged_tasks.php'>View Flagged Tasks</a></li>";
									echo "<li><a href='view_banned_users.php'>View Banned Users</a></li>";
								}
							?>
							
						</ul>
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
	<h1>Create a Task</h1>
	<div id="content">
	<form action="store_task.php" method="post" enctype="multipart/form-data">
		Title:<br>
		<input type="text" name="title" required><br>
		<br>Type of paper:<br>
		<select name="type">
			<option value="Dissertation">Dissertation</option>
			<option value="Thesis">Thesis</option>
			<option value="Research Paper">Research Paper</option>
		</select>
		<br>Desctiption of the task:<br>
		<textarea name="desc" rows="10" cols="30"></textarea>
		<br>Format of document:<br>
		<select name="format">
			<option value="pdf">PDF</option>
			<option value="doc">DOC</option>
			<option value="docx">DOCX</option>
		</select>
		<br>Tags:<br>
		<select name="tag1">
		<?php 
			$result->execute();
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				echo "<option value='".$row['Tag_ID']."'>".$row['Title']."</option>";
			}
		?>
		</select>
		<select name="tag2">
		<?php 
			echo "<option value=''>--</option>";
			$result->execute();
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				echo "<option value='".$row['Tag_ID']."'>".$row['Title']."</option>";
			}
		?>
		</select>
		<select name="tag3">
		<?php 
			echo "<option value=''>--</option>";
			$result->execute();
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				echo "<option value='".$row['Tag_ID']."'>".$row['Title']."</option>";
			}
		?>
		</select>
		<select name="tag4">
		<?php
			echo "<option value=''>--</option>";
			$result->execute();
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				echo "<option value='".$row['Tag_ID']."'>".$row['Title']."</option>";
			}
		?>
		</select>
		<br>Number of words:<br>
		<input type="number" name="words" min="1"><br>
		<br>Number of pages:<br>
		<input type="number" name="pages" min="1"><br>
		<br>Deadline for task stream:<br>
		<input type="date" name="d_stream" required><br>
		<br>Deadline for task submission:<br>
		<input type="date" name="d_submission" required><br>
		<br>Document Preview:<br> 
    	<input type="file" name="classnotes" value="" /><br />
		<br><input type="submit" name="submit" value="Create Task" />
	
	</form>
	</div>
	</div>
	<div id="content_footer"></div>
    <div id="footer">
      <p><a href="HomePage.html">Home</a> | <a href="TaskCreate.html">Task Creation</a> | <a href="MyTasks.html">My Tasks</a> | <a href="contact.html">Contact Us</a></p>
      <p>Copyright &copy; textured_orbs | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">Website templates</a></p>
    </div>
  </div>
</body>
</html>