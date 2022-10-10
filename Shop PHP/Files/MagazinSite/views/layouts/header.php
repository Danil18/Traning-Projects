<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Главная</title>
        <link href="/MagazinSite/template/css/style.css" rel="stylesheet">
        <script src="/MagazinSite/template/js/jquery.js"></script>
        <script src="/MagazinSite/template/js/script.js"></script>
    </head><!--/head-->

    <body>
        <header id="header"><!--header-->
            <div class="header-top"><!--header-top-->

                <div class="logo">
                    <a href="/MagazinSite/"><h1>E-Magazin</h1></a>
                </div>

                <div class="shop-menu">
                    <ul class="navbar">
                        <li><a href="/MagazinSite/cart"> Корзина
                                <span id="cart-count">(<?php echo Cart::countItems(); ?>)</span>
                            </a></li>
                        <?php if (User::isGuest()): ?>
                            <li><a href="/MagazinSite/user/login/"> Вход</a></li>
                            <li><a href="/MagazinSite/user/register/"> Регистрация</a></li>
                        <?php else: ?>
                            <li><a href="/MagazinSite/cabinet/"> Аккаунт</a></li>
                            <li><a href="/MagazinSite/user/logout/"> Выход</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div><!--/header-top-->

            <div class="header-bottom"><!--header-bottom-->
                <div class="mainmenu">
                    <ul class="navbar-row">
                        <li><h3><a href="/MagazinSite/">Главная</a></h3></li>
                        <li><h3><a href="/MagazinSite/catalog/">Каталог товаров</a></h3></li>
                        <li><h3><a href="/MagazinSite/about/">О магазине</a></h3></li>
                        <li><h3><a href="/MagazinSite/contacts/">Контакты</a></h3></li>
                    </ul>
                </div>
            </div><!--/header-bottom-->

        </header><!--/header-->