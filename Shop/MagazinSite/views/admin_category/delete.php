<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="admin-main">
            <br/>
                <ol class="menu-admin">
                    <li><a href="/MagazinSite/admin">Админпанель</a></li>
                    <li><a href="/MagazinSite/admin/category">Управление категориями</a></li>
                    <li class="location">Удалить категорию</li>
                </ol>
            <h4>Удалить категорию #<?php echo $id; ?></h4>
            <p class="question-admin">Вы действительно хотите удалить эту категорию?</p>
            <form method="post">
                <input type="submit" class="delete-btn-admin" name="submit" value="Удалить" />
            </form>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>