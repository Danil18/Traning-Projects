<?php

include_once ROOT . '/models/Category.php';
include_once ROOT . '/models/Product.php';

/**
 * Контроллер CartController
 */
class SiteController {

    /**
     * Action для главной страницы
     */
    public function actionIndex() {
        //Список категорий для левого меню
        $categories = array();
        $categories = Category::getCategoriesList();
        //Список последних товаров
        $latestProducts = array();
        $latestProducts = Product::getLatestProducts();
        //Список рекомендуемых товаров
        $sliderProducts = array();
        require_once (ROOT . '/views/site/index.php');

        return true;
    }

    /**
     * Action для страницы "Контакты"
     */
    public function actionContact() {

        $userEmail = '';
        $userText = '';
        $result = false;

        if (isset($_POST['submit'])) {
            //Если форма отправлена
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            //Валидация полей
            $errors = User::validateContact($userEmail, $userText);
            if ($errors == false) {
                $message = "Текст: {$userText}. От {$userEmail}";
                $result = User::mailForAdmin('admin.site@mail.ru', $message, 'Тема сообщения');
                return $result;
            }
        }
        require_once (ROOT . '/views/site/contact.php');
        return true;
    }

    /**
     * Action для страницы "О магазине"
     */
    public function actionAbout() {

        require_once (ROOT . '/views/site/about.php');
        return true;
    }

}
