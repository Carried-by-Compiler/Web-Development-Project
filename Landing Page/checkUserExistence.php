<?php


function checkUserIdExistence($i) {
    require("connect.php");

    $result = $dbh->prepare("SELECT COUNT(*) FROM users WHERE User_ID = :i");
    $result->bindParam(':i', $i);

    $result->execute();
    $rows = $result->fetch(PDO::FETCH_NUM);
    if ($rows[0] != 0) {
        return true;
    } else {
        return false;
    }
}

function checkUserExistence($i, $p) {
    require("connect.php");

    $result = $dbh->prepare("SELECT COUNT(*) FROM users WHERE User_ID = :i AND Password = :p"); // CHANGED implement so that any ID can be used.
    $result->bindParam(':i', $i);
    $result->bindParam(':p', $p);
    $result->execute();
    $rows = $result->fetch(PDO::FETCH_NUM);
    if ($rows[0] != 0) {
        return true;
    } else {
        return false;
    }
}

 ?>
