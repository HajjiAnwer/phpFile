<?php
 ini_set('display_errors', 1);
    try {
        include 'database_connection.php';
        include 'DatabaseTable.php';
        $jokesTable=new DatabaseTable($pdo,'joke','idjoke');
        $authorTable=new DatabaseTable($pdo,'author','id');
        $result= $jokesTable->findAll();
        $jokes=[];
        foreach($result as $joke)
        {
            $author=$authorTable->findById($joke['authorid']);
            $jokes[]=[
                'idjoke'=>$joke['idjoke'],
                'joketext'=>$joke['joketext'],
                'jokedate'=>$joke['jokedate'],
                'name'=>$author['name']
            ];
        }
        $tite='joke list';
        $totaljoke=$jokesTable->total();
        ob_start();
        include 'output.html.php';
        $output=ob_get_clean();
     
         
       
    } 
    catch (PDOException $e) {
        $output = 'Unable to connect to the database server: ' .
        $e->getMessage() . 'in'. 
        $e->getFile() . ':' . 
        $e->getLine();
    }

   
   include 'head.html.php';
   
    include 'footer.html.php';
?>