<?php
class IjdbRoutes{
    public function callAction($route){
        include 'DatabaseTable.php';
        include 'database_connection.php';
        $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');
        if ($route === 'joke/list') 
        {
            include 'JokeController.php';
            $controller = new JokeController($jokesTable,$authorsTable);
            $page = $controller->list();
        } 
        elseif ($route === '') 
        {
            include 'JokeController.php';
            $controller = new JokeController($jokesTable,$authorsTable);
            $page = $controller->home();
        } 
        elseif ($route === 'joke/edit') 
        {
            include 'JokeController.php';
            $controller = new JokeController($jokesTable,$authorsTable);
            $page = $controller->edit();
        } 
        elseif ($route === 'joke/delete') 
        {
            include 'JokeController.php';
            $controller = new JokeController($jokesTable,$authorsTable);
            $page = $controller->delete();
        } 
        elseif ($route === 'register') 
        {
            include 'RegisterController.php';
            $controller = new RegisterController($authorsTable);
            $page = $controller->showForm();
        }
        return $page;
    }
}