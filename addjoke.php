<?php
ini_set('display_errors', 1);
if (isset($_POST['joketext'])) 
{
    try 
    {
        include __DIR__.'/includeFile/DatabaseConnection.php';
        include 'function.php';
        insert($pdo, 'joke', ['authorid' => 2, 
                            'jokeText' => $_POST['joketext'],
                             'jokedate' => new DateTime()
                             ]);
        header('location: jokes.php');
    } 
    catch (PDOException $e) 
    {
        $title = 'An error has occurred';
        $output = 'Database error: ' . 
        $e->getMessage() . ' in '. 
        $e->getFile() . ':' . $e->getLine();
    }
} 
else 
{
    $title = 'Add a new joke';
    ob_start();
    include  __DIR__ . '/includeFile/addjoke.html.php';
    $output = ob_get_clean();
}
include  __DIR__ . '/includeFile/layout.html.php';