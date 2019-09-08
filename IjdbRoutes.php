<?php
class IjdbRoutes
{
    private $authorsTable;
    private $jokesTable;
    private $authentication;
    private $categoriesTable;
    private $jokeCategoriesTable;
    public function __construct(DatabaseTable $jokesTable,DatabaseTable $authorsTable,Authentication $authentication,DatabaseTable $categoriesTable,DatabaseTable $jokeCategoriesTable)
    {
        include __DIR__ . '/includeFile/DatabaseConnection.php';
        //
       // include 'Authentication.php';
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
        $this->authentication=$authentication;
        $this->categoriesTable= $categoriesTable;
        $this->jokeCategoriesTable= $jokeCategoriesTable;
        //$this->jokesTable = new DatabaseTable($pdo,'joke', 'idjoke');
        //$this->authorsTable = new DatabaseTable($pdo,'author', 'id');
        //$this->authentication =new Authentication($this->authorsTable,'email', 'password');
    }
    public function checkPermission($permission): bool 
    {
        $user = $this->authentication->getUser();
        if ($user && $user->hasPermission($permission)) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }
    public function getRoutes()
    {
        //include __DIR__ .'/classe/DatabaseTable.php';
        include __DIR__ .'/includeFile/DatabaseConnection.php';
        include __DIR__ .'/controller/JokeController.php';
        include __DIR__ .'/controller/register.php';
        include __DIR__ .'/controller/Login.php';
        include __DiR__ .'/controller/Category.php';
        include __DiR__ .'/includeFile/Joke.php';
        $jokesTable = new DatabaseTable($pdo, 'joke', 'idjoke','Joke',[&$this->authorsTable,&$this->jokeCategoriesTable]);
        $authorsTable = new DatabaseTable($pdo, 'author', 'id','Author',[&$this->jokesTable]);
        $categoriesTable=new DatabaseTable($pdo,'category','id','Categori', [&$this->jokesTable, &$this->jokeCategoriesTable]);
        $jokeCategoriesTable=new DatabaseTable($pdo,'jokecategory','categoryid');
        $jokeCat=new Joke($authorsTable,$jokeCategoriesTable);
        $jokeController = new JokeController($jokesTable,$authorsTable,
                        $this->authentication,$categoriesTable);
        $authorController=new Register($authorsTable);
        $loginController = new Login($this->authentication);
        $categoryController = new Category($this->categoriesTable);
        $routes = [
        'author/permissions' =>['GET' => ['controller' => $authorController,
                                          'action' => 'permissions'],
                                'POST' => ['controller' => $authorController,
                                            'action' => 'savePermissions'],
                                'login' => true,
                                'permissions' => Author::EDIT_USER_ACCESS],
        'author/list' => ['GET' => ['controller' => $authorController,
                                    'action' => 'list'],
                          'login' => true,
                            'permissions' => Author::EDIT_USER_ACCESS],
        'category/delete' => ['POST' => ['controller' => $categoryController,
                                         'action' => 'delete'],
                              'login' => true,
                              'permissions' => Author::REMOVE_CATEGORIES],
        'category/list' => ['GET' => ['controller' => $categoryController,
                                      'action' => 'list'],
                            'login' => true,
                            'permissions' => Author::LIST_CATEGORIES],
        'category/edit' => ['POST' => ['controller' => $categoryController,
                                       'action' => 'saveEdit'],
                            'GET' => ['controller' => $categoryController,
                                      'action' => 'edit'],
                            'login' => true,
                            'permissions' => Author::EDIT_CATEGORIES
                           ],
        'author/register' => ['GET' => ['controller' => $authorController,
                                        'action' => 'registrationForm'],
                              'POST'=> ['controller' =>$authorController,
                                        'action' => 'registerUser']
                             ],
        'author/success' => ['GET' => ['controller' => $authorController,
                                       'action' => 'success']
                            ],
        'login' => ['GET' => ['controller' => $loginController,
                              'action' => 'loginForm'],
                    'POST' => ['controller' => $loginController,
                               'action' => 'processLogin']
                   ],
        'login/success' => ['GET' => ['controller' => $loginController,
                                      'action' => 'success'
                                     ],
                           'login' => true],
        'login/error' => ['GET' => ['controller' => $loginController,
                                    'action' => 'error']
                           ],
        'logout' => ['GET' => ['controller' => $loginController,
                               'action' => 'logout']
                    ],
        'joke/edit' => ['POST' => ['controller' => $jokeController,
                                   'action' => 'saveEdit'],
                        'GET' => ['controller' => $jokeController,
                                             'action' => 'edit'],
                        'login' => true,
                        'permissions' => 1
                       ],
        'joke/delete' => ['POST' => ['controller' => $jokeController,
                                     'action' => 'delete'],
                          'login' => true,
                           'permissions' => Author::DELETE_JOKES
                         ],
        'joke/list' => ['GET' => ['controller' => $jokeController,
                                  'action' => 'list']
                       ],
        '' => ['GET' => ['controller' => $jokeController,
                         'action' => 'home']
              ]
                ];
        return $routes;
    }
    public function getAuthentication()
    {
        return $this->authentication;
    }
}