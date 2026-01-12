<?php require_once 'views/layouts/customer_header.php'; ?>

<!-- Mobile Welcome Block (Moved here or kept in header, keeping here ensures it is part of flow) -->
<!-- Actually handled in Header for global presence, but specific to Home? 
     Design shows it at top. Header has it. Good. -->

<div class="home-layout">

    <!-- DESKTOP SIDEBAR (Visible only on Desktop) -->
    <aside class="sidebar display-desktop-only">
        <div class="filter-group">
            <span class="filter-title">Filter by Price</span>
            <div style="display: flex; gap: 10px;">
                <input type="text" placeholder="Min"
                    style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <input type="text" placeholder="Max"
                    style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
        </div>

        <div class="filter-group">
            <span class="filter-title">Filter by Category</span>
            <?php foreach ($categories as $cat): ?>
                <label class="checkbox-label">
                    <input type="checkbox">
                    <?= htmlspecialchars($cat['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">

        <!-- Top Categories (Mobile Horizontal Scroll / Desktop Grid?) -->
        <div class="section-header">
            <h2 class="section-title">Top Categories</h2>
            <a href="/Ecom-CMS/shop" class="view-all">View All</a>
        </div>

        <div class="categories-scroll">
            <?php foreach ($categories as $cat): ?>
                <div class="cat-item">
                    <?php
                    $catPath = 'assets/uploads/' . ($cat['image'] ?? '');
                    $img = (!empty($cat['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/Ecom-CMS/' . $catPath))
                        ? '/Ecom-CMS/' . $catPath
                        : 'https://via.placeholder.com/80?text=' . urlencode($cat['name']);
                    ?>
                    <img src="<?= $img ?>" class="cat-img" alt="<?= htmlspecialchars($cat['name']) ?>">
                    <div class="cat-name">
                        <?= htmlspecialchars($cat['name']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Featured Products -->
        <?php if (!empty($featuredProducts)): ?>
            <div class="section-header">
                <h2 class="section-title">Featured Products <span class="tag special">SPECIAL</span></h2>
            </div>
            <div class="product-grid">
                <?php foreach ($featuredProducts as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Latest Products -->
        <div class="section-header">
            <h2 class="section-title">Latest Products <span class="tag new">NEW</span></h2>
        </div>
        <div class="product-grid">
            <?php foreach ($latestProducts as $prod): ?>
                <?php include 'views/customer/partials/product_card.php'; ?>
            <?php endforeach; ?>
        </div>

        <!-- Sale Products -->
        <?php if (!empty($saleProducts)): ?>
            <div class="section-header">
                <h2 class="section-title">Sale Products <span class="tag sale">Sale..!</span></h2>
            </div>
            <div class="product-grid">
                <?php foreach ($saleProducts as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>

</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>