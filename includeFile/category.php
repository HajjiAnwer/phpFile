<?php
class Categori
{
    public $id;
    public $categoryname;
    private $jokesTable;
    private $jokeCategoriesTable;
    public function __construct(DatabaseTable $jokesTable,DatabaseTable $jokeCategoriesTable)
    {
        $this->jokesTable = $jokesTable;
        $this->jokeCategoriesTable = $jokeCategoriesTable;
    }
    public function getJokes($limit = null, $offset = null)
    {
        $jokeCategories = $this->jokeCategoriesTable->find('categoryid', $this->id,null, $limit, $offset);
        $jokes = [];
        foreach ($jokeCategories as $jokeCategory) 
        {
            $joke =  $this->jokesTable->findById($jokeCategory->idjoke);
            if ($joke) 
            {
                $jokes[] = $joke;
            }
        }
        usort($jokes, [$this, 'sortJokes']);
        return $jokes;
    }
    public function getNumJokes() 
    {
        return $this->jokeCategoriesTable->total('categoryid',$this->id);
    }
    private function sortJokes($a, $b) 
    {
        $aDate = new \DateTime($a->jokedate);
        $bDate = new \DateTime($b->jokedate);
        if ($aDate->getTimestamp() == $bDate->getTimestamp()) 
        {
            return 0;
        }
        return $aDate->getTimestamp() > $bDate->getTimestamp() ? -1 : 1;}
}