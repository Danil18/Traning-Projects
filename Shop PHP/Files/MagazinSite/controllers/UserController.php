<?php

/**
 * Контроллер UserController
 */
class UserController {
    
    /**
     * Action для страницы "Регистрация"
     */
    public function actionRegister(){
        $name = '';
        $email = '';
        $password = '';
        $result = false;
        
        if(isset($_POST['submit'])){
            // Если форма отправлена 
            // Получаем данные из формы
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            // Валидация полей
            $errors = User::validateRegister($name, $email, $password);
            if($errors == false){
                // Если ошибок нет
                // Регистрируем пользователя
                $result = User::register($name, $email, $password);
            }
        }
        require_once (ROOT . '/views/user/register.php');
        return true;
    }
    
    /**
     * Action для страницы "Вход на сайт"
     */
    public function actionLogin(){
        $email = '';
        $password = '';
        
        if(isset($_POST['submit'])){
            // Если форма отправлена 
            // Получаем данные из формы
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            //Валидация полей
            $errors = User::validateLogin($email, $password);
            if(!$errors){
                $userId = User::checkUserData($email, $password);

                if($userId == false){
                    //Если данные не правильные - показываем ошибку
                    $errors[] = 'неправильные данные для входа на сайт';
                } else {
                    //Если данные правильныеБ запоминаем пользователя в сессии
                    User::auth($userId);
                    //Перенаправляем пользователя в кабинет
                    header("Location: /MagazinSite/cabinet/");
                }
            }
        }
        require_once (ROOT . '/views/user/login.php');
        return true;
    }
    
    /*
     * Удаляем данные о пользователе из сессии
     */
    public function actionLogout(){
        session_start();
        // Удаляем информацию о пользователе из сессии
        unset($_SESSION["user"]);
        // Перенаправляем пользователя на главную страницу
        header("Location: /MagazinSite/");
    }
}
