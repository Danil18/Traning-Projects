<?php
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET,POST,PUT");
// Получение данных из тела запроса
function getFormData($method) {
    // GET: данные возвращаем как есть
    if ($method === 'GET') return $_GET;
    // В остальных случаях декодируем JSON
    return json_decode(file_get_contents('php://input'), true);
}
// Определяем метод запроса
$method = $_SERVER['REQUEST_METHOD'];
// Получаем данные из тела запроса
$formData = getFormData($method);
// Разбираем url
$url = (isset($_GET['q'])) ? $_GET['q'] : '';
$url = rtrim($url, '/');
$urls = explode('/', $url);
// Определяем роутер и urldata
$router = $urls[0];
$urlData = array_slice($urls, 1);
// Подключаем файл-роутер и запускаем главную функцию
include_once 'routers/' . $router . '.php';
route($method, $urlData, $formData);
?>
