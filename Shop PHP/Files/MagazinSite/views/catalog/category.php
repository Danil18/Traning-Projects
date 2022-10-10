<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="left-sidebar">
        <h2>Каталог</h2>
        <div class="category-panel">
            <?php foreach ($categories as $categoryItem): ?>
                <div class="category">
                    <h4>
                        <a href="/MagazinSite/category/<?php echo$categoryItem['id']; ?>"
                           class="<?php if ($categoryId == $categoryItem['id']) echo 'active'; ?>">
                               <?php echo $categoryItem['name']; ?>
                        </a>
                    </h4>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="products"><!--products-->
        <h2 class="title text-center">Последние товары</h2>

        <?php foreach ($categoryProducts as $product): ?>
            <div class="single-products">
                <span class="product-img">
                    <img src="<?php echo Product::getImage($product['id']); ?>" alt="" />
                </span>
                <?php if ($product['is_new']): ?>
                    <img src="/MagazinSite/template/images/home/new.png" class="new" alt=""/>
                <?php endif; ?>
                <h2><?php echo $product['price']; ?>$</h2>
                <p>
                    <a href="/MagazinSite/product/<?php echo $product['id']; ?>">
                        <?php echo $product['name']; ?>
                    </a>
                </p>
                <a href="#" data-id="<?php echo $product['id']; ?>" class="add-to-cart">В корзину</a>
            </div>
        <?php endforeach; ?>

    </div><!--products-->
    <!-- Постраничная навигация -->
    <?php echo $pagination->get(); ?>

</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>