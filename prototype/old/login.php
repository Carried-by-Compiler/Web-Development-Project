<?php
require("/connect.php");
$result = $dbh->prepare("UPDATE Task_Status ts
						 INNER JOIN Deadlines ON ts.Task_ID = Deadlines.Task_ID 
						 SET ts.Status = 'UNCLAIMED'
						 WHERE Deadlines.Claim_D <= CURDATE() AND Status = 'PENDING_CLAIM'");
$result->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="/project/css/login.css">
</head>
<body>
	<form action="index.php"><input type="submit" value="Register"/></form>
	<div class="container">
	<img src="./css/user.png">
		<form method="post" action="login_user.php">
			<div class="form-input">
				<input type="text" name="id" placeholder="Enter University ID">
			</div>
			<div class="form-input">
				<input type="password" name="pass" placeholder="Enter Password">
			</div>
				<input type="submit" name="submit" value="LOGIN" class="btn-login"><br>
				<a href="#">Forget password?</a>
		</form>
	</div>
</body>
</html>	
