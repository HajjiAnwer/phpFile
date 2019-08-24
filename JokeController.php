<?php
ini_set('display_errors', 1);
class JokeController{
    private $jokesTable;
    private $authorsTable;
    public function __construct(DatabaseTable $jokesTable,DatabaseTable $authorsTable)
    {
        $this->jokesTable=$jokesTable;
        $this->authorsTable=$authorsTable;
    }
    public function list()
    {
        $result= $this->jokesTable->findAll();
        $jokes=[];
        foreach($result as $joke)
        {
            $author=$this->authorsTable->findById($joke['authorid']);
            $jokes[]=[
                'idjoke'=>$joke['idjoke'],
                'joketext'=>$joke['joketext'],
                'jokedate'=>$joke['jokedate'],
                'name'=>$author['name']
            ];
        }
        $title='joke list';
        $totaljokes=$this->jokesTable->total();
        ob_start();
        include 'output.html.php';
        $output=ob_get_clean();
        return ['template' => 'output.html.php','title' => $title,
                'variables' => ['totaljokes' => $totaljokes,'jokes' => $jokes]
                ];
    }
    public function home() 
    {
        $title = 'Internet Joke Database';
        ob_start();
        include  __DIR__ . '/../templates/home.html.php';
        $output = ob_get_clean();
        return ['template' => 'home1.html.php', 'title' => $title];
    }
    public function delete() 
    {
        $this->jokesTable->delete($_POST['idjoke']);
        header('location:/joke/list');
    }
    public function edit() 
    {
        if (isset($_POST['joke'])) 
        {
            $joke = $_POST['joke'];
            $joke['jokedate'] = new DateTime();
            $joke['authorId'] = 1;
            $this->jokesTable->save($joke);
            header('location: /joke/list');
        }
        else 
        {
            if (isset($_GET['idjoke'])) 
            {
                $joke = $this->jokesTable->findById($_GET['idjoke']);
            }
            $title = 'Edit joke';
            ob_start();
            include 'addjoke.html.php';
            $output = ob_get_clean();
            return ['template' => 'addjoke.html.php','title' => $title,
                    'variables' => ['joke' => $joke ?? null]
                    ];
        }
    }
}
?>