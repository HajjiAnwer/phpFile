<?php
ini_set('display_errors', 1);
include __DIR__ . '/includeFile/DatabaseConnection.php';
include 'function.php';
try 
{
    if (isset($_POST['joketext'])) 
    {
        updateJoke($pdo, ['idjoke' => $_POST['idjoke'],
                   'joketext' => $_POST['joketext'],
                   'authorid' => 2]);
        header('location: jokes.php');
    } 
    else 
    {
        $joke = getJoke($pdo, $_GET['idjoke']);
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