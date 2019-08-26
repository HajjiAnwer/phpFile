<?php
ini_set('display_errors', 1);
try 
{
    include __DIR__ . '/includeFile/DatabaseConnection.php';
    include __DIR__.'/includeFile/DatabaseTable.php';
    $jokesTable = new DatabaseTable($pdo, 'joke', 'idjoke');
    $jokesTable->delete($_POST['idjoke']);
    header('location: jokes.php');
}
catch (PDOException $e) 
{
    $title = 'An error has occurred';
    $output = 'Unable to connect to the database server: ' .
    $e->getMessage() . ' in '. 
    $e->getFile() . ':' . $e->getLine();
}
include  __DIR__ . '/includeFile/layout.html.php';