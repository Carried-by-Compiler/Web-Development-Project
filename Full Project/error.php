<?php

$error_message = htmlspecialchars($_GET['e']);

if ($error_message == 101) {
	
	echo "<h1>This User Has Been Banned</h1>";
	echo "<p>According to our records, the registering user has been banned. Please contact the admin for more details.</p>";
	echo "<a href='index.html'>Click here to return</a>";
	
} else {
	
	echo "<h1>Error!</h1>";
	echo "<p>".$error_message."</p>";
	echo "<a href='index.html'>Click to return</a>";
	
}

?>