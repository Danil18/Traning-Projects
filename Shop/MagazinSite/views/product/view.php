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

    <div class="product-details"><!--product-details-->
        <div class="product-details-top">
            <div class="img-product">
                <img src="<?php echo Product::getImage($product['id']); ?>" alt="" />
            </div>

            <div class="product-information"><!--/product-information-->
                <?php if ($product['is_new']): ?>    
                    <img src="/MagazinSite/template/images/home/new.jpg" alt="" />
                <?php endif; ?>
                <h3><?php echo $product['name']; ?></h3>
                <p>Код товара: <?php echo $product['code']; ?></p>
                <span>
                    <span class="price">US $<?php echo $product['price']; ?></span>
                    <a href="#" data-id="<?php echo $product['id']; ?>" class="btn-add-to-cart"> В корзину</a>
                </span>
                <p><b>Наличие:</b> <?php echo Product::getAvailabilityText($product['availability']); ?></p>
                <p><b>Производитель:</b> <?php echo $product['brand']; ?></p>
            </div><!--/product-information-->
        </div>                              
        <div class="product-details-bottom">
            <h5>Описание товара</h5>
            <?php echo str_replace("/ ", "<br/>",$product['description']); ?>
        </div>
    </div><!--/product-details-->

</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
