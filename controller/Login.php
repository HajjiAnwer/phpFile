<?php 
class Login
{
    private $authentication;
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }
    public function error()
    {
        return ['template' => 'loginerror.html.php', 
                'title'=> 'You are not logged in'];
    }    
    public function loginForm() 
    {
        return ['template' => 'login.html.php',
                'title' => 'Log In'];
    }
    public function processLogin() 
    {
        if ($this->authentication->login($_POST['email'],$_POST['password'])) 
        {
            header('location: /login/success');
        }
        else 
        {
            return ['template' => 'login.html.php',
                    'title' => 'Log In',
                    'variables' => ['error' => 'Invalid username/password.']
                    ];
        }
    }
    public function success() 
    {
        return ['template' => 'loginsuccess.html.php',
                'title' => 'Login Successful'];
    }
    public function logout() 
    {
        unset($_SESSION);
        session_destroy();
        return ['template' => 'logout.html.php',
                'title' => 'You have been logged out'];
    }
}