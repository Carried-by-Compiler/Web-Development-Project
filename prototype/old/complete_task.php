<?php 

/*
complete_task.php:

- Update task as complete
- TODO write review for the task

*/

require("/connect.php");

$result = $dbh->prepare("UPDATE Task_Status SET Status = 'COMPLETE' WHERE Task_ID = ".$_POST['t_id']);
$result->execute();

echo "<h1>Completed Task. Well Done!!!!!!!</h1>";
echo "<a href='home_page.php'>Home</a>";

?>