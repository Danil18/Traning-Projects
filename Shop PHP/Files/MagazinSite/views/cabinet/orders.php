<?php include ROOT. '/views/layouts/header.php'; ?>

<section>
    <div class="orders">
        <h2>Список заказов</h2>
        <br/>
        <table class="product-in-cart">
            <tr>
                <th>Номер заказа</th>
                <th>Дата заказа</th>
                <th>Сумма заказа</th>
                <th>Статус</th>
                <th></th>
            </tr>
            <?php foreach ($ordersList as $order): ?>
                <tr>
                    <td>
                        <a class="view" href="/MagazinSite/cabinet/order/view/<?php echo $order['id']; ?>">
                            <?php echo $order['id']; ?>
                        </a>
                    </td>
                    <td><?php echo $order['date']; ?></td>
                    <td><?php echo $order['total_price']; ?>$</td>
                    <td><?php echo Order::getStatusText($order['status']); ?></td>    
                    <td><a class="view" href="/MagazinSite/cabinet/order/view/<?php echo $order['id']; ?>" title="Смотреть"> Смотреть</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="/MagazinSite/cabinet" class="admin-btn"> Назад</a>
    </div>
</section>

<?php include ROOT. '/views/layouts/footer.php'; ?>