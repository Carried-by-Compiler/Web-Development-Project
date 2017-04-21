var id = document.forms["LoginPage"]["id"];
var pass  = document.forms["LoginPage"]["pass"];

// Error display messgaes
var ID_error    = document.getElementById("ID_error");
var password_error = document.getElementById("password_error");



//Event Listeners
id.addEventListener("blur", idVerify, true);

function ValidateInfo()
{
	var passwordPattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
	var idPattern = /^[0-9]{3,9}$/;
	
	if(id.value == "")
	{
		ID_error.textContent = "ID number is required";
		id.style.border = "1px solid red";
		id.focus();
		return false;
	}
	
	if(!(idPattern.test(id.value)))
	{
		ID_error.textContent = "ID is invalid";
		id.style.border = "1px solid red";
		id.focus();
		return false;
	}
	
	if(pass.value == "")
	{
		password_error.textContent = "Password is required";
		pass.style.border = "1px solid red";
		pass.focus();
		return false;
	}
	
	if(!(passwordPattern.test(pass.value)))
	{
		password_error.textContent = "Password is incorrect format";
		pass.style.border = "1px solid red";
		pass.focus();
		return false;
	}
}

function idVerify()
{
	if (id.value != "") 
	{
		name_error.innerHTML = "";
		username.style.border = "1px solid #110E0F";
		return true;
	}
}