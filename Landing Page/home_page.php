<?php

session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: index.html");
} else {
	require("./models/User.class.php");
	$user = new User($_SESSION['user_id']);
	$_SESSION['user'] = $user;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>User's Homepage</title>
</head>
<body>
	<h1><?php echo $_SESSION['user']->getF_name()." ".$_SESSION['user']->getS_name(); ?></h1>
	<a href="logout.php">LogOut</a>
</body>
</html>