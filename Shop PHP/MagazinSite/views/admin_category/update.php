<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="admin-main">
            <br/>
                <ol class="menu-admin">
                    <li><a href="/MagazinSite/admin">Админпанель</a></li>
                    <li><a href="/MagazinSite/admin/category">Управление категориями</a></li>
                    <li class="location">Редактировать категорию</li>
                </ol>

            <h4>Редактировать категорию "<?php echo $category['name']; ?>"</h4>
            <br/>
                <div class="login-form">
                    <form action="#" method="post">
                        <p>Название</p>
                        <input type="text" name="name" placeholder="" value="<?php echo $category['name']; ?>">
                        <p>Порядковый номер</p>
                        <input type="text" name="sort_order" placeholder="" value="<?php echo $category['sort_order']; ?>">
                        <p>Статус</p>
                        <select name="status">
                            <option value="1" <?php if ($category['status'] == 1) echo ' selected="selected"'; ?>>Отображается</option>
                            <option value="0" <?php if ($category['status'] == 0) echo ' selected="selected"'; ?>>Скрыта</option>
                        </select>
                        <br>
                        <br>
                        <input type="submit" name="submit" value="Сохранить">
                    </form>
                </div>
            </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>