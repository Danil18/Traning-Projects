<?php include ROOT. '/views/layouts/header.php'; ?>

<section>
    <div class="user-cabinet">
            <h1>Кабинет пользователя</h1>
            
            <h3>Привет, <?php echo $user['name']; ?></h3>
            <ul>
                <li><a href="/MagazinSite/cabinet/edit">Редактировать данные</a></li>
                <li><a href="/MagazinSite/cabinet/orders">Список покупок</a></li>
            </ul>
    </div>
</section>

<?php include ROOT. '/views/layouts/footer.php'; ?>