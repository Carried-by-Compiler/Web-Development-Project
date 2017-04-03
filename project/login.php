<?php

/*
Check if the user is registred in database.
If registered:
    check password
    if correct:
        go to their page
    else:
        display error message and give them link back to homepage
else :
    Display error message and give them link back to home page.
*/
if (isset($_POST['id']) && isset($_POST['pass'])) {

    require("./loginHelper/checkExists.php");
    require("./loginHelper/passwordChecker.php");
    $exists = exists($_POST['id']);
    if ($exists == true) {
        if (checkPassword($_POST['id'], $_POST['pass']) == true) {
            session_start();
            $_SESSION['userID'] = $_POST['id'];
            header("Location: userPage.php");
        } else {
            echo "<h1>ID with entered password do not exist</h1>";
            echo "<a href='index.html'>Click here to register</a>";
        }

    } else {
        echo "User with this ID does not exist<br>";
        echo "<a href='index.html'>Click here to register</a>";
    }

} else {
    echo "<h1>Form was not entered properly</h1>";
    echo "<a href='index.html'>Click here to go back</a>";
}

 ?>
