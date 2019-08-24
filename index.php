
<?php
ini_set('display_errors', 1);
try 
{
    include 'EntryPoint.php';
    include 'IjdbRoutes.php';
    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
    $entryPoint = new EntryPoint($route,new IjdbRoutes());
    $entryPoint->run();
} 
catch (PDOException $e) 
{
    $title = 'An error has occurred';
    $output = 'Database error: ' . 
    $e->getMessage() . ' in '. 
    $e->getFile() . ':' . $e->getLine();
    include 'head.html.php';
include 'footer.html.php';
}
?>