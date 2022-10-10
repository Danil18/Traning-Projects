<?php
/**
 * Абстрактный класс AdminBase содержит общую логику для контроллеров, которые 
 * используются в панели администратора
 */
abstract class AdminBase {
    
    /*
     * Метод, который проверяет пользователя на то, является ли он администратором
     * @return boolean
     */
    public static function checkAdmin(){
        //Проверяет авторизован ли пользователь, если нет, он будет переадресован
        $userId = User::checkLogged();
        // Получаем информацию о текущем пользователе
        $user = User::getUserById($userId);
        
        //Если роль пользователя admin
        if($user['role'] == 'admin'){
            return true;
        }
        
        //Иначе завершаем работу с сообщением о закрытом доступе
        die('Access denied');
    }
}
