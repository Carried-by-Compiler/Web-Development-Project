<?php

session_start();
if (!isset($_SESSION['user']) || !isset($_POST['submit'])) {

	header("Location: index.php");

} else {
	
	try {
		require("connect.php");
		$query = "INSERT INTO Tasks (Owner, Date_Created, Title, Type, Description, Pages, Words, Format)
	   	 	  VALUES
	   	      (:owner, NOW(), :title, :type, :d, :p, :w, :f);";
		$result = $dbh->prepare($query);

		$result->bindParam(':owner', $_SESSION['user_id']);
		$result->bindParam(':title', $_POST['title']);
		$result->bindParam(':type', $_POST['type']);
		$result->bindParam(':d', $_POST['desc']);
		$result->bindParam(':p', $_POST['pages']);
		$result->bindParam(':w', $_POST['words']);
		$result->bindParam(':f', $_POST['format']);
		
		$result->execute();
		
		$last = $dbh->lastInsertID();

		$query = "INSERT INTO Deadlines (Task_ID, Claim_D, Sub_D)
				  VALUES (:id, :c, :s)";
		$deadlinesInput = $dbh->prepare($query);
		$deadlinesInput->bindParam('id', $last);
		$deadlinesInput->bindParam(':c', $_POST['d_stream']);
		$deadlinesInput->bindParam(':s', $_POST['d_submission']);
		$deadlinesInput->execute();

		$query = "INSERT INTO Task_Status (Task_ID)
				  VALUES (:i)";
		$task_status = $dbh->prepare($query);
		$task_status->bindParam(':i', $last);
		$task_status->execute();

		echo "<h1>Task Added Successfully</h1>";
		echo "<a href='HomePage.php'>Return to Home</a>";

		$dbh = null;
		
	} catch (PDOException $exception) {
		header("Location: error.php?e=$exception->getMessage()");
	}
	

	//define ("FILEREPOSITORY","C:/wamp64/www/pro/test/uploaded_files"); //Set a constant
	define ('SITE_ROOT', realpath(dirname(__FILE__)));
    
    
    if (is_uploaded_file($_FILES['classnotes']['tmp_name'])) { //file posted?

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['classnotes']['tmp_name']);

        if ($mime != "application/pdf" &&
            $mime != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" &&
            $mime != "application/msword") { 
            echo "<p>Class notes must be uploaded in PDF/DOCX/DOC format.</p>"; 
        
        } else { /* move uploaded file to final destination. */
            
            $name = $last;
            $result = move_uploaded_file($_FILES['classnotes']['tmp_name'],  SITE_ROOT."\\uploaded_files\\$name.".$_POST['format']);
            
            if ($result == 1) {
                echo "<p>File successfully uploaded.</p>";
            } else {
                echo "<p>There was a problem uploading the file.</p>";
            }
        } //endIF
    } //endI

	

}




?>