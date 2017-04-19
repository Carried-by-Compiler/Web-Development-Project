<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
	

</head>
<body>
	<div id="wrapper">
	<!<img src="./css/user.png">
		<form name="LoginPage" method="post" action="index.php" onsubmit="return ValidateInfo()">
			
			<div >
				<input type="text" name="number" placeholder="Enter University ID" class="textInput">
				<div id="ID_error" class="val_error"></div>
			</div>
			
			<div >
				<input type="password" name="password" placeholder="Enter Password" class="textInput">
				<div id="password_error" class="val_error"></div>
			</div>
				
				<input type="submit" name="submit" value="LOGIN" class="btn">
		</form>
	</div>
</body>
</html>	

<script type="text/JavaScript">
	
	//Changes the values into text
	var number = document.forms["LoginPage"]["number"];
	var password  = document.forms["LoginPage"]["password"];
	
	// Error display messgaes
	var ID_error    = document.getElementById("ID_error");
	var password_error = document.getElementById("password_error");
	


	//Event Listeners
	number.addEventListener("blur", idVerify, true);
	
	function ValidateInfo()
	{
		var passwordPattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
		var idPattern = /^[0-9]{3,7}$/;
		
		if(number.value == "")
		{
			ID_error.textContent = "ID number is required";
			number.style.border = "1px solid red";
			number.focus();
			return false;
		}
		
		if(!(idPattern.test(number.value)))
		{
			ID_error.textContent = "ID is invalid";
			number.style.border = "1px solid red";
			number.focus();
			return false;
		}
		
		if(password.value == "")
		{
			password_error.textContent = "Password is required";
			password.style.border = "1px solid red";
			password.focus();
			return false;
		}
		
		if(!(passwordPattern.test(password.value)))
		{
			password_error.textContent = "Password is incorrect format";
			password.style.border = "1px solid red";
			password.focus();
			return false;
		}
	}
	
	function idVerify()
	{
		if (number.value != "") 
		{
			name_error.innerHTML = "";
			username.style.border = "1px solid #110E0F";
			return true;
		}
	}

</script>