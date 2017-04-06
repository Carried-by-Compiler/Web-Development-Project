<?php
//Go through all tasks in database and update status depending on current date.

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
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="./css/register.css">
	<script type="text/JavaScript">
		function validateInput()
		{
			var x=document.forms["Register"]["f_name"].value;
			var y=document.forms["Register"]["s_name"].value;
			var z=document.forms["Register"]["email"].value;
			var a=document.forms["Register"]["pass"].value;
			var b=document.forms["Register"]["conpass"].value;
			var txt = "";
			var valid = true;
			//boolean allValid = true;
			
			if(validateName(x))
			{
				txt += "FN Valid\n";
			}
			else
			{
				txt += "FN Not valid\n";
				valid = false;
			}
			
			if(validateName(y))
			{
				txt += "SN Valid\n"
			}
			else
			{
				txt += "SN Not valid\n"
				valid = false;
			}
			
			if(z == "")
			{
				txt = "Please enter an email\n";
				valid = false;
			}
			else if(validateEmail(z))
			{
				txt += "Email Valid\n"
			}
			else
			{
				txt += "Email not valid\n"
				valid = false;
			}
			
			var passValid = false;
			if(a == "")
			{
				txt += "Please enter a password\n";
				valid = false;
			}
			else if(validatePassword(a))
			{
				txt += "Password is okay\n";
				passValid = true;
				
			}
			else
			{
				txt += "Password is invalid\n";
				valid = false;
			}
			
			if(passValid)
			{
				if(b == a)
				{
					txt += "Confirm pass okay\n";
				}
				else
				{
					txt += "Confirm pass not the same as password\n";
					valid = false;
				}
			}
			
			alert(txt);
		
			
			
			//This would be removed and redirect to main page if valid if not will remain on the same page
			if(valid)
			{
				alert("Register is okay");
			}
			else
			{
				alert("Register bad");
			}
			alert(valid);
			return valid;
		}
		
		function validateName(name)
		{
			var alpha = /^[a-zA-Z]+$/;
			return alpha.test(name);
		}
		
		function validateEmail(z)
		{
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(z);
		}
		
		function validatePassword(pass)   
		{   
			var passw=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;  
			return passw.test(pass);
		}
	</script>
</head>
<body>
	<form action="login.php"><input type="submit" value="LogIn"/></form>
	<div class="container">
		<img src="./css/user.png">
		
		<form id='Register' action="insert_user.php" method="post" onsubmit="return validateInput();">
			<div class="form-input">
				<input type="text" name="id" placeholder="Enter University ID" required>
			</div>
			<div class="form-input">
				<input type="text" id='f_name' name="f_name" placeholder="Enter Firstname">
				<input type="text" id='s_name' name="s_name" placeholder="Enter Lastname">
			</div>
			<div class="form-input">
				<input type="text" id='email' name="email" placeholder="Enter Student/Lecturer Email" required>
			</div>
			<div class="form-input">
				<input type="password" id='pass' name="pass" placeholder="Enter Password" required>
			</div>
			<div class="form-input">
				<input type="password" id='conpass' placeholder="Confirm Password"> <!--Add code to confirm password-->
			</div>
			<div class="form-input">
				<li class="dropdown"><a href="#" class="dropdown-btn">Subject</a>
					<div class="dropdown-menu">
						<select name="opt">
						<option value="111">Computer Science</option>
						<option value="222">Engineering</option>
						<option value="333">Mathematics</option>
						<option value="444">Science</option>
						<option value="555">Law</option>
						<option value="666">Business</option>
						</select>	
					</div>
			</div>
				<input type="submit" name="submit" value="REGISTER" class="btn-login">
				<br>
		</form>

	</div>
</body>
</html>	
