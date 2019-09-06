<?php
class Author
{
    const EDIT_JOKES = 1;
    const DELETE_JOKES = 2;
    const LIST_CATEGORIES = 4;
    const EDIT_CATEGORIES = 8;
    const REMOVE_CATEGORIES = 16;
    const EDIT_USER_ACCESS = 32;
    public $id;
    public $name;
    public $email;
    public $password;
    private $jokesTable;
    private $permissions;
    public function __construct(DatabaseTable $jokesTable)
    {
        $this->jokesTable = $jokesTable;
    }
    public function getJokes()
    {
        return $this->jokesTable->find('authorId',$this->id);
    }
    public function hasPermission($permission)  
    {
        return $this->permissions & $permission;
    }
    public function addJoke($joke) 
    {
        $joke['authorid'] = $this->id;
        return $this->jokesTable->save($joke);
    }
}