<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="admin-main">
        <br/>
        <ol class="menu-admin">
            <li><a href="/MagazinSite/admin">Админпанель</a></li>
            <li class="location">Управление товарами</li>
        </ol>
        <a href="/MagazinSite/admin/product/create" class="admin-btn"> Добавить товар</a>
        <h4>Список товаров</h4>
        <br/>
        <table class="table-admin">
            <tr>
                <th>ID товара</th>
                <th>Артикул</th>
                <th>Название товара</th>
                <th>Цена</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($productsList as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['code']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>  
                    <td><a href="/MagazinSite/admin/product/update/<?php echo $product['id']; ?>" title="Редактировать"> Редактировать</a></td>
                    <td><a href="/MagazinSite/admin/product/delete/<?php echo $product['id']; ?>" title="Удалить"> Удалить</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>