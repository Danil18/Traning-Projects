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

    <div class="checkout">
        <h2>Корзина</h2>
        <?php if ($result): ?>
            <p class="mail-for-user">Заказ оформлен. Мы Вам перезвоним.</p>
        <?php else: ?>
            <p class="mail-for-user">Выбрано товаров: <?php echo $totalQuantity; ?>, на сумму: <?php echo $totalPrice; ?> $.</p><br/>
            <div>
                <?php if (isset($errors) && is_array($errors)): ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error): ?>
                            <li> - <?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <p class="mail-for-user">Для оформления заказа заполните форму. Наш менеджер свяжется с Вами.</p>
                <div class="login-form">
                    <form action="#" method="post">
                        <p>Ваше имя</p>
                        <input type="text" name="userName" placeholder="" value="<?php echo $userName; ?>"/>
                        <p>Номер телефона</p>
                        <input type="text" name="userPhone" placeholder="" value="<?php echo $userPhone; ?>"/>
                        <p>Комментарий к заказу</p>
                        <input type="text" name="userComment" placeholder="Сообщение" value="<?php echo $userComment; ?>"/>
                        <br/>
                        <br/>
                        <input type="submit" name="submit" class="btn btn-default" value="Оформить" />
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>