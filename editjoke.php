<?php
ini_set('display_errors', 1);
try 
{
    include __DIR__ . '/includeFile/DatabaseConnection.php';
    include __DIR__ . '/includeFile/DatabaseTable.php';
    $jokesTable = new DatabaseTable($pdo, 'joke', 'idjoke');
    if (isset($_POST['joke'])) 
    {
        $joke = $_POST['joke'];
        $joke['jokedate'] = new DateTime();
        $joke['authorId'] = 1;
        $jokesTable->save($joke);
        header('location: jokes.php');
    } 
    else 
    {
        if (isset($_GET['idjoke'])) 
        {
            $joke = $jokesTable->findById($_GET['idjoke']);
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