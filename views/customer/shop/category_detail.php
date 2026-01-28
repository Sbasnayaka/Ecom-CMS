<?php
$hide_mobile_header = true; // Hide global header
require_once 'views/layouts/customer_header.php';
?>

<div class="home-layout">

    <!-- SIDEBAR -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <main class="main-content">

        <!-- Figma Header: Back | Title/Subtitle | Search+Avatar -->
        <div class="mobile-header d-lg-none"
            style="display: flex; align-items: center; justify-content: space-between; padding: 20px 0; margin-bottom: 10px;">

            <!-- Left: Back Button & Title -->
            <div style="display: flex; align-items: center; gap: 15px;">
                <!-- Back Logic: Go back to 'All Categories' usually, or history back is risky in SPA-like, 
                     but here we assume going BACK to 'Categories' list is safest default. -->
                <a href="<?= BASE_URL ?>shop/categories" class="back-btn"
                    style="width: 35px; height: 35px; background: #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-chevron-left" style="font-size: 14px;"></i>
                </a>
                <div>
                    <h1 style="font-size: 20px; font-weight: 800; line-height: 1.2; margin: 0;">
                        <?= htmlspecialchars($category['name']) ?></h1>
                    <!-- Dynamic Subtitle: 'Product Category' OR Parent Name -->
                    <p style="font-size: 11px; color: #888; margin: 0;">
                        <?= isset($parentCategoryName) ? htmlspecialchars($parentCategoryName) : 'Product Category' ?>
                    </p>
                </div>
            </div>

            <!-- Right: Search & Avatar -->
            <div style="display: flex; align-items: center; gap: 10px;">
                <a href="<?= BASE_URL ?>shop/index"
                    style="width: 40px; height: 40px; background: #ede7f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #5e35b1;">
                    <i class="fas fa-search" style="font-size: 18px;"></i>
                </a>

                <?php
                $logoUrl = $settings['shop_logo'] ?? '';
                $logoUrl = str_replace('/Ecom-CMS/', BASE_URL, $logoUrl);
                $logo = (!empty($logoUrl)) ? $logoUrl : 'https://via.placeholder.com/40';
                ?>
                <img src="<?= $logo ?>" alt="Logo"
                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            </div>
        </div>

        <!-- Sub Categories (Horizontal Scroll) -->
        <?php if (!empty($subCategories)): ?>
            <div class="section-header">
                <h2 class="section-title">Sub Categories</h2>
            </div>

            <div class="categories-scroll" style="margin-bottom: 30px;">
                <?php foreach ($subCategories as $sub): ?>
                    <a href="<?= BASE_URL ?>shop/category/<?= $sub['id'] ?>" class="cat-item" style="text-decoration: none;">
                        <?php
                        $subPath = 'assets/uploads/' . $sub['image'];
                        $subImg = (!empty($sub['image']) && file_exists(ROOT_PATH . $subPath))
                            ? BASE_URL . $subPath
                            : 'https://via.placeholder.com/80?text=' . urlencode($sub['name']);
                        ?>
                        <img src="<?= $subImg ?>" class="cat-img" alt="<?= htmlspecialchars($sub['name']) ?>">
                        <div class="cat-name"><?= htmlspecialchars($sub['name']) ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Product Grid Title -->
        <div class="section-header">
            <h2 class="section-title"><?= htmlspecialchars($category['name']) ?> Collection</h2>
        </div>

        <!-- Product Grid -->
        <div class="product-grid"
            style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; padding-bottom: 40px;">
            <?php if (empty($products)): ?>
                <div style="grid-column: 1 / -1; padding: 40px; text-align: center; color: #777;">
                    <p>No products found in this collection.</p>
                </div>
            <?php else: ?>
                <?php foreach ($products as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>