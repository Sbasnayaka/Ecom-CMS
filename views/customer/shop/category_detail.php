<?php require_once 'views/layouts/customer_header.php'; ?>

<div class="home-layout">

    <!-- SIDEBAR -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <main class="main-content">

        <!-- Header with Back Button (Mobile) -->
        <div class="mobile-header"
            style="padding: 20px 0; margin-bottom: 10px; align-items: center; gap: 15px; justify-content: flex-start;">
            <a href="<?= BASE_URL ?>shop/categories" class="back-btn"
                style="width: 35px; height: 35px; background: #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-chevron-left" style="font-size: 14px;"></i>
            </a>
            <div>
                <h1 style="font-size: 20px; font-weight: 800; line-height: 1.2;">
                    <?= htmlspecialchars($category['name']) ?>
                </h1>
                <p style="font-size: 11px; color: #888;">Product Category</p>
            </div>
            <!-- Search/Avatar from Figma removed here as per specific 'Content' focus, 
                 but if needed we can align right. Figma shows it. Let's stick to simple Header first. 
                 Actually Figma shows standard Header at top. I am replicating the "Denim Collection" Title part. -->
        </div>

        <!-- Sub Categories (Horizontal Scroll) -->
        <?php if (!empty($subCategories)): ?>
            <div class="section-header">
                <h2 class="section-title">Sub Categories</h2>
            </div>

            <div class="categories-scroll" style="margin-bottom: 30px;">
                <?php foreach ($subCategories as $sub): ?>
                    <a href="<?= BASE_URL ?>shop?cat=<?= $sub['id'] ?>" class="cat-item" style="text-decoration: none;">
                        <?php
                        $subPath = 'assets/uploads/' . $sub['image'];
                        $subImg = (!empty($sub['image']) && file_exists(ROOT_PATH . $subPath))
                            ? BASE_URL . $subPath
                            : 'https://via.placeholder.com/80?text=' . urlencode($sub['name']);
                        ?>
                        <img src="<?= $subImg ?>" class="cat-img" alt="<?= htmlspecialchars($sub['name']) ?>">
                        <div class="cat-name">
                            <?= htmlspecialchars($sub['name']) ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Product Grid Title -->
        <div class="section-header">
            <h2 class="section-title">
                <?= htmlspecialchars($category['name']) ?> Collection
            </h2>
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