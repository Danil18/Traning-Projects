<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <?php if ($result): ?>
        <p class="mail-for-user">Сообщение отправлено! Мы ответим Вам на указанный email.</p>
    <?php else: ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>


        <div class="login-form">
            <h2>Обратная связь</h2>
            <h5>Есть вопрос? Напишите нам</h5>
            <form action="#" method="post">
                <p>Ваша почта</p>
                <input type="email" name="userEmail" placeholder="E-mail" value="<?php echo $userEmail; ?>"/>
                <p>Сообщение</p>
                <input type="text" name="userText" placeholder="Сообщение" value="<?php echo $userText; ?>"/>
                <br/>
                <input type="submit" name="submit" value="Отправить" />
            </form>
        </div>
    <?php endif; ?>
    <br/>
    <br/>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>