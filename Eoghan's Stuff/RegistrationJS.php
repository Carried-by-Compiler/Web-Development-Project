<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="ForAlternativeRegister.css">
</head>
<body>
	<div class="container">
	<img src="./css/user.png">
		<form name="Register" action="index.php" method="post" onsubmit="return Validate()">
			
			<div class="form-input">
				<input type="text" name="id" placeholder="Enter University ID" class="input">
				<div id="id_error" class="val_error"></div>
			</div>
			
			<div class="form-input">
				<input type="text" name="f_name" placeholder="Enter Firstname" class="input">
				<div id="name_error" class="val_error"></div>
				<input type="text" name="s_name" placeholder="Enter Lastname" class="input">
				<div id="sName_error" class="val_error"></div>
			</div>
			
			<div class="form-input">
				<input type="text" name="email" placeholder="Enter Student/Lecturer Email" class="input">
				<div id="email_error" class="val_error"></div>
			</div>
			
			<div class="form-input">
				<input type="password" name="pass" placeholder="Enter Password" class="input">
				<div id="password_error" class="val_error"></div>
			</div>
			
			
			<div class="form-input">
				<input type="password" name="confirmPass" placeholder="Confirm Password" class="input"> <!--Add code to confirm password-->
			</div>
			
			<div class="form-input">
				<li class="dropdown"><a href="#" class="dropdown-btn">Subject</a>
					<div class="dropdown-menu">
						<select name="opt">
						<option value"1">Computer Science</option>
						<option value"2">Engineering</option>
						<option value"3">Mathematics</option>
						</select>	
					<div id="dropdown_error" class="val_error"></div>
					</div>
			</div>
				<input type="submit" name="submit" value="REGISTER" class="btn-login"><br>
		</form>
	</div>
</body>
</html>	

<script type="text/JavaScript">
	var userNumber = document.forms["Register"]["id"];
	var fName = document.forms["Register"]["f_name"];
	var sName = document.forms["Register"]["s_name"];
	var userEmail = document.forms["Register"]["email"];
	var password = document.forms["Register"]["pass"];
	var confirmPass = document.forms["Register"]["confirmPass"];
	var dropdown = document.forms["Register"]["opt"];
	
	var id_error = document.getElementById("id_error");
	var name_error = document.getElementById("name_error");
	var email_error = document.getElementById("email_error");
	var password_error = document.getElementById("password_error");
	
	//username.addEventListener("blur", nameVerify, true);
	//userEmail.addEventListener("blur", emailVerify, true);
	
	function Validate()
	{
		var fPattern = /^[a-zA-Z]{3,}$/;
		var passwordPattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
		var idPattern = /^[0-9]{3,9}$/;
		
		if(userNumber.value == "")
		{
			id_error.textContent = "User number is required";
			userNumber.style.border = "1px solid red";
			userNumber.focus();
			return false;
		}
		if(!(idPattern.test(userNumber.value)))
		{
			id_error.textContent = "User number is invalid format";
			userNumber.style.border = "1px solid red";
			userNumber.focus();
			return false;
		}
		if(fName.value == "")
		{
			name_error.textContent = "First name is required";
			fName.style.border = "1px solid red";
			fName.focus();
			return false;
		}
		if(!(fPattern.test(fName.value)))
		{
			name_error.textContent = "First Name is invalid";
			fName.style.border = "1px solid red";
			fName.focus();
			return false;
		}
		if(sName.value == "")
		{
			name_error.textContent = "Surname is required";
			sName.style.border = "1px solid red";
			sName.focus();
			return false;
		}
		if(!(fPattern.test(sName.value)))
		{
			name_error.textContent = "Surname is invalid";
			fName.style.border = "1px solid red";
			fName.focus();
			return false;
		}
		if(email.value == ""){
			email_error.textContent = "Email is required";
			email.style.border = "1px solid red";
			email.focus();
			return false;
		}

		if (password.value != confirmPass.value) {
			password_error.textContent = "The two passwords do not match";
			password.style.border = "1px solid red";
			confirmPass.style.border = "1px solid red";
			password.focus();
			return false;
		}

		if (password.value == "" || confirmPass.value == "") {
			password_error.textContent = "Password required";
			password.style.border = "1px solid red";
			confirmPass.style.border = "1px solid red";
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
		
	function nameVerify(){
		if (username.value != "") {
			name_error.innerHTML = "";
			username.style.border = "1px solid #110E0F";
			return true;
		}
	}
	
	function emailVerify(){
		if (email.value != "") {
			email_error.innerHTML = "";
			email.style.border = "1px solid #110E0F";
			return true;
		}
	}
</script>