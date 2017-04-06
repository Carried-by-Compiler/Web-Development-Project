<?php  

/*
republish_task.php:
- Enter new claim date and submission date
- Change status to PENDING_CLAIM
- Remove claimant id
*/
session_start();
require("/connect.php");
?>

<?php if (!isset($_POST['publish'])) : ?>
	<h1>Republish Task</h1>

	<form action="republish_task.php" method="POST">
		Deadline for task stream:<br>
		<input type="date" name="d_stream" required><br>
		<br>Deadline for task submission:<br>
		<input type="date" name="d_submission" required><br>
		<br><input type="submit" name="publish">
	</form>
<?php else: ?>
	<?php
		$result = $dbh->prepare("UPDATE deadlines d JOIN Task_Status ts ON d.Task_ID = ts.Task_ID SET d.Claim_D = :c, d.Sub_D = :d, ts.Claimant = NULL, ts.Status = 'PENDING_CLAIM' WHERE d.Task_ID = :id");
		$result->bindParam(':c', $_POST['d_stream']);
		$result->bindParam(':d', $_POST['d_submission']);
		$result->bindParam(':id', $_SESSION['t_id']);
		$result->execute();
		header("Location: HomePage.php");
	?>
<?php endif; ?>