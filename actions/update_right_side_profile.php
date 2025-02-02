<?php

require_once('../database/connection.php');
require_once('../entities/user.class.php');
require_once('../entities/session.class.php');
require_once('../entities/product.class.php');
require_once('../entities/category.class.php');

$db = getDatabaseConnection();
$option = $_GET['option'];
$session = new Session();
$user = User::getUser($db, $session->getId());
$products = Product::getProductsByUser($db, $session->getId());

switch ($option) {
    case 'personalData':
        ?>
        <h1>Personal Data</h1>
        <div class="personal-data">
            <h2>Account Data</h2>
            <form action="../CRUD/update_user.php" method="POST" class="edit-profile">
                <div class="form-group">    
                    <label for="username">Username:</label>
                    <input type="text" id="edit-username" name="edit-username" value=<?php echo $user->userName ?> required>
                </div>
                <div class="form-group">    
                    <label for="name">Name:</label>
                    <input type="text" id="edit-name" name="edit-name" value=<?php echo $user->name ?> required>
                </div>
                <div class="form-group">    
                    <label for="surname">Surname:</label>
                    <input type="text" id="edit-surname" name="edit-surname" value=<?php echo $user->surname ?> required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="edit-address" name="edit-address" value=<?php echo $user->address ?> required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="edit-email" name="edit-email" value=<?php echo $user->email ?> required>
                </div>
                <div class="form-group">
                    <label for="phone-number">Phone Number:</label>
                    <input type="tel" id="edit-phone-number" name="edit-phone-number" value=<?php echo $user->phoneNumber ?> required>
                </div>
                <button type="submit">Update</button>
            </form>
        </div>
        <div class="change-password">
            <h2>Change Password</h2>
            <form action="../CRUD/update_password.php" method="POST" class="reset-pass">
                <div class="form-group">
                    <label for="password">Current Password:</label>
                    <input type="password" id="edit-password" name="edit-password" required>
                </div>
                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="password" id="edit-new-password" name="edit-new-password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm New Password:</label>
                    <input type="password" id="edit-confirm-password" name="edit-confirm-password" required>
                </div>
                <button type="submit">Save</button>
            </form>
        </div>
        <?php
        break;
    case 'myOrders':
        ?>
        <h1>My Orders</h1>
        <div class="my-orders">
        <?php
        $productsPurchased = Product::getProductsPurchasedByUser($db, $session->getId());
        if (empty($productsPurchased)) {
            echo "You have no products ordered";
        } else {
            foreach ($productsPurchased as $item) {
                $product = $item['product'];
                $transactionDate = $item['transactionDate'];
                ?>
                <div class="order">
                    <a href="../pages/productPage.php?product_id=<?= $product->id ?>">
                        <img src="../<?= htmlspecialchars($product->imagePath); ?>" alt="Imagem de <?= htmlspecialchars($product->name); ?>">
                    </a>
                    <p><?= htmlspecialchars($product->name); ?></p>
                    <p><?= number_format($product->price, 2); ?> €</p>
                    <p><strong>Date:</strong> <?= htmlspecialchars($transactionDate); ?></p>
                </div>
                <?php
            }
        }
        ?>
        </div>
        <?php
        break;
    case 'mySales':
        ?>
        <h1>My Sellings</h1>
        <div class="my-orders">
            <?php
            if (empty($products)) {
                echo "You have no products for sale";
            } else {
                foreach ($products as $product) {
                    $soldClass = $product->isSold ? 'sold' : '';
                    ?>
                    <div class="order <?= $soldClass ?>">
                        <a href="../pages/productPage.php?product_id=<?= $product->id ?>">
                            <img src="../<?= htmlspecialchars($product->imagePath); ?>" alt="Image of <?= htmlspecialchars($product->name); ?>">
                        </a>
                        <p><?= htmlspecialchars($product->name); ?></p>
                        <p><?= number_format($product->price, 2); ?> €</p>
                        <?php if ($product->isSold): ?>
                            <p class="sold-label">SOLD</p>
                        <?php endif; ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
        break;
    default:
        echo "Invalid option";
        break;
    }
?>