<?php
ini_set('display_errors', 1);
class JokeController
{
    private $authorsTable;
    private $jokesTable;
    public function __construct(DatabaseTable $jokesTable,DatabaseTable $authorsTable  ) 
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
    }
    public function list() 
    {
        $result =$this->jokesTable->findAll();
        $jokes = [];
        //var_dump ($result);
        foreach ($result as $joke) 
        {
            $author =$this->authorsTable->findById($joke['authorid']);
            $jokes[] = ['idjoke' => $joke['idjoke'],
                        'joketext' => $joke['joketext'],
                        'jokedate' => $joke['jokedate'],
                        'name' => $author['name'],
                    ];
        }
        $title = 'Joke list';
        $totalJokes =$this->jokesTable->total();
        ob_start();
        include __DIR__.'/includeFile/jokes.html.php';
        $output = ob_get_clean();
        return ['template' => 'jokes.html.php', 'title' => $title,
                'variables' => ['totalJokes' => $totalJokes,'jokes' => $jokes]
                ];

    }
    public function home()
    {
        $title = 'Internet Joke Database';
        ob_start();
        include  __DIR__ . '/includeFile/home.html.php';
        $output = ob_get_clean();
        return ['template' => 'home.html.php', 'title' => $title];
    }
    public function delete()
    {
        $this->jokesTable->delete($_POST['idjoke']);
        header('location: /joke/list');
    }
    public function saveEdit() 
    {
        $joke = $_POST['joke'];
        $joke['jokedate'] = new \DateTime();
        $joke['authorId'] = 1;
        $this->jokesTable->save($joke);
        header('location: /joke/list');
    }
    public function edit() 
    {
        if (isset($_GET['idjoke'])) 
        {
            $joke = $this->jokesTable->findById($_GET['idjoke']);
        }
        $title = 'Edit joke';
        return ['template' => 'editjoke.html.php',
                'title' => $title,
                'variables' => ['joke' => $joke ?? null]
               ];
    }
}
