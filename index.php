<?php
//ini_set('display_errors', 1);
try
{
    include 'EntryPoint.php';
    include 'IjdbRoutes.php';
    include 'Authentication.php';
    include __DIR__ . '/classe/DatabaseTable.php';
    include __DIR__ . '/includeFile/DatabaseConnection.php';
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    $entryPoint = new EntryPoint($route, $_SERVER['REQUEST_METHOD'], 
    new IjdbRoutes(new DatabaseTable($pdo,'joke', 'idjoke'),
                   new DatabaseTable($pdo,'author', 'id'),
                   new Authentication(new DatabaseTable($pdo,'author', 'id'),
                                      'email', 'password')
                  ),
    new IjdbRoutes(new DatabaseTable($pdo,'joke', 'idjoke'),
                   new DatabaseTable($pdo,'author', 'id'),
                   new Authentication(new DatabaseTable($pdo,'author', 'id'),
                                       'email', 'password')),
    new Authentication(new DatabaseTable($pdo,'author', 'id'),
                                       'email', 'password')              
                  );
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