<?php
ini_set('display_errors', 1);
include __DIR__ . '/includeFile/DatabaseConnection.php';
include 'function.php';
try 
{
    if (isset($_POST['joke'])) 
    {
        $joke = $_POST['joke'];
        $joke['jokedate'] = new DateTime();
        $joke['authorId'] = 1;
        save($pdo, 'joke', 'idjoke', $joke);
        header('location: jokes.php');
    } 
    else 
    {
        if (isset($_GET['idjoke'])) 
        {
            $joke = findById($pdo, 'joke', 'idjoke', $_GET['idjoke']);
        }
        $title = 'Edit joke';
        ob_start();
        include  __DIR__ . '/includeFile/editjoke.html.php';
        $output = ob_get_clean();
    }
} 
catch (PDOException $e) 
{
    $title = 'An error has occurred';
    $output = 'Database error: ' . 
    $e->getMessage() . 'in ' . 
    $e->getFile() . ':' . 
    $e->getLine();
}
include  __DIR__ . '/includeFile/layout.html.php';