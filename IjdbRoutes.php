<?php
class IjdbRoutes
{
    private $authorsTable;
    private $jokesTable;
    private $authentication;
    public function __construct(DatabaseTable $jokesTable,DatabaseTable $authorsTable,Authentication $authentication)
    {
        include __DIR__ . '/includeFile/DatabaseConnection.php';
        //
       // include 'Authentication.php';
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
        $this->authentication=$authentication;
        //$this->jokesTable = new DatabaseTable($pdo,'joke', 'idjoke');
        //$this->authorsTable = new DatabaseTable($pdo,'author', 'id');
        //$this->authentication =new Authentication($this->authorsTable,'email', 'password');
    }
    public function getRoutes()
    {
        //include __DIR__ .'/classe/DatabaseTable.php';
        include __DIR__ .'/includeFile/DatabaseConnection.php';
        include __DIR__ .'/controller/JokeController.php';
        include __DIR__ .'/controller/register.php';
        include __DIR__ .'/controller/Login.php';
        $jokesTable = new DatabaseTable($pdo, 'joke', 'idjoke');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');
        $jokeController = new JokeController($jokesTable,$authorsTable,$this->authentication);
        $authorController=new Register($authorsTable);
        $loginController = new Login($this->authentication);
        $routes = [
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
                         'login' => true
                        ],
         'joke/delete' => ['POST' => ['controller' => $jokeController,
                                      'action' => 'delete'],
                           'login' => true
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