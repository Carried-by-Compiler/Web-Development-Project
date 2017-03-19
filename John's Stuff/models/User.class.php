<?php
class User
{
	private $id;
	private $f_name;
	private $s_name;
	private $email;
	private $subject;
	private $points;

	function __construct($id)
	{
		require("/connect.php");
		$query = "SELECT *
				  FROM Users
				  WHERE User_ID = $id";
		$result = $dbh->prepare($query);
		$result->execute();

		while($row = $result->fetch(PDO::FETCH_ASSOC)) 
		{
			$this->id = $row['User_ID'];
			$this->f_name = $row['FirstName'];
			$this->s_name = $row['LastName'];
			$this->email = $row['Email'];
			$this->subject = $row['Subject'];
			$this->points = $row['Rep_Points'];
		}
		$dbh = null;
	}

	public function getId(){
		return $this->id;
	}

	public function getF_name(){
		return $this->f_name;
	}

	public function getS_name(){
		return $this->s_name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getSubject(){
		return $this->subject;
	}

	public function getPoints(){
		return $this->points;
	}

	public function setPoints($p){
		require("/connect.php");
		$query = "UPDATE Users
				  SET Rep_Points = Rep_Points + $p
				  WHERE User_ID = $this->id";
		$result = $dbh->prepare($query);
		$result->execute();

		$query = "SELECT Rep_Points
				  FROM Users
				  WHERE User_ID = $this->id";
		$r = $dbh->prepare($query);
		$r->execute();

		while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
			$this->points = $row['Rep_Points'];
		}
		$dbh = null;
	}

}
?>