<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="admin-main">
        <br/>
        <ol class="menu-admin">
            <li><a href="/MagazinSite/admin">Админпанель</a></li>
            <li><a href="/MagazinSite/admin/product">Управление товарами</a></li>
            <li class="locatin">Редактировать товар</li>
        </ol>
        <h4>Добавить новый товар</h4>
        <br/>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="login-form">
            <form action="#" method="post" enctype="multipart/form-data">
                <p>Название товара</p>
                <input type="text" name="name" placeholder="" value="">
                <p>Артикул</p>
                <input type="text" name="code" placeholder="" value="">
                <p>Стоимость, $</p>
                <input type="text" name="price" placeholder="" value="">
                <p>Категория</p>
                <select name="category_id">
                    <?php if (is_array($categoriesList)): ?>
                        <?php foreach ($categoriesList as $category): ?>
                            <option value="<?php echo $category['id']; ?>">
                                <?php echo $category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <br/>
                <br/>
                <p>Производитель</p>
                <input type="text" name="brand" placeholder="" value="">
                <p>Изображение товара</p>
                <input type="file" name="image" placeholder="" value="">
                <p>Детальное описание</p>
                <textarea name="description" class="textarea"></textarea>
                <br/>
                <br/>
                <p>Наличие на складе</p>
                <select name="availability">
                    <option value="1" selected="selected">Да</option>
                    <option value="0">Нет</option>
                </select>
                <br/>
                <br/>
                <p>Новинка</p>
                <select name="is_new">
                    <option value="1" selected="selected">Да</option>
                    <option value="0">Нет</option>
                </select>
                <br/>
                <br/>
                <p>Рекомендуемые</p>
                <select name="is_recommended">
                    <option value="1" selected="selected">Да</option>
                    <option value="0">Нет</option>
                </select>
                <br/>
                <br/>
                <p>Статус</p>
                <select name="status">
                    <option value="1" selected="selected">Отображается</option>
                    <option value="0">Скрыт</option>
                </select>
                <br/>
                <br/>
                <input type="submit" name="submit" value="Сохранить">
                <br/><br/>
            </form>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
