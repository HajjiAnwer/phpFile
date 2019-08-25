<?php
ini_set('display_errors', 1);
try 
{
    include __DIR__.'/includeFile/DatabaseConnection.php';
    include 'function.php';
    $jokes = allJokes($pdo);
    $title = 'Joke list';
    $totalJokes=totalJokes($pdo);
    ob_start();
    include __DIR__.'/includeFile/jokes.html.php';
    $output = ob_get_clean();
} 
catch (PDOException $e) 
{
    $title = 'An error has occurred';
    $output = 'Database error: ' . 
    $e->getMessage() . 'in ' 
    .$e->getFile() . ':' . $e->getLine();
}
include __DIR__.'/includeFile/layout.html.php';