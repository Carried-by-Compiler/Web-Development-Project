<?php

if(!isset($_POST['id'])) {

	header("Location: index.html");

} else {

	require("checkUserExistence.php");
    $exists = checkUserExistence($_POST['id'], $_POST['pass']);  // TODO check if this works.
     if ($exists == true) {
        echo "<h1>User of entered ID already exists!</h1><br>";
        echo "<a href='index.html'>Click here to login</a>";
    } else {

    	try {

    		require("connect.php");
    		$result = $dbh->prepare("INSERT INTO `Users` (User_ID, FirstName, LastName, Email, `Subject`, `Password`)
                                     VALUES (:id, :f_name, :l_name, :e, :c, :pass)");
    		$result->bindParam(':id', $_POST['id']);
            $result->bindParam(':f_name', $_POST['f_name']);
            $result->bindParam(':l_name', $_POST['s_name']);
            $result->bindParam(':e', $_POST['email']);
            $result->bindParam(':c', $_POST['opt']);
            $result->bindParam(':pass', $_POST['pass']);
            $result->execute();

            echo "Added successfully";

    	} catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        } finally {
        	$dbh = null;
        }

    }
}


?>