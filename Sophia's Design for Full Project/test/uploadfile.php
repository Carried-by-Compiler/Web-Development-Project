<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>File Upload Example</title>
    <meta name="description" content="Answer for question 1">
    <meta name="author" content="asanka">
</head>
    <body>
    <?php
    define ("FILEREPOSITORY","C:\\wamp64\www\pro\\test\\uploaded_files"); //Set a constant
    
    
    if (is_uploaded_file($_FILES['classnotes']['tmp_name'])) { //file posted?

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['classnotes']['tmp_name']);

        if ($mime != "application/pdf") { //is it a pdf?
            echo "<p>Class notes must be uploaded in PDF format.</p>"; 
        
        } else { /* move uploaded file to final destination. */
            
            $name = $_POST['name'];
            $result = move_uploaded_file($_FILES['classnotes']['tmp_name'],  FILEREPOSITORY."//$name.pdf");
            
            if ($result == 1) {
                echo "<p>File successfully uploaded.</p>";
            } else {
                echo "<p>There was a problem uploading the file.</p>";
            }
        } //endIF
    } //endIF
    ?>


	    </body>
</html>
