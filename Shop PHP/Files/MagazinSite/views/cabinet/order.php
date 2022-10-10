<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="orders">
        <h3>Просмотр заказа #<?php echo $order['id']; ?></h3>
        <h5>Информация о заказе</h5>
        <table class="product-in-cart">
            <tr>
                <td>Номер заказа</td>
                <td><?php echo $order['id']; ?></td>
            </tr>
            <tr>
                <td><b>Статус заказа</b></td>
                <td><?php echo Order::getStatusText($order['status']); ?></td>
            </tr>
            <tr>
                <td><b>Дата заказа</b></td>
                <td><?php echo $order['date']; ?></td>
            </tr>
        </table>

        <h5>Товары в заказе</h5>

        <table class="product-in-cart">
            <tr>
                <th>ID товара</th>
                <th>Артикул товара</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['code']; ?></td>
                    <td>
                        <a class="product-link" href="/MagazinSite/product/<?php echo $product['id']; ?>">
                            <?php echo $product['name']; ?>
                        </a>
                    </td>
                    <td><?php echo $product['price']; ?>$</td>
                    <td><?php echo $productsQuantity[$product['id']]; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"> Общая стоимость:</td>
                <td><?php echo $totalPrice; ?>$</td>
            </tr>
        </table>
        <a href="/MagazinSite/cabinet/orders/" class="admin-btn"> Назад</a>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>