<?php

function exists($i_d) {
	require("connect.php");

	$result = $dbh->prepare("SELECT COUNT(*) FROM users WHERE User_ID = :i"); // CHANGED implement so that any ID can be used.
    $result->bindParam(':i', $i_d);
    $result->execute();
    $rows = $result->fetch(PDO::FETCH_NUM);
    if ($rows[0] != 0) {
        return true;
    } else {
        return false;
    }
}



?>