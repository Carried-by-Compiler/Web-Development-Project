<?php
/**
 *
 */
class User
{
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $course;
    private $password;

    function __construct($ID)
    {
        require("./loginHelper/connect.php");

        $result = $dbh->prepare("Select * from users where User_ID = ".$ID);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $this->id = $row['User_ID'];
            $this->firstname = $row['FirstName'];
            $this->lastname = $row['LastName'];
            $this->email = $row['Email'];
            $this->course = $row['Subject'];
            $this->password = $row['Password'];
        }
        $dbh = null;
    }

    public function getID() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function getAge() {
        return $this->age;
    }

    public function getM() {
        return $this->m;
    }
}

 ?>
