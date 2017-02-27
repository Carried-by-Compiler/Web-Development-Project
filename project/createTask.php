<?php

session_start();
require_once("./models/User.class.php");
if (!isset($_SESSION['userID'])) {
    header("Location: index.html");

}

 ?>

 <!DOCTYPE html>
 <html>
     <head>
         <meta charset="utf-8">
         <title>Task Creation</title>
     </head>
     <body>
        <h1>Create A Task</h1>
        <p>Fill in the details to create a task</p>
        <br>
        <form action="insertTask.php" method="post" id="task_form">
            Enter Type of document: <br>
            <select name="type">
                <option value="Thesis">Thesis</option>
                <option value="Dissertation">Dissertation</option>
                <option value="Assignment">Assignment</option>
                <option value="Research Paper">Research Paper</option>
            </select> <br>
            <br>Enter a tag:<br>
            <input type="text" name="tag"> <br>
            <br>Enter number of pages of the document:<br>
            <input type="number" name="n_of_pages" min="1"> <br>
            <br>Enter number of words of the document:<br>
            <input type="number" name="n_of_words" min="0"> <br>
            <br>File format of document preview:<br>
            <select name="file_type">
                <option value="pdf">PDF</option>
                <option value=".docx">.DOCX</option>
                <option value="doc">DOC</option>
                <option value="open_office">Open Office</option>
            </select> <br>
            <br>Deadline date for display:<br>
            <input type="date" name="deadline_display"> <br>
            <br>Deadline date for task completion:<br>
            <input type="date" name="deadline_task"> <br>
            <br><textarea name="desc" form="task_form">Enter task description here...</textarea> <br>
            <br><input type="submit" name="submit">
        </form>

     </body>
 </html>
