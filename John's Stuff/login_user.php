<?php

if (isset($_POST['id']) && isset($_POST['pass'])) {

	require("checkUserExistence.php");
	if (checkUserExistence($_POST['id'], $_POST['pass']) == true) {
		  
		session_start();
		$_SESSION['user_id'] = $_POST['id'];
		header("Location: home_page.php");
		
		
	} else {
		echo "<h1>ID with entered password do not exist</h1>";
		echo "<a href='index.html'>Click here to register</a>";
	    echo "<a href='login.html'>Click here to login again</a>";
	}

} else {
   echo "<h1>Form was not entered properly</h1>";
   echo "<a href='login.html'>Click here to go back</a>";
}


?>