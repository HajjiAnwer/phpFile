<?php
try 
{
    include $_GET['controller'].'.php';
    $action = $_GET['action'] ?? 'home';    
    $controllerName = $_GET['controller'] ?? 'joke';
    if ($action == strtolower($action) &&
        $controllerName == strtolower($controllerName)) 
    {
        $className = ucfirst($controllerName) . 'Controller';
        include  $className . '.php';
        $controller = new $className($jokesTable, $authorsTable);
        $page = $controller->$action();
    }
    else 
    {
        http_response_code(301);
        header('location: index.php?controller=' 
                .strtolower($controllerName) .
                 '&action=' .strtolower($action));
    }
    $title = $page['title'];
    if (isset($page['variables'])) 
    {
        $output = loadTemplate($page['template'],$page['variables']);
    } 
    else 
    {
        $output = loadTemplate($page['template']);
    }
} 
catch (PDOException $e) 
{
    $title = 'An error has occurred';
    $output = 'Database error: ' . 
    $e->getMessage() . ' in '. 
    $e->getFile() . ':' . $e->getLine();
}
  include 'head.html.php';
    include 'footer.html.php';
?>  