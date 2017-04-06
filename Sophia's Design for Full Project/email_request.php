<?php 
session_start();

if (!isset($_SESSION['user'])) {
	header("Location: index.php");
} else {
	if (isset($_POST['request'])) {
		require("/connect.php");
		$result = $dbh->prepare("SELECT Owner FROM Tasks WHERE Task_ID = :id");
		$result->bindParam(':id', $_POST['t_id']);
		$result->execute();
		$row = $result->fetch(PDO::FETCH_ASSOC);
		$dbh = null;

		$sendto = $row['Owner']."@studentmail.ul.ie";
		$subject = "Full File Request";
		$body = "Hi there! As you may have known, I have claimed a task of yours. I am sending this email to request for your full file. It would be much appreciated!";
	}
	
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Full File Request</title>
	<style type="text/css" media="screen">
		textarea {
			resize: none;
		}
	</style>
</head>
<body>
	<h1>Email Template For File Request</h1>
	<p>Please copy these details to your email client/program and just send.</p>
	<br>
	<p>Recipient's Email Address:</p>
	<textarea rows="2" cols="40" readonly disabled>
	<?php echo $sendto; ?>
	</textarea>
	<br><p>Subject:</p>
	<textarea rows="2" cols="40" readonly disabled>
	<?php echo $subject; ?>
	</textarea>
	<br><p>Body:</p>
	<textarea rows="5" cols="50" readonly disabled>
	<?php echo $body; ?>
	</textarea>
	<br><br>
	
	<footer>
		<?php echo "
	<a href='mailto:".$sendto."?subject=".$subject."&body=".$body."'>Click here to rediect to an installed email client.</a>
	"; ?><br><br>
		<nav>
			<a href="HomePage.php">Home</a> |
			<a href="task_creation.php">Create a task</a> |
			<a href="logout.php">LogOut</a>
		</nav>
	</footer>
</body>
</html>