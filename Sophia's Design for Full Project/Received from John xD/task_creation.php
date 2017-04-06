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
	<link rel="stylesheet" href="">
</head>
<body>
	<h1>Create a Task</h1>
	<nav>
		<a href="HomePage.php">Home</a> |
		<a href="my_task.php">View My Tasks</a>
	</nav>
	<br>
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
		<br><input type="submit" name="submit">
		
	</form>
</body>
</html>