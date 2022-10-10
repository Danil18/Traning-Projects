<?php

/**
 * Класс Cart
 * Компонент для работы корзиной
 */
class Cart {
    
    /**
     * Добавление товара в корзину (сессию)
     * @param int $id <p>id товара</p>
     * @return integer <p>Количество товаров в корзине</p>
     */
    public static function addProduct($id){
        $id = intval($id);
        
        //Пустой массив для товаров в коризне
        $productInCart = array();
        
        //Если в корзине уже есть товары
        if(isset($_SESSION['products'])){
            //То заполним наш массив товарами
            $productInCart = $_SESSION['products'];
        }
        
        //Если товар есть в корзине, но был добавлен ещё раз, увеличим количество
        if(array_key_exists($id, $productInCart)){
            $productInCart[$id]++;
        } else {
            //Добавление нового товара в корзину
            $productInCart[$id] = 1;
        }
        // Записываем массив с товарами в сессию
        $_SESSION['products'] = $productInCart;
        // Возвращаем количество товаров в корзине
        return self::countItems();
    }
    
    /**
     * Подсчет количество товаров в корзине (в сессии)
     * @return int <p>Количество товаров в корзине</p>
     */
    public static function countItems(){
        // Проверка наличия товаров в корзине
        if(isset($_SESSION['products'])){
            // Если массив с товарами есть
            // Подсчитаем и вернем их количество
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity){
                $count += $quantity;
            }
            return $count;
        } else {
            // Если товаров нет, вернем 0
            return 0;
        }
    }
    
    /**
     * Возвращает массив с идентификаторами и количеством товаров в корзине<br/>
     * Если товаров нет, возвращает false;
     * @return mixed: boolean or array
     */
    public static function getProducts(){
        if(isset($_SESSION['products'])){
            return $_SESSION['products'];
        }
        return false;
    }
    
    /**
     * Получаем общую стоимость переданных товаров
     * @param array $products <p>Массив с информацией о товарах</p>
     * @return integer <p>Общая стоимость</p>
     */
    public static function getTotalPrice($products){
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productInCart = self::getProducts();
        
        if($productInCart){
            $total = 0;
            foreach ($products as $item){
                // Находим общую стоимость: цена товара * количество товара
                $total += $item['price'] * $productInCart[$item['id']];
            }
        }
        return $total;
    }
    /**
     * Удаляет товар с указанным id из корзины
     * @param integer $id <p>id товара</p>
     */
    public static function deleteProduct($id){
        //Проверяем наличие товара в сессии
        if(isset($_SESSION['products'][$id])){
            //Если товар есть
            //Удаляем товар из сессии
            unset ($_SESSION['products'][$id]);
        }
    }

    /**
     * Очищает корзину
     */
    public static function clear(){
        //Проверяем наличие товаров в сессии
        if(isset($_SESSION['products'])){
            //Если список товаров есть
            //Удаляем его из сессии
            unset($_SESSION['products']);
        }
    }
    
}
