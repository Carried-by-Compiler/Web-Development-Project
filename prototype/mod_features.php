<?php

require("/models/User.class.php");
require("/connect.php");


session_start();

if (!isset($_POST['delete']) && !isset($_POST['seen']) && !isset($_POST['ban']) && !isset($_POST['unban'])) {
	header("Location: HomePage.php");
} else {

	if (isset($_POST['delete'])) {
	
		$result = $dbh->prepare("DELETE FROM Tasks WHERE Task_ID = ".$_POST['t_id'].";");
		$result->execute();

		echo "<h1>Deletion successful</h1>";
		echo "<a href='HomePage.php'>Home</a>";

	} else if (isset($_POST['seen'])) {

		$result = $dbh->prepare("UPDATE Flagged_Tasks SET Review_Status = 'CHECKED' WHERE Task_ID = ".$_POST['t_id'].
								 " AND Flagger = ". $_POST['f_id']);
		$result->execute();
		$dbh = null;

		header("Location: HomePage.php");

	} else if (isset($_POST['ban'])) {

		// Get the id of owner of the flagged task and insert the user_id into the banned_user table
		$result_ban_user = $dbh->prepare("INSERT INTO Banned_Users (Banned_User, Banner, Date_Banned, Ban_Desc) VALUES 
										  (:uid, :bid, NOW(), :d);");

		$result = $dbh->prepare("SELECT t.Owner 
								 FROM Tasks t JOIN Flagged_Tasks ft ON t.Task_ID = ft.Task_ID
								 WHERE ft.Task_ID = :tid AND Flagger = :fid");
		$result->bindParam(':tid', $_POST['t_id']);
		$result->bindParam('fid', $_POST['f_id']);
		$result->execute();
		$row = $result->fetch(PDO::FETCH_ASSOC);

		$user_id = $row['Owner'];
		$banner_id = $_SESSION['user']->getId();

		$result_ban_user->bindParam(':uid', $user_id);
		$result_ban_user->bindParam(':bid', $banner_id);
		$result_ban_user->bindParam(':d', $_POST['desc']);
		$result_ban_user->execute();

		$r = $dbh->prepare("UPDATE Flagged_Tasks SET Review_Status = 'CHECKED' WHERE Task_ID = ".$_POST['t_id'].
							" AND Flagger = ". $_POST['f_id']);
		$r->execute();


		header("Location: HomePage.php");

	} else if (isset($_POST['unban'])) {

		$result = $dbh->prepare("DELETE FROM Banned_Users WHERE Banned_User = :id");
		$result->bindParam(':id', $_POST['uid']);
		$result->execute();

		header("Location: HomePage.php");
	}
}

?>