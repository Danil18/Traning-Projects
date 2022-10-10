<?php

/**
 * Контроллер AdminCategoryController
 * Управление категориями товаров в админпанели
 */
class AdminCategoryController extends AdminBase{
    
    /**
     * Action для страницы "Управление категориями"
     */
    public function actionIndex(){
        
        self::checkAdmin();
        // Получаем список категорий
        $categoriesList = Category::getCategoriesListAdmin();
        
        require_once (ROOT . '/views/admin_category/index.php');
        return true;
    }
    
    /**
     * Action для страницы "Добавить категорию"
     */
    public function actionCreate(){
        
        self::checkAdmin();
        
        if(isset($_POST['submit'])){
            // Получаем данные из формы
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];
            
            $errors = Category::validateCategory($name, $sortOrder, $status);
            if($errors == false){
                // Добавляем новую категорию
                Category::createCategory($name, $sortOrder, $status);
                header("Location: /MagazinSite/admin/category");
            }
        }
        require_once (ROOT . '/views/admin_category/create.php');
        return true;
    }
    
    /**
     * Action для страницы "Редактировать категорию"
     */
    public function actionUpdate($id){
        
        self::checkAdmin();
        // Получаем данные о конкретной категории
        $category = Category::getCategoryById($id);
        
        if(isset($_POST['submit'])){
            // Получаем данные из формы
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];
            
            $errors = Category::validateCategory($name, $sortOrder, $status);
            if($errors == false){
                // Сохраняем изменения
                Category::updateCategoryById($id, $name, $sortOrder, $status);
                header("Location: /MagazinSite/admin/category");
            }
        }
        require_once (ROOT . '/views/admin_category/update.php');
        return true;
    }
    
    /**
     * Action для страницы "Удалить категорию"
     */
    public function actionDelete($id){
        
        self::checkAdmin();
        
        if(isset($_POST['submit'])){
            // Удаляем категорию
            Category::deleteCategoryById($id);
                
            header("Location: /MagazinSite/admin/category");
        }
        require_once (ROOT . '/views/admin_category/delete.php');
        return true;
    }
}
