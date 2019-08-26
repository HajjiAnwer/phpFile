<?php
ini_set('display_errors', 1);
try 
{
    include __DIR__.'/includeFile/DatabaseConnection.php';
    include __DIR__.'/includeFile/DatabaseTable.php';
    $jokesTable = new DatabaseTable($pdo, 'joke', 'idjoke');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');
    $result =$jokesTable->findAll();
    $jokes = [];
    foreach ($result as $joke) 
    {
        $author =$authorsTable->findById($joke['authorid']);
        $jokes[] = ['idjoke' => $joke['idjoke'],
                    'joketext' => $joke['joketext'],
                    'jokedate' => $joke['jokedate'],
                    'name' => $author['name'],
                ];
    }
    $title = 'Joke list';
    $totalJokes =$jokesTable->total();
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