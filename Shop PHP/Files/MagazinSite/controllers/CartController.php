<?php

/**
 * Контроллер CartController
 * Корзина
 */
class CartController {
        
    /**
     * Action для добавления товара в корзину при помощи ajax
     * @param integer $id <p>id товара</p>
     */
    public function actionAddAjax($id){
        // Добавляем товар в корзину и печатаем результат: количество товаров в корзине
        echo Cart::addProduct($id);
        return true;
    }
    
    /**
     * Action для страницы "Корзина"
     */
    public function actionIndex(){
        $categories = array();
        $categories = Category::getCategoriesList();
        //Получим данные из корзины
        $productsInCart = Cart::getProducts();
        
        if($productsInCart){
            //Получаем полную информацию о товарах для списка
            $productIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productIds);
            //Получаем общую стоимость товаров
            $totalPrice = Cart::getTotalPrice($products);
        }
        require_once (ROOT . '/views/cart/index.php');
        return true;
    }
    
    /**
     * Action для добавления товара в корзину синхронным запросом
     * @param integer $id <p>id товара</p>
     */
    public function actionDelete($id){
        // Удаляем заданный товар из корзины
        Cart::deleteProduct($id);
        
        header("Location: /MagazinSite/cart/");
    }
    
    public function actionDeleteAll(){
        // Очищаем всю корзину
        Cart::clear();
        
        header("Location: /MagazinSite/cart/");
    }
    
    /**
     * Action для страницы "Оформление покупки"
     */
    public function actionCheckout(){
        //Список категорий для оевого меню
        $categories = array();
        $categories = Category::getCategoriesList();
        //Статус успешного оформления
        $result = false;
        
        //Форма отправлена?
        if(isset($_POST['submit'])){
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            
            //Валидация полей
            $errors = User::validateCheckout($userName, $userPhone);
            //Форма заполнена корректно?
            if($errors == false){
                //Собираем информацию о заказе
                $productInCart = Cart::getProducts();
                if(User::isGuest()){
                    $userId = false;
                } else {
                    $userId = User::checkLogged();
                }
                
                //Сохраняем заказ в БД
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productInCart);
                
                if($result){
                    //Оповещаем админа о новом заказе
                    User::mailForAdmin('admin.site@mail.ru', 'http//localhost/MagazinSite/admin/orders', 'Новый заказ');
                    //Очищаем корзину
                    Cart::clear();
                }
            } else{
                //Форма не корректна
                $productInCart = Cart::getProducts();
                $productsIds = array_keys($productInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        } else{
            //Форма не отправлена
            //Получаем данные из корзины
            $productInCart = Cart::getProducts();
            //Есть товары в корзине?
            if($productInCart == false){
                //Нет товаров
                //Отправляем пользователя на главную за товарами
                header("Loaction: /MagazinSite/");
            } else {
                //В корзине есть товары
                //Итоги: общая стоимость. Количество товаров
                $productsIds = array_keys($productInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
                
                $userName = false;
                $userPhone = false;
                $userComment = false;
                //Пользователь авторизован?
                if(User::isGuest()){
                    //Нет, форма пустая
                } else {
                    //Да, получаем информацию о пользователе из БД
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);
                    //Подставляем в форму
                    $userName = $user['name'];
                }
            }
        }
        require_once (ROOT . '/views/cart/checkout.php');
        return true;
    }
}
