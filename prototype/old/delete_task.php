<?php

if (!isset($_POST['delete'])) {
	header("Location: home_page.php");
} else {
	require("/connect.php");
	$result = $dbh->prepare("DELETE FROM Tasks WHERE Task_ID = ".$_POST['t_id'].";");
	$result->execute();
	$dbh = null;

	echo "<h1>Deletion successful</h1>";
	echo "<a href='home_page.php'>Home</a>";
}

?>