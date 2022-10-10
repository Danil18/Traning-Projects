<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="left-sidebar">
        <h2>Каталог</h2>
        <div class="category-panel">
            <?php foreach ($categories as $categoryItem): ?>
                <div class="category">
                    <h4>
                        <a href="/MagazinSite/category/<?php echo$categoryItem['id']; ?>">
                            <?php echo $categoryItem['name']; ?>
                        </a>
                    </h4>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="block-cart">
        <h2>Корзина</h2>

        <?php if ($productsInCart): ?>
            <p>Вы выбрали такие товары:</p>
            <table class="product-in-cart">
                <tr>
                    <th>Код товара</th>
                    <th>Название</th>
                    <th>Стомость, $</th>
                    <th>Количество, шт</th>
                    <th>Удалить</th>
                </tr>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['code']; ?></td>
                        <td>
                            <a class="product-link" href="/MagazinSite/product/<?php echo $product['id']; ?>">
                                <?php echo $product['name']; ?>
                            </a>
                        </td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $productsInCart[$product['id']]; ?></td>                        
                        <td>
                            <a class="delete" href="/MagazinSite/cart/delete/<?php echo $product['id']; ?>"> Удалить</a>
                        </td>                        
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2">Итого:</td>
                    <td><?php echo $totalPrice; ?></td>
                    <td><?php echo Cart::countItems(); ?></td>
                    <td>
                        <a class="delete" href="/MagazinSite/cart/deleteAll"> Очистить всё</a>
                    </td>
                </tr>


            </table>
            <h3><a class="checkout-btn" href="/MagazinSite/cart/checkout">Оформить заказ</a></h3>
        <?php else: ?>
            <p>Корзина пуста</p>
        <?php endif; ?>

    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>