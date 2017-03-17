<?php

session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: index.html");
} 

?>
<!DOCTYPE html>
<html>
<head>
	<title>User's Homepage</title>
</head>
<body>
	<h1><?php echo $_SESSION['user_id']; ?></h1>
	<a href="logout.php">LogOut</a>
</body>
</html>