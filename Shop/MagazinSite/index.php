<?php

// FRONT CONTROLLER


// Общие настройки
ini_set('display_errors', 1);// Включение ошибок
error_reporting(E_ALL);

session_start();

// Подключение файлов системы
define('ROOT', dirname(__FILE__)); // константа ROOT, содержащая путь к дирректории с сайтом
require_once(ROOT.'/components/Autoload.php');// подключение Router через ROOT 

// Установка соединения с БД


// Вызов Router
$router = new Router();
$router->run();

