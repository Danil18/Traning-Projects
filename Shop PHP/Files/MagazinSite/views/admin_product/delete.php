<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="admin-main">
            <br/>
                <ol class="menu-admin">
                    <li><a href="/MagazinSite/admin">Админпанель</a></li>
                    <li><a href="/MagazinSite/admin/product">Управление товарами</a></li>
                    <li class="location">Удалить товар</li>
                </ol>
            <h4>Удалить товар #<?php echo $id; ?></h4>
            <p>Вы действительно хотите удалить этот товар?</p>
            <form method="post">
                <input type="submit" class="delete-btn-admin" name="submit" value="Удалить" />
            </form>
        </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>