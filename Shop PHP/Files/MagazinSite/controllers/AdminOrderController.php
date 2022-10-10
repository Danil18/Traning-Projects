<?php

/**
 * Контроллер AdminOrderController
 * Управление заказами в админпанели
 */
class AdminOrderController extends AdminBase{
    
    /**
     * Action для страницы "Управление заказами"
     */
    public function actionIndex(){
        
        self::checkAdmin();
        // Получаем список заказов
        $ordersList = Order::getOrderList();
        
        require_once (ROOT . '/views/admin_order/index.php');
        return true;
    }
    
    /**
     * Action для страницы "Просмотр заказа"
     */
    public function actionView($id){
        
        self::checkAdmin();
        // Получаем данные о конкретном заказе
        $order = Order::getOrderById($id);
        // Получаем массив с идентификаторами и количеством товаров
        $productsQuantity = json_decode($order['products'], true);
        // Получаем массив с индентификаторами товаров
        $productsIds = array_keys($productsQuantity);
        // Получаем список товаров в заказе
        $products = Product::getProductsByIds($productsIds);
        
        require_once (ROOT . '/views/admin_order/view.php');
        return true;
    }
      
    /**
     * Action для страницы "Редактирование заказа"
     */
    public function actionUpdate($id){
        
        self::checkAdmin();
        // Получаем данные о конкретном заказе
        $order = Order::getOrderById($id);
        
        if(isset($_POST['submit'])){
            // Получаем данные из формы
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            $date = $_POST['date'];
            $status = $_POST['status'];
            // Сохраняем изменения
            Order::updateOrderById($id, $userName, $userPhone, $userComment, $date, $status);
                
            header("Location: /MagazinSite/admin/order/view/$id");
        }
        require_once (ROOT . '/views/admin_order/update.php');
        return true;
    }
    
    /**
     * Action для страницы "Удалить заказ"
     */
    public function actionDelete($id){
        
        self::checkAdmin();
        
        if(isset($_POST['submit'])){
            
            Order::deleteOrderById($id);
                
            header("Location: /MagazinSite/admin/order");
        }
        require_once (ROOT . '/views/admin_order/delete.php');
        return true;
    }
}
