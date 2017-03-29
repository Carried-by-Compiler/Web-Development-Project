<?php 

$to = "15167798@studentmail.ul.ie";
$subject = "Sample Mail";

$message = "<h1>It Worked!!!</h1>";
$message .= "<p>Awesome it automatically sends emails. Time to use this for you project lol xD</p>";

$retval = mail($to, $subject, $message);

if ($retval == true) {
	echo "<h1>Message Sent Succesfully</h1>";
} else {
	echo "Message could not be sent..";
}


?>