<?php
class Joke
{
    public $idjoke;
    public $authorid;
    public $jokedate;
    public $joketext;
    private $authorsTable;
    private $author;
    private $jokeCategoriesTable;
    public function __construct(DatabaseTable $authorsTable,DatabaseTable $jokeCategoriesTable)
    {
        $this->authorsTable = $authorsTable;
        $this->jokeCategoriesTable = $jokeCategoriesTable;
    }
    public function getAuthor()
    {
        if (empty($this->author)) 
        {
            $this->author = $this->authorsTable->findById($this->authorid);
        }
        return $this->author;
    }
    public function addCategory($categoryid) 
    {
        $jokeCat = ['idjoke' => $this->idjoke,
                    'categoryid' => $categoryid];
        $this->jokeCategoriesTable->save($jokeCat);
    }
    public function hasCategory($categoryid) 
    {
        $jokeCategories = $this->jokeCategoriesTable->find('idjoke', $this->idjoke);
        foreach ($jokeCategories as $jokeCategory) 
        {
            if ($jokeCategory->categoryid == $categoryid) 
            {
                return true;
            }
        }
    }
    public function clearCategories() 
    {
        $this->jokeCategoriesTable->deleteWhere('idjoke',$this->idjoke);
    }
}