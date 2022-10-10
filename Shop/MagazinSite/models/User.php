<?php

/**
 * Класс User - модель для работы с пользователями
 */
class User {

    /**
     * Регистрация пользователя 
     * @param string $name <p>Имя</p>
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function register($name, $email, $password) {
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'INSERT INTO user (name, email, password) '
                . 'VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    public static function mailForAdmin($adminEmail, $message, $subject) {
        $result = mail($adminEmail, $subject, $message);
        return $result;
    }

    /**
     * Валидация полей при регистрации 
     * @param string $name <p>Имя</p>
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function validateRegister($name, $email, $password) {
        $errors = false;

        if (!User::checkName($name)) {
            $errors[] = 'Имя не должно быть короче 4-х символов';
        }
        if (!User::checkEmail($email)) {
            $errors[] = 'Неправильный email';
        }
        if (!User::checkPassword($password)) {
            $errors[] = 'Пароль не должен быть короче 6-ти символов';
        }
        if (User::checkEmailExists($email)) {
            $errors[] = 'Такой email уже используется';
        }
        return $errors;
    }
    
    /**
     * Валидация полей при редактировании 
     * @param string $name <p>Имя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function validateEdit($name, $password) {
        $errors = false;

        if (!User::checkName($name)) {
            $errors[] = 'Имя не должно быть короче 4-х символов';
        }
        if (!User::checkPassword($password)) {
            $errors[] = 'Пароль не должен быть короче 6-ти символов';
        }
        return $errors;
    }

    /**
     * Валидация полей при входе 
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function validateLogin($email, $password) {
        $errors = false;

        if (!User::checkEmail($email)) {
            $errors[] = 'Неправильный email';
        }
        if (!User::checkPassword($password)) {
            $errors[] = 'Пароль не должен быть короче 6-ти символов';
        }
        // Проверяем существует ли пользователь
        return $errors;
    }

    /**
     * Валидация полей при отправке сообщения во вкладке контактов 
     * @param string $email <p>E-mail</p>
     * @param string $userText <p>Сообщение</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function validateContact($email, $userText) {
        $errors = false;

        if (!User::checkEmail($email)) {
            $errors[] = 'Неправильный email';
        }
        if (!isset($userText) || empty($userText)) {
            $errors[] = 'Сообщение не может быть пустым';
        }
        // Проверяем существует ли пользователь
        return $errors;
    }

    /**
     * Валидация полей оформлении заказа
     * @param string $name <p>Имя</p>
     * @param string $phone <p>Телефон</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function validateCheckout($name, $phone) {
        $errors = false;

        if (!User::checkName($name)) {
            $errors[] = 'Имя не должно быть короче 4-х символов';
        }
        if (!User::checkPhone($phone)) {
            $errors[] = 'Неправильный телефон';
        }
        return $errors;
    }

    /**
     * Проверяет имя: не меньше, чем 4 символа
     * @param string $name <p>Имя</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkName($name) {
        if (strlen($name) >= 4) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет имя: не меньше, чем 6 символов
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPassword($name) {
        if (strlen($name) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет телефон: на соответствие регулярному выражению
     * @param string $phone <p>Телефон</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPhone($userPhone) {
        $pattern = "^\+?[\s\-\(\)0-9]{6,19}$";
        if ((preg_match("~$pattern~", $userPhone))) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет не занят ли email другим пользователем
     * @param type $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmailExists($email) {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Проверяем существует ли пользователь с заданными $email и $password
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($email, $password) {
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();
        // Обращаемся к записи
        $user = $result->fetch();
        if ($user) {
            // Если запись существует, возвращаем id пользователя
            return $user['id'];
        }
        return false;
    }

    /**
     * Запоминаем пользователя
     * @param integer $userId <p>id пользователя</p>
     */
    public static function auth($userId) {
        // Записываем идентификатор пользователя в сессию
        $_SESSION['user'] = $userId;
    }

    /**
     * Возвращает идентификатор пользователя, если он авторизирован.<br/>
     * Иначе перенаправляет на страницу входа
     * @return string <p>Идентификатор пользователя</p>
     */
    public static function checkLogged() {
        //Если сессия есть, то вернём идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header("Location: /MagazinSite/user/login");
    }

    /**
     * Проверяет является ли пользователь гостем
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function isGuest() {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * Возвращает пользователя с указанным id
     * @param integer $id <p>id пользователя</p>
     * @return array <p>Массив с информацией о пользователе</p>
     */
    public static function getUserById($id) {
        if ($id) {
            $db = Db::getConnection();
            // Текст запроса к БД
            $sql = 'SELECT * FROM user WHERE id = :id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            //Указываем, что хотим получить данные в виде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
    }

    /**
     * Редактирование данных пользователя
     * @param integer $id <p>id пользователя</p>
     * @param string $name <p>Имя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function edit($id, $name, $password) {
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "UPDATE user SET name = :name, password = :password"
                . " WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

}
