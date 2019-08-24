<?php
ini_set('display_errors', 1);
try{
include 'database_connection.php';
include 'DatabaseTable.php';
$jokesTable=new DatabaseTable($pdo,'joke','idjoke');
    if(isset($_POST['joke']))
    {
        $joke=$_POST['joke'];
        $joke['jokedat']=new DataTime();
        $joke['authorid']=1;
        $jokesTable->save($joke);
        header('location: joke.php');                                                                                                                                                                                                                                                  
        
    }
    else{
        if (isset($_GET['idjoke'])) 
        {
            $joke = $jokesTable->findById($_GET['idjoke']);
        }
        $title = 'Edit joke';
        ob_start();
        include 'addjoke.html.php';
        $output = ob_get_clean();
    }
}
catch(PDOException $e)
{
        $title='An error has occured';
        $output='Database error'. $e->getMessage(). 'in'. 
        $e->getFile(). ':'. $e->getLine();
        }
    include 'head.html.php';
    include 'footer.html.php';

?>