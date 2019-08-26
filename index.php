<?php
ini_set('display_errors', 1);
function loadTemplate($templateFileName, $variables = [])
{
    extract($variables);
    ob_start();
    include __DIR__.'/includeFile/'.$templateFileName;
    return ob_get_clean();
}
try
{
    include __DIR__.'/includeFile/DatabaseConnection.php';
    include __DIR__.'/includeFile/DatabaseTable.php';
    include 'JokeController.php';
    $jokesTable = new DatabaseTable($pdo, 'joke', 'idjoke');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');
    $jokeController = new JokeController($jokesTable,$authorsTable);
    $action = $_GET['action'] ?? 'home';
    $page = $jokeController->$action();
    $title = $page['title'];
    if (isset($page['variables'])) 
    {
        $output=loadTemplate($page['template'],$page['variables']);
    }
    else{
        $output=loadTemplate($page['template']);
    }
} 
catch (PDOException $e) 
{
    $title = 'An error has occurred';
    $output = 'Database error: ' . 
    $e->getMessage() . ' in '. 
    $e->getFile() . ':' . $e->getLine();
}
include __DIR__.'/includeFile/layout.html.php';