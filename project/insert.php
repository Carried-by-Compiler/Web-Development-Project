<?php
/*
check if user is already in the database.
if
    it is present, display message and give them link to login.
else
    add user into database.
*/
if (isset($_POST['id'])) {
    require("./loginHelper/checkExists.php");
    $exists = exists($_POST['id']); // TODO redirect user to home page when they type in Insert.php in bar.
    if ($exists == true) {
        echo "<h1>User of entered ID already exists!</h1><br>";
        echo "<a href='index.html'>Click here to login</a>";
    } else {

        try {
            require("./loginHelper/connect.php");
            $result = $dbh->prepare("INSERT INTO users (User_ID, firstname, lastname, email, course, pass_word)
                                     VALUES (:id, :f_name, :l_name, :e, :c, :pass)");
            $result->bindParam(':id', $_POST['id']);
            $result->bindParam(':f_name', $_POST['f_name']);
            $result->bindParam(':l_name', $_POST['s_name']);
            $result->bindParam(':e', $_POST['email']);
            $result->bindParam(':c', $_POST['opt']);
            $result->bindParam(':pass', $_POST['pass']);
            $result->execute();

            session_start();
            $_SESSION['userID'] = $_POST['id'];
            header("Location: userPage.php");
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }

        $dbh = null;

    }

} else {
    header("Location: index.html");
}


 ?>
