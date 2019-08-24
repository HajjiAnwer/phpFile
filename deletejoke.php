<?php
ini_set('display_errors', 1);
    try {
        include 'database_connection.php';
        include 'DatabaseTable.php';
        $jokesTable=new DatabaseTable($pdo,'joke','idjoke');
        $jokesTable->delete($_POST['idjoke']);
        header('location: joke.php');}
    catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = 'Unable to connect to the database server: ' .
         $e->getMessage() . ' in '. $e->getFile() . ':' . $e->getLine();}

include 'head.html.php';
include 'footer.html.php';

?>