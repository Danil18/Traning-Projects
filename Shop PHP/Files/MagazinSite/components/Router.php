<?php

/**
 * Класс Router
 * Компонент для работы с маршрутами
 */
class Router {
    
    /**
     * Свойство для хранения массива роутов
     * @var array 
     */
    private  $routes; //Массив маршрутов
    
    /**
     * Конструктор
     */
    public function __construct() {
        // Путь к файлу с роутами
        $routesPath = ROOT.'/config/routes.php';//Путь к роутам
        // Получаем роуты из файла
        $this->routes = include($routesPath);//Запись роутов в массив
    }
    
    /**
     * Возвращает строку запроса
     */
    private function getURI(){
         if (!empty($_SERVER['REQUEST_URI'])){
             return substr($_SERVER['REQUEST_URI'], strlen('/MagazinSite/'));
        }
    }

    /**
     * Метод для обработки запроса
     */
    public function run(){
        
        // Получаем строку запроса
        $uri = $this->getURI();
        
        // Проверяем наличие такого запроса в массиве маршрутов routes.php
        foreach ($this->routes as $uriPattern => $path){
            
            // Сравниваем $uriPattern и $uri
            if(preg_match("~$uriPattern~", $uri)){
            
                //Получаем внутренний путь из внешнего согласно правилу.
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
            
                // Определяем контроллер, action, параметры
                $segments = explode('/', $internalRoute); //Делим строку на 2 элемента
                $controllerName = array_shift($segments).'Controller'; //Получаем имя контроллера
                //array_shift() Получает первый элемент массива и удоляет его из массива
                $controllerName = ucfirst($controllerName);//Переводим первую букву в верхний регистр
                
                $actionName = 'action'.ucfirst(array_shift($segments));
                
                $parameters = $segments;
                
                // Подключить файл класса контроллера
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                if(file_exists($controllerFile)){
                    include_once($controllerFile);
                }
                // Создать объект, вызвать метод(т.е. action)
                $controllerObject = new $controllerName;
                
                /* Вызываем необходимый метод ($actionName) у определенного 
                 * класса ($controllerObject) с заданными ($parameters) параметрами
                 */
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);//Вызываем action в объекте и передаём параметры в виде переменных, а не массива
                
                if($result != null){
                    break;
                }
            }
        }
    }
}
