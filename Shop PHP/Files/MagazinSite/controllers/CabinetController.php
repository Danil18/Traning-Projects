<?php

/**
 * Контроллер CabinetController
 * Кабинет пользователя
 */
class CabinetController {
    
    /**
     * Action для страницы "Кабинет пользователя"
     */
    public function actionIndex(){
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
        
        require_once (ROOT . '/views/cabinet/index.php');
        return true;
    }
    
    public function actionOrders(){
        $userId = User::checkLogged();
        
        $ordersList = Order::getUserOrdersList($userId);
        $i = 0;
        while($i < count($ordersList)){
            $ordersList[$i]['total_price'] = Order::getTottalPriceInOrder($ordersList[$i]['id']);
            $i++;
        }
        require_once (ROOT . '/views/cabinet/orders.php');
        return true;
    }
    
    public function actionViewOrder($id){
        // Получаем данные о конкретном заказе
        $order = Order::getOrderById($id);
        // Получаем массив с идентификаторами и количеством товаров
        $productsQuantity = json_decode($order['products'], true);
        // Получаем массив с индентификаторами товаров
        $productsIds = array_keys($productsQuantity);
        // Получаем список товаров в заказе
        $products = Product::getProductsByIds($productsIds);
        // Получаем общую цену за все товары
        $totalPrice = Order::getTottalPriceInOrder($id);
        
        require_once (ROOT . '/views/cabinet/order.php');
        return true;
    }
    
    /**
     * Action для страницы "Редактирование данных пользователя"
     */
    public function actionEdit(){
        //Получаем ИД пользователя из сессии
        $userId = User::checkLogged();
        
        //Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
        $name = $user['name'];
        $password = $user['password'];
        $result = false;
        
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $password = $_POST['password'];
            
            $errors = User::validateEdit($name, $password);
            if($errors == false){
                // Если ошибок нет, сохраняет изменения профиля
                $result = User::edit($userId, $name, $password);
            }
        }
        require_once (ROOT . '/views/cabinet/edit.php');
        return true;
    }
}
