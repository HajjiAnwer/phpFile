<?php
ini_set('display_errors', 1);
class Register
{
    private $authorsTable;
    public function __construct(DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
    }
    public function list() 
    {
        $authors = $this->authorsTable->findAll();
        return ['template' => 'authorList.html.php',
                'title' => 'Author List',
                'variables' => ['authors' => $authors]
                ];
    }
    public function savePermissions() 
    {
        $author = ['id' => $_GET['id'],'permissions' => array_sum($_POST['permissions'] ?? [])];
        var_dump($author['permission']);
        $this->authorsTable->save($author);
        header('location: /author/list');
    }
    public function permissions() 
    {
        $author = $this->authorsTable->findById($_GET['id']);
        $reflected = new \ReflectionClass('Author');
        $constants = $reflected->getConstants();
        var_dump($author);
        return ['template' => 'permession.html.php',
                'title' => 'Edit Permissions',
                'variables' => ['author' => $author,
                                'permissions' => $constants]
                ];
    }
    public function registrationForm()
    {
        return ['template' => 'register.html.php','title' => 'Register an account'];
    }
    public function success()
    {
        return ['template' => 'registersuccess.html.php',
                'title' => 'Registration Successful'];
    }
    public function registerUser() 
    {
        $author = $_POST['author'];
        $valid=true;
        $errors = [];
        if (empty($author['name'])) 
        {
            $valid = false;
            $errors[] = 'Name cannot be blank';
        }
        if (empty($author['email'])) 
        {
            $valid = false;
            $errors[] = 'Email cannot be blank';
        }
        else if (filter_var($author['email']) == false) 
        {
            $valid = false;
            $errors[] = 'Invalid email address';
        }
        else 
        { // If the email is not blank and valid:
            // convert the email to lowercase
            $author['email'] = strtolower($author['email']);
            // Search for the lowercase version of $author['email']
            if (count($this->authorsTable->find('email', $author['email'])) > 0) 
            {
                $valid = false;$errors[] = 'That email address is already registered';
            }
        }
        if (empty($author['password'])) 
        {
            $valid = false;
            $errors[] = 'Password cannot be blank';
        }
        // If $valid is still true, no fields were blank// and the data can be added
        if ($valid == true) 
        {
            $author['password'] =password_hash($author['password'],PASSWORD_DEFAULT);
            $this->authorsTable->save($author);
            header('Location: /author/success');
        }
        else 
        {
            // If the data is not valid, show the form again
            return ['template' => 'register.html.php',
                    'title' => 'Register an account',
                    'variables' => ['errors' => $errors,
                                    'author' => $author
                                   ]
                   ];
        }
        
    }
    
}

