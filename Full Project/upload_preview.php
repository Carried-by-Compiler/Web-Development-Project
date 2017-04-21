<?php 
	require("./models/User.class.php");
	session_start();

	if (!isset($_SESSION['user'])) {
		header("Location: index.html");
	}
	
	require("checkUserExistence.php");
		
	$banned = checkIfBanned($_SESSION['user_id']);
	if ($banned == true) {
		header("Location: error.php?e=101");
	}
	
	if (!isset($_FILES['classnotes']['tmp_name'])) {
		echo "<h1>No file was uploaded!</h1>";
		echo "<a href='HomePage.php'>Return to HomePage</a>";
	}

	//define ("FILEREPOSITORY","C:/wamp64/www/pro/test/uploaded_files"); //Set a constant (localhost)
	define ('SITE_ROOT', realpath(dirname(__FILE__))); // define ('SITE_ROOT', realpath(dirname(__FILE__)));

	
	if (is_uploaded_file($_FILES['classnotes']['tmp_name'])) { //file posted?
	
		$format = $_POST['format'];
		
		
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $_FILES['classnotes']['tmp_name']);
		$correct = true;
		switch ($format) {
			case "pdf":
				if ($mime != "application/pdf") {
					echo "<h1>File must be in pdf</h1>";
					$correct = false;
				}
					
				break;
			case "doc":
				if ($mime != "application/msword") {
					echo "<h1>File must be in doc</h1>";
					$correct = false;
				}
					
				break;
			case "docx":
				if ($mime != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
					echo "<h1>File must be in docx</h1>";
					$correct = false;
				}
					
				break;
		}
		
		if ($correct == true) {
			
			if ($mime != "application/pdf" &&
				$mime != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" &&
				$mime != "application/msword") { 
			echo "<h1>Class notes must be uploaded in PDF/DOCX/DOC format.</h1>"; 
			echo "<a href='HomePage.php'>Return to home page</a>";
			$correct = false;
		
			}

			if ($correct == true) { /* move uploaded file to final destination. */
				
				$name = $_POST['t_id'];
				$result = move_uploaded_file($_FILES['classnotes']['tmp_name'],  SITE_ROOT."\\uploaded_files\\$name.".$_POST['format']);
				
				if ($result == 1) {
					echo "<h1>File successfully uploaded.</h1>";
					echo "<a href='HomePage.php'>Return to home page</a>";
				} else {
					echo "<p>There was a problem uploading the file.</p>";
					echo "<a href='HomePage.php'>Return to home page</a>";
				}
			}
			
		}
	}

?>