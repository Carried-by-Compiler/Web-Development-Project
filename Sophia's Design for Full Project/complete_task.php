<?php 

/*
complete_task.php:

- Update task as complete
- TODO write review for the task

*/

require("/connect.php");

$result = $dbh->prepare("UPDATE Task_Status SET Status = 'COMPLETE' WHERE Task_ID = ".$_POST['t_id']);
$result->execute();

$result = $dbh->prepare("UPDATE Tasks SET Claimant_Review = :d WHERE Task_ID = ".$_POST['t_id']);
$result->bindParam(':d', $_POST['task_review']);
$result->execute();

echo "<h1>Completed Task. Well Done!!!!!!!</h1>";
echo "<a href='HomePage.php'>Home</a>";

?>