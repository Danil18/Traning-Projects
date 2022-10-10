<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <?php if ($result): ?>
        <p class="mail-for-user">Вы зарегестрированы!<p>
    <?php else: ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="login-form">
            <h2>Регистрация на сайте</h2>
            <form action="#" method="post">
                <p>Введите ваше имя</p>
                <input type="text" name="name" placeholder="Имя" value="<?php echo $name; ?>"/>
                <p>Введите ваш Email</p>
                <input type="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/>
                <p>Введите пароль</p>
                <input type="password" name="password" placeholder="Пароль" value="<?php echo $password; ?>"/>
                <input type="submit" name="submit" class="btn btn-default" value="Регистрация" />
            </form>
        </div>

    <?php endif; ?>

    <br/>
    <br/>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>