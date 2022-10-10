<?php

/**
 * Контроллер CatalogController
 * Каталог товаров
 */
class CatalogController {
    
    /**
     * Action для страницы "Каталог товаров"
     */
    public function actionIndex($page = 1){
        // Список категорий для левого меню
        $categories = Category::getCategoriesList();
        // Список последних товаров на странице
        $latestProducts = Product::getProductsListByCatalog($page);
        // Общее количетсво товаров (необходимо для постраничной навигации)
        $total = Product::getTotalProducts();
        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');
        
        require_once (ROOT . '/views/catalog/index.php');
        
        return true;
    }
    
    /**
     * Action для страницы "Категория товаров"
     */
    public function actionCategory($categoryId, $page = 1){
        // Список категорий для левого меню
        $categories = Category::getCategoriesList();
        // Список товаров в категории
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);
        // Общее количетсво товаров (необходимо для постраничной навигации)
        $total = Product::getTotalProductsInCategory($categoryId);
        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');
        
        require_once (ROOT . '/views/catalog/category.php');
        
        return true;
    }
    
}
