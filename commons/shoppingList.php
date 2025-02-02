<?php
require_once(__DIR__ . '/../entities/shoppinglist.class.php');
require_once(__DIR__ . '/../entities/product.class.php');
require_once(__DIR__ . '/../entities/user.class.php');
require_once(__DIR__ . '/../entities/session.class.php');

function drawShoppingListMain(PDO $db, array $shoppingList) { 
    $session = new Session();
    $userId = $session->getId();
    $user = User::getUser($db, $userId);
    $total_price = 0;
    $num_items = 0;
    ?>
    <link rel="stylesheet" href="../css/shoppingList.css">
    <script src="../javascript/script.js" defer></script>
    <main class="shopping-list-page">
        <article class="cart-details">
            <h2>My Shopping Cart</h2>
            <?php if (empty($shoppingList)): ?>
                <p>Your shopping cart is empty.</p>
            <?php else: ?>
                <?php foreach ($shoppingList as $cartItem):
                    $product = Product::getProduct($db, $cartItem->productId);
                    if ($product): 
                        $total_price += $product->price;
                        $num_items++;
                    ?>
                        <div class="shopping-item" data-id="<?= $cartItem->productId ?>">
                            <a href="../pages/productPage.php?product_id=<?= $cartItem->productId ?>">
                                <img src="../<?= htmlspecialchars($product->imagePath); ?>" alt="Imagem de <?= htmlspecialchars($product->name); ?>" class="cart-image">
                            </a>
                            <div class="item-info">
                                <p class="item-name"><?= htmlspecialchars($product->name); ?></p>
                                <p class="item-price"><?= number_format($product->price, 2); ?> €</p>
                                <p class="item-description"><?= htmlspecialchars($product->description); ?></p>
                            </div>
                            <button class="remove-from-shopping-list" data-id="<?= $cartItem->productId ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    <?php 
                    endif;
                endforeach; ?>
        </article>
        <article class="checkout-area">
            <h2>Checkout</h2>
            <form action="../pages/buySuccess.php" method="POST">
                <div class="form-group">
                    <span>Total Price:</span>
                    <span id="total"><?php echo htmlspecialchars($total_price, ENT_QUOTES, 'UTF-8'); ?> €</span>
                    <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total_price, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <span>Number of products:</span>
                    <span id="num_products"><?php echo htmlspecialchars($num_items, ENT_QUOTES, 'UTF-8'); ?></span>
                    <input type="hidden" name="num_items" value="<?php echo htmlspecialchars($num_items, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <span>Address:</span>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user->address, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <span>Payment Methods:</span>
                    <div class="payment-methods">
                        <input type="radio" id="credit-card" name="payment_method" value="credit_card" required>
                        <label for="credit-card">Credit Card</label>
                        <input type="radio" id="paypal" name="payment_method" value="paypal" required>
                        <label for="paypal">Paypal</label>
                        <input type="radio" id="mbway" name="payment_method" value="mbway" required>
                        <label for="mbway">MBWay</label>
                        <input type="radio" id="atm" name="payment_method" value="atm" required>
                        <label for="atm">ATM</label>
                    </div>
                </div>
                <div class="product-inputs">
                    <?php foreach ($shoppingList as $index => $cartItem):
                        $product = Product::getProduct($db, $cartItem->productId);
                        if ($product): 
                            ?>
                            <input type="hidden" name="products[<?php echo $index; ?>][id]" value="<?php echo htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="products[<?php echo $index; ?>][name]" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="products[<?php echo $index; ?>][quantity]" value="1">
                            <input type="hidden" name="products[<?php echo $index; ?>][price]" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php endif;
                    endforeach; ?>
                </div>
                <button type="submit" class="checkout-button">Proceed to Checkout</button>
            </form>
        </article>
        <?php endif; ?>
    </main>
<?php
}
?>
