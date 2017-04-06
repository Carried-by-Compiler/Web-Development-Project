<?php

session_start();

if (!isset($_SESSION['user'])) {
	header("Location: index.php");
} else {
	require("/connect.php");
	$rating = $_POST['review'];
	$result = $dbh->prepare("UPDATE Task_Status SET Rating = :r WHERE Task_ID = :id");
	$result->bindParam(':r', $_POST['review']);
	$result->bindParam(':id', $_POST['t_id']);
	$result->execute();
	
	$get_rep_points = $dbh->prepare("SELECT Rep_Points FROM Users WHERE User_ID = ".$_POST['u_id']);
	$get_rep_points->execute();
	$row = $get_rep_points->fetch(PDO::FETCH_ASSOC);
	$totalPoints = $row['Rep_Points'];
	
	if ($_POST['review'] == 'HAPPY') {
		$total = $totalPoints + 5;
	} else {
		$total = $totalPoints - 5; 
	}
	
	$rep_points_result = $dbh->prepare("UPDATE Users SET Rep_Points = :points WHERE User_ID = :i");
	$rep_points_result->bindParam(":points", $total);
	$rep_points_result->bindParam(":i", $_POST['u_id']);
	$rep_points_result->execute();
	
	header("Location: my_tasks.php");
}
?>