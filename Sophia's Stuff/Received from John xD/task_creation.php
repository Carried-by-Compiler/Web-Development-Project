<?php

session_start();

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
		<a href="home_page.php">Home</a> |
		<a href="my_task.php">View My Tasks</a>
	</nav>
	<br>
	<form action="/project/store_task.php" method="post">
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
			<option value="PDF">PDF</option>
			<option value="DOC">DOC</option>
			<option value="DOCX">DOCX</option>
		</select>
		<br>Number of words:<br>
		<input type="number" name="words" min="1"><br>
		<br>Number of pages:<br>
		<input type="number" name="pages" min="1"><br>
		<br>Deadline for task stream:<br>
		<input type="date" name="d_stream" required><br>
		<br>Deadline for task submission:<br>
		<input type="date" name="d_submission" required><br>
		<br><input type="submit" name="submit">
	</form>
</body>
</html>