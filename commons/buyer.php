<?php
require_once(__DIR__ .'/../entities/category.class.php');

function drawBuyerMain(PDO $db) { 
    $categories = Category::getAllCategories($db);
    ?>
    <link rel="stylesheet" href="../css/buyer.css">
    <link rel="stylesheet" href="../css/notification.css">

    <main>
        <nav class="gallery-wrap">
            <img src="../images/categories/previous.png" id="backBtn">
            <div class="gallery">
                <div>
                    <span><img src="../images/categories/roupa.jpg"></span>
                    <span><img src="../images/categories/calcado.jpg"></span>
                    <span><img src="../images/categories/acessorios.jpg"></span>
                    <span><img src="../images/categories/tecnologia.jpg"></span>
                    <span><img src="../images/categories/decoracao.jpg"></span>
                    <span><img src="../images/categories/brinquedos.jpg"></span>
                    <span><img src="../images/categories/jogos.jpg"></span>
                    <span><img src="../images/categories/desporto.jpg"></span>
                    <span><img src="../images/categories/casa.jpg"></span>
                    <span><img src="../images/categories/beleza.jpg"></span>
                    <span><img src="../images/categories/antiguidades.jpg"></span>
                    <span><img src="../images/categories/diversos.jpg"></span>
                </div>
            </div>
            <img src="../images/categories/next.png" id="nextBtn">
            <script src="../javascript/scroller.js"></script>
        </nav>
        <div class="filter-sort-bar">
            <div class="filter">
                <button class="filter-button">
                    <i class="fas fa-filter"></i><span class="filter-text">Filtrar</span>
                </button>
                <div class="filter-options">
                    <ul>
                        <li>
                            <span>Categoria:</span>
                            <?php foreach ($categories as $category): ?>
                                <div>
                                    <input type="checkbox" id="category-<?= htmlspecialchars($category->id) ?>" name="category" value="<?= htmlspecialchars($category->id) ?>">
                                    <label for="category-<?= htmlspecialchars($category->id) ?>"><?= htmlspecialchars($category->name) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </li>
                        <li>
                            <span>Estado:</span>
                            <div>
                                <input type="checkbox" id="state-almost-new" name="state" value="Almost New">
                                <label for="state-almost-new">Almost New</label>
                            </div>
                            <div>
                                <input type="checkbox" id="state-used" name="state" value="Used">
                                <label for="state-used">Used</label>
                            </div>
                            <div>
                                <input type="checkbox" id="state-bad" name="state" value="Bad State">
                                <label for="state-bad">Bad State</label>
                            </div>
                        </li>
                        <li>
                            <span>Preço:</span>
                            <input type="number" id="priceMin" placeholder="Mínimo" style="width: 70px;">
                            <input type="number" id="priceMax" placeholder="Máximo" style="width: 70px;">
                        </li>
                        <li>
                            <button onclick="applyFilters()">Aplicar Filtros</button>
                            <button onclick="clearFilters()">Limpar Filtros</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sort">
                <button class="sort-button" onclick="toggleDropdown()"><i class="fas fa-sort-amount-down"></i><span class="sort-text">Ordenar</span></button>
                <div class="sort-options">
                    <ul>
                        <li><button onclick="sortProducts('price', 'ASC')">Preço Ascendente</button></li>
                        <li><button onclick="sortProducts('price', 'DESC')">Preço Descendente</button></li>
                        <li><button onclick="sortProducts('name', 'ASC')">Ordem Alfabética A-Z</button></li>
                        <li><button onclick="sortProducts('name', 'DESC')">Ordem Alfabética Z-A</button></li>
                        <li><button onclick="sortProducts('publicationDate', 'ASC')">Recomendado</button></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-grid" id="productGrid">
            <?php
            $products = Product::getAllProducts($db);
            foreach ($products as $product): ?>
                <div class="product">
                    <a href="../pages/productPage.php?product_id=<?= $product->id ?>">
                        <img src="../<?= htmlspecialchars($product->imagePath); ?>" alt="Imagem de <?= htmlspecialchars($product->name); ?>">
                    </a>
                    <p><?= htmlspecialchars($product->name); ?></p>
                    <p><?= number_format($product->price, 2); ?> €</p>
                </div>
            <?php endforeach; ?>
        </article>
    </main>
<?php 
}
?>