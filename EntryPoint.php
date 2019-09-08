<?php
class EntryPoint
{
    private $route;
    private $method;
    private $routes;
    private $authentication;
    public function __construct(string $route,string $method,IjdbRoutes $routes,IjdbRoutes $get, Authentication $authentication) 
    {
        $this->route = $route;
        $this->method=$method;
        $this->routes = $routes;
        $this->authentication=$authentication;
        $this->get=$get;
        $this->checkUrl();
    }
    private function checkUrl()
    {
        if ($this->route !== strtolower($this->route)) 
        {
            http_response_code(301);
            header('location: ' . strtolower($this->route));
        }
    }
    private function loadTemplate($templateFileName,$variables = [])
    {
        extract($variables);
        ob_start();
        include  $_SERVER["DOCUMENT_ROOT"] . '/includeFile/' . $templateFileName;
        return ob_get_clean();
    }
    public function run()
    {
        $routes = $this->routes->getRoutes();
        $get=$this->get->getAuthentication();
        if (isset($routes[$this->route]['login']) &&
            isset($routes[$this->route]['login']) &&
            !$get->isLoggedIn()) 
        {
            header('location: /login/error');
        }
        /*else if (isset($routes[$this->route]['permissions']) 
                && !$this->routes->checkPermission($$routes[$this->route]['permissions']))
        {
            var_dump($routes[$this->route]['permissions']);
            header('location: /login/error');
        }*/ 
        else 
        {
            $controller = $routes[$this->route][$this->method]['controller'];
            $action = $routes[$this->route][$this->method]['action'];
            var_dump($action);
            $page = $controller->$action();
            $title = $page['title'];
            if (isset($page['variables'])) 
            {
                $output = $this->loadTemplate($page['template'],$page['variables']);
            } 
            else 
            {
                $output = $this->loadTemplate($page['template']);
            }
            echo $this->loadTemplate('layout.html.php', 
                                    ['loggedIn' =>$this->authentication->isLoggedIn(),
                                    'output' => $output,
                                    'title' => $title]);
        }
    }   
}
