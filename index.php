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
    $jokesTable = new DatabaseTable($pdo, 'joke', 'idjoke');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    echo $route;
    if ($route == strtolower($route)) 
    {
        if ($route === 'joke/list') 
        {
            include __DIR__.'/controller/JokeController.php';
            $controller = new JokeController($jokesTable,$authorsTable);
            $page = $controller->list();
        } 
        elseif ($route === '') 
        {
            include __DIR__.'/controller/JokeController.php';
            $controller = new JokeController($jokesTable,$authorsTable);
            $page = $controller->home();
        } 
        elseif ($route === 'joke/edit') 
        {
            include __DIR__.'/controller/JokeController.php';
            $controller = new JokeController($jokesTable,$authorsTable);
            $page = $controller->edit();
        } 
        elseif ($route === 'joke/delete') 
        {
            include __DIR__.'/controller/JokeController.php';
            $controller = new JokeController($jokesTable,$authorsTable);
            $page = $controller->delete();
        } 
        elseif ($route === 'register') 
        {
            include __DIR__ .'/controller/RegisterController.php';
            $controller = new RegisterController($authorsTable);
            $page = $controller->showForm();
        }
    } 
    else 
    {
        http_response_code(301);
        header('location: index.php?route=' . strtolower($route));
    }
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