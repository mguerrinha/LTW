<?php
require_once(__DIR__ . '/../database/connection.php');
require_once(__DIR__ . '/../entities/user.class.php');
require_once(__DIR__ . '/../entities/session.class.php');

function drawHeader() { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GreenBrowse</title>
    <link rel="icon" href="../images/logo_image.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
            name = "LTW Project - 2024"
            encoding = "utf-8"
            author = "Joao Sousa, Miguel Guerrinha, Rui Cruz"
    >
    <link rel="stylesheet" href="../css/header.css">
    <title>Responsive Website</title>
    <link rel="stylesheet" href="../css/notification.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="../javascript/search.js" defer></script>
    <script src="../javascript/filter.js" defer></script>
    <script src="../javascript/sort.js" defer></script>
    <script src="../javascript/notification.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <div class="logo_image">
                    <a href ="../index.php"><img src="../images/logo_image.png" alt="logo_image"></a>
                </div>
                <div class="logo_name">
                    <a href ="../index.php"><img src="../images/logo_name.png" alt="logo_name"></a>
                </div>
            </div>
            <div class="right">
                <div class="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                    <input type="text" id="searchInput" placeholder="Search..." name="search">
                </div>
                <ul class="profile">
                    <?php
                    $db = getDatabaseConnection();
                    $session = new Session();
                    if ($session->isLoggedIn()) {
                        $user = User::getUser($db, $session->getId());
                        ?>
                        <?php if ($user->isAdmin) { ?>
                            <li><a href="../pages/profilePage.php"><i class="fa fa-user-cog"></i></a></li>
                        <?php } else { ?>
                            <li><a href="../pages/profilePage.php"><i class="fa fa-user"></i></a></li>
                        <?php } ?>
                        <li><a href="../pages/sellerPage.php"><i class="fa fa-add"></i></a></li>
                        <li><a href="../pages/wishlistPage.php"><i class="fa fa-heart"></i></a></li>
                        <li><a href="../pages/shoppinglistPage.php"><i class="fa fa-shopping-cart"></i></a></li>
                        <li><a href="../actions/action_logout.php"><i class="fa fa-sign-out-alt"></i></a></li>
                        <li><p>Hello, <?= htmlspecialchars($user->name); ?></p></li>
                        <?php
                    }
                    else {
                        ?>
                        <li><a href="../pages/loginPage.php"><i class="fa fa-user"></i></a></li>
                        <li><a href="../pages/loginPage.php"><i class="fa fa-heart"></i></a></li>
                        <li><a href="../pages/loginPage.php"><i class="fa fa-shopping-cart"></i></a></li>
                        <li><a href="../pages/loginPage.php"><i class="fa fa-sign-in-alt"></i></a></li>
                        <?php
                    }
                    ?>
                </ul>     
            </div>   
        </nav>
    </header> <?php 
} ?>

<?php

function drawFooter() { ?>
    <link rel="stylesheet" href="../css/footer.css">
        <footer>
            <div class="footer-container">
                <div class="footer-logo">
                    <a href ="../index.php"><img src="../images/logo.png" alt="logo"></a>
                </div>
                <div class="footer-about">
                    <h3>About Us</h3>
                    <p>We are committed to delivering the best services to our customers.</p>
                    <p> Learn more about what we do and how we do it.</p>
                </div>
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="../index.php">Home</a></li>
                        <?php
                        $session = new Session();
                        if ($session->isLoggedIn()) {
                            echo '<li><a href="../pages/profilePage.php">Profile</a></li>';
                            echo '<li><a href="../pages/sellerPage.php">Seller</a></li>';
                        }
                        else {
                            echo '<li><a href="../pages/loginPage.php">Profile</a></li>';
                            echo '<li><a href="../pages/loginPage.php">Seller</a></li>';
                        }
                        ?>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <p>Email: contact@example.com</p>
                    <p>Phone: +123 456 7890</p>
                </div>
            </div>
            <div class="rights-reserved">
                <h4>© GreenBrowse 2024</h4>
            </div>
        </footer>
    </body>
</html> <?php
}
?>

<?php

function drawNotifications(Session $session) { ?>
    <section id="notifications">
    <?php foreach ($session->getNotifications() as $notification) { ?>
        <article class="<?=$notification['type']?>">
        <i class='fas fa-exclamation-circle'></i>
        <?=$notification['text']?>
        </article>
    <?php } ?> </section> 
<?php 
}

