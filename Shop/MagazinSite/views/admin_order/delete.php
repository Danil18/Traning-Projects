<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="admin-main">
            <br/>
                <ol class="menu-admin">
                    <li><a href="/MagazinSite/admin">Админпанель</a></li>
                    <li><a href="/MagazinSite/admin/order">Управление заказами</a></li>
                    <li class="location">Удалить заказ</li>
                </ol>
            <h4>Удалить заказ #<?php echo $id; ?></h4>
            <p class="question-admin">Вы действительно хотите удалить этот заказ?</p>
            <form method="post">
                <input class="delete-btn-admin" type="submit" name="submit" value="Удалить" />
            </form>
        </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>