<?php
declare(strict_types = 1);

require_once('../entities/category.class.php');

function drawSellerMain(PDO $db) { 
    $categories = Category::getAllCategories($db);
    ?>
    <link rel="stylesheet" href="../css/seller.css">
    <link rel="stylesheet" href="../css/notification.css">
    <main>
        <form action="../CRUD/add_product.php" method="post" enctype="multipart/form-data" class="form-seller">
            <h2>Adicionar Produto</h2>
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name_product" required><br>

            <label for="description">Descrição:</label>
            <textarea id="description" name="description_product" required></textarea><br>

            <label for="brand">Marca:</label>
            <input type="text" id="brand" name="brand_product" required><br>

            <label for="model">Modelo:</label>
            <input type="text" id="model" name="model_product" required><br>

            <label for="size">Tamanho:</label>
            <input type="text" id="size" name="size_product" required><br>

            <label for="price">Preço:</label>
            <input type="number" id="price" name="price_product" min="1" step="0.01" required><br>

            <label for="state">Estado:</label>
            <select id="state" name="state_product" required>
                <option value="Almost New">Almost New</option>
                <option value="Used">Used</option>
                <option value="Bad State">Bad State</option>
            </select><br>

            <label for="categories">Categorias:</label><br>
            <div class="all-categories">
            <div class="category-grid">
            <?php 
            $count = 0;
            foreach ($categories as $category): 
                if ($count % 3 == 0 && $count != 0): ?>
                    </div><div class="category-grid">
                <?php endif; ?>
                <div class="category-item">
                    <input type="checkbox" id="category_<?= htmlspecialchars((string)$category->id) ?>" name="categories_product[]" value="<?= htmlspecialchars((string)$category->id) ?>">
                    <label for="category_<?= htmlspecialchars((string)$category->id) ?>"><?= htmlspecialchars($category->name) ?></label>
                </div>
            <?php 
            $count++;
            endforeach; 
            ?>
            </div>
            </div>
            <br>

            <label for="image">Imagem do Produto:</label>
            <input type="file" id="image" name="image_product" required><br>

            <input type="submit" value="Add Product">
        </form>
    </main>
<?php 
}
?>