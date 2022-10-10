<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="user-edit">
        <?php if ($result): ?>
            <p class="mail-for-user">Данные отредактированы!</p>
        <?php else: ?>
            <?php if (isset($errors) && is_array($errors)): ?>
                <ul class="errors">
                    <?php foreach ($errors as $error): ?>
                        <li> - <?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div class="login-form">
                <h2>Редактирование данных</h2>
                <form action="#" method="post">
                    <p>Имя:</p>
                    <input type="text" name="name" placeholder="Имя" value="<?php echo $name; ?>"/>
                    <p>Пароль:</p>
                    <input type="password" name="password" placeholder="Пароль" value="<?php echo $password; ?>"/>
                    <br/>
                    <input type="submit" name="submit" class="btn btn-default" value="Сохранить" />
                </form>
            </div>
        <?php endif; ?>
        <br/>
        <br/>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>