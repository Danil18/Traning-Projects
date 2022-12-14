<?php

return array(
    //Товар:
    'product/([0-9]+)' => 'product/view/$1', //actionView в ProductController
    //Каталог:
    'catalog/page-([0-9]+)' => 'catalog/index/$1',
    'catalog/' => 'catalog/index', //actionIndex в CatalogController
    //Категории товаров:
    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', //actionCategory в CatalogController
    'category/([0-9]+)' => 'catalog/category/$1', //actionCategory в CatalogController
    //Корзина:
    'cart/add/([0-9]+)' => 'cart/add/$1', //actionAdd в CartController
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', //actionAdd в CartController
    'cart/delete/([0-9]+)' => 'cart/delete/$1',
    'cart/checkout' => 'cart/checkout',
    'cart/deleteAll' => 'cart/deleteAll',
    'cart' => 'cart/index', //actionIndex в CartController
    //Пользователь:
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'cabinet/edit' => 'cabinet/edit',
    'cabinet/orders' => 'cabinet/orders',
    'cabinet/order/view/([0-9]+)' => 'cabinet/viewOrder/$1',
    'cabinet' => 'cabinet/index',
    // Управление товарами:    
    'admin/product/create' => 'adminProduct/create',
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
    'admin/product' => 'adminProduct/index',
    // Управление категориями:    
    'admin/category/create' => 'adminCategory/create',
    'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',
    'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
    'admin/category' => 'adminCategory/index',
    // Управление заказами:    
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',
    'admin/order/view/([0-9]+)' => 'adminOrder/view/$1',
    'admin/order' => 'adminOrder/index',
    //Админпанель:
    'admin' => 'admin/index',
    //О магазине:
    'about' => 'site/about',
    'contacts' => 'site/contact',
    //Главная:
    '' => 'site/index', //action Index в SiteController
    
);

