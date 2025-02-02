<?php
require_once(__DIR__ . '/../entities/user.class.php');
require_once(__DIR__ . '/../entities/session.class.php');
require_once(__DIR__ . '/../entities/shoppinglist.class.php');
require_once(__DIR__ . '/../entities/product.class.php');
require_once('../database/connection.php');

date_default_timezone_set('Europe/Lisbon');

$session = new Session();
$db = getDatabaseConnection();
$userId = $session->getId();
$user = User::getUser($db, $userId);

$totalPrice = $_POST['total_price'];
$numItems = $_POST['num_items'];
$paymentMethod = $_POST['payment_method'];
$address = $_POST['address'];
$products = $_POST['products'];

function getPaymentMethodName($method) {
    switch ($method) {
        case 'credit_card': return 'Credit Card';
        case 'paypal': return 'Paypal';
        case 'mbway': return 'MBWay';
        case 'atm': return 'ATM';
        default: return 'Unknown';
    }
}

function clearShoppingList(PDO $db, $userId) {
    $stmt = $db->prepare('DELETE FROM Shoppinglist WHERE buyerId = ?');
    $stmt->execute([$userId]);
}

function addPurchase(PDO $db, int $productId, int $buyerId, string $paymentMethod, string $address) {
    $transactionDate = date('Y-m-d H:i:s');
    $stmt = $db->prepare('INSERT INTO Purchase (productId, buyerId, transactionDate, methodTransition, address) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$productId, $buyerId, $transactionDate, $paymentMethod, $address]);
}

foreach ($products as $product) {
    if (isset($product['id'])) {
        $productObj = Product::getProduct($db, (int)$product['id']);
        if ($productObj) {
            $productObj->setSold($db, (int)$product['id']);
            addPurchase($db, (int)$product['id'], $userId, $paymentMethod, $address);
        } else {
            echo "Product with ID " . htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8') . " not found.<br>";
        }
    } else {
        echo "Product ID is missing for one of the products.<br>";
    }
}

clearShoppingList($db, $userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo_image.png">
    <link rel="stylesheet" href="../css/buySuccess.css">
    <title>Checkout Success</title>
</head>
<body>
    <div class="checkout-success">
        <h2>Thank you for your purchase, <?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?>!</h2>
        <p>Your purchase was successful. Here are the details of your order:</p>
        <div class="details">
            <p><strong>Total Price:</strong> <?php echo htmlspecialchars($totalPrice, ENT_QUOTES, 'UTF-8'); ?> €</p>
            <p><strong>Number of Products:</strong> <?php echo htmlspecialchars($numItems, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars(getPaymentMethodName($paymentMethod), ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($address, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Products Purchased:</strong></p>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li>
                        <strong>Name:</strong> <?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?><br>
                        <strong>Quantity:</strong> <?php echo htmlspecialchars($product['quantity'], ENT_QUOTES, 'UTF-8'); ?><br>
                        <strong>Price:</strong> <?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?> €
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <a href="../index.php" class="back-button">Return to Home</a>
</body>
</html>
