<?php

$values = array("title", "type", "format", "words", "pages", "d_stream", "d_submission", "desc");

foreach ($values as $i) {
	echo $_POST[$i]." | ";
}


?>