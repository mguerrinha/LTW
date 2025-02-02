<?php

declare(strict_types = 1); 
require_once(__DIR__ . '/../entities/product.class.php');
require_once(__DIR__ . '/../entities/comment.class.php');
require_once(__DIR__ . '/../entities/user.class.php');
require_once('../entities/session.class.php');


function drawProductMain($product) {
    $session = new Session();
    $db = getDatabaseConnection();
    if ($session->isLoggedIn()) {
        $userAux = User::getUser($db, $session->getId());
    }
    ?>
    <link rel="stylesheet" href="../css/product.css">
    <main class="product-page">
        <div class="product-details">
            <div class="product-image">
                <img src="../<?= htmlspecialchars($product->imagePath); ?>" alt="Imagem de <?= htmlspecialchars($product->name); ?>">
            </div>
            <div class="product-info">
                <h1><?php echo $product->name; ?></h1>
                <p><?php echo $product->description; ?></p>
                <?php
                if ($session->isLoggedIn() && ($session->getId() !== $product->userId) && !$product->isSold) {
                    ?>
                    <div class="price-and-cart-wishlist">
                        <div class="price-and-cart">
                            <span class="price"><strong>Preço: </strong><?php echo $product->price; ?> €</span>
                            <button class="add-to-cart" onclick="addProductToCart(<?php echo $product->id; ?>)">Adicionar ao Carrinho</button>
                        </div>
                        <div class="wishlist">
                            <button class="add-to-wishlist" onclick="addFavProduct(<?php echo $product->id; ?>)">Adicionar aos Favoritos</button>
                        </div>
                        <?php if ($userAux->isAdmin) { ?>
                            <div class="price-and-edit-delete">
                                <div class="edit-product">
                                    <button class="delete-product" onclick="deleteProduct(<?= $product->id ?>)">Delete<i class="fas fa-trash-alt"></i></button>
                                    <script src="../javascript/script.js"></script>
                                </div>
                            </div>
                        <?php } ?>
                        <script src="../javascript/script.js"></script>
                    </div>
                    <?php
                }
                else if ($session->isLoggedIn() && ($session->getId() === $product->userId)) {
                ?>
                <div class="price-and-edit-delete">
                    <div class="price-edit">
                        <span class="price"><strong>Preço:</strong><?php echo '&nbsp;' . $product->price; ?>€</span>
                    </div>
                    <div class="edit-product">
                        <a href="../pages/editProductPage.php?product_id=<?= $product->id ?>"><h1>Edit</h1></a>
                        <button class="delete-product" onclick="deleteProduct(<?= $product->id ?>)">Delete<i class="fas fa-trash-alt"></i></button>
                        <script src="../javascript/script.js"></script>
                    </div>
                </div>
                <?php
                } else {
                ?>
                    <div class="price-and-cart-wishlist">
                        <div class="price-and-cart">
                            <span class="price"><strong>Preço:</strong><?php echo '&nbsp;' . $product->price; ?>€</span>
                        </div>
                    </div>
                <?php
                }
                ?>
                <?php
                $productCategories = Product::getProductCategories($db, $product->id);
                ?>
                <ul class="product-attributes">
                    <li><strong>Categorias: </strong>
                        <?php
                        if (empty($productCategories)) {
                            echo 'No categories';
                        } else {
                            $categoryNames = array_map(function($category) {
                                return htmlspecialchars($category['name']);
                            }, $productCategories);
                            echo implode(', ', $categoryNames);
                        }
                        ?>
                    </li>
                    <li><strong>Marca: </strong><?php echo $product->brand; ?></li>
                    <li><strong>Modelo: </strong><?php echo $product->model; ?></li>
                    <li><strong>Tamanho: </strong><?php echo $product->size; ?></li>
                    <li><strong>Condição: </strong><?php echo $product->state; ?></li>
                </ul>
            </div>
        </div>
        <div class="comment-section">
            <h2>Comentários</h2>
            <div class="comments-container">
                <?php
                $comments = Comment::getCommentsByProduct($db, $product->id);
                foreach ($comments as $comment) {
                    $user = User::getUser($db, $comment->userId);
                    ?>
                    <div class="comment" data-id="<?php echo $comment->id; ?>">
                        <div class="comment-meta">
                            <div class = "details">
                                <span class="comment-author"><?php echo htmlspecialchars($user->userName); ?> | </span>
                                <span class="comment-date"><?php echo $comment->dateTime->format('d/m/Y H:i'); ?></span>
                            </div>
                            <?php
                            if ($session->isLoggedIn() && ($session->getId() === $comment->userId || $userAux->isAdmin)) {
                            ?>
                                <div class="comment-delete">
                                    <button class="delete-comment" onclick="removeComment(<?php echo $comment->id; ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <script src="../javascript/script.js"></script>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="comment-content">
                            <?php echo htmlspecialchars($comment->commentary); ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
            $session = new Session();
            if ($session->isLoggedIn()) {
            $user = User::getUser($db, $session->getId());
            $dateTime = new DateTime();
            $dateTime = $dateTime->format('Y/m/d H:i')
            ?>
                <textarea placeholder="Adicione um comentário..."></textarea>
                <button class="submit-comment" onclick="submitComment(<?php echo $product->id; ?>, '<?php echo $user->name;?>', '<?php echo $dateTime ?>')"> Enviar Comentário</button>
                <script src="../javascript/script.js"></script>
            <?php
            }
            ?>
        </div>
    </main>
<?php
}