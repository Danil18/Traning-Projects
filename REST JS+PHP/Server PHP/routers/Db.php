<?php

class Db {

    public static function getConnection(){

        $db = new PDO("mysql:host=localhost;dbname=lab_rest", 'root', '');
        // Задаем кодировку
        $db->exec("set names utf8");

        return $db;
    }
}

?>
