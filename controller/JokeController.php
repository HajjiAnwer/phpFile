<?php
ini_set('display_errors', 1);
class JokeController
{
    private $authorsTable;
    private $jokesTable;
    private $authentication;
    private $categoriesTable;
    public function __construct(DatabaseTable $jokesTable,DatabaseTable $authorsTable, Authentication $authentication,DatabaseTable $categoriesTable ) 
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
        $this->authentication=$authentication;
        $this->categoriesTable=$categoriesTable;
    }
    public function list() 
    {
        $page = $_GET['page']    ?? 1;
        $offset = ($page-1)*3;
        if (isset($_GET['category'])) 
        {
            $category = $this->categoriesTable->findById($_GET['category']);
            $jokes = $category->getJokes(3,$offset);
            $totalJokes = $category->getNumJokes();
        }
        else 
        {
            $jokes = $this->jokesTable->findAll('jokedate DESC',3,$offset);
            $totalJokes = $this->jokesTable->total();
        }
        include 'Markdown.php';
        $categories = $this->categoriesTable->findAll();
        $title = 'Joke list';
        $author = $this->authentication->getUser();
        ob_start();
        include __DIR__.'/includeFile/jokes.html.php';
        $output = ob_get_clean();
        return ['template' => 'jokes.html.php', 'title' => $title,
                'variables' => ['totalJokes' => $totalJokes,
                                'jokes' => $jokes,
                                'user' => $author,
                                'categories' => $categories,
                                'currentPage' => $page,
                                'category' => $_GET['category'] ?? null]
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
        $author = $this->authentication->getUser();
        $joke = $this->jokesTable->findById($_POST['id']);
        if ($joke->authorId != $author->id && 
            !$author->hasPermission(Author::DELETE_JOKES)) 
            {
                return;
            }
        $this->jokesTable->delete($_POST['idjoke']);
        header('location: /joke/list');
    }
    public function saveEdit() 
    {
        $author = $this->authentication->getUser();
        $joke = $_POST['joke'];
        $joke['jokedate'] = new \DateTime();
        $jokeEntity=$author->addJoke($joke);
        $jokeEntity->clearCategories();
        foreach ($_POST['category'] as $categoryid) 
        {
            $jokeEntity->addCategory($categoryid);
        }
        header('location: /joke/list');
    }
    public function edit() 
    {
        if (isset($_GET['idjoke'])) 
        {
            $joke = $this->jokesTable->findById($_GET['idjoke']);
        }
        $author = $this->authentication->getUser();
        $categories = $this->categoriesTable->findAll();
        $title = 'Edit joke';
        return ['template' => 'editjoke.html.php',
                'title' => $title,
                'variables' => ['joke' => $joke ?? null,
                                'user' => $author,
                                'categories' => $categories]
               ];
    }
}
