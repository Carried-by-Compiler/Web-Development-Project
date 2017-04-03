<?php  

require("/connect.php");

$result = $dbh->prepare("SELECT * FROM Users u JOIN Banned_Users b ON u.User_ID = b.Banned_User;");
$result->execute();


?>
<!DOCTYPE html>
<html>
<head>
	<title>Banned Users</title>
	<style>
		.contents {
			overflow-y: auto;
			height: 85%;
			margin-top: 15px;
		}
	</style>
</head>
<body>

	<h1>Banned Users</h1>
	<nav>
		<a href="HomePage.php">Home</a> |
		<a href="my_tasks.php">View My Tasks</a> |
		<a href="task_creation.php">Create Task</a> |
		<a href="flagged_tasks.php">View Flagged Tasks</a> 
	</nav>

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

</body>
</html>