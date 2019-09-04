<?php
//ini_set('display_errors', 1);
try
{
    include 'EntryPoint.php';
    include 'IjdbRoutes.php';
    include 'Authentication.php';
    include __DIR__ . '/includeFile/Author.php';
    include __DIR__ . '/includeFile/Joke.php';
    include __DIR__ . '/classe/DatabaseTable.php';
    include __DIR__ . '/includeFile/DatabaseConnection.php';
    $jokesTable=new DatabaseTable($pdo,'joke','idjoke','Joke',[&$authorsTables]);
    $authorsTables=new DatabaseTable($pdo,'author','id','Author',[&$jokesTable]);
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    $entryPoint = new EntryPoint($route, $_SERVER['REQUEST_METHOD'], 
    new IjdbRoutes($jokesTable,$authorsTables,new Authentication($authorsTables,'email', 'password')),
    new IjdbRoutes($jokesTable,$authorsTables,new Authentication($authorsTables,'email', 'password')),
    new Authentication($authorsTables,'email', 'password'));
    $entryPoint->run();
} 
catch (PDOException $e) 
{
    $title = 'An error has occurred';
    $output = 'Database error: ' . 
    $e->getMessage() . ' in '. 
    $e->getFile() . ':' . $e->getLine();
    include __DIR__.'/includeFile/layout.html.php';
}