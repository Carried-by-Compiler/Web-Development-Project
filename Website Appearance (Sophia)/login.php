<?php

if (isset($_POST['id']) && isset($_POST['pass'])) {

    require("checkUserExistence.php");
    if (checkUserExistence($_POST['id'], $_POST['pass']) == true) {
        
    	require("connect.php");
    	$result = $dbh->prepare("Select * from users where User_ID = ".$_POST['id']);
        $result->execute();
        echo "<table>";
        echo "<tr><th>User_ID</th><th>FirstName</th><th>LastName</th><th>Email</th><th>Subject</th><th>Reputation Points</th></tr>";
        for ($i = 0; $row = $result->fetch(); $i++) {
        	// TODO get user's homepage from Sophia
        	// Have sessions implemented
        	// Use Object Oriented Approach
            echo "<tr><td>".$row['User_ID']."</td><td>".$row['FirstName']."</td><td>".$row['LastName']."</td><td>".$row['Email']."</td><td>".$row['Subject']."</td><td>".$row['Rep_Points']."</td></tr>";
    	}
    	echo "</table>";
    $dbh = null;


    } else {
        echo "<h1>ID with entered password do not exist</h1>";
        echo "<a href='index.html'>Click here to register</a>";
         echo "<a href='AlternativeLogin.html'>Click here to login again</a>";
    }

} else {
    echo "<h1>Form was not entered properly</h1>";
    echo "<a href='AlternativeLogin.html'>Click here to go back</a>";
}


?>