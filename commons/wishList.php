<?php

declare(strict_types = 1); 
require_once(__DIR__ . '/../entities/wishlist.class.php');
require_once(__DIR__ . '/../entities/product.class.php');

function drawWishListMain(PDO $db, array $wishList) { ?>
    <link rel="stylesheet" href="../css/wishList.css">
    <main class="wishlist-page">
        <h2>My WishList</h2>
        <article class="wishlist-items">
            <?php foreach ($wishList as $wishItem):
                $product = Product::getProduct($db, $wishItem->productId);
                if ($product): ?>
                    <div class="wishlist-item" data-id="<?= $wishItem->productId ?>">
                        <a href="../pages/productPage.php?product_id=<?= $wishItem->productId ?>">
                            <img src="../<?= htmlspecialchars($product->imagePath); ?>" alt="Imagem de <?= htmlspecialchars($product->name); ?>">
                        </a>
                        <div class="item-info">
                            <p class="item-name"><?= htmlspecialchars($product->name); ?></p>
                            <p class="item-price"><?= number_format($product->price, 2); ?> €</p>
                            <button class="remove-from-wishlist" onclick="removeFavProduct(<?= $wishItem->productId ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                            <script src="../javascript/script.js"></script>
                        </div>
                    </div>
            <?php endif;
            endforeach; ?>
        </article>
    </main>
<?php 
}
?>