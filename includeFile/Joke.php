<?php
class Joke
{
    public $idjoke;
    public $authorid;
    public $jokedate;
    public $joketext;
    private $authorsTable;
    private $author;
    public function __construct(DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
    }
    public function getAuthor()
    {
        if (empty($this->author)) 
        {
            $this->author = $this->authorsTable->findById($this->authorid);
        }
        return $this->author;
    }
}