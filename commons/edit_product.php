<?php

function editProductPage(Product $product) { ?>
    <link rel="stylesheet" href="../css/edit_product.css">
    <link rel="stylesheet" href="../css/notification.css">
    <main class="edit-product-page">
        <div class="product-details">
            <div class="edit-product-image">
                <img src="../<?= htmlspecialchars($product->imagePath); ?>" alt="Imagem de <?= htmlspecialchars($product->name); ?>">
            </div>
            <form action="../CRUD/update_product.php" method="POST" class="edit-product">
                <div class="left-side">
                    <div class="form-group">    
                        <label for="productName">Name:</label>
                        <input type="text" id="product-name" name="product-name" value="<?php echo $product->name ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" id="edit-description" name="edit-description" value="<?php echo $product->description ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="edit-price" name="edit-price" value=<?php echo $product->price ?> required>
                    </div>
                </div>
                <div class="right-side">
                    <div class="form-group">
                        <label for="brand">Brand:</label>
                        <input type="text" id="edit-brand" name="edit-brand" value="<?php echo $product->brand ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="model">Model:</label>
                        <input type="text" id="edit-model" name="edit-model" value="<?php echo $product->model ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="size">Size:</label>
                        <input type="text" id="edit-size" name="edit-size" value="<?php echo $product->size ?>" required>
                    </div>
                </div>
                <button type="submit">Update</button>
                <input type="hidden" name="product-id" value="<?php echo $product->id ?>">
            </form>
        </div>
    </main>
<?php
}
?>