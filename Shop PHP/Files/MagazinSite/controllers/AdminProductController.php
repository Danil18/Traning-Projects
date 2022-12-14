<?php

/**
 * Контроллер AdminProductController
 * Управление товарами в админпанели
 */
class AdminProductController extends AdminBase {

    /**
     * Action для страницы "Управление товарами"
     */
    public function actionIndex() {

        self::checkAdmin();
        // Получаем список товаров
        $productsList = Product::getProductsList();

        require_once (ROOT . '/views/admin_product/index.php');
        return true;
    }

    /**
     * Action для страницы "Удалить товар"
     */
    public function actionDelete($id) {
        self::checkAdmin();

        if (isset($_POST['submit'])) {
            //Если форма отправлена
            //Удаляем товар
            Product::deleteProductById($id);

            header("Location: /MagazinSite/admin/product");
        }
        require_once (ROOT . '/views/admin_product/delete.php');
        return true;
    }

    /**
     * Action для страницы "Добавить товар"
     */
    public function actionCreate() {

        self::checkAdmin();
        // Получаем список категорий для выпадающего списка
        $categoriesList = Category::getCategoriesListAdmin();

        if (isset($_POST['submit'])) {
            // Получаем данные из формы
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            $errors = Product::validateProduct($options);
            if ($errors == false) {
                // Добавляем новый товар и получаем его id
                $id = Product::createProduct($options);
                if ($id) {
                    // Проверим, загружалось ли через форму изображение
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        // Если загружалось, переместим его в нужную папке, дадим новое имя
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                    }
                }
                header("Location: /MagazinSite/admin/product");
            }
        }
        require_once (ROOT . '/views/admin_product/create.php');
        return true;
    }

    /**
     * Action для страницы "Редактировать товар"
     */
    public function actionUpdate($id) {

        self::checkAdmin();
        // Получаем список категорий для выпадающего списка
        $categoriesList = Category::getCategoriesListAdmin();
        // Получаем данные о конкретном заказе
        $product = Product::getProductById($id);

        if (isset($_POST['submit'])) {
            // Получаем данные из формы редактирования
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            $errors = Product::validateProduct($options);
            if ($errors == false) {
                // Сохраняем изменения
                if (Product::updateProductById($id, $options)) {
                    // Если запись сохранена
                    // Проверим, загружалось ли через форму изображение
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        // Если загружалось, переместим его в нужную папке, дадим новое имя
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                    }
                }
                header("Location: /MagazinSite/admin/product");
            }
        }
        require_once (ROOT . '/views/admin_product/update.php');
        return true;
    }

}
