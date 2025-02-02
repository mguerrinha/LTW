<?php
require_once('../entities/session.class.php');
require_once('../entities/user.class.php');
require_once('../entities/category.class.php');

function drawAdminMain(PDO $db) {
    $session = new Session(); 
    $currentUser = $session->getId();
    $users = User::getAllUsersExceptCurrent($db, $currentUser);
    $categories = Category::getAllCategories($db);
    ?>
    <link rel="stylesheet" href="../css/admin.css">
    <main class="admin-main">
        <h1 class="admin-title">Admin Page</h1>
        <h2 class="admin-subtitle">Users</h2>
        <ul class="admin-list">
            <?php foreach ($users as $user) { ?>
                <li class="admin-list-item">
                    <?= htmlspecialchars($user['userName']) ?>
                    <?php if (!$user['isAdmin']) { ?>
                        <button class="admin-button" onclick="promoteUser(<?= htmlspecialchars($user['id']) ?>)">Promote to Admin</button>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
        <h2 class="admin-subtitle">Categories</h2>
        <ul id="category-list" class="admin-list">
            <?php foreach ($categories as $category) { ?>
                <li class="admin-list-item" id="category-<?= htmlspecialchars($category->id) ?>">
                    <?= htmlspecialchars($category->name) ?>
                    <button class="admin-button" onclick="removeCategory(<?= htmlspecialchars($category->id) ?>)">Remove</button>
                </li>
            <?php } ?>
        </ul>
        <h3 class="admin-subtitle">Add New Category</h3>
        <form id="add-category-form" class="admin-form">
            <input type="text" name="category_name" id="category_name" required>
            <button type="submit" class="admin-button">Add Category</button>
        </form>
        <script src="../javascript/admin.js" defer></script>
    </main>
    <?php 
}
?>
