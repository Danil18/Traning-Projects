<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="admin-main">
        <br/>
        <ol class="menu-admin">
            <li><a href="/MagazinSite/admin">Админпанель</a></li>
            <li class="location">Управление категориями</li>
        </ol>
        <a href="/MagazinSite/admin/category/create" class="admin-btn"> Добавить категорию</a>
        <h4>Список категорий</h4>
        <br/>
        <table class="table-admin">
            <tr>
                <th>ID категории</th>
                <th>Название категории</th>
                <th>Порядковый номер</th>
                <th>Статус</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($categoriesList as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo $category['name']; ?></td>
                    <td><?php echo $category['sort_order']; ?></td>
                    <td><?php echo Category::getStatusText($category['status']); ?></td>  
                    <td><a href="/MagazinSite/admin/category/update/<?php echo $category['id']; ?>" title="Редактировать"> Редактировать</a></td>
                    <td><a href="/MagazinSite/admin/category/delete/<?php echo $category['id']; ?>" title="Удалить"> Удалить</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>