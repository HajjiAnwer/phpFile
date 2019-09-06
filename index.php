<?php
//ini_set('display_errors', 1);
try
{
    include 'EntryPoint.php';
    include 'IjdbRoutes.php';
    include 'Authentication.php';
    include __DIR__ . '/includeFile/Author.php';
    include __DIR__ . '/controller/Joke.php';
    include __DIR__ . '/includeFile/category.php';
    include __DIR__ . '/classe/DatabaseTable.php';
    include __DIR__ . '/includeFile/DatabaseConnection.php';
    //include __DIR__ . '/controller/Category.php';
    $jokeCategoriesTable=new DatabaseTable($pdo,'jokecategory','categoryid');
    $jokesTable=new DatabaseTable($pdo,'joke','idjoke','Joke',[&$authorsTable,&$jokeCategoriesTable]);
    $authorsTable=new DatabaseTable($pdo,'author','id','Author',[&$jokesTable]);
    $categoriesTable=new DatabaseTable($pdo,'category','id');
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    $entryPoint = new EntryPoint($route, $_SERVER['REQUEST_METHOD'], 
    new IjdbRoutes($jokesTable,$authorsTable,new Authentication($authorsTable,'email', 'password'),$categoriesTable,$jokeCategoriesTable),
    new IjdbRoutes($jokesTable,$authorsTable,new Authentication($authorsTable,'email', 'password'),$categoriesTable,$jokeCategoriesTable),
    new Authentication($authorsTable,'email', 'password'));
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