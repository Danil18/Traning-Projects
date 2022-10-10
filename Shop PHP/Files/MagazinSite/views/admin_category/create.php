<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="admin-main">
        <br/>
        <ol class="menu-admin">
            <li><a href="/MagazinSite/admin">Админпанель</a></li>
            <li><a href="/MagazinSite/admin/category">Управление категориями</a></li>
            <li class="location">Добавить категорию</li>
        </ol>

        <h4>Добавить новую категорию</h4>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="login-form">
            <form action="#" method="post">
                <p>Название</p>
                <input type="text" name="name" placeholder="" value="">
                <p>Порядковый номер</p>
                <input type="text" name="sort_order" placeholder="" value="">
                <p>Статус</p>
                <select name="status">
                    <option value="1" selected="selected">Отображается</option>
                    <option value="0">Скрыта</option>
                </select>
                <br>
                <br>
                <input type="submit" name="submit" value="Сохранить">
            </form>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>