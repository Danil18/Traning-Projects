<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="admin-main">
        <br/>     
        <ol class="menu-admin">
            <li><a href="/MagazinSite/admin">Админпанель</a></li>
            <li class="location">Управление заказами</li>
        </ol>
        <h4>Список заказов</h4>
        <br/>
        <table class="table-admin">
            <tr>
                <th>ID заказа</th>
                <th>Имя покупателя</th>
                <th>Телефон покупателя</th>
                <th>Дата оформления</th>
                <th>Статус</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($ordersList as $order): ?>
                <tr>
                    <td>
                        <a href="/MagazinSite/admin/order/view/<?php echo $order['id']; ?>">
                            <?php echo $order['id']; ?>
                        </a>
                    </td>
                    <td><?php echo $order['user_name']; ?></td>
                    <td><?php echo $order['user_phone']; ?></td>
                    <td><?php echo $order['date']; ?></td>
                    <td><?php echo Order::getStatusText($order['status']); ?></td>    
                    <td><a href="/MagazinSite/admin/order/view/<?php echo $order['id']; ?>" title="Смотреть"> Смотреть</a></td>
                    <td><a href="/MagazinSite/admin/order/update/<?php echo $order['id']; ?>" title="Редактировать"> Редактировать</a></td>
                    <td><a href="/MagazinSite/admin/order/delete/<?php echo $order['id']; ?>" title="Удалить"> Удалить</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
