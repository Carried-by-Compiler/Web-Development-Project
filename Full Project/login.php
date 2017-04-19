<?php
require("/connect.php");
$result = $dbh->prepare("UPDATE Task_Status ts
						 INNER JOIN Deadlines ON ts.Task_ID = Deadlines.Task_ID 
						 SET ts.Status = 'UNCLAIMED'
						 WHERE Deadlines.Claim_D <= CURDATE() AND Status = 'PENDING_CLAIM'");
$result->execute();

/*$result = $dbh->prepare("UPDATE Task_Status ts
						 INNER JOIN Deadlines ON ts.Task_ID = Deadlines.Task_ID 
						 SET ts.Status = 'FAILED'
						 WHERE Deadlines.Claim_D <= CURDATE() AND Status = 'CLAIMED'");
$result->execute();*/
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="./css/login.css">
	<script type="text/JavaScript">
		function validateInfo()
		{
			var x=document.forms["LoginPage"]["id"].value;
			var y=document.forms["LoginPage"]["userpassword"].value;
			var txt = "";
			var valid = true;
			if (validateID(x))
			{
				txt += "id is valid\n";
			}
			else
			{
				txt += "id not valid\n";
				valid = false;
			}
			
			if(CheckPassword(y))
			{
				txt += "Password is okay\n";
			}
			else
			{
				txt += "Password is not okay\n";
				valid = false;
			}
			
			
			alert(txt);
			
			//place holder for where to go next
			if(valid)
			{
				alert("Login okay");
			}
			else
			{
				alert("Login not okay");
			}
			return valid;
			
		}
		
		function validateID(email)
		{
			 var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			 
			 return !isNaN(email);
		}
		
		function CheckPassword(inputtxt)   
		{   
			var passw=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;  
			return passw.test(inputtxt);
		}
	</script>
</head>
<body>
	<form action="index.php"><input type="submit" value="Register"/></form>
	<div class="container">
	<img src="./css/user.png">
		<form id='LoginPage' method="post" action="login_user.php" onsubmit="return validateInfo();">
			<div class="form-input">
				<input type="text" id="id" name="id" placeholder="Enter University ID">
			</div>
			<div class="form-input">
				<input type="password" id='userpassword' name="pass" placeholder="Enter Password">
			</div>
				<input type="submit" name="submit" value="LOGIN" class="btn-login"><br>
		</form>
	</div>
</body>
</html>	
